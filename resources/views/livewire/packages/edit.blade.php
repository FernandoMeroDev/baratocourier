<div>
    <flux:heading class="mb-2" size="lg">Editar Paquete</flux:heading>
        
    <flux:text class="mb-3">Actualize la información del paquete.</flux:text>

    <form wire:submit="update" class="grid grid-cols-2 gap-3">
        <flux:input 
            name="status"
            label="Estado (no editable)"
            value="{{$package->status}}"
            disabled
        />

        <flux:field>
            <flux:label>Referencia de Servicio (no editable)</flux:label>

            <flux:select wire:model="form.category_id" disabled>
                <flux:select.option value="">Seleccione...</flux:select.option>
                @foreach($categories as $category)
                    <flux:select.option value="{{$category->id}}">{{$category->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:error name="form.category_id" />
        </flux:field>

        <flux:input 
            wire:model="form.tracking_number"
            label="Número de Seguimiento"
        />

        <flux:input 
            wire:model="form.referencia"
            label="Referencia"
        />

        <flux:field>
            <flux:label>Tienda</flux:label>

            <flux:select wire:model="form.shop_id" required>
                <flux:select.option value="">Seleccione...</flux:select.option>
                @foreach($shops as $shop)
                    <flux:select.option value="{{$shop->id}}">{{$shop->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:error name="form.shop_id" />
        </flux:field>

        <flux:field>
            <flux:label>Método de Envío</flux:label>

            <flux:select wire:model="form.shipping_method_id" required>
                <flux:select.option value="">Seleccione...</flux:select.option>
                @foreach($shipping_methods as $shipping_method)
                    <flux:select.option value="{{$shipping_method->id}}">{{$shipping_method->name}}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:error name="form.shipping_method_id" />
        </flux:field>

        <x-fieldset.simple title="Dirección de entrega:" class="space-y-3 my-3 col-span-2">
            <flux:input wire:model="form.line_1" label="Dirección" maxlength="255" />

            <flux:input wire:model="form.line_2" label="Referencia" maxlength="255" />

            <flux:field>
                <flux:label>Provincia</flux:label>

                <flux:select wire:model="form.province_name" placeholder="Seleccione...">
                    @foreach($provinces as $province)
                        <flux:select.option value="{{$province->name}}">{{$province->name}}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.province_name" />
            </flux:field>

            <flux:input wire:model="form.city_name" label="Ciudad" maxlength="255" />

            <flux:input wire:model="form.zip_code" label="Código Postal" required maxlength="20" />
        </x-fieldset.simple>

        <x-fieldset.simple title="Enviar a:" class="space-y-3 my-3 col-span-2">
            <flux:input wire:model="form.name" label="Nombres" maxlength="255" />

            <flux:input wire:model="form.lastname" label="Apellidos" maxlength="255" />

            <flux:input wire:model="form.identity_card" label="Cédula" maxlength="30" />

            <flux:input wire:model="form.phone_number" label="Número de Teléfono" maxlength="10" />
        </x-fieldset.simple>

        {{-- Para las guías --}}
        {{-- <flux:input 
            wire:model="form.items_count"
            label="Número de Items"
            type="number" min="1" step="1" max="9999"
        />

        <flux:input 
            wire:model="form.price"
            label="Valor"
            type="number" min="0.01" step="0.01" max="9999.99"
        />

        <flux:input 
            wire:model="form.weight"
            label="Valor"
            type="number" min="0.01" step="0.01" max="9999.99"
        /> --}}

        <div class="flex justify-between col-span-2">
            <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>

            <flux:button wire:click="delete" variant="danger">Eliminar</flux:button>
        </div>

        <flux:error name="form.*" />
    </form>
</div>
