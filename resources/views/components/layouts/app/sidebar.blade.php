@use('App\Permissions\Data')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            @canany(Data::$permissions)
            <flux:navlist variant="outline">
                @canany(['packages', 'waybills'])
                <flux:navlist.group 
                    heading="Bodega" expandable class="grid"
                    :expanded="request()->routeIs(['packages.*', 'waybills.*'])"
                >
                    @can('packages')
                    <flux:navlist.item icon="plus" :href="route('packages.create')" :current="request()->routeIs('packages.create')">
                        Registro de Paquetes
                    </flux:navlist.item>
                    @endcan
                    @can('waybills')
                    <flux:navlist.item icon="folder-open" :href="route('waybills.index')" :current="request()->routeIs('waybills.index')">
                        Archivo de Guías
                    </flux:navlist.item>
                    @endcan
                </flux:navlist.group>
                @endcan
                @can('shipments')
                <flux:navlist.group 
                    heading="Embarques" expandable class="grid"
                    :expanded="request()->routeIs(['shipments.*'])"
                >
                    <flux:navlist.item icon="plus" :href="route('shipments.create')" :current="request()->routeIs('shipments.create')">
                        Crear Embarque
                    </flux:navlist.item>
                    <flux:navlist.item icon="folder-open" :href="route('shipments.index')" :current="request()->routeIs('shipments.index')">
                        Archivo de Embarques
                    </flux:navlist.item>
                </flux:navlist.group>
                @endcan
                @can('clients')
                <flux:navlist.group 
                    heading="Clientes" expandable class="grid"
                    :expanded="request()->routeIs(['clients.*'])"
                >
                    <flux:navlist.item icon="plus" :href="route('clients.create')" :current="request()->routeIs('clients.create')">
                        Registro de Clientes
                    </flux:navlist.item>
                    <flux:navlist.item icon="user-circle" :href="route('clients.index')" :current="request()->routeIs('clients.index')">
                        Mis Clientes
                    </flux:navlist.item>
                </flux:navlist.group>
                @endcan
            </flux:navlist>
            @endcanany

            <flux:spacer />

            <flux:navlist variant="outline">
                @can('users')
                <flux:navlist.item icon="user" href="{{route('users.index')}}">
                    Usuarios
                </flux:navlist.item>
                @endcan
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
