@component('mail::message')
# Bonjour
<p>
Vous avez une action (<strong>{{ $step->titre  }}</strong>) à effectuer.
</p>
<p>
@component('mail::button', ['url' => $step_url])
Accéder à l'Action
@endcomponent
</p>

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
