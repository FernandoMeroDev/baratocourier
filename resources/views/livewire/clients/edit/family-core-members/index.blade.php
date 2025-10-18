<div>
    <div class="mb-6">
        <flux:text class="mt-2">Carpeta de núcleo familiar del Cliente.</flux:text>
    </div>

    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <flux:select title="Seleccione para ordenar y buscar por campo" wire:model.live="search_field" placeholder="Seleccione Campo...">
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

        @forelse ($members as $member)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <flux:button icon="pencil" x-on:click="$dispatch('edit-family-core-member', { id: {{$member->id}} })"></flux:button>
                </td>
                <td class="p-3">
                    {{$member->names}}
                </td>
                <td class="p-3">
                    {{$member->lastnames}}
                </td>
                <td class="p-3">
                    {{$member->identity_card}}
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
                <flux:button x-on:click="$flux.modal('create-family-core-member').show()" icon="plus"></flux:button>
            </td>
            <td class="p-3">
                Nuevo Registro
            </td>
            <td></td>
        </x-table.tr>
    </x-table>

    <x-pagination :paginator="$members" />

    <flux:modal 
        name="create-family-core-member"  class="md:w-96"
        x-on:created-family-core-member.window="$wire.$refresh(); $flux.modal('create-family-core-member').close()"
    >
        <livewire:clients.edit.family-core-members.create :$client />
    </flux:modal>

    <flux:modal 
        name="edit-family-core-member"  class="md:w-96"
        x-on:edited-family-core-member.window="$wire.$refresh(); $flux.modal('edit-family-core-member').close()"
        x-on:deleted-family-core-member.window="$wire.$refresh(); $flux.modal('edit-family-core-member').close()"
        x-on:edit-family-core-member.window="$flux.modal('edit-family-core-member').show()"
    >
        <livewire:clients.edit.family-core-members.edit :$client />
    </flux:modal>
</div>

