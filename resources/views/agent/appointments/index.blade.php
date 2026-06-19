@extends('layouts.agent')

@section('content')

<div class="p-8">


<h1 class="text-3xl font-black text-[#0A2E5D]">
Mes rendez-vous
</h1>

<p class="text-slate-500 mt-2">
Demandes de visite reçues sur mes biens
</p>



<div class="mt-10 bg-white rounded-3xl shadow p-6">


<table class="w-full">

<thead>

<tr class="border-b text-left">

<th class="p-3">
Client
</th>

<th>
Téléphone
</th>

<th>
Bien
</th>

<th>
Date
</th>

</tr>

</thead>



<tbody>


@forelse($appointments as $appointment)


<tr class="border-b">


<td class="p-3 font-bold">

{{ $appointment->name }}

</td>


<td>

{{ $appointment->phone }}

</td>


<td>

{{ $appointment->property->title ?? '-' }}

</td>


<td>

{{ $appointment->created_at->format('d/m/Y') }}

</td>


</tr>


@empty


<tr>

<td colspan="4"
class="p-5 text-center text-slate-400">

Aucun rendez-vous

</td>

</tr>


@endforelse


</tbody>


</table>


</div>


</div>


@endsection