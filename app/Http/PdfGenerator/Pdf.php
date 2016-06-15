<?php

namespace App\Http\PdfGenerator;

use Illuminate\View\View;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\DetectDevice\Device;

class Pdf
{
    public static function renderLandscape(View $view)
    {
        return static::render($view, 'landscape');
    }

    public static function render(View $view, $orientation = 'letter')
    {
        if (Device::isAndroidMobile()) {
            return $view;
        }

        $html = $view->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();

        $output = $dompdf->output();
        return response($output)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="report.pdf')
            ->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

}
