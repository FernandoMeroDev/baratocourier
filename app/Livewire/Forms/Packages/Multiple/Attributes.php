<?php

namespace App\Livewire\Forms\Packages\Multiple;

trait Attributes
{
    public $tracking_number = null; // Nullable

    public $shop_id;

    public $reference = null; // Nullable

    public $shipping_method_id;

    public $shipping_address_id;

    public $category_id;

    // Variables for each package
    public $weights = [];

    public $prices = [];

    public $person_types = [];

    public $person_ids = [];

    public $items_counts = [];

    public $descriptions = [];
}
