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
            // Client Code
            $sheet->setCellValue('A'.$i, $waybill->package->client_domain . $waybill->package->client_code);
            // Bag Number
            $sheet->setCellValue('B'.$i, $waybill->shippingBag->number);
            // Tracking Number
            $sheet->setCellValue('C'.$i, $waybill->package->tracking_number);
            // Waybill Number
            $sheet->setCellValue('D'.$i, $waybill->readable_number());
            // Package Category
            $sheet->setCellValue('E'.$i, $waybill->package->category->name);
            if($waybill->package->category->code == 'g'){
                // Sender identity card
                $sheet->setCellValue('F'.$i, $waybill->package->client_identity_card);
                // Sender complete names
                $sheet->setCellValue('G'.$i, $waybill->package->client_complete_name());
            } else $sheet->setCellValue('F'.$i, '------------'); $sheet->setCellValue('G'.$i, '------------');
            // Receiver identity card
            $sheet->setCellValue('H'.$i, $waybill->personalData->identity_card);
            // Receiver complete names
            $sheet->setCellValue('I'.$i, $waybill->personalData->complete_name());
            // Waybill Description
            $sheet->setCellValue('J'.$i, $waybill->description);
            // Waybill items count
            $sheet->setCellValue('K'.$i, $waybill->items_count);
            // Waybill price
            $sheet->setCellValue('L'.$i, '$'.$waybill->price);
            // Shipping City - Province
            $address = $waybill->package->decodeShippingAddress();
            $sheet->setCellValue('M'.$i, $address->city_name . ' - ' . $address->province_name);
            // Shipping Method
            $sheet->setCellValue('N'.$i, $waybill->package->shippingMethod->name);
            // Shipping Address Line
            $sheet->setCellValue('O'.$i, $address->line_1);
            // Shipping Target complete name
            $sheet->setCellValue('P'.$i, $address->target->name . ' ' . $address->target->lastname);
            // Shipping Target identity card
            $sheet->setCellValue('Q'.$i, $address->target->identity_card);
            // Shipping Target phone number
            $sheet->setCellValue('R'.$i, $address->target->phone_number);
            // Shipment date
            $sheet->setCellValue('S'.$i, date('d/m/Y', strtotime($shipment->shipment_datetime)));
            // Shipment time
            $sheet->setCellValue('T'.$i, date("H:i:s", strtotime($shipment->shipment_datetime)));
            // Unshipment date
            if( ! is_null($shipment->unshipment_datetime))
                $sheet->setCellValue('U'.$i, date('d/m/Y', strtotime($shipment->unshipment_datetime)));
            else $sheet->setCellValue('U'.$i, '------------');
            // Unshipment time
            if( ! is_null($shipment->unshipment_datetime))
                $sheet->setCellValue('V'.$i, date("H:i:s", strtotime($shipment->unshipment_datetime)));
            else $sheet->setCellValue('V'.$i, '------------');
            // Shipment Status
            $sheet->setCellValue('W'.$i, $shipment->status);
            $this->styleShipmentStatus($sheet, $shipment->status, 'W'.$i);
            // Package Status
            $sheet->setCellValue('X'.$i, $waybill->package->status);
            $this->stylePackageStatus($sheet, $waybill->package->status, 'X'.$i);
            $i++;
        }
    }

    private function stylePackageStatus(Worksheet $sheet, string $satus, string $field): void
    {
        if($satus == Package::$valid_statuses['eeuu_warehouse']){
            $color = 'FF4BA5D1';
            $text_color = Color::COLOR_WHITE;
        } elseif($satus == Package::$valid_statuses['transit']){
            $color = 'FFBFBFBF';
            $text_color = Color::COLOR_BLACK;
        } else
            return; // Cancel operation
        $sheet->getStyle($field)->getFont()->getColor()->setARGB($text_color);
        $sheet->getStyle($field)->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB($color); 
    }

    private function styleShipmentStatus(Worksheet $sheet, string $satus, string $field): void
    {
        if($satus == Shipment::$valid_statuses['unshipment'])
            $color = 'FF2B7FFF';
        elseif($satus == Shipment::$valid_statuses['shipment'])
            $color = 'FF00C951';
        else $color = 'FF000000';
        $sheet->getStyle($field)->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle($field)->getFill()->setFillType(Fill::FILL_SOLID)
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
    }
}
