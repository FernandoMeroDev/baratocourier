@use('App\Models\Lands\Land')

<div>
    <flux:heading size="lg">Archivo de Desembarques</flux:heading>

    <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mt-3" />

    <x-table class="w-full my-3">
        <x-slot:thead>
            <x-table.th>
                Nr. Desembarque
            </x-table.th>
            <x-table.th>
                F. Desembarque
            </x-table.th>
            <x-table.th>
                Desembarcado por
            </x-table.th>
            <x-table.th>
                Estado
            </x-table.th>
            <x-table.th>Acciones</x-table.th>
        </x-slot:thead>

        @forelse ($lands as $land)
            <x-table.tr>
                <td class="p-3">
                    {{$land->readable_number()}}
                </td>
                <td class="p-3">
                    {{$land->land_datetime ?? '---------'}}
                </td>
                <td class="p-3">
                    {{$land->user->name}}
                </td>
                <td class="p-3">
                    <span
                        @if($land->status == Land::$valid_statuses['unlanded']) class="bg-blue-500 text-white p-1 rounded" 
                        @elseif($land->status == Land::$valid_statuses['landed']) class="bg-green-500 text-white p-1 rounded" @endif
                    >{{$land->status}}</span>
                </td>
                <td class="w-5 px-3 py-1">
                    <div class="flex">
                        <a 
                            @if($land->status == Land::$valid_statuses['unlanded'])
                                href="{{route('lands.land', $land->id)}}"
                            @endif
                            class="mr-2"
                        >
                            <flux:button
                                :disabled="$land->status != Land::$valid_statuses['unlanded']"
                                 variant="filled">Desembarcar</flux:button>
                        </a>
                        <flux:button 
                            :disabled="$land->status == Land::$valid_statuses['unlanded']"
                            x-on:click="window.open('{{route('lands.land-report', $land->id)}}')"
                            icon="arrow-down-tray" class="mr-2"></flux:button>
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
                <a href="{{route('lands.create')}}">
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

    <x-pagination :paginator="$lands" />
</div>