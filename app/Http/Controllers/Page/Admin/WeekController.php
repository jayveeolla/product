<?php

namespace App\Http\Controllers\Page\Admin;

use App\Http\Controllers\Controller;
use App\Models\Week;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WeekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('access week')) {
            return abort(401);
        }

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;

        $weeks = Week::with([])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                    $query->where('week', 'like', '%' . $query_string . '%')
                        ->orWhere('size', 'like', '%' . $query_string . '%')
                        ->orWhere('gender', 'like', '%' . $query_string . '%')
                        ->orWhere('weeks_to_go', 'like', '%' . $query_string . '%')
                        ->orWhere('description', 'like', '%' . $query_string . '%');
                }
            })
            ->paginate($perPage);

        return Inertia::render('crud/Product/Index', [
            'weeks' => $weeks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('create week')) {
            return abort(401);
        }

        return Inertia::render('crud/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *https://www.postman.com/collections/07d38475f61f8b343d3b
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('view week')) {
            return abort(401);
        }

        return Inertia::render('crud/Product/Show', [
            'week' => Week::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (!auth()->user()->can('edit week')) {
            return abort(401);
        }

        return Inertia::render('crud/Product/Edit', [
            'week' => Week::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function duplicate(Request $request, $id)
    {
        return Inertia::render('crud/Product/Duplicate', [
            'week' => Week::find($id)
        ]);
    }
}
