<?php

namespace App\Models;

use App\Enums\Yes_No;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class events extends Model
{
    use HasFactory, HasApiTokens, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_event',
        'type_event',
        'group_event',
        'date_register',
        'date_start',
        'date_end',
        'hour_start',
        'hour_end',
        'register_start_date',
        'register_end_date',
        'description_event',
        'thumbnail',
        'sede_id',
        'files',
        'aquien_va_dirigido',
        'director_CT_only',
        'administrative_area_only',
        'administrative_area_participants_id',
        'workplace_center_participants_id',
        'event_host',
        'email',
        'phone_number',
        'visible_data_host',
        'asigned_host',
        'have_event_activity',
        'notification_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        "deleted_at",
        "created_at",
        "updated_at",
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'date_register' => 'datetime',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'register_start_date' => 'datetime',
        'register_end_date' => 'datetime',
        'hour_start' => 'datetime',
        'hour_end' => 'datetime',
        'group_event' => Yes_No::class,
    ];
}