<?php

namespace App\Exports;

use App\Models\events;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class EventExport implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return [
            'id',
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
            'sede_id',
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
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('events')->select(
            'id',
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
            'sede_id',
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
            'notification_enabled'
        )->get();

    }
}