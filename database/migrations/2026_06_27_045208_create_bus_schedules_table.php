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
        Schema::create('bus_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_id')->unique();
            $table->string('route_from');
            $table->string('route_to');
            $table->time('departure_time');
            $table->string('bus_model');
            $table->string('depot_name');
            $table->decimal('fare', 10, 2);
            $table->integer('available_seats')->default(51);
            $table->string('duration');
            $table->string('bus_type');
            $table->date('schedule_date');
            $table->string('bus_image')->nullable();
            $table->char('status', 1)->default('Y');
            $table->integer('delay_minutes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_schedules');
    }
};
