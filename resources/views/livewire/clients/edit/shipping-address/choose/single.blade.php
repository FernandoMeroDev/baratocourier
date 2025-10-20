<div>
    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
    </div>

    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Dirección
            </x-table.th>
            <x-table.th>
                Enviar a:
            </x-table.th>
            <x-table.th>
                Cédula
            </x-table.th>
            <x-table.th>
                Teléfono
            </x-table.th>
        </x-slot:thead>

        @forelse ($addresses as $address)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <input 
                        x-on:click="$dispatch('address-selected', { address: `{{$address->completeAddress()}}` })"
                        wire:model="choosed_id" type="radio" value="{{$address->id}}" class="size-5" id="adress-{{$address->id}}" />
                </td>
                <td class="p-3">
                    <label for="adress-{{$address->id}}">
                        {{$address->completeAddress()}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="adress-{{$address->id}}">
                        {{$address->target->name. ', ' . $address->target->lastname}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="adress-{{$address->id}}">
                        {{$address->target->identity_card}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="adress-{{$address->id}}">
                        {{$address->target->phone_number}}
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

    <x-pagination :paginator="$addresses" />
</div>
