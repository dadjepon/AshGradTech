<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('requirements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('major_id')->constrained();
        $table->integer('year');
        $table->float('semester_1');
        $table->float('semester_2');
        $table->float('semester_3');
        $table->float('semester_4');
        $table->float('semester_5');
        $table->float('semester_6');
        $table->float('semester_7');
        $table->float('semester_8');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
