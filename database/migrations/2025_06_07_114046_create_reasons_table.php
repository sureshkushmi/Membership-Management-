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
       Schema::create('reasons', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->enum('type', ['rejected', 'suspended', 'terminated']);
        $table->text('reason');
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reasons');
    }
};
