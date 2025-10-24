<?php

namespace App\Http\Controllers\Shipments;

use App\Http\Controllers\Controller;
use App\Models\Packages\Package;
use App\Models\Shipments\Shipment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DownloadManifestController extends Controller
{
    use Columns;

    protected Worksheet $sheet;

    public function __invoke(Shipment $shipment)
    {
        $filename = 'Manifiesto';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->writeSheet($sheet, $shipment);

        $xls = new Xls($spreadsheet);

        // Write a memory buffer
        $tempMemory = fopen('php://memory', 'r+');
        $xls->save($tempMemory);
        rewind($tempMemory);
        // Get bynary contents
        $xlsOutput = stream_get_contents($tempMemory);
        fclose($tempMemory);

        return response($xlsOutput, 200)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', 'attacthment; filename="'.$filename.'.xls"');
    }

    private function writeSheet(Worksheet $sheet, Shipment $shipment): void
    {
        $this->writeHeaders($sheet);
        $i = 2;
        foreach($shipment->waybills() as $waybill){
            // Client complete names
            $this->writeCell($i, $waybill->package->client_complete_name());
            // Client identity card
            $this->writeCell($i, $waybill->package->client_identity_card);
            // Client Code
            $this->writeCell($i, $waybill->package->client_domain . $waybill->package->client_code);
            // Bag Number
            $this->writeCell($i, $waybill->shippingBag->number);
            // Tracking Number
            $this->writeCell($i, $waybill->package->tracking_number);
            // Waybill Number
            $this->writeCell($i, $waybill->readable_number());
            // Package Category
            $this->writeCell($i, $waybill->package->category->name);
            if($waybill->package->category->code == 'g'){
                // Sender identity card
                $this->writeCell($i, $waybill->package->client_identity_card);
                // Sender complete names
                $this->writeCell($i, $waybill->package->client_complete_name());
            } else {
                $this->writeCell($i, '------------');
                $this->writeCell($i, '------------');
            }
            // Receiver identity card
            $this->writeCell($i, $waybill->personalData->identity_card);
            // Receiver complete names
            $this->writeCell($i, $waybill->personalData->complete_name());
            // Waybill Description
            $this->writeCell($i, $waybill->description);
            // Waybill items count
            $this->writeCell($i, $waybill->items_count);
            // Waybill price
            $this->writeCell($i, '$'.$waybill->price);
            // Shipping City - Province
            $address = $waybill->package->decodeShippingAddress();
            $this->writeCell($i, $address->city_name . ' - ' . $address->province_name);
            // Shipping Method
            $this->writeCell($i, $waybill->package->shippingMethod->name);
            // Shipping Address Line
            $this->writeCell($i, $address->line_1);
            // Shipping Target complete name
            $this->writeCell($i, $address->target->name . ' ' . $address->target->lastname);
            // Shipping Target identity card
            $this->writeCell($i, $address->target->identity_card);
            // Shipping Target phone number
            $this->writeCell($i, $address->target->phone_number);
            // Shipment date
            $this->writeCell($i, date('d/m/Y', strtotime($shipment->shipment_datetime)));
            // Shipment time
            $this->writeCell($i, date("H:i:s", strtotime($shipment->shipment_datetime)));
            // Unshipment date
            if( ! is_null($shipment->unshipment_datetime))
                $this->writeCell($i, date('d/m/Y', strtotime($shipment->unshipment_datetime)));
            else $this->writeCell($i, '------------');
            // Unshipment time
            if( ! is_null($shipment->unshipment_datetime))
                $this->writeCell($i, date("H:i:s", strtotime($shipment->unshipment_datetime)));
            else $this->writeCell($i, '------------');
            // Shipment Status
            $this->styleShipmentStatus($shipment->status, $i);
            $this->writeCell($i, $shipment->status);
            // Package Status
            $this->stylePackageStatus($waybill->package->status, $i);
            $this->writeCell($i, $waybill->package->status);
            $this->current_letter_i = 0;
            $i++;
        }
    }

    private function writeCell($i, $content)
    {
        $this->sheet->setCellValue(
            $this->letters[$this->current_letter_i].$i,
            $content
        );
        $this->current_letter_i++;
    }

    private function stylePackageStatus(string $satus, int $i): void
    {
        $field = $this->letters[$this->current_letter_i] . $i;
        if($satus == Package::$valid_statuses['eeuu_warehouse']){
            $color = 'FF4BA5D1';
            $text_color = Color::COLOR_WHITE;
        } elseif($satus == Package::$valid_statuses['transit']){
            $color = 'FFBFBFBF';
            $text_color = Color::COLOR_BLACK;
        } else
            return; // Cancel operation
        $this->sheet->getStyle($field)->getFont()->getColor()->setARGB($text_color);
        $this->sheet->getStyle($field)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($color); 
    }

    private function styleShipmentStatus(string $satus, int $i): void
    {
        $field = $this->letters[$this->current_letter_i] . $i;
        if($satus == Shipment::$valid_statuses['unshipment'])
            $color = 'FF2B7FFF';
        elseif($satus == Shipment::$valid_statuses['shipment'])
            $color = 'FF00C951';
        else $color = 'FF000000';
        $this->sheet->getStyle($field)->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $this->sheet->getStyle($field)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($color); 
    }

    private function writeHeaders(Worksheet $sheet): void
    {
        $i = 1;
        // Headers
        foreach($this->columns as $col => $name){
            $sheet->setCellValue($col.'1', $name);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $i++;
        }
        $sheet->getStyle('A1:'.$col.'1')->getFont()->setBold(true);
        $this->sheet = $sheet;
    }
}
