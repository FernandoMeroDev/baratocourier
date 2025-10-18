<div>
    <form wire:submit="update" class="space-y-6">
        <div>
            <flux:heading size="lg">Editar Cliente</flux:heading>
            <flux:text class="mt-2">Edite la información del registro de Cliente.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input wire:model="form.name" label="Nombre" maxlength="255" />

            <flux:input wire:model="form.identity_card" label="Cédula" required maxlength="500" />

            <flux:input wire:model="form.phone_number" label="Número de Teléfono" required maxlength="10" />

            <flux:input wire:model="form.residential_address" label="Dirección Residencial" required maxlength="500" />

            <flux:input wire:model="form.email" label="Email" type="email" required maxlength="500" />
        </div>

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Guardar cambios</flux:button>
            
            <flux:button wire:click="delete" variant="danger">Eliminar</flux:button>
        </div>
    </form>

    <hr class="my-10">

    <x-accordion.simple>
        <x-slot:title>
            <div class="flex"><flux:icon.folder class="mr-2" /> Destinatarios</div>
        </x-slot:title>
        <livewire:clients.edit.receivers.index :client="$form->client" />
    </x-accordion.simple>

    <hr class="my-10">

    <x-accordion.simple title="Núcleo Familiar">
        <x-slot:title>
            <div class="flex"><flux:icon.folder class="mr-2" /> Núcleo Familiar</div>
        </x-slot:title>
        <livewire:clients.edit.family-core-members.index :client="$form->client" />
    </x-accordion.simple>

    <hr class="my-10">
</div>
