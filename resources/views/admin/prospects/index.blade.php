@extends('layouts.app')

@section('content')

<section class="min-h-screen bg-[#F8F9FB] px-6 py-10">

    <div class="max-w-7xl mx-auto">


        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-10">

            <div>
                <p class="text-[#C89B3C] font-bold uppercase tracking-[0.3em]">
                    Administration
                </p>

                <h1 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    Gestion des clients potentiels
                </h1>
            </div>


            <a href="{{ route('admin.dashboard') }}"
               class="rounded-full border border-[#0A2E5D] px-6 py-3 font-bold text-[#0A2E5D] hover:bg-[#0A2E5D] hover:text-white transition">

                Retour dashboard

            </a>


        </div>



        {{-- ALERTS --}}

        @if(session('success'))

            <div class="mb-6 rounded-2xl bg-green-50 border border-green-200 p-5 text-green-700">
                {{ session('success') }}
            </div>

        @endif



        {{-- STATISTIQUES --}}

        <div class="grid md:grid-cols-5 gap-6 mb-10">


            <div class="bg-white rounded-3xl shadow p-6">
                <p class="text-slate-500">
                    Total
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $totalProspects }}
                </h2>
            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Nouveaux
                </p>

                <h2 class="text-4xl font-black text-green-600 mt-3">
                    {{ $newProspects }}
                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Contactés
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $contactedProspects }}
                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Visites
                </p>

                <h2 class="text-4xl font-black text-[#C89B3C] mt-3">
                    {{ $visitProspects }}
                </h2>

            </div>



            <div class="bg-white rounded-3xl shadow p-6">

                <p class="text-slate-500">
                    Convertis
                </p>

                <h2 class="text-4xl font-black text-[#0A2E5D] mt-3">
                    {{ $convertedProspects }}
                </h2>

            </div>


        </div>




        {{-- FILTRES --}}


        <div class="bg-white rounded-3xl shadow p-6 mb-8">


            <form method="GET"
                  action="{{ route('admin.prospects.index') }}"
                  class="flex flex-col md:flex-row gap-4">


                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nom, téléphone ou email..."
                    class="flex-1 rounded-2xl border border-slate-200 px-5 py-4"
                >



                <select
                    name="status"
                    class="rounded-2xl border border-slate-200 px-5 py-4">


                    <option value="">
                        Tous les statuts
                    </option>

                    <option value="nouveau"
                    @selected(request('status') === 'nouveau')>
                        Nouveau
                    </option>


                    <option value="contacte"
                    @selected(request('status') === 'contacte')>
                        Contacté
                    </option>


                    <option value="visite"
                    @selected(request('status') === 'visite')>
                        Visite
                    </option>


                    <option value="negociation"
                    @selected(request('status') === 'negociation')>
                        Négociation
                    </option>


                    <option value="converti"
                    @selected(request('status') === 'converti')>
                        Converti
                    </option>


                    <option value="perdu"
                    @selected(request('status') === 'perdu')>
                        Perdu
                    </option>


                </select>



                <button
                    type="submit"
                    class="rounded-2xl bg-[#0A2E5D] px-8 py-4 font-bold text-white hover:bg-[#071F3F] transition">

                    Rechercher

                </button>


            </form>


        </div>





        {{-- TABLEAU --}}


        <div class="bg-white rounded-3xl shadow overflow-hidden">


            <div class="overflow-x-auto">


                <table class="w-full text-left">


                    <thead class="bg-slate-50 text-[#0A2E5D]">


                        <tr>

                            <th class="p-5">
                                Nom
                            </th>

                            <th class="p-5">
                                Contact
                            </th>

                            <th class="p-5">
                                Bien
                            </th>

                            <th class="p-5">
                                Statut
                            </th>

                            <th class="p-5">
                                Date
                            </th>

                            <th class="p-5">
                                Action
                            </th>


                        </tr>


                    </thead>




                    <tbody>


                    @forelse($prospects as $prospect)


                        <tr class="border-t border-slate-100">


                            <td class="p-5 font-bold text-[#0A2E5D]">

                                {{ $prospect->name }}

                            </td>



                            <td class="p-5 text-slate-600">


                                <div>
                                    {{ $prospect->phone }}
                                </div>

                                <div>
                                    {{ $prospect->email }}
                                </div>


                            </td>




                            <td class="p-5">


                                @if($prospect->property)

                                    <a href="{{ route('properties.show',$prospect->property) }}"
                                       class="font-bold text-[#0A2E5D]">

                                        {{ $prospect->property->title }}

                                    </a>


                                @else

                                    -

                                @endif


                            </td>




                            <td class="p-5">


                                <form method="POST"
                                      action="{{ route('admin.prospects.update-status',$prospect) }}"


                                    @csrf

                                    @method('PATCH')


                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-xl border border-slate-200 px-3 py-2">


                                        @foreach([
                                            'nouveau'=>'Nouveau',
                                            'contacte'=>'Contacté',
                                            'visite'=>'Visite',
                                            'negociation'=>'Négociation',
                                            'converti'=>'Converti',
                                            'perdu'=>'Perdu'
                                        ] as $key=>$label)


                                            <option value="{{ $key }}"
                                            @selected($prospect->status === $key)>

                                                {{ $label }}

                                            </option>


                                        @endforeach


                                    </select>


                                </form>


                            </td>




                            <td class="p-5 text-slate-600">


                                {{ $prospect->created_at->format('d/m/Y') }}


                            </td>




                            <td class="p-5">


                                <a href="tel:{{ $prospect->phone }}"
                                   class="font-bold text-green-700">

                                    Appeler

                                </a>


                            </td>


                        </tr>



                    @empty


                        <tr>

                            <td colspan="6"
                                class="p-8 text-center text-slate-500">

                                Aucun prospect trouvé.

                            </td>


                        </tr>


                    @endforelse



                    </tbody>


                </table>



            </div>




            <div class="p-6 border-t border-slate-100">

                {{ $prospects->links() }}

            </div>



        </div>



    </div>


</section>


@endsection