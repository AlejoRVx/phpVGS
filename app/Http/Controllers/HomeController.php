<?php

namespace App\Http\Controllers;

use App\Repositories\NoticiaRepository;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private NoticiaRepository $noticias) {}

    public function index(): View
    {
        $noticias = $this->noticias->all();
        $topVentas = $this->noticias->topVentas(6);

        return view('main', compact('noticias', 'topVentas'));
    }
}
