<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registrar Destinatario</flux:heading>
            <flux:text class="mt-2">Ingrese la información del destinatario.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input wire:model="form.names" label="Nombres" maxlength="255" />

            <flux:input wire:model="form.lastnames" label="Apellidos" maxlength="255" />

            <flux:input wire:model="form.identity_card" label="Cédula" maxlength="30" />
        </div>

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</div>