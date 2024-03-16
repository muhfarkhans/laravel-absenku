<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('photo');
            $table->timestamps();

            $table->foreign('division_id')
                ->references('id')
                ->on('divisions')
                ->onUpdate('cascade')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
