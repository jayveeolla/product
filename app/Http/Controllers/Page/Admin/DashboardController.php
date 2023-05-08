<?php

namespace App\Http\Controllers\Page\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Week;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

         $productData = Week::
            get();

        return Inertia::render('Dashboard', [
            'productData' => $productData,
        ]);
    
}
}