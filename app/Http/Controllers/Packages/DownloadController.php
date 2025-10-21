<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Packages\Package;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function __invoke(Package $package)
    {
        $dompdf = new Dompdf();
        $dompdf->setPaper([0, 0, 432, 288], 'landscape');

        $filename = 'Guía.pdf';

        $dompdf->loadHtml($this->generateHTML($package));

        $dompdf->render();
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$filename.'"');
    }

    private function generateHTML(Package $package): string
    {
        $template = Storage::get('waybill_template.html');

        // Load logo
        if($package->logo){
            $logo_path = "/users/franchisee/logos/$package->logo";
            $base64 = base64_encode(Storage::get($logo_path));
            $mimeType = Storage::mimeType($logo_path);
            $data = 'data:' . $mimeType . ';base64,' . $base64;
            $logo = "<img class=\"logo\" src=\"$data\" />";
            $template = str_replace('{{logo}}', $logo, $template);
        } else {
            $template = str_replace('{{logo}}', '<p class="no-logo">No tiene logo</p>', $template);
        }

        // Text variables
        $user = $package->user;
        $waybill = $package->waybills->get(0);
        $template = str_replace('{{courier_name}}', $package->courier_name, $template);
        $template = str_replace('{{address}}', $package->address, $template);
        $template = str_replace(
            '{{phone_number}}', $waybill->personalData->phone_number == 'Ninguno' ? '0999999999' : $waybill->personalData->phone_number, $template
        );
        // [TODO] Add Barcode here
        $template = str_replace('{{guide_domain}}', $package->guide_domain, $template);
        $template = str_replace('{{waybill_number}}', '00001', $template); // [TODO] Add real waybill_number
        $template = str_replace('{{waybill_text_reference}}', $user->franchisee->waybill_text_reference, $template);
        $template = str_replace('{{weight}}', $waybill->weight, $template);
        $template = str_replace('{{created_at}}', $package->created_at, $template);

        if($package->tracking_number)
            $template = str_replace('{{tracking_number}}', $package->tracking_number, $template);
        else $template = str_replace('{{tracking_number}}', 'Sin número de seguimiento', $template);

        if($package->tracking_number)
            $template = str_replace('{{reference}}', $package->reference, $template);
        else $template = str_replace('{{reference}}', 'Sin referencia', $template);

        $template = str_replace('{{category}}', $package->category->name, $template);
        $template = str_replace('{{shipping_address}}', 'Bolívar - Manabí - Ecuador', $template); // [TODO] Add real shipping address
        $template = str_replace('{{shipping_method}}', $package->shippingMethod->abbreviation, $template);
        $template = str_replace('{{client_code}}', $package->client_code, $template);

        return $template;
    }
}
