<?php

namespace App\Http\Controllers\Shipments;

trait Columns
{
    protected array $columns = [
        'A' => 'ID DE CLIENTE',
        'B' => 'NÚMERO DE SACA',
        'C' => 'NÚMERO DE SEGUIMIENTO',
        'D' => 'NÚMERO DE GUÍA',
        'E' => 'REFERENCIA DEL SERVICIO',
        'F' => 'CEDULA DE REMITENTE',
        'G' => 'NOMBRES Y APELLIDOS REMITENTE',
        'H' => 'CEDULA DE CONSIGNATARIO',
        'I' => 'NOMBRE Y APEPLLIDO DEL CONSIGNATARIO',
        'J' => 'CONTENIDO',
        'K' => 'CANTIDAD DE ITEMS',
        'L' => 'VALOR',
        'M' => 'CIUDAD DE ENVIO',
        'N' => 'METODO DE ENVIO',
        'O' => 'DIRECCION DE ENVIO',
        'P' => 'DATOS DE ENVIO',
        'Q' => 'CEDULA DE ENVIO	',
        'R' => 'CELULAR DE ENVIO',
        'S' => 'FECHA DE EMBARQUE',
        'T' => 'HORA DE EMBARQUE',
        'U' => 'FECHA DE DESEMBARQUE',
        'V' => 'HORA DE DESEMBARQUE',
        'W' => 'ESTADO DE EMBARQUE',
        'X' => 'ESTADO DEL PAQUETE ',
    ];
}