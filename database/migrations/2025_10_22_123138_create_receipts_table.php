<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roi_record_id');
            $table->string('file_path');
            $table->timestamps();
            $table->softDeletes();
            
            // $table->foreign('roi_record_id')->references('id')->on('roi_records')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};
