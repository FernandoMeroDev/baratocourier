<div>
    <flux:heading size="lg">Archivo de Guías</flux:heading>

    <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mt-3" />

    <x-table class="w-full my-3">
        <x-slot:thead>
            <x-table.th>
                Fecha
            </x-table.th>
            <x-table.th>
                N. Guía
            </x-table.th>
            <x-table.th>
                Peso
            </x-table.th>
            <x-table.th>
                Creado por
            </x-table.th>
            <x-table.th>
                Acciones
            </x-table.th>
        </x-slot:thead>

        @forelse ($waybills as $waybill)
            <x-table.tr>
                <td class="p-3">
                    {{-- {{date('Y-m-d H:i:s', )}} --}}
                    {{$waybill->package->created_at}}
                </td>
                <td class="p-3 text-blue-500 underline">
                    {{$waybill->readable_number()}}
                </td>
                <td class="p-3">
                    {{$waybill->weight}} Lb
                </td>
                <td class="p-3">
                    {{$waybill->package->user->name}}
                </td>
                <td class="w-5 px-3 py-1">
                    <div class="flex">
                        <a href="#" class="mr-2">
                            <flux:button icon="pencil"></flux:button>
                        </a>
                        <a href="#">
                            <flux:button icon="trash" variant="danger"></flux:button>
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
    </x-table>

    <x-pagination :paginator="$waybills" />
</div>