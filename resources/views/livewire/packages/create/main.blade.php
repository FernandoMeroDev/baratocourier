<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <div class="flex items-center">
                <flux:heading size="lg">Registro de Paquete</flux:heading>

                <a href="{{route('packages.choose-client')}}" class="ml-3">
                    <flux:button icon="arrow-path">Cambiar Cliente</flux:button>
                </a>
            </div>
            <flux:text class="mt-2">Registre un paquete para: <strong>{{$client->completeName()}}</strong>.</flux:text>
        </div>

        <div 
            x-data="validator({{json_encode($categories)}}, {{$client->id}})" 
            class="grid grid-cols-2 gap-x-3 gap-y-6"
        >
            {{-- Row 1 --}}
            <flux:input label="Número de Seguimiento:" placeholder="JSJSN" wire:model="form.tracking_number" maxlength="500" />

            <flux:field>
                <flux:label>Tienda:</flux:label>

                <flux:select wire:model="form.shop_id" required>
                    <flux:select.option value="">Seleccione...</flux:select.option>
                    @foreach($shops as $shop)
                        <flux:select.option value="{{$shop->id}}">{{$shop->name}}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.shop_id" />
            </flux:field>

            {{-- Row 2 --}}
            <flux:input label="Referencia:" wire:model="form.reference" maxlength="500" />

            <flux:field>
                <flux:label>Método de Envío:</flux:label>

                <flux:select wire:model="form.shipping_method_id" required>
                    <flux:select.option value="">Seleccione...</flux:select.option>
                    <flux:select.option value="1">Método A</flux:select.option>
                    <flux:select.option value="2">Método B</flux:select.option>
                    <flux:select.option value="3">Método C</flux:select.option>
                    <flux:select.option value="4">Método D</flux:select.option>
                </flux:select>

                <flux:error name="form.shipping_method_id" />
            </flux:field>

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
                    @foreach($categories as $category)
                        <flux:select.option id="package_category_{{$category->code}}" value="{{$category->id}}">
                            {{$category->name}}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.category_id" />
            </flux:field>

            <div class="col-span-2" x-on:person-selected.window="handlePersonSelected($event)">
                <div x-show=" ! personal_data_visible" class="flex items-center">
                    <flux:button 
                        icon:trailing="arrow-path" 
                        x-on:click="personal_data_visible = true">
                        Datos Personales
                    </flux:button>
                    <p id="current_person_selected" class="ml-2 font-bold"></p>
                </div>
                <x-fieldset.simple title="Datos Personales:" x-show="personal_data_visible">
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
                            <flux:input label="Nombres" value="{{$client->name}}" readonly name="client_name" />
                            <flux:input label="Apellidos" value="{{$client->lastname}}" readonly name="client_lastname" />
                        </div>
                        <flux:input label="Cédula" value="{{$client->identity_card}}" readonly name="client_identity_card" />
                        <flux:input label="Teléfono" value="{{$client->phone_number}}" readonly name="client_phone_number" />
                        <flux:input label="Dir. Residencial" value="{{$client->residential_address}}" readonly name="client_residential_address" />
                        <flux:input label="Email" value="{{$client->email}}" readonly name="client_email" />
                    </div>
                    {{-- Receivers --}}
                    <div x-show="$wire.form.person_type == 'receiver'" id="receivers-panel">
                        <livewire:clients.edit.receivers.choose.single wire:model="form.person_id" :data="$client" />
                    </div>
                    {{-- FamilyCoreMembers --}}
                    <div x-show="$wire.form.person_type == 'family_core_member'" id="family-core-panel">
                        <livewire:clients.edit.family-core-members.choose.single wire:model="form.person_id" :data="$client" />
                    </div>
                </x-fieldset.simple>
            </div>

            {{-- Row 5 --}}
            <flux:field class="col-span-2">
                <flux:label>Descripción del paquete</flux:label>
                <flux:description><strong>NOTA:</strong> Detalle del contenido de su paquete, ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume.</flux:description>
                <flux:textarea 
                    wire:model="form.description" resize="vertical" 
                    placeholder="Ingrese los detalles de la compra, por ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume." 
                />
                <flux:error name="form.individual" />
            </flux:field>

            {{-- Row 6 --}}
            <div class="col-span-2" x-on:address-selected.window="handleAddressSelected($event)">
                <div x-show=" ! shipping_address_visible" class="flex items-center">
                    <flux:button 
                        icon:trailing="arrow-path" 
                        x-on:click="shipping_address_visible = true">
                        Dirección de Envío
                    </flux:button>
                    <p id="current_shipping_address_selected" class="ml-2 font-bold"></p>
                </div>
                <x-fieldset.simple title="Dirección de Envío:" x-show="shipping_address_visible">
                    <livewire:clients.edit.shipping-address.choose.single wire:model="form.shipping_address_id" :$client />
                </x-fieldset.simple>
            </div>
        </div>

        <div class="flex">
            <flux:button type="submit" variant="primary">Registrar Paquete</flux:button>

            <flux:spacer />
        </div>

        <flux:error name="form.*" />
    </form>

    @assets @vite(['resources/js/components/packages/create/main/validator.js']) @endassets
</div>
