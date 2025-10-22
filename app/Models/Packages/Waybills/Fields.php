<?php

namespace App\Models\Packages\Waybills;

class Fields {
    public static array $html = [
        'logo' => '<div class="logo-container">{{logo}}</div>',
        'courier_name' => '<p class="courier-name">{{courier_name}}</p>',
        'address' => '<p class="address">{{address}}</p>',
        'phone_number' => '<p class="phone-number">{{phone_number}}</p>',
        'barcode' => '<div class="barcode">{{barcode}}</div>',
        'guide_domain' => '<p><span class="guide-domain">{{guide_domain}}</span>',
        'waybill_number' => '<span class="waybill-number">{{waybill_number}}</span></p>',
        'waybill_text_reference' => '<p class="waybill-text-reference">{{waybill_text_reference}}</p>',
        'weight' => '<p><span class="weight">Peso: {{weight}} lb</span> |',
        'created_at' => ' <span class="created-at">Fecha: {{created_at}}</span></p>',
        'tracking_number' => '<p class="tracking-number">{{tracking_number}}</p>',
        'reference' => '<p class="reference">{{reference}}</p>',
        'category' => '<p class="category">Ref. SERVICIO: {{category}}</p>',
        'shipping_address' => '<p class="shipping-address">{{shipping_address}}</p>',
        'shipping_method' => '<p><span class="shipping-method">{{shipping_method}}</span> -',
        'client_code' => ' <span class="client-code">{{client_code}}</span></p>',
        'client_name' => '<p class="client-name">{{client_name}}</p>',
    ];
}