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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_event');
            $table->enum('type_event', ['En Linea', 'Presencial']);
            $table->enum('group_event', ['Si', 'No']);
            $table->date('date_register');
            $table->date('date_start');
            $table->date('date_end');
            $table->time('hour_start');
            $table->time('hour_end');
            $table->string('register_start_date');
            $table->string('register_end_date');
            $table->longText('description_event');
            $table->string('thumbnail');
            $table->foreignId('sede_id')->constrained('sedes');
            $table->string('files');
            $table->json('aquien_va_dirigido');
            $table->enum('director_CT_only', ['Si', 'No']);
            $table->enum('administrative_area_only', ['Si', 'No']);
            $table->foreignId('administrative_area_participants_id')->constrained('administrative_area_participants');
            $table->foreignId('workplace_center_participants_id')->constrained('workplace_center_participants');
            $table->string('event_host');
            $table->string('email');
            $table->string('phone_number');
            $table->string('visible_data_host');
            $table->string('asigned_host');
            $table->enum('have_event_activity', ['Si', 'No']);
            $table->enum('notification_enabled', ['Si', 'No']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};