@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-12 px-6">

    <a
        href="{{ route('admin.property-inquiries.index') }}"
        class="text-[#0A2E5D] font-semibold"
    >
        ← Retour
    </a>

    <h1 class="text-4xl font-black text-[#0A2E5D] mt-4 mb-8">
        Détail de la demande
    </h1>

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <div class="grid md:grid-cols-2 gap-8">

            <div>
                <h3 class="font-bold text-slate-500">
                    Bien concerné
                </h3>

                <p class="text-xl font-bold text-[#0A2E5D] mt-2">
                    {{ $propertyInquiry->property->title }}
                </p>
            </div>

            <div>
                <h3 class="font-bold text-slate-500">
                    Statut
                </h3>

                <p class="mt-2">
                    @if($propertyInquiry->status === 'new')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            Nouveau
                        </span>
                    @else
                        <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-full">
                            Traité
                        </span>
                    @endif
                </p>
            </div>

        </div>

        <hr class="my-8">

        <div class="grid md:grid-cols-2 gap-8">

            <div>
                <h3 class="font-bold text-slate-500">
                    Nom
                </h3>

                <p class="mt-2">
                    {{ $propertyInquiry->name }}
                </p>
            </div>

            <div>
                <h3 class="font-bold text-slate-500">
                    Téléphone
                </h3>

                <p class="mt-2">
                    {{ $propertyInquiry->phone }}
                </p>
            </div>

            <div>
                <h3 class="font-bold text-slate-500">
                    Email
                </h3>

                <p class="mt-2">
                    {{ $propertyInquiry->email ?? 'Non renseigné' }}
                </p>
            </div>

            <div>
                <h3 class="font-bold text-slate-500">
                    Date
                </h3>

                <p class="mt-2">
                    {{ $propertyInquiry->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

        </div>

        <hr class="my-8">

        <div>

            <h3 class="font-bold text-slate-500 mb-3">
                Message
            </h3>

            <div class="bg-slate-50 rounded-2xl p-6">
                {{ $propertyInquiry->message }}
            </div>

        </div>

    </div>

</div>

@endsection