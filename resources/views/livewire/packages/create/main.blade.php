<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <flux:heading size="lg">Registro de Paquete</flux:heading>
        </div>

        <div 
            x-data="validator([
                {id: 1, name: 'B 4X4', code: 'b'},
                {id: 2, name: 'C', code: 'c'},
                {id: 3, name: 'A (documentos) 4X4', code: 'a'},
                {id: 4, name: 'Especial', code: 'special'},
                {id: 5, name: 'G Migrante', code: 'g'},
                {id: 6, name: 'D', code: 'd'},
            ])" 
            class="grid grid-cols-2 gap-x-3 gap-y-6"
        >
            {{-- Row 1 --}}
            <flux:input label="Número de Seguimiento:" placeholder="JSJSN" wire:model="form.tracking_number" maxlength="500" />

            <flux:field>
                <flux:label>Tienda:</flux:label>

                <flux:select wire:model="form.shop_id" required>
                    <flux:select.option value="">Seleccione...</flux:select.option>
                    <flux:select.option value="1">Tienda A</flux:select.option>
                    <flux:select.option value="2">Tienda B</flux:select.option>
                    <flux:select.option value="3">Tienda C</flux:select.option>
                    <flux:select.option value="4">Tienda D</flux:select.option>
                </flux:select>

                <flux:error name="form.shop_id" />
            </flux:field>

            {{-- Row 2 --}}
            <div class="col-span-2">
                <flux:input label="Referencia:" wire:model="form.reference" maxlength="500" />
            </div>

            {{-- Row 3 --}}
            <flux:input 
                label="Precio de compra del paquete (USD):" placeholder="0.00" icon="currency-dollar" 
                x-on:change="checkCategoryAviability()"
                wire:model="form.price" type="number" required min="0.01" step="0.01" max="99999.99" />
            
            <flux:field>
                <flux:label>Peso en LB recibido:&nbsp;(<span x-text="weight_kg"></span>&nbsp;Kg)</flux:label>

                <flux:input 
                    placeholder="0.0" 
                    x-on:change="checkCategoryAviability()"
                    wire:model="form.weight" type="number" required min="0.01" step="0.01" max="99999.99" />

                <flux:error name="form.weight" />
            </flux:field>

            {{-- Row 4 --}}
            <flux:input label="Cantidad de Items:" placeholder="0" wire:model="form.items_count" type="number" required min="1" step="1" max="9999" />

            <flux:field>
                <flux:label>Categoria:</flux:label>

                <flux:select x-on:change="checkPersonTypeAviability($event)" wire:model="form.category_id" required>
                    <flux:select.option value="">Seleccione...</flux:select.option>
                    <flux:select.option id="package_category_b" value="1">B 4X4</flux:select.option>
                    <flux:select.option id="package_category_c" value="2">C</flux:select.option>
                    <flux:select.option id="package_category_a" value="3">A (documentos)</flux:select.option>
                    <flux:select.option id="package_category_special" value="4">Especial</flux:select.option>
                    <flux:select.option id="package_category_g" value="5">G Migrante</flux:select.option>
                    <flux:select.option id="package_category_d" value="6">D</flux:select.option>
                </flux:select>

                <flux:error name="form.shop_id" />
            </flux:field>

            <div class="col-span-2">
                <x-fieldset.simple title="Datos Personales:">
                    <p x-show=" ! personal_data_enabled ">Selecciones categoría...</p>
                    <flux:radio.group 
                        wire:model="form.person_type" variant="segmented"
                        x-show="personal_data_enabled"
                        x-on:change="checkPersonTypeSelection($event)"
                    >
                        <flux:radio id="person_type_client" value="client" label="Cliente" />
                        <flux:radio id="person_type_receiver" value="receiver" label="Destinatario" />
                        <flux:radio id="person_type_family_core_member" value="family_core_member" label="Núcleo Familiar" />
                    </flux:radio.group>

                    {{-- Client --}}
                    <div x-show="$wire.form.person_type == 'client'" id="client-panel" class="mt-3 space-y-3">
                        <a href="{{route('packages.choose-client')}}">
                            <flux:button icon="arrow-path">Cambiar Cliente</flux:button>
                        </a>
                        <div class="grid grid-cols-2 gap-3 mt-3">
                            <flux:input label="Nombres" value="{{$client->name}}" name="client_name" />
                            <flux:input label="Apellidos" value="{{$client->lastname}}" name="client_lastname" />
                        </div>
                        <flux:input label="Cédula" value="{{$client->identity_card}}" name="client_identity_card" />
                        <flux:input label="Teléfono" value="{{$client->phone_number}}" name="client_phone_number" />
                        <flux:input label="Dir. Residencial" value="{{$client->residential_address}}" name="client_residential_address" />
                        <flux:input label="Email" value="{{$client->email}}" name="client_email" />
                    </div>
                    {{-- Receivers --}}
                    <div x-show="$wire.form.person_type == 'receiver'" id="receivers-panel">
                        <livewire:clients.edit.receivers.choose.single wire:model="form.person_id" :$client />
                    </div>
                    {{-- FamilyCoreMembers --}}
                    <div x-show="$wire.form.person_type == 'family_core_member'" id="family-core-panel">
                        <livewire:clients.edit.family-core-members.choose.single wire:model="form.person_id" :$client />
                    </div>
                </x-fieldset.simple>
            </div>

            {{-- Row 6 --}}
            <div class="col-span-2">
                <flux:label>Opciones</flux:label>
                <flux:field variant="inline">
                    <flux:checkbox wire:model="form.individual" />
                    <flux:label>Un solo paquete</flux:label>
                    <flux:error name="form.individual" />
                </flux:field>
            </div>

            {{-- Row 7 --}}
            <flux:field class="col-span-2">
                <flux:label>Descripción del paquete</flux:label>
                <flux:description><strong>NOTA:</strong> Detalle del contenido de su paquete, ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume.</flux:description>
                <flux:textarea 
                    wire:model="form.description" resize="vertical" 
                    placeholder="Ingrese los detalles de la compra, por ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume." 
                />
                <flux:error name="form.individual" />
            </flux:field>
        </div>

        <div class="flex">
            <flux:button type="submit" variant="primary">Registrar Paquete</flux:button>

            <flux:spacer />
        </div>

        <flux:error name="form.*" />
    </form>

    @assets @vite(['resources/js/components/packages/create/main/validator.js']) @endassets
</div>
