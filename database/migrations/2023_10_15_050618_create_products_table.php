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
        Schema::create('labresults', function (Blueprint $table) {
            $table->id();
            $table->string('labresults_code');
            $table->string('test_name');
            $table->string('result');
            $table->integer('status')->default(1);
            $table->foreignId('medicalrecords_id')->constrained('medicalrecords')->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('LabResults');
    }
};
