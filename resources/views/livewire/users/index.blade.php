@use('App\Permissions\Translator')
<div>
    <div class="flex mb-3">
        <flux:input type="text" placeholder="Buscar" wire:model.live="search" class="mr-2" />
        <a href="{{route('users.create-types')}}">
            <flux:button>Nuevo</flux:button>
        </a>
        {{-- <flux:modal.trigger name="create-product">
            <flux:button>Nuevo</flux:button>
        </flux:modal.trigger> --}}
    </div>

    {{-- <livewire:products.create @created="$refresh" /> --}}

    <x-table class="w-full mb-3">
        <x-slot:thead>
            <x-table.th></x-table.th>
            <x-table.th>
                Usuario
            </x-table.th>
            <x-table.th>
                Email
            </x-table.th>
            <x-table.th>
                Roles
            </x-table.th>
        </x-slot:thead>

        @forelse ($users as $user)
            <x-table.tr>
                <td class="w-5 px-3 py-1">
                    <flux:button icon="pencil" x-on:click="$dispatch('edit-user', { user_id: {{$user->id}} })"></flux:button>
                </td>
                <td class="p-3">
                    {{$user->name}}
                </td>
                <td class="p-3">
                    {{$user->email}}
                </td>
                <td class="p-3">
                    @forelse($user->getRoleNames() as $role)
                        {{Translator::role($role) . ', '}}
                    @empty
                        Ninguno...
                    @endforelse
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

    <x-pagination :paginator="$users" />

    {{-- <livewire:products.edit @edited="$refresh" /> --}}
</div>