<?php

namespace App\Http\Controllers\Shipments;

trait Columns
{
    protected array $columns = [
        'A' => 'NOMBRES Y APELLIDOS CLIENTE',
        'B' => 'CEDULA CLIENTE',
        'C' => 'ID DE CLIENTE',
        'D' => 'NÚMERO DE SACA',
        'E' => 'NÚMERO DE SEGUIMIENTO',
        'F' => 'NÚMERO DE GUÍA',
        'G' => 'REFERENCIA DEL SERVICIO',
        'H' => 'CEDULA DE REMITENTE',
        'I' => 'NOMBRES Y APELLIDOS REMITENTE',
        'J' => 'CEDULA DE CONSIGNATARIO',
        'K' => 'NOMBRE Y APEPLLIDO DEL CONSIGNATARIO',
        'L' => 'CONTENIDO',
        'M' => 'CANTIDAD DE ITEMS',
        'N' => 'VALOR',
        'O' => 'CIUDAD DE ENVIO',
        'P' => 'METODO DE ENVIO',
        'Q' => 'DIRECCION DE ENVIO',
        'R' => 'DATOS DE ENVIO',
        'S' => 'CEDULA DE ENVIO	',
        'T' => 'CELULAR DE ENVIO',
        'U' => 'FECHA DE EMBARQUE',
        'V' => 'HORA DE EMBARQUE',
        'W' => 'FECHA DE DESEMBARQUE',
        'X' => 'HORA DE DESEMBARQUE',
        'Y' => 'ESTADO DE EMBARQUE',
        'Z' => 'ESTADO DEL PAQUETE ',
    ];

    protected array $letters = [
        'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];

    protected int $current_letter_i = 0;
}