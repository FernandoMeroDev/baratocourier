<div>
    <form wire:submit="update" class="space-y-6">
        <div>
            <flux:heading size="lg">Editar Destinatario</flux:heading>
            <flux:text class="mt-2">Ingrese la información del Destinatario.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input wire:model="form.names" label="Nombres" maxlength="255" />

            <flux:input wire:model="form.lastnames" label="Apellidos" maxlength="255" />

            <flux:input wire:model="form.identity_card" label="Cédula" maxlength="30" />
        </div>

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Guardar</flux:button>

            <flux:button wire:click="delete" variant="danger">Eliminar</flux:button>
        </div>
    </form>
</div>