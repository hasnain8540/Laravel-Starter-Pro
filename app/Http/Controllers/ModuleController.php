<?php

namespace App\Http\Controllers;

use App\DataTables\module\ModuleDataTable;
use App\Models\Module;
use App\Repositories\module\ModuleInterface;
use Illuminate\Http\Request;
use DB;

class ModuleController extends Controller
{

    protected $Repository;

    public function __construct(ModuleInterface $Repository) {
        $this->Repository = $Repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->Repository->all();

        return view('pages.module.index', compact('list'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadCumb=[
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('module.index'), 'title' => 'Modules', 'active' => false],
            ['path' => url()->current(), 'title' => 'Create', 'active' => true]
        ];

        return view('pages.module.create', compact('breadCumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->store($request->all());

            DB::commit();

            return redirect()->route('module.index')->with('success', __('Module Added Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('module.index')->with('danger', __('Something went Wrong'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = $this->Repository->getById($id);
        $breadCumb = [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('module.index'), 'title' => 'Modules', 'active' => false],
            ['path' => url()->current(), 'title' => 'View Module', 'active' => true]
        ];

        return view('pages.module.view', compact('detail', 'breadCumb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadCumb= [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('module.index'), 'title' => 'Modules', 'active' => false],
            ['path' => url()->current(), 'title' => 'Edit', 'active' => true]
        ];

        $detail = $this->Repository->getById($id);

        return view('pages.module.edit',compact('detail','breadCumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->update($request->all(), $id);

            DB::commit();

            return redirect()->route('module.index')->with('success', __('Module Updated Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('module.index')->with('danger', __('Something went Wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [

            'module_id' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->destroy($request->all());

            DB::commit();

            return redirect()->route('module.index')->with('success', __('Module Deleted Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('module.index')->with('danger', __('Something went Wrong'));
        }
    }
}
