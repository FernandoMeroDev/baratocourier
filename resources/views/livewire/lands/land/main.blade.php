<div>
    <x-fieldset.simple>
        <flux:heading>
            Guías Adjuntas
        </flux:heading>

        <div class="mt-3">
            <x-table>
                <x-slot:thead>
                    <x-table.th>
                        Número de Guía
                    </x-table.th>
                    <x-table.th>
                        Consignatario
                    </x-table.th>
                    <x-table.th>
                        Número de Tracking
                    </x-table.th>
                    <x-table.th></x-table.th>
                </x-slot:thead>
                @forelse($waybills as $waybill)
                    <x-table.tr wire:key="waybill-{{$waybill->id}}">
                        <td class="p-3">
                            {{$waybill->readable_number()}}
                        </td>
                        <td class="p-3">
                            {{
                                'CI: ' . $waybill->personalData->identity_card
                                . ', ' . $waybill->personalData->name 
                                . ' ' . $waybill->personalData->lastname
                            }}
                        </td>
                        <td class="p-3">
                            {{$waybill->package->tracking_number ?? 'Ninguno'}}
                        </td>
                        <td class="w-5 px-3 py-1">
                            <flux:button wire:click="removeWaybill({{$waybill->id}})" icon="trash"></flux:button>
                        </td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <td class="p-3">No hay Guías en la saca...</td>
                    </x-table.tr>
                @endforelse
            </x-table>
        </div>
        <div class="mt-6">
            <flux:input 
                wire:model="waybill_id"
                placeholder="Ej: BC001556" class="col-span-2"
                x-data="{
                    add(event) {
                        event.target.focus();
                        event.target.value = null;
                        $wire.addWaybill();
                    }
                }" name="barcode" x-on:change="add($event)"
            />
        </div>
        <div>
            <flux:error name="waybill_id" />
        </div>
    </x-fieldset.simple>

    <x-fieldset.simple>
        <flux:heading>
            Paquetes por de Desembarcar
        </flux:heading>

        <div class="mt-3">
            <x-table>
                <x-slot:thead>
                    <x-table.th>
                        Guías
                    </x-table.th>
                    <x-table.th>
                        Número de Tracking
                    </x-table.th>
                    <x-table.th>
                        Referencia de Servicio
                    </x-table.th>
                    <x-table.th>
                        Cliente
                    </x-table.th>
                </x-slot:thead>
                @forelse($packages as $package)
                    <x-table.tr wire:key="package-{{$package->id}}">
                        <td class="p-3">
                            @foreach($package->waybillsInBag() as $waybill)
                                <x-shipments.land.waybill-number
                                    :waybills-count="$package->waybills->count()"
                                    :waybill-number="$waybill->readable_number()"
                                    :loop-last="$loop->last"
                                    :landed="$waybills->contains($waybill)"
                                />
                            @endforeach
                        </td>
                        <td class="p-3">
                            {{$package->tracking_number ?? 'Ninguno'}}
                        </td>
                        <td class="p-3">
                            {{$package->category->name}}
                        </td>
                        <td class="p-3">
                            {{
                                'CI: ' . $package->client_identity_card
                                . ', ' . $package->client_name 
                                . ' ' . $package->client_lastname
                            }}
                        </td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <td class="p-3">No hay Paquetes...</td>
                    </x-table.tr>
                @endforelse
            </x-table>
        </div>
    </x-fieldset.simple>

    <div class="flex my-3">
        <flux:button wire:click="makeLand" variant="primary">Desembarcar</flux:button>

        <flux:spacer />
    </div>

    <div 
        x-data="{ error: false, message: 'Error' }" x-show="error"
        x-on:validation-error.window="
            error = true; 
            message = $event.detail.message; 
            setTimeout(() => error = false, 5000)
        " x-transition class="text-red-500"
    >
        <p x-text="message"></p>
    </div>
</div>
