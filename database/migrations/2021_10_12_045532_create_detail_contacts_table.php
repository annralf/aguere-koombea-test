<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('value');
            $table->integer('row');
            $table->string('name');
            $table->string('dateOfBirth');
            $table->string('phone');
            $table->string('address');
            $table->string('creditCard');
            $table->string('franchise');
            $table->string('email');
            $table->foreignId('file_id')->constrained('files_contacts');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_contacts');
    }
}
