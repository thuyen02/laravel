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
        Schema::create('medicalrecords', function (Blueprint $table) {
            $table->id();
            $table->string('medicalrecords_code');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->string('medicalrecords_diagnosis');
            $table->string('medicalrecords_treatment');
            $table->string('medicalrecords_prescription');
            $table->string('image')->nullable();
            $table->date('medicalrecords_date');
            $table->integer('status')->default(1);
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicalrecords');
    }
};

