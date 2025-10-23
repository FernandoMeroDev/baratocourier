<?php

namespace App\Http\Controllers\Packages;

use App\Http\Controllers\Controller;
use App\Models\Packages\Package;
use App\Models\Packages\Waybills\Fields;
use App\Models\Packages\Waybills\PersonalData;
use App\Models\Packages\Waybills\Styles;
use App\Models\Packages\Waybills\Waybill;
use App\Models\traits\SequentialFormater;
use App\Models\User\Franchisee;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class DownloadController extends Controller
{
    use SequentialFormater;

    private ?Franchisee $styler = null;

    public function __invoke(Package $package, Request $request)
    {
        if(! is_null($request->get('use_styles_of')) ){
            if($styler = Franchisee::find($request->get('use_styles_of')))
                $this->styler = $styler;
        }

        $dompdf = new Dompdf();
        $dompdf->setPaper([0, 0, 432, 288], 'landscape');

        $filename = 'Guía.pdf';

        $dompdf->loadHtml($this->generateHTML($package));

        $dompdf->render();
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$filename.'"');
    }

    private function barcode(Waybill $waybill): string
    {
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeBinary = $barcodeGenerator->getBarcode(
            $this->formatSequential($waybill->id, 6), $barcodeGenerator::TYPE_CODE_128
        );
        $base64 = base64_encode($barcodeBinary);
        $data = 'data:image/png;base64,' . $base64;
        return "<img class=\"barcode\" src=\"$data\" />";
    }

    private function generateHTML(Package $package): string
    {
        $user = $package->user;
        $styles = is_null($this->styler)
            ? json_decode($user->franchisee->waybill_styles)
            : json_decode($this->styler->waybill_styles);

        $template = Storage::get('templates/waybill_base_template.html');

        $template = $this->stylize($template, $styles);

        $count = $package->waybills->count();
        $i = 0;
        foreach($package->waybills as $waybill){
            $waybill_template = $this->buildWaybillTemplate($styles);
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
            $waybill_template = str_replace('{{address}}', $user->franchisee->readable_address(), $waybill_template);
            $waybill_template = str_replace(
                '{{phone_number}}', $waybill->personalData->phone_number, $waybill_template
            );
            $waybill_template = str_replace('{{barcode}}', $this->barcode($waybill), $waybill_template);
            $waybill_template = str_replace('{{guide_domain}}', $package->guide_domain, $waybill_template);
            $waybill_template = str_replace('{{waybill_number}}', $this->formatSequential($waybill->waybill_number, 6), $waybill_template);
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

    private function buildWaybillTemplate(object $styles): string
    {
        $template = '';
        $fields = collect([]);
        foreach($styles as $field => $style)
            $fields->push(['name' => $field,'position' => $style->position]);
        $fields = $fields->sortBy('position');
        $template .= '<div class="root">';
        foreach($fields as $field){
            $template .= Fields::$html[$field['name']];
        }
        $template .= '</div>';
        return $template;
    }

    private function stylize(string $template, object $styles): string
    {
        $template = $this->stylizeBlock('logo', $template, $styles);
        $template = $this->stylizeText('courier_name', $template, $styles);
        $template = $this->stylizeText('address', $template, $styles);
        $template = $this->stylizeText('phone_number', $template, $styles);
        $template = $this->stylizeBlock('barcode', $template, $styles);
        $template = $this->stylizeText('guide_domain', $template, $styles);
        $template = $this->stylizeText('waybill_number', $template, $styles);
        $template = $this->stylizeText('waybill_text_reference', $template, $styles);
        $template = $this->stylizeText('weight', $template, $styles);
        $template = $this->stylizeText('created_at', $template, $styles);
        $template = $this->stylizeText('tracking_number', $template, $styles);
        $template = $this->stylizeText('reference', $template, $styles);
        $template = $this->stylizeText('category', $template, $styles);
        $template = $this->stylizeText('shipping_address', $template, $styles);
        $template = $this->stylizeText('shipping_method', $template, $styles);
        $template = $this->stylizeText('client_code', $template, $styles);
        $template = $this->stylizeText('client_name', $template, $styles);
        return $template . '</style>';
    }

    private function stylizeText(string $field, string $template, object $styles): string
    {
        $class = str_replace('_', '-', $field);
        $template .= " .$class { "
            . "font-size: " . $styles->{$field}->size . "px;"
            . "text-align: " . $styles->{$field}->align . ";"
            . "margin-top: " . $styles->{$field}->margin_top . "px;"
            . "margin-bottom: " . $styles->{$field}->margin_bottom . "px;"
            . "font-style: " . $styles->{$field}->font_style . ";"
            . "font-weight: " . $styles->{$field}->font_weight . ";"
            . "}";
        return $template;
    }

    private function stylizeBlock(string $field, string $template, object $styles): string
    {
        $template = str_replace('{{'.$field.'_size}}', $styles->{$field}->size, $template);
        $template = str_replace('{{'.$field.'_align}}', Styles::alignBlock($styles->{$field}->align), $template);
        $template = str_replace('{{'.$field.'_margin_top}}', $styles->{$field}->margin_top, $template);
        $template = str_replace('{{'.$field.'_margin_bottom}}', $styles->{$field}->margin_bottom, $template);
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
}
