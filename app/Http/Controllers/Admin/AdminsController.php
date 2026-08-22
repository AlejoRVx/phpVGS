<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\NoticiaRepository;
use App\Services\Admin\DashboardService;
use Illuminate\View\View;

class AdminsController extends Controller
{
    public function __construct(
        private DashboardService $dashboard,
        private NoticiaRepository $noticias
    ) {}

    public function index(): View
    {
        $datos = $this->dashboard->metricas();
        $noticias = $this->noticias->all();

        return view('admin.main', array_merge($datos, compact('noticias')));
    }
}
