<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Sozo Habitat',
                'email' => 'contact@sozohabitat.com',
                'phone_1' => '0787463032',
                'phone_2' => '0787587996',
                'whatsapp' => '2250787463032',
                'address' => 'Côte d’Ivoire',
            ]
        );

        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],

            'email' => ['nullable', 'email', 'max:255'],
            'phone_1' => ['nullable', 'string', 'max:30'],
            'phone_2' => ['nullable', 'string', 'max:30'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],

            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],

            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('logo')) {
            if (
                $settings->logo &&
                file_exists(public_path('images/settings/' . $settings->logo))
            ) {
                unlink(public_path('images/settings/' . $settings->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            $logo->move(public_path('images/settings'), $logoName);

            $validated['logo'] = $logoName;
        }

        $settings->update($validated);

        return redirect()
            ->route('admin.site-settings.edit')
            ->with('success', 'Paramètres du site mis à jour avec succès.');
    }
}