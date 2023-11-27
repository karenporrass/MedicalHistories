<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professional_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_document')->constrained('users')->onDelete('cascade');
            $table->integer('code_history')->unique();
            $table->integer('review');
            $table->text('state_patient');
            $table->text('health_history');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
};
