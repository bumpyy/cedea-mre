<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;

class Nav extends Component
{
    public $nav_items;

    public $locale;

    public $brands;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->locale = App::currentLocale();

        // * TYPE DOC
        // * [label : string
        // *  route : string | route
        // *  disable : boolean
        // *  submenu : [
        // *         label : string
        // *         route : string | route
        // *         submenu: [
        // *             label : string
        // *             route : string | route
        // *         ][]
        // *     ][]
        // * ][]
        $this->nav_items = [
            [
                'label' => 'Masuk',
                'route' => route('login'),
                'disable' => false,
                'submenu' => [],
            ],

        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
