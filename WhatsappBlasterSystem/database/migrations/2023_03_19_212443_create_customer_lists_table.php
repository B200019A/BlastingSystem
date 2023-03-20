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
        Schema::create('customer_lists', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('blasting_id');
            $table->string('attribute1');
            $table->string('attribute2');
            $table->string('attribute3');
            $table->string('attribute4');
            $table->string('attribute5');
            $table->string('attribute6');
            $table->string('attribute7');
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_lists');
    }
};
