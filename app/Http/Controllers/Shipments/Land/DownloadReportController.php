<?php

namespace App\Http\Controllers\Shipments\Land;

use App\Http\Controllers\Controller;
use App\Models\Packages\Package;
use App\Models\Shipments\Shipment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DownloadReportController extends Controller
{
    use Columns;

    protected Worksheet $sheet;

    public function __invoke(Shipment $shipment)
    {
        $filename = 'Reporte Desembarque';

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
            // Package creation date
            $this->writeCell($i, $waybill->package->created_at);
            // Franchisee complete name
            $this->writeCell($i, $waybill->package->user->name);
            // Client code
            $this->writeCell($i, $waybill->package->client_domain . $waybill->package->client_code);
            // Client identity card
            $this->writeCell($i, $waybill->package->client_identity_card);
            // Client complete names
            $this->writeCell($i, $waybill->package->client_complete_name());
            // Waybill Number
            $this->writeCell($i, $waybill->readable_number());
            // Package Category
            $this->writeCell($i, $waybill->package->category->name);
            // Waybill Weight
            $this->writeCell($i, $waybill->weight);
            // Package Reference
            $this->writeCell($i, $waybill->package->reference);
            // Tracking Number
            $this->writeCell($i, $waybill->package->tracking_number);
            // Shipping City
            $address = $waybill->package->decodeShippingAddress();
            $this->writeCell($i, $address->city_name);
            // Shipping Province
            $this->writeCell($i, $address->province_name);
            // Shipping Method
            $this->writeCell($i, $waybill->package->shippingMethod->name);
            // Shipping Target complete name
            $this->writeCell($i, $address->target->name . ' ' . $address->target->lastname);
            // Shipping Target identity card
            $this->writeCell($i, $address->target->identity_card);
            // Shipping Target phone number
            $this->writeCell($i, $address->target->phone_number);
            // Unshipment datetime
            if( ! is_null($shipment->unshipment_datetime))
                $this->writeCell($i, date('Y-m-d H:i:s', strtotime($shipment->unshipment_datetime)));
            else $this->writeCell($i, '------------');

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
