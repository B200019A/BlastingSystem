<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMessage extends Command
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
    public function handle(): void
    {
        $this->info('Successfully sent daily quote to everyone.');
    }
}
