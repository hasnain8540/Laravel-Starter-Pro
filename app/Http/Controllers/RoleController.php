<?php

namespace App\Http\Controllers;

use App\Repositories\role\RoleInterface;
use Illuminate\Http\Request;
use DB;

class RoleController extends Controller
{
    protected $Repository;

    public function __construct(RoleInterface $Repository)
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

        return view('pages.role.index',compact('list'));
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
            ['path' => route('role.index'), 'title' => 'Role', 'active' => false],
            ['path' => url()->current(), 'title' => 'Create', 'active' => true]
        ];

        $module = $this->Repository->getModule();

        return view('pages.role.create',compact('module','breadCumb'));
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

            return redirect()->route('role.index')->with('success', __('Role Added Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('role.index')->with('danger', __('Something went Wrong'));
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

        $attached = $this->Repository->attachedPermission($id);
        $breadCumb = [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('role.index'), 'title' => 'Role', 'active' => false],
            ['path' => url()->current(), 'title' => 'View Role', 'active' => true]
        ];

        return view('pages.role.view', compact('detail', 'attached', 'breadCumb'));
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
            ['path' => route('role.index'), 'title' => 'Role', 'active' => false],
            ['path' => url()->current(), 'title' => 'Edit', 'active' => true]
        ];

        $role = $this->Repository->getById($id);

        $module = $this->Repository->getModule();

        return view('pages.role.edit',compact('role','module','breadCumb'));
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

            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->update($request->all(), $id);

            DB::commit();

            return redirect()->back()->with('success', __('Role Updated Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('role.index')->with('danger', __('Something went Wrong'));
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

            'role_id' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->destroy($request->all());

            DB::commit();

            return redirect()->route('role.index')->with('success', __('Role Deleted Successfully'));
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('role.index')->with('danger', __('Something went Wrong'));
        }
    }
}
