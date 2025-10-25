<?php

namespace App\Http\Controllers\Shipments\Land;

trait Columns
{
    protected array $columns = [
        'A' => 'FECHA DE CREACION DE GUÍA',
        'B' => 'FRANQUICIADO',
        'C' => 'ID DE CLIENTE',
        'D' => 'CÉDULA DE CLIENTE',
        'E' => 'CLIENTE',
        'F' => 'NÚMERO DE GUÍA',
        'G' => 'CATEGORÍA',
        'H' => 'PESO EN LIBRAS',
        'I' => 'REFERENCIA',
        'J' => 'NUMERO DE SEGUIMIENTO',
        'K' => 'CIUDAD DE ENVÍO',
        'L' => 'PROVINCIA',
        'M' => 'MÉTODO DE ENVÍO',
        'N' => 'DATOS DE ENVÍO',
        'O' => 'CEDULA DE ENVIO',
        'P' => 'TELÉFONO DE ENVIO',
        'Q' => 'FECHA Y HORA DE DESEMBARQUE'
    ];

    protected array $letters = [
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];

    protected int $current_letter_i = 0;
}