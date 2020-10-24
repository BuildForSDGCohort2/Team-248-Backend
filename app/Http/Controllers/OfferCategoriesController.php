<?php

namespace App\Http\Controllers;

use App\Services\RetrieveCategoriesService;
use Illuminate\Http\Request;

class OfferCategoriesController extends Controller
{

    public function index(Request $request, RetrieveCategoriesService $service)
    {
        return $service->execute();
    }
}
