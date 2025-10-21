<?php

namespace App\Livewire\Forms\Users\Franchisee;

trait Attributes
{
    public $phone_number = '';

    public $courier_name = '';

    public $logo = null;

    // Address
    public $address_line = '';

    public $state = '';

    public $city = '';

    public $zip_code = '';
    
    public $guide_domain = '';

    public $client_domain = '';

    public $waybill_text_reference = '';
}
