<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Slide;
use Flash;
use Illuminate\Http\Request;

class SlidesController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Slide::sorted()->get();

        return view('admin.slides.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,bmp,png',
        ]);

        $item = Slide::create($request->all());

        $item->saveImage($item, $request);

        Flash::success("Запись - {$item->id} сохранена");

        return redirect(route('admin.slides.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = Slide::findOrFail($id);

        return view('admin.slides.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $item = Slide::findOrFail($id);

        $item->update($request->all());

        $item->saveImage($item, $request);

        Flash::success("Запись - {$id} обновлена");

        return redirect(route('admin.slides.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        Slide::destroy($id);

        if ($request->ajax()){
            return json_encode([
                'status' => 'ok'
            ]);
        }

        Flash::success("Запись - {$id} удалена");

        return redirect(route('admin.slides.index'));
    }
}
