<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Psikolog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $psikologs = Psikolog::with('user')
            ->where('verification_status', 'verified')
            ->take(6)
            ->get();

        $articles = Article::with('author')
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('psikologs', 'articles'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
