<div>
    <x-fieldset.simple>
        <flux:heading>
            Guías Adjuntas
        </flux:heading>

        @if($bag)
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
        @else
            <p>
                Ninguna Saca seleccionada...
            </p>
        @endif
    </x-fieldset.simple>
</div>
