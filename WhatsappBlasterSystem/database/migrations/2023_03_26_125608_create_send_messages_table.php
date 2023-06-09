<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('send_messages', function (Blueprint $table) {
            $table->id();
            $table->string("user_id");
            $table->string("message_id");
            $table->string("blaster_id");
            $table->string("customer_id");
            $table->longText("full_message");
            $table->Datetime("send_time");
            $table->timestamp("fail_at")->nullable();
            $table->timestamp("pass_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_messages');
    }
};
