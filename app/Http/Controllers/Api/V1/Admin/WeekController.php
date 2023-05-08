<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreWeekRequest;
use App\Http\Requests\Admin\UpdateWeekRequest;
use App\Models\Week;
use Illuminate\Http\Request;
use App\Http\Resources\Week as WeekResource;
use App\Models\Babies;
use Illuminate\Support\Str;

class WeekController extends Controller
{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('access week')) return abort(401);
        $sort = explode('.', $request->input('sort', 'id'));
        $order = $request->input('order', 'asc');

        $perPage = $request->has('perPage') ? $request->input('perPage') : 10;
        $user = auth()->user();
        $weeks = Week::with([])
            ->where(function ($query) use ($request) {
                if ($request->has('query')) {
                    $query_string = $request->input('query');
                    $query->where('product_title', 'like', '%' . $query_string . '%')
                        ->orWhere('price', 'like', '%' . $query_string . '%')
                        
                        ->orWhere('quanity', 'like', '%' . $query_string . '%')
                        ->orWhere('sku', 'like', '%' . $query_string . '%');
                       
                }
            })
            ->when(count($sort) >= 2, function ($query)  use ($sort, $order) {
                if ($sort[0] != 'contact') {
                    $className = 'App\\Models\\' . Str::ucfirst($sort[0]);
                    $table = Str::plural($sort[0]);
                    $query->orderBy($className::select($sort[1])->whereColumn($table . '.id', `weeks.` . $sort[0] . '_id'), $order);
                }
            })
            ->when(count($sort) == 1, function ($query) use ($sort, $order) {
                $query->orderBy($sort[0], $order);
            })
            ->paginate($perPage);

        return new WeekResource($weeks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWeekRequest $request)
    {
        $week = Week::create($request->validated());

        if ($request->hasFile('image')) {
            $week->addMedia($request->file('image'))->toMediaCollection('photo');
        }

        if (!$request->hasFile('image') && $request->has('photo_media')) {
            $weekMedia = Week::find($request->input('photo_media')['model_id']);
            if ($weekMedia->getFirstMedia('photo')) {
                $week->addMedia($weekMedia->getFirstMedia('photo')->getPath())
                    ->preservingOriginal()
                    ->toMediaCollection('photo');
            }
        }

        return (new WeekResource($week))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('view week')) return abort(401);

        return new WeekResource(Week::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWeekRequest $request, $id)
    {
        $week = Week::findOrFail($id);
        $week->update($request->validated());

        if ($request->hasFile('image')) {
            $week->clearMediaCollection('photo');
            $week->addMedia($request->file('image'))->toMediaCollection('photo');
        }
        return (new WeekResource($week))->response()->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete week')) return abort(401);

        Week::findOrFail($id)->delete();

        return response('Week Deleted', 204);
    }


    public function upload(Request $request)
    {

        if (!auth()->user()->can('store week') || !auth()->user()->can('update week')) {
            return abort(401);
        }

        $request->validate([
            'image' => 'mimes:jpeg,jpg,png|max:1000',
        ]);

        $model = new Week();
        $model->id = 0;
        $model->exists = true;
        $media =  $model->addMedia($request->file('image'))->toMediaCollection('photo');
        return $media->getFullUrl();
    }
}
