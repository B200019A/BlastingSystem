<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Models\OnsendApi;
use App\Models\SendMessage;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Auth;
class SendWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Respectively send an message to everyone arrive the send time via whatsapp.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:i');
        //plus second same format with db
        $currentTime = $currentTime . '' . ':00';
        $messages = Message::where('send_time', $currentTime)->get();

        foreach ($messages as $message) {
            $currentTime = Carbon::now();
            foreach ($message->blasters->customers as $customers) {
                //orignal text
                $oriText = $message->message;
                //replace attribute text in messge
                $oriText = str_replace('[attribute1]', $customers->attribute1, $oriText);
                $oriText = str_replace('[attribute2]', $customers->attribute2, $oriText);
                $oriText = str_replace('[attribute3]', $customers->attribute3, $oriText);
                $oriText = str_replace('[attribute4]', $customers->attribute4, $oriText);
                $oriText = str_replace('[attribute5]', $customers->attribute5, $oriText);
                $oriText = str_replace('[attribute6]', $customers->attribute6, $oriText);
                $oriText = str_replace('[attribute7]', $customers->attribute7, $oriText);
                //store send message table
                $send_messages = SendMessage::create([
                    'user_id' => $message->user_id,
                    'message_id' => $message->id,
                    'blaster_id' => $message->blasters->id,
                    'customer_id' => $customers->id,
                    'full_message' => $oriText,
                    'send_time' => $currentTime, //store current time
                ]);
            }
            //send message to customer
            $api = OnsendApi::where('user_id', $message->user_id)->first();
            $apiKey = $api->api;

            $find_send_messages = SendMessage::where('send_time', $currentTime)->get();
            foreach ($find_send_messages as $find_send_messages) {
                //get phone number
                $phoneNumber = $find_send_messages->customers->attribute1;

                if ($message->image != null) {
                    // url("images/{$find_send_messages->blasters->image}")
                    $data = [
                        'phone_number' => $phoneNumber,
                        'message' => $find_send_messages->full_message,
                        'type' => 'image',
                        'url' => url("public/images/{$message->image}"),
                    ];
                } else {
                    $data = [
                        'phone_number' => $phoneNumber,
                        'message' => $find_send_messages->full_message,
                    ];
                }
                //onsend api send to targe phone number
                $response = \Illuminate\Support\Facades\Http::accept('application/json')
                    ->withToken($apiKey)
                    ->post('https://onsend.io/api/v1/send', $data);

                //check send message status
                $response = json_decode($response, true);
                $collection = collect($response);
                $time = Carbon::now();
                if (Arr::has($collection, 'errors')) {
                    $find_send_messages->fail_at = $time;
                } else {
                    if (!$collection['success']) {
                        //cannot send the target phone number
                        $find_send_messages->fail_at = $time;
                    } else {
                        //successful send the phone number
                        $find_send_messages->pass_at = $time;
                    }
                }
                $find_send_messages->save();
            }
        }
        $this->info('Successfully sent Whatsapp quote to target send time.');
    }
}
