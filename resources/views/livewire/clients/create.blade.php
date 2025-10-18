<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registrar Cliente</flux:heading>
            <flux:text class="mt-2">Ingrese a la información de registro de Cliente.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input wire:model="form.name" label="Nombre" maxlength="255" />

            <flux:input wire:model="form.identity_card" label="Cédula" required maxlength="500" />

            <flux:input wire:model="form.phone_number" label="Número de Teléfono" required maxlength="10" />

            <flux:input wire:model="form.residential_address" label="Dirección Residencial" required maxlength="500" />

            <flux:input wire:model="form.email" label="Email" type="email" required maxlength="500" />
        </div>

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Guardar cambios</flux:button>
        </div>
    </form>
</div>
