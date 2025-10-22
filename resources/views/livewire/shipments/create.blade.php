<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registrar Embarque</flux:heading>
            <flux:text class="mt-2">Ingrese la información del registro del Embarque.</flux:text>
        </div>

        <div class="space-y-2">
            <flux:input 
                label="Fecha de Envío" wire:model="form.shipping_date" type="date" 
                required
                {{-- [TODO] Add Client side validation --}}
            />

            <flux:input label="Referencia" wire:model="form.reference" maxlength="255" />

            <flux:field>
                <flux:label>Tipo</flux:label>

                <flux:select wire:model="form.shipment_type_id" placeholder="Seleccione..." required>
                    @foreach($types as $type)
                        <flux:select.option value="{{$type->id}}">{{$type->name}}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.shipment_type_id" />
            </flux:field>

            <div class="grid grid-cols-2 gap-3">
                <flux:input label="Fecha de Llegada 1" wire:model="form.arrival_min_date" type="date" required />

                <flux:input label="Fecha de Llegada 2" wire:model="form.arrival_max_date" type="date" required />
            </div>
        </div>

        <div class="flex">
            <flux:button type="submit" variant="primary">Registrar Embarque</flux:button>
            
            <flux:spacer />
        </div>
    </form>
</div>
