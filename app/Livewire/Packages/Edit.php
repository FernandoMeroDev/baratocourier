<?php

namespace App\Livewire\Packages;

use App\Livewire\Forms\Packages\UpdateForm;
use App\Models\Packages\Category;
use App\Models\Packages\Package;
use App\Models\Packages\ShippingMethod;
use App\Models\Province;
use App\Models\Shop;
use Livewire\Component;

class Edit extends Component
{
    public Package $package;

    public UpdateForm $form;

    public function mount(Package $package)
    {
        $this->package = $package;
        $this->form->setPackage($package);
    }

    public function render()
    {
        return view('livewire.packages.edit', [
            'shops' => Shop::all(),
            'shipping_methods' => ShippingMethod::all(),
            'categories' => Category::all(),
            'provinces' => Province::all()
        ]);
    }

    public function update()
    {
        $this->form->update();
    }

    public function delete()
    {
        // dump('Deleted');
    }
}
