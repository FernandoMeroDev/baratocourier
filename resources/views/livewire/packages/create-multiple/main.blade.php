<div>
    <form wire:submit="store" class="space-y-6">
        <div>
            <div class="flex items-center">
                <flux:heading size="lg">Registro de Paquetes</flux:heading>

                <a href="{{route('packages.choose-client')}}" class="ml-3">
                    <flux:button icon="arrow-path">Cambiar Cliente</flux:button>
                </a>
            </div>
            <flux:text class="mt-2">Registre paquetes para: <strong>{{$client->completeName()}}</strong>.</flux:text>
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
                    @foreach($shipping_methods as $shipping_method)
                        <flux:select.option value="{{$shipping_method->id}}">
                            {{$shipping_method->name . "($shipping_method->abbreviation)" }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="form.shipping_method_id" />
            </flux:field>

            {{-- Row 3 --}}
            <div class="col-span-2" x-on:address-selected.window="handleAddressSelected($event)">
                <div x-show=" ! shipping_address_visible" class="flex items-center">
                    <flux:button 
                        icon:trailing="arrow-path" 
                        x-on:click="shipping_address_visible = true">
                        Dirección de Envío
                    </flux:button>
                    <p wire:ignore id="current_shipping_address_selected" class="ml-2 font-bold"></p>
                </div>
                <x-fieldset.simple title="Dirección de Envío:" x-show="shipping_address_visible">
                    <livewire:clients.edit.shipping-address.choose.single wire:model="form.shipping_address_id" :$client />
                </x-fieldset.simple>
            </div>

            {{-- Row 4 --}}
            <div class="col-span-2">
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
            </div>

            {{-- Row 5 --}}
            <div 
                x-show="generation_available"
                x-on:generated-packages.window="setPersonalDataVisible(); generation_available = false"
                class="flex items-end col-span-2" placeholder="Número de fracciones..."
            >
                <flux:input label="Número de Fracciones" wire:model="packages_count" />
                <flux:button wire:click.prevent="generatePackages" class="ml-3">
                    Fraccionar Paquete
                </flux:button>
            </div>

            {{-- Row n --}}
            @for($i = 0; $i < $packages_count; $i++)
                <x-fieldset.simple wire:key="{{$i}}" class="col-span-2 pt-10 mt-6 grid grid-cols-2 gap-x-3 gap-y-6">
                    <x-slot:title>
                        <span class="text-3xl font-bold text-[#E2A200]">
                            Fracción {{$i+1}}
                        </span>
                    </x-slot:title>
                    {{-- Price --}}
                    <flux:input 
                        label="Precio de compra del paquete (USD):" placeholder="0.00" icon="currency-dollar" 
                        x-on:change="checkCategoryAviability({{$i}})"
                        wire:model="form.prices.{{$i}}" type="number" required min="0.01" step="0.01" max="99999.99" />
                    
                    {{-- Weight --}}
                    <flux:field>
                        <flux:label>Peso en LB recibido:&nbsp;(<span x-text="weights_kg[{{$i}}]"></span>&nbsp;Kg)</flux:label>

                        <flux:input 
                            placeholder="0.0" 
                            x-on:change="checkCategoryAviability({{$i}})"
                            wire:model="form.weights.{{$i}}" type="number" required min="0.01" step="0.01" max="99999.99" />

                        <flux:error name="form.weights.{{$i}}" />
                    </flux:field>

                    {{-- Personal Data --}}
                    <div class="col-span-2" x-on:person-selected.window="handlePersonSelected($event, {{$i}})">
                        <div x-show=" ! personal_data_visible[{{$i}}]" class="flex items-center">
                            <flux:button 
                                icon:trailing="arrow-path" 
                                x-on:click="personal_data_visible[{{$i}}] = true">
                                Datos Personales
                            </flux:button>
                            <p id="current_person_selected_{{$i}}" class="ml-2 font-bold"></p>
                        </div>
                        <x-fieldset.simple title="Datos Personales:" x-show="personal_data_visible[{{$i}}]">
                            <p x-show=" ! personal_data_enabled[{{$i}}]">Seleccione categoría...</p>
                            <flux:radio.group 
                                wire:model="form.person_types.{{$i}}" variant="segmented"
                                x-show="personal_data_enabled[{{$i}}]"
                                x-on:change="checkPersonTypeSelection($event, {{$i}})"
                            >
                                <flux:radio class="person_type_client" value="client" label="Cliente" />
                                <flux:radio class="person_type_receiver" value="receiver" label="Destinatario" />
                                <flux:radio class="person_type_family_core_member" value="family_core_member" label="Núcleo Familiar" />
                            </flux:radio.group>

                            {{-- Client --}}
                            <div x-show="$wire.form.person_types?.[{{$i}}] == 'client'" id="client-panel" class="mt-3 space-y-3">
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
                            <div x-show="$wire.form.person_types?.[{{$i}}] == 'receiver'" id="receivers-panel">
                                <livewire:clients.edit.receivers.choose.single 
                                    wire:model="form.person_ids.{{$i}}" 
                                    :data="['client' => $client, 'i' => $i]" />
                            </div>
                            {{-- FamilyCoreMembers --}}
                            <div x-show="$wire.form.person_types?.[{{$i}}] == 'family_core_member'" id="family-core-panel">
                                <livewire:clients.edit.family-core-members.choose.single 
                                    wire:model="form.person_ids.{{$i}}" 
                                    :data="['client' => $client, 'i' => $i]" />
                            </div>
                        </x-fieldset.simple>
                    </div>

                    {{-- Items Count --}}
                    <flux:input 
                        label="Cantidad de Items:"  wire:model="form.items_counts.{{$i}}" type="number" 
                        placeholder="0" required min="1" step="1" max="9999" 
                        class="col-span-2"
                    />

                    <flux:field class="col-span-2">
                        <flux:label>Descripción del paquete</flux:label>
                        <flux:description><strong>NOTA:</strong> Detalle del contenido de su paquete, ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume.</flux:description>
                        <flux:textarea 
                            wire:model="form.descriptions.{{$i}}" resize="vertical" 
                            placeholder="Ingrese los detalles de la compra, por ejemplo: blusas, pantalones, pares de zapatos, barbies, perfume." 
                        />
                        <flux:error name="form.descriptions.{{$i}}" />
                    </flux:field>
                </x-fieldset.simple>
            @endfor
        </div>

        <div class="flex">
            <flux:button type="submit" variant="primary">Registrar Paquete</flux:button>

            <flux:spacer />
        </div>

        <flux:error name="form.*" />
    </form>

    @assets @vite(['resources/js/components/packages/create-multiple/main/validator.js']) @endassets
</div>
