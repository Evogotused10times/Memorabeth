<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBurialRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('burial_records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('plot_id')->unique();
            $table->string('dates')->nullable();
            $table->decimal('latitude', 9, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('burial_records');
    }
}