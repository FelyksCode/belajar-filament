<?php

namespace App\Http\Controllers;

use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $homepageSections = HomepageSection::visible()->ordered()->get();

        $sections = $homepageSections->map(function ($section) {
            return [
                'id' => $section->slug,
                'title' => $section->name,
                'recipes' => $section->getRecipes(),
                'visible' => $section->visible,
                'order' => $section->order,
            ];
        });

        return view('home', compact('sections'));
    }
}
