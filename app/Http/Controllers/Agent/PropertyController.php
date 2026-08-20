<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Services\PropertyMediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function __construct(
        private readonly PropertyMediaService $media
    ) {
    }

    public function index(): View
    {
        $properties = Property::where(
            'user_id',
            auth()->id()
        )
            ->latest()
            ->paginate(10);

        return view(
            'agent.properties.index',
            compact('properties')
        );
    }

    public function create(): View
    {
        return view('agent.properties.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->rules()
        );

        $uploads = $this->extractUploads($validated);
        $validated['user_id'] = $request->user()->id;

        DB::transaction(function () use (
            $validated,
            $uploads,
            $request
        ): void {
            $property = Property::create($validated);

            $this->media->attachUploads(
                $property,
                $request->user(),
                $uploads['main_image'],
                $uploads['gallery_images'],
                $uploads['videos']
            );
        });

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Bien ajouté avec succès.');
    }

    public function edit(
        Request $request,
        Property $property
    ): View {
        $this->media->authorizeProperty(
            $request->user(),
            $property
        );

        $property->load(['images', 'videos']);

        return view(
            'agent.properties.edit',
            compact('property')
        );
    }

    public function update(
        Request $request,
        Property $property
    ): RedirectResponse {
        $this->media->authorizeProperty(
            $request->user(),
            $property
        );

        $validated = $request->validate(
            $this->rules()
        );

        $uploads = $this->extractUploads($validated);

        DB::transaction(function () use (
            $property,
            $validated,
            $uploads,
            $request
        ): void {
            $property->update($validated);

            $this->media->attachUploads(
                $property,
                $request->user(),
                $uploads['main_image'],
                $uploads['gallery_images'],
                $uploads['videos']
            );
        });

        return redirect()
            ->route('agent.properties.index')
            ->with('success', 'Bien modifié avec succès.');
    }

    public function destroy(
        Request $request,
        Property $property
    ): RedirectResponse {
        $this->media->authorizeProperty(
            $request->user(),
            $property
        );

        $this->media->deleteAllForProperty($property);
        $property->delete();

        return back()->with(
            'success',
            'Bien supprimé avec succès.'
        );
    }

    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'surface' => ['nullable', 'numeric', 'min:0'],
            'type' => [
                'required',
                Rule::in([
                    'villa',
                    'duplex',
                    'appartement',
                    'maison_basse',
                    'terrain',
                ]),
            ],
            'transaction' => [
                'required',
                Rule::in(['vente', 'location']),
            ],
            'description' => ['nullable', 'string'],
            'main_image_key' => ['nullable', 'string', 'max:500'],
            'gallery_image_keys' => ['nullable', 'array', 'max:4'],
            'gallery_image_keys.*' => [
                'required',
                'string',
                'max:500',
                'distinct',
            ],
            'property_video_keys' => ['nullable', 'array', 'max:2'],
            'property_video_keys.*' => [
                'required',
                'string',
                'max:500',
                'distinct',
            ],
        ];
    }

    private function extractUploads(array &$validated): array
    {
        $uploads = [
            'main_image' => $validated['main_image_key'] ?? null,
            'gallery_images' => $validated['gallery_image_keys'] ?? [],
            'videos' => $validated['property_video_keys'] ?? [],
        ];

        unset(
            $validated['main_image_key'],
            $validated['gallery_image_keys'],
            $validated['property_video_keys']
        );

        return $uploads;
    }
}