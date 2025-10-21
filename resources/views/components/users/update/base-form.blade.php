<div>
    <flux:heading size="lg">Editar Usuario</flux:heading>
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
    placeholder="Nombre Representativo"
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
