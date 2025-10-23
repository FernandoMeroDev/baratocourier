@use('App\Models\Shipments\Shipment')

<div>
    <flux:heading size="lg">Embarques</flux:heading>

    <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mt-3" />

    <x-table class="w-full my-3">
        <x-slot:thead>
            <x-table.th>
                Nr. Embarque
            </x-table.th>
            <x-table.th>
                F. Envío
            </x-table.th>
            <x-table.th>
                Embarcado por
            </x-table.th>
            <x-table.th>
                Estado
            </x-table.th>
            <x-table.th>
                Tipo
            </x-table.th>
            <x-table.th>Acciones</x-table.th>
        </x-slot:thead>

        @forelse ($shipments as $shipment)
            <x-table.tr>
                <td class="p-3">
                    {{$shipment->readable_number()}}
                </td>
                <td class="p-3">
                    {{$shipment->shipping_date}}
                </td>
                <td class="p-3">
                    {{$shipment->user->name}}
                </td>
                <td class="p-3">
                    <span
                        @if($shipment->status == Shipment::$valid_statuses['shipment']) class="bg-green-500 text-white p-1 rounded" 
                        @elseif($shipment->status == Shipment::$valid_statuses['unshipment']) class="bg-blue-500 text-white p-1 rounded" 
                        @elseif($shipment->status == Shipment::$valid_statuses['landed']) class="bg-black text-white p-1 rounded" @endif
                    >{{$shipment->status}}</span>
                </td>
                <td class="p-3">
                    {{$shipment->type->name}}
                </td>
                <td class="w-5 px-3 py-1">
                    <div class="flex">
                        <a 
                            @if($shipment->status == Shipment::$valid_statuses['unshipment'])
                                href="{{route('shipments.ship', $shipment->id)}}"
                            @endif
                            class="mr-2"
                        >
                            <flux:button
                                :disabled="$shipment->status != Shipment::$valid_statuses['unshipment']"
                                 variant="filled">Embarcar</flux:button>
                        </a>
                        {{-- <a href="{{route('shipments.edit', $shipment->id)}}"> --}}
                        <a href="#">
                            <flux:button icon="pencil"></flux:button>
                        </a>
                    </a>
                </td>
            </x-table.tr>
        @empty
            <x-table.tr>
                <td></td>
                <td class="p-3">
                    No hay resultados...
                </td>
            </x-table.tr>
        @endforelse
        <x-table.tr>
            <td class="p-3">
                <a href="{{route('shipments.create')}}">
                    <flux:button icon="plus"></flux:button>
                </a>
            </td>
            <td class="p-3">
                Nuevo Registro
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </x-table.tr>
    </x-table>

    <x-pagination :paginator="$shipments" />
</div>