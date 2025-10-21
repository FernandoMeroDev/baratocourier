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
        $template = Storage::get('templates/waybill_base_template.html');

        $user = $package->user;
        $count = $package->waybills->count();
        $i = 0;
        foreach($package->waybills as $waybill){
            $waybill_template = Storage::get('templates/waybill_template.html');
            // Load logo
            if($package->logo){
                $logo_path = "/users/franchisee/logos/$package->logo";
                $base64 = base64_encode(Storage::get($logo_path));
                $mimeType = Storage::mimeType($logo_path);
                $data = 'data:' . $mimeType . ';base64,' . $base64;
                $logo = "<img class=\"logo\" src=\"$data\" />";
                $waybill_template = str_replace('{{logo}}', $logo, $waybill_template);
            } else {
                $waybill_template = str_replace('{{logo}}', '<p class="no-logo">No tiene logo</p>', $waybill_template);
            }
            $waybill_template = str_replace('{{courier_name}}', $package->courier_name, $waybill_template);
            $waybill_template = str_replace('{{address}}', $user->franchisee->address, $waybill_template);
            $waybill_template = str_replace(
                '{{phone_number}}', $waybill->personalData->phone_number, $waybill_template
            );
            // [TODO] Add Barcode here
            $waybill_template = str_replace('{{guide_domain}}', $package->guide_domain, $waybill_template);
            $waybill_template = str_replace('{{waybill_number}}', $this->formatSequeltial($waybill->waybill_number, 6), $waybill_template);
            $waybill_template = str_replace('{{waybill_text_reference}}', $user->franchisee->waybill_text_reference, $waybill_template);
            $waybill_template = str_replace('{{weight}}', $waybill->weight, $waybill_template);
            $waybill_template = str_replace('{{created_at}}', $package->created_at, $waybill_template);

            if($package->tracking_number)
                $waybill_template = str_replace('{{tracking_number}}', $package->tracking_number, $waybill_template);
            else $waybill_template = str_replace('{{tracking_number}}', 'Sin número de seguimiento', $waybill_template);

            if($package->tracking_number)
                $waybill_template = str_replace('{{reference}}', $package->reference, $waybill_template);
            else $waybill_template = str_replace('{{reference}}', 'Sin referencia', $waybill_template);

            $waybill_template = str_replace('{{category}}', $package->category->name, $waybill_template);
            $waybill_template = str_replace('{{shipping_address}}', $this->extractShippingAddress($package), $waybill_template); // [TODO] Add real shipping address
            $waybill_template = str_replace('{{shipping_method}}', $package->shippingMethod->abbreviation, $waybill_template);
            $waybill_template = str_replace('{{client_code}}', $package->client_code, $waybill_template);
            $waybill_template = str_replace('{{client_name}}', $this->extractClientName($waybill->personalData),$waybill_template);

            if($count > 1 && $i != ($count - 1))
                $waybill_template .= '<div style="page-break-before: always;"></div>';
            $template .= $waybill_template;
            $i++;
        }
        
        $template .= '</body></html>';

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
