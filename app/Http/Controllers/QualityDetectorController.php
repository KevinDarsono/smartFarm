<?php

namespace App\Http\Controllers;

use App\Models\Land;
use Illuminate\Http\Request;

class QualityDetectorController extends Controller
{
    public function index(Land $land)
    {
        return view('quality-detector.index', compact('land'));
    }
}
