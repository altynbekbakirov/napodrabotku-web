<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Main;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('sdf');
        return view('admin.main.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $row  = new Main;
        return view('admin.main.create', compact('row'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $row = Main::create($request->except('logo'));

        if($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $row->addMedia($file)
                ->usingFileName(uniqid() . '.'.trim($file->getClientOriginalExtension()))
                ->toMediaCollection('main_logo', 'main_logo');
            $row->save();
        }

        return redirect()->route('main.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = Main::findOrfail($id);
        return view('admin.main.show',compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Main::findOrfail($id);
        if($row->socials){
            $socials = json_encode($row->socials, JSON_PRETTY_PRINT);
        }else{
            $socials = '';
        }

        return view('admin.main.edit',compact('row', 'socials'));
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
        $row = Main::findOrFail($id);
        $row->update($request->except('logo'));

        if($request->hasFile('logo'))
        {
            $file = $request->file('logo');
            $row->addMedia($file)
                ->usingFileName(uniqid() . '.'.trim($file->getClientOriginalExtension()))
                ->toMediaCollection('main_logo', 'main_logo');
            $row->save();
        }

        return redirect()->route('main.show', $row);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Main $main)
    {
        $main->delete();
        return response('Success', 200);
    }

    public function removethumb(Request $request){
        $row = Main::findOrfail($request->page);
        $row->getMedia('main_logo')->last()->delete();
        return response()->json([
            'status' => 'true'
        ]);
    }


    public function api(){
        $data = Main::get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $buttons = '<a href="'.route('main.edit', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-info m-btn--icon m-btn--icon-only m-btn--pill" title="Редактировать">
                            <i class="jam jam-write"></i>
                        </a>
                        <a href="'.route('main.destroy', $row->id).'" data-id="'.$row->id.'" class="btn-to-alert m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Удалить">
                            <i class="jam jam-trash-alt"></i>
                        </a>';
            })
            ->addColumn('logo', function ($row) {
                if($row->getMedia('main_logo')->last()){
                    $image = '<img height="60px" class="img-fluid rounded" src="'.asset($row->getMedia('main_logo')->last()->getUrl('logo_middle')).'">';
                }else{
                    $image = '';
                }
                return $image;
            })
            ->rawColumns(['action', 'logo'])
            ->make(true);
    }
}
