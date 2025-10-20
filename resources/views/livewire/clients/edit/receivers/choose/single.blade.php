<div>
    <div class="mb-6">
        <flux:text class="mt-2">Carpeta de destinatarios del Cliente.</flux:text>
    </div>

    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <flux:select title="Seleccione para ordenar y buscar por campo" wire:model.live="search_field" placeholder="Ordenar por...">
            <flux:select.option value="names">Nombres</flux:select.option>
            <flux:select.option value="lastnames">Apellidos</flux:select.option>
            <flux:select.option selected value="identity_card">Cédula</flux:select.option>
        </flux:select>
    </div>

    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Nombres
            </x-table.th>
            <x-table.th>
                Apellidos
            </x-table.th>
            <x-table.th>
                Cédula
            </x-table.th>
        </x-slot:thead>

        @forelse ($receivers as $receiver)
            <x-table.tr>
                <td class="p-3 flex justify-center items-center">
                    <input 
                        x-on:click="$dispatch('person-selected', {
                            name: '{{$receiver->names}} {{$receiver->lastnames}}', 
                            identity_card: '{{$receiver->identity_card}}' 
                        })"
                        wire:model="choosed_id" type="radio" value="{{$receiver->id}}" class="size-5" id="receiver-{{$receiver->id}}" />
                </td>
                <td class="p-3">
                    <label for="receiver-{{$receiver->id}}">
                        {{$receiver->names}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="receiver-{{$receiver->id}}">
                        {{$receiver->lastnames}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="receiver-{{$receiver->id}}">
                        {{$receiver->identity_card}}
                    </label>
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

    <x-pagination :paginator="$receivers" />
</div>
