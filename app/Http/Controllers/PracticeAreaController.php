<?php

namespace App\Http\Controllers;

use App\Support\PracticeAreas;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PracticeAreaController extends Controller
{
    public function show(string $slug): View
    {
        $area = PracticeAreas::find($slug);

        if ($area === null) {
            throw new NotFoundHttpException();
        }

        return view('services.show', [
            'area'  => $area,
            'areas' => PracticeAreas::all(),
        ]);
    }
}
