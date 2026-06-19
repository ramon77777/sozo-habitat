<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Property;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create();

        // Accueil
        $sitemap->add(
            Url::create('/')
                ->setPriority(1.0)
        );
        // Liste des biens
        $sitemap->add(
            Url::create('/biens')
                ->setPriority(0.9)
        );

        // Pages des biens
        $properties = Property::latest()->get();

        foreach ($properties as $property) {

            $sitemap->add(
                Url::create(
                    route('properties.show', $property)
                )
                ->setLastModificationDate($property->updated_at)
                ->setPriority(0.8)
            );

        }

        return $sitemap->toResponse(request());
    }
}