<div>
    <flux:heading size="xl">
        Embarque de EABC000185
    </flux:heading>

    <div class="sm:grid grid-cols-2 gap-4 mt-3 space-y-3">
        <livewire:shipments.ship.bags :$shipment />

        <livewire:shipments.ship.waybills />

        <div class="col-span-2">
            <livewire:shipments.ship.packages :$shipment />
        </div>
    </div>

    <div class="flex my-3">
        <flux:button wire:click="ship" variant="primary">Embarcar</flux:button>

        <flux:spacer />
    </div>

    <div 
        x-data="{ error: false, message: 'Error' }" x-show="error"
        x-on:validation-error.window="
            error = true; 
            message = $event.detail.message; 
            setTimeout(() => error = false, 5000)
        " x-transition class="text-red-500"
    >
        <p x-text="message"></p>
    </div>
</div>
