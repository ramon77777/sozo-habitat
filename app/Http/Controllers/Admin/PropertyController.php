<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function create()
    {
        return view('admin.properties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'type' => ['required', 'in:villa,duplex,appartement,maison_basse,terrain'],
            'transaction' => ['required', 'in:vente,location'],
            'description' => ['nullable', 'string'],
            'has_acd' => ['nullable', 'boolean'],
            'is_lot_approved' => ['nullable', 'boolean'],
            'document_type' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'max:5120'],
            'gallery_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'property_videos.*' => ['nullable', 'file', 'mimes:mp4,webm,mov,qt', 'max:51200'],
            'featured' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/properties'), $imageName);

            $validated['main_image'] = $imageName;
        }


        $validated['featured'] = $request->boolean('featured');
        $validated['has_acd'] = $request->boolean('has_acd');
        $validated['is_lot_approved'] = $request->boolean('is_lot_approved');

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

        $property = Property::create($validated);

        if ($request->hasFile('gallery_images')) {

            $order = 1;

            foreach ($request->file('gallery_images') as $image) {

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(
                    public_path('images/properties/gallery'),
                    $filename
                );

                $property->images()->create([
                    'image_path' => $filename,
                    'is_main'    => false,
                    'sort_order' => $order++,
                ]);
            }
        }

        if ($request->hasFile('property_videos')) {

            $order = 1;

            foreach ($request->file('property_videos') as $video) {

                $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();

                $video->move(
                    public_path('videos/properties'),
                    $filename
                );

                $property->videos()->create([
                    'video_path' => $filename,
                    'sort_order' => $order++,
                ]);
            }
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bien ajouté avec succès.');
    }


    public function edit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
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
            'type' => ['required', 'in:villa,duplex,appartement,maison_basse,terrain'],
            'transaction' => ['required', 'in:vente,location'],
            'description' => ['nullable', 'string'],
            'has_acd' => ['nullable', 'boolean'],
            'is_lot_approved' => ['nullable', 'boolean'],
            'document_type' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'image', 'max:5120'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'featured' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('main_image')) {
            if ($property->main_image && file_exists(public_path('images/properties/' . $property->main_image))) {
                unlink(public_path('images/properties/' . $property->main_image));
            }

            $image = $request->file('main_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/properties'), $imageName);

            $validated['main_image'] = $imageName;
        }

        $validated['featured'] = $request->boolean('featured');
        $validated['has_acd'] = $request->boolean('has_acd');
        $validated['is_lot_approved'] = $request->boolean('is_lot_approved');

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

        $property->update($validated);

        if ($request->hasFile('property_videos')) {
            $order = $property->videos()->max('sort_order') + 1;

            foreach ($request->file('property_videos') as $video) {
                $filename = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();

                $video->move(
                    public_path('videos/properties'),
                    $filename
                );

                $property->videos()->create([
                    'video_path' => $filename,
                    'sort_order' => $order++,
                ]);
            }
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bien modifié avec succès.');
    }

    public function destroy(Property $property)
    {
        if (
            $property->main_image &&
            file_exists(public_path('images/properties/' . $property->main_image))
        ) {
            unlink(
                public_path('images/properties/' . $property->main_image)
            );
        }

        $property->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Bien supprimé avec succès.');
    }
}