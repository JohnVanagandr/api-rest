<x-mail::message>
    # Hola {{ $user->name }}
    Has cambiado tu correo electronico. Por favor verifica la nueva dirección usando el siguiente elace
    <x-mail::button :url="route('verify', $user->verification_token)">
        Confirmar mi cuenta
    </x-mail::button>
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
