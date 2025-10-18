<div>
    <form wire:submit="update" class="space-y-6">
        <div>
            <flux:heading size="lg">Editar Dirección de Envío</flux:heading>
            <flux:text class="mt-2">Ingrese la dirección de envío del Cliente.</flux:text>
        </div>

        <div class="space-y-2">
            <x-fieldset.simple title="Enviar a:" class="my-6">
                <flux:input wire:model="form.name" label="Nombres" maxlength="255" />

                <flux:input wire:model="form.lastname" label="Apellidos" maxlength="255" />

                <flux:input wire:model="form.identity_card" label="Cédula" maxlength="30" />

                <flux:input wire:model="form.phone_number" label="Número de Teléfono" maxlength="10" />
            </x-fieldset.simple>

            <flux:input wire:model="form.line_1" label="Dirección" maxlength="255" />

            <flux:input wire:model="form.line_2" label="Referencia" maxlength="255" />

            <flux:field>
                <flux:label>Provincia</flux:label>

                <flux:select wire:model="form.province_id" placeholder="Seleccione...">
                    @foreach($provinces as $province)
                        <flux:select.option value="{{$province->id}}">{{$province->name}}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.state" />
            </flux:field>

            <flux:input wire:model="form.city_name" label="Ciudad" maxlength="255" />

            <flux:input wire:model="form.zip_code" label="Código Postal" required maxlength="20" />
        </div>

        <div class="flex justify-between">
            <flux:button type="submit" variant="primary">Guardar</flux:button>

            <flux:button wire:click="delete" variant="danger">Eliminar</flux:button>
        </div>
    </form>
</div>