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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->string('applicant_name');
            $table->string('address');
            $table->string('cellphone_no')->nullable();
            $table->string('email')->nullable();
            $table->string('facebook_messenger')->nullable();
            $table->string('next_of_kin');

            $table->json('lots')->nullable();

            $table->text('terms')->nullable();
            $table->text('remarks')->nullable();

            $table->string('purchaser_name');
            $table->boolean('signature_agreement')->default(false);
            $table->string('agent_name');
            $table->date('date');

            $table->string('file_path')->nullable();

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};