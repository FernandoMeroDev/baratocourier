<div
    x-on:changed-waybills.window="$wire.refreshPackages"
>
    <x-fieldset.simple>
        <flux:heading>
            Paquetes Acabados de Embarcar
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
                            @foreach($package->waybills as $waybill)
                                <x-shipments.ship.waybill-shipment
                                    :waybills-count="$package->waybills->count()"
                                    :waybill-number="$waybill->readable_number()"
                                    :loop-last="$loop->last"
                                    :shipment="$shipment->checkWaybill($waybill)"
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
</div>
