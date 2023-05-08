<?php

namespace App\Http\Controllers\Page\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Weeks;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $productData = Weeks::
            get('product_title', 'quanity');

dd($productData);
        return Inertia::render('crud/Dashboard', [
            'productData' => $productData,
        ]);
    }
}
