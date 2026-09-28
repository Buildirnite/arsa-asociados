<?php

namespace App\Http\Controllers;

use App\Support\PracticeAreas;
use App\Support\ServiceAreas;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServiceAreaController extends Controller
{
    public function index(): View
    {
        return view('service-areas.index', [
            'featured' => ServiceAreas::featured(),
            'others' => ServiceAreas::others(),
        ]);
    }

    public function show(string $slug): View
    {
        $area = ServiceAreas::find($slug);

        if ($area === null) {
            throw new NotFoundHttpException();
        }

        return view('service-areas.show', [
            'area' => $area,
            'featured' => ServiceAreas::featured(),
            'practiceAreas' => PracticeAreas::all(),
        ]);
    }
}
