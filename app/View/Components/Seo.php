<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    public $title;
    public $description;
    public $image;

    public function __construct(
        $title = null,
        $description = null,
        $image = null
    ) {
        $this->title = $title ?? 'Sozo Habitat - Immobilier en Côte d\'Ivoire';

        $this->description = $description ?? 
            'Sozo Habitat vous accompagne dans vos projets immobiliers en Côte d\'Ivoire : achat, vente et location de biens immobiliers.';

        $this->image = $image ?? asset('images/logo.png');
    }

    public function render(): View|Closure|string
    {
        return view('components.seo');
    }
}