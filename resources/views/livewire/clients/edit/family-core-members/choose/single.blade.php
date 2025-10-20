<div>
    <div class="mb-6">
        <flux:text class="mt-2">Carpeta de núcleo familiar del Cliente.</flux:text>
    </div>

    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <flux:select title="Seleccione para ordenar y buscar por campo" wire:model.live="search_field" placeholder="Ordenar por...">
            <flux:select.option value="names">Nombres</flux:select.option>
            <flux:select.option value="lastnames">Apellidos</flux:select.option>
            <flux:select.option selected value="identity_card">Cédula</flux:select.option>
            <flux:select.option selected value="last_use_at">Último uso</flux:select.option>
        </flux:select>
    </div>

    <x-table class="w-full mb-3" x-on:family-core-member-selected.window="$wire.memberSelected($event.detail.member_id)">
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
            <x-table.th>
                Último uso
            </x-table.th>
        </x-slot:thead>

        @forelse ($members as $member)
            @php $id_suffix = isset($i) ? ($member->id . '-' . $i) : $member->id @endphp
            <x-table.tr>
                <td class="p-3 flex justify-center items-center">
                    <input 
                        x-on:change="$dispatch('person-selected', {
                            name: '{{$member->completeName()}}', 
                            identity_card: '{{$member->identity_card}}'
                            {{isset($i) ? (', i: '. $i) : null}}
                        }); $dispatch('family-core-member-selected', {
                            member_id: {{$member->id}}
                        })"
                        wire:model="choosed_id" type="radio" value="{{$member->id}}" class="size-5" id="family-core-member-{{$id_suffix}}" />
                </td>
                <td class="p-3">
                    <label for="family-core-member-{{$id_suffix}}">
                        {{$member->names}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="family-core-member-{{$id_suffix}}">
                        {{$member->lastnames}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="family-core-member-{{$id_suffix}}">
                        {{$member->identity_card}}
                    </label>
                </td>
                <td class="p-3">
                    <label for="family-core-member-{{$id_suffix}}">
                        {{$member->last_use_at ?? 'Nunca'}}
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

    <x-pagination :paginator="$members" :id-suffix="'-'.$i" />
</div>
