<div>
    <flux:heading size="lg">Registrar Usuario</flux:heading>
    <flux:text class="mt-2">Ingrese a la información del usuario.</flux:text>
</div>

<!-- Name -->
<flux:input
    wire:model="form.name"
    :label="__('Name')"
    type="text"
    required
    autofocus
    autocomplete="name"
    :placeholder="__('Full name')"
/>

<!-- Email Address -->
<flux:input
    wire:model="form.email"
    :label="__('Email address')"
    type="email"
    required
    autocomplete="email"
    placeholder="email@example.com"
/>

<!-- Password -->
<flux:input
    wire:model="form.password"
    :label="__('Password')"
    type="password"
    required
    autocomplete="new-password"
    :placeholder="__('Password')"
    viewable
/>

<!-- Confirm Password -->
<flux:input
    wire:model="form.password_confirmation"
    :label="__('Confirm password')"
    type="password"
    required
    autocomplete="new-password"
    :placeholder="__('Confirm password')"
    viewable
/>

{{-- <flux:field>
    <flux:label>Rol</flux:label>

    <flux:select wire:model="form.role" placeholder="Seleccione...">
        @foreach($roles as $role)
            <flux:select.option :selected="true" value="{{$role->name}}">
                {{Translator::role($role->name)}}
            </flux:select.option>
        @endforeach
    </flux:select>

    <flux:error name="form.role" />
</flux:field> --}}