<?php
namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Storage;

class MakePDF
{
    public static function generate($event)
    {
        $fileName = time() . "evento.pdf";
        $image = $event->thumbnail;
        $content = base64_encode(Storage::get($image));
        $event->thumbnail = $content;
        $pdf = pdf::loadView('pdf.evento', compact('event'));
        Storage::put('public/tmp/' . $fileName, $pdf->output());
        $path = env('PATH_PDF_MAIL') . $fileName;
        return $path;
    }
}