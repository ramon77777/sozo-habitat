@extends('layouts.agent')


@section('content')


<div class="p-8">


<div class="flex justify-between mb-8">

<h1 class="text-3xl font-black text-[#0A2E5D]">
Mes biens
</h1>


<a href="{{ route('agent.properties.create') }}"
class="bg-[#C89B3C] text-white px-6 py-3 rounded-full">

Ajouter un bien

</a>


</div>



<div class="bg-white rounded-3xl shadow p-6">


<table class="w-full">


<thead>

<tr>

<th class="text-left p-3">
Titre
</th>

<th>
Ville
</th>

<th>
Prix
</th>

<th>
Actions
</th>

</tr>

</thead>



<tbody>


@forelse($properties as $property)


<tr class="border-b">


<td class="p-3">
{{ $property->title }}
</td>


<td>
{{ $property->city }}
</td>


<td>
{{ number_format($property->price) }} FCFA
</td>


<td>


<a href="{{ route('agent.properties.edit',$property) }}"
class="text-blue-600">

Modifier

</a>



<form action="{{ route('agent.properties.destroy',$property) }}"
method="POST"
class="inline">

@csrf
@method('DELETE')


<button class="text-red-600 ml-3">

Supprimer

</button>


</form>


</td>


</tr>



@empty

<tr>

<td colspan="4"
class="text-center p-5">

Aucun bien

</td>

</tr>


@endforelse


</tbody>


</table>


</div>


</div>


@endsection