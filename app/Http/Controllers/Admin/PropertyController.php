<?php

namespace App\Http\Controllers\Admin;

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

    public function create(): View
    {
        return view('admin.properties.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->rules()
        );

        $uploads = $this->extractUploads($validated);
        $propertyData = $this->preparePropertyData(
            $validated,
            $request
        );

        DB::transaction(function () use (
            $propertyData,
            $uploads,
            $request
        ): void {
            $property = Property::create($propertyData);

            $this->media->attachUploads(
                $property,
                $request->user(),
                $uploads['main_image'],
                $uploads['gallery_images'],
                $uploads['videos']
            );
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bien ajouté avec succès.');
    }

    public function edit(Property $property): View
    {
        $property->load(['images', 'videos']);

        return view(
            'admin.properties.edit',
            compact('property')
        );
    }

    public function update(
        Request $request,
        Property $property
    ): RedirectResponse {
        $validated = $request->validate(
            $this->rules()
        );

        $uploads = $this->extractUploads($validated);
        $propertyData = $this->preparePropertyData(
            $validated,
            $request
        );

        DB::transaction(function () use (
            $property,
            $propertyData,
            $uploads,
            $request
        ): void {
            $property->update($propertyData);

            $this->media->attachUploads(
                $property,
                $request->user(),
                $uploads['main_image'],
                $uploads['gallery_images'],
                $uploads['videos']
            );
        });

        return redirect()
            ->route('admin.dashboard')
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

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bien supprimé avec succès.');
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
            'surface' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'living_rooms' => ['nullable', 'integer', 'min:0'],
            'kitchens' => ['nullable', 'integer', 'min:0'],
            'garages' => ['nullable', 'integer', 'min:0'],
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
            'has_acd' => ['nullable', 'boolean'],
            'is_lot_approved' => ['nullable', 'boolean'],
            'document_type' => ['nullable', 'string', 'max:255'],
            'featured' => ['nullable', 'boolean'],
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

    private function preparePropertyData(
        array $validated,
        Request $request
    ): array {
        $validated['featured'] = $request->boolean('featured');
        $validated['has_acd'] = $request->boolean('has_acd');
        $validated['is_lot_approved'] = $request->boolean(
            'is_lot_approved'
        );

        if ($validated['type'] === 'terrain') {
            $validated['bedrooms'] = null;
            $validated['bathrooms'] = null;
            $validated['living_rooms'] = null;
            $validated['kitchens'] = null;
            $validated['garages'] = null;
        } else {
            $validated['has_acd'] = false;
            $validated['is_lot_approved'] = false;
            $validated['document_type'] = null;
        }

        return $validated;
    }
}