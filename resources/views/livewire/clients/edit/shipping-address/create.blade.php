<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registrar Dirección de Envío</flux:heading>
            <flux:text class="mt-2">Ingrese la dirección de envío del Cliente.</flux:text>
        </div>

        <div class="space-y-2">
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

        <div class="flex">
            <flux:spacer />

            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</div>