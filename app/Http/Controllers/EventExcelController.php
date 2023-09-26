<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class EventExcelController extends Controller
{
    public function index()
    {
        $excel = Excel::store(new EventExport, 'public/tmp/event.xlsx');
        //Storage::disk('public')->put('event.xlsx', $excel);
        return response()->json(['message' => 'success']);

    }
}