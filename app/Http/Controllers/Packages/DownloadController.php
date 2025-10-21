<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Packages\Package;
use App\Models\Packages\Waybills\PersonalData;
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
        $template = str_replace('{{address}}', $user->franchisee->address, $template);
        $template = str_replace(
            '{{phone_number}}', $waybill->personalData->phone_number, $template
        );
        // [TODO] Add Barcode here
        $template = str_replace('{{guide_domain}}', $package->guide_domain, $template);
        $template = str_replace('{{waybill_number}}', $this->formatSequeltial($waybill->waybill_number, 6), $template);
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
        $template = str_replace('{{shipping_address}}', $this->extractShippingAddress($package), $template); // [TODO] Add real shipping address
        $template = str_replace('{{shipping_method}}', $package->shippingMethod->abbreviation, $template);
        $template = str_replace('{{client_code}}', $package->client_code, $template);
        $template = str_replace('{{client_name}}', $this->extractClientName($waybill->personalData),$template);

        return $template;
    }
    
    private function extractShippingAddress(Package $package): string
    {
        $shipping_address = json_decode($package->shipping_address);
        return $shipping_address->city_name . ' - ' . $shipping_address->province_name . ' - ' . 'Ecuador';
    }

    private function extractClientName(PersonalData $data): string
    {
        $firstname = preg_split('/\s+/', $data->name)[0];
        $lastname = preg_split('/\s+/', $data->lastname)[0];
        return $firstname . ' ' . $lastname;
    }

    private function formatSequeltial(int $number, int $padding): string 
    {
        return mb_str_pad((string) $number, $padding, '0', STR_PAD_LEFT);
    }
}
