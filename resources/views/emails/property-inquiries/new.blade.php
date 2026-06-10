<x-mail::message>
# Nouvelle demande de visite

Une nouvelle demande de visite a été envoyée depuis Sozo Habitat.

## Bien concerné

**{{ $inquiry->property->title ?? 'Bien supprimé' }}**

## Informations du prospect

**Nom :** {{ $inquiry->name }}

**Téléphone :** {{ $inquiry->phone }}

**Email :** {{ $inquiry->email ?? 'Non renseigné' }}

## Message

{{ $inquiry->message ?? 'Aucun message.' }}

<x-mail::button :url="route('admin.property-inquiries.show', $inquiry)">
Voir la demande
</x-mail::button>

Merci,<br>
{{ config('app.name') }}
</x-mail::message>