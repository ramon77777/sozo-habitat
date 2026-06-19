@extends('layouts.agent')

@section('content')


<div class="p-8">


    <h1 class="text-4xl font-black text-[#0A2E5D]">
        Mes clients
    </h1>


    <p class="text-slate-500 mt-2">
         Clients qui vous sont affectés
    </p>




    <div class="mt-10 bg-white rounded-3xl shadow p-6">


        <table class="w-full">


            <thead>


                <tr class="border-b text-left">


                    <th class="p-3">
                        Nom
                    </th>


                    <th>
                        Téléphone
                    </th>


                    <th>
                        Email
                    </th>


                    <th>
                        Statut
                    </th>


                </tr>


            </thead>




            <tbody>



            @forelse($prospects as $prospect)



                <tr class="border-b">


                    <td class="p-3 font-bold">

                        {{ $prospect->name }}

                    </td>



                    <td>

                        {{ $prospect->phone }}

                    </td>



                    <td>

                        {{ $prospect->email ?? '-' }}

                    </td>




                    <td>


                        <span class="px-3 py-1 rounded-full bg-slate-100">

                            {{ $prospect->status }}

                        </span>


                    </td>



                </tr>




                @empty


                <tr>

                    <td colspan="4"
                        class="p-5 text-center text-slate-400">

                        Aucun client

                    </td>


                </tr>


            @endforelse



            </tbody>


        </table>


    </div>



    <div class="mt-6">

        {{ $prospects->links() }}

    </div>



</div>


@endsection