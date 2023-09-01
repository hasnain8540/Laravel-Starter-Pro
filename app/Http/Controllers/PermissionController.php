<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Repositories\permission\PermissionInterface;
use Illuminate\Http\Request;
use DB;

class PermissionController extends Controller
{
    protected $Repository;

    public function __construct(PermissionInterface $Repository)
    {
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

        return view('pages.permission.index',compact('list'));
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
            ['path' => route('permission.index'), 'title' => 'Permissions', 'active' => false],
            ['path' => url()->current(), 'title' => 'Create', 'active' => true]
        ];

        $module = $this->Repository->getModule();

        return view('pages.permission.create',compact('module','breadCumb'));
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

            'module' => 'required',
            'type' => 'required',
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->store($request->all());

            DB::commit();

            return redirect()->route('permission.index')->with('success', __('Permission Added Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('permission.index')->with('danger', __('Something went Wrong'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = $this->Repository->getById($id);

        $associated = $this->Repository->associatedRole($id);
        $breadCumb = [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('permission.index'), 'title' => 'Permissions', 'active' => false],
            ['path' => url()->current(), 'title' => 'View Permission', 'active' => true]
        ];

        return view('pages.permission.view', compact('detail', 'associated', 'breadCumb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadCumb= [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('permission.index'), 'title' => 'Permissions', 'active' => false],
            ['path' => url()->current(), 'title' => 'Edit', 'active' => true]
        ];

        $module = Module::get();

        $detail = $this->Repository->getById($id);

        return view('pages.permission.edit',compact('detail','module','breadCumb'));
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
        $this->validate($request, [

            'module' => 'required',
            'type' => 'required',
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->update($request->all(), $id);

            DB::commit();

            return redirect()->route('permission.index')->with('success', __('Permission Updated Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('permission.index')->with('danger', __('Something went Wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [

            'permission_id' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->destroy($request->all());

            DB::commit();

            return redirect()->route('permission.index')->with('success', __('Permission Deleted Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('permission.index')->with('danger', __('Something went Wrong'));
        }
    }
}
