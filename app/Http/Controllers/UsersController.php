<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LocationGroup;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Auth;
use App\Repositories\user\UserInterface;
use App\Repositories\locationGroup\LocationGroupInterface;
use Spatie\Activitylog\Models\Activity;

class UsersController extends Controller
{
    protected $Repository;

    public function __construct(UserInterface $Repository)
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

        return view('pages.user.index',compact('list'));
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
            ['path' => route('user.index'), 'title' => 'User', 'active' => false],
            ['path' => url()->current(), 'title' => 'Create', 'active' => true]
        ];

        $role = $this->Repository->getRole($ids = []);

        $group = $this->Repository->getGroup();

        return view('pages.user.create',compact('role','group','breadCumb'));
    }

    /**
     * Get Location Detail
     */

    public function getLocation(Request $request)
    {
        $this->validate($request, [

            'location' => 'required'
        ]);

        $detail = $this->Repository->getLocation($request->location);

        return response()->json(['success' => true, 'detail' => $detail]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
            'role' => 'required',
            'activelocation' => 'required',
            'defaultlocation' => 'required',
        ],[
            'activelocation.required' => 'Please select at least one location group.',
            'defaultlocation.required' => 'Please select at least one default location.'
        ]);

        DB::beginTransaction();
        try{

            $this->Repository->store($request->all());

            DB::commit();

            return redirect()->route('user.index')->with('success',__('User Added Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = $this->Repository->getById($id);
        $breadCumb = [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('user.index'), 'title' => 'User', 'active' => false],
            ['path' => url()->current(), 'title' => 'View User', 'active' => true]
        ];

        return view('pages.user.view', compact('detail', 'breadCumb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breadCumb= [
            ['path' => url('/'), 'title' => 'Home', 'active' => false],
            ['path' => '', 'title' => 'Admin', 'active' => false],
            ['path' => '', 'title' => 'ACL', 'active' => false],
            ['path' => route('user.index'), 'title' => 'User', 'active' => false],
            ['path' => url()->current(), 'title' => 'Edit', 'active' => true]
        ];

        $user = $this->Repository->getById($id);

        $userRole = DB::table('model_has_roles')->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_id', $user->id)
            ->get();

        $ids = $userRole->pluck('id');

        $role = $this->Repository->getRole($ids);

        $group = $this->Repository->getGroup();

        $userLocations = UserLocation::where('user_id',$id)->get();

        return view('pages.user.edit',compact('user','role','group','userLocations','breadCumb','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'activelocation' => 'required',
            'defaultlocation' => 'required',
        ],[
            'activelocation.required' => 'Please select at least one location group.',
            'defaultlocation.required' => 'Please select at least one default location.'
        ]);

        if(isset($request->password) && isset($request->password_confirmation)) {
            $this->validate($request, [

                'password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
            ]);
        }

        DB::beginTransaction();
        try{

            $this->Repository->update($request->all(), $id);

            DB::commit();

            return redirect()->route('user.index')->with('success',__('User Updated Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [

            'user_id' => 'required'
        ]);

        DB::beginTransaction();
        try{

            $this->Repository->destroy($request->all());

            DB::commit();

            return redirect()->route('user.index')->with('success',__('User Deleted Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    public function groupActivate(Request $request)
    {
        $this->validate($request, [

            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        if(isset($request->password) && isset($request->password_confirmation)) {
            $this->validate($request, [

                'password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
            ]);
        }

        DB::beginTransaction();
        try{

            $this->Repository->update($request->all(), $id);

            DB::commit();

            return redirect()->route('user.index')->with('success', __('User Updated Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger', __('Something went Wrong'));

        }
    }

    public function selectedDestroy(Request $request)
    {
        $this->validate($request, [

            'user_ids' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $this->Repository->selectedDestroy($request->all());

            DB::commit();

            return redirect()->route('user.index')->with('success', __('User Deleted Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger', __('Something went Wrong'));

        }
    }

    /**
     * User Information Update Function
     */
    public function userInformationUpdate(Request $request, $id)
    {
        $this->validate($request, [

            'first_name' => 'required',
            'email' => 'required'
        ]);

        if(isset($request->password) && isset($request->password_confirmation)) {
            $this->validate($request, [

                'password' => 'required|min:8|required_with:password_confirmation|same:password_confirmation',
            ]);
        }

        DB::beginTransaction();
        try{

            $user = $this->Repository->userInformation($request->all(), $id);

            DB::commit();

            return redirect()->route('user.edit',['id'=>$user->id])->with('success',__('User Information Updated Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * User Location Update Route Start
     */
    public function userLocationUpdate(Request $request, $id)
    {
        $this->validate($request, [

            'activelocation' => 'required',
            'defaultlocation' => 'required',
        ],[
            'activelocation.required' => 'Please select at least one location group.',
            'defaultlocation.required' => 'Please select at least one default location.'
        ]);


        DB::beginTransaction();
        try{

            $user = $this->Repository->userLocation($request->all(), $id);

            DB::commit();

            return redirect()->route('user.edit',['id'=>$user->id])->with('success',__('User Location Updated Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * User Roles Attachment
     */
    public function userRoleAttach(Request $request, $id)
    {
        $this->validate($request, [

            'role' => 'required',
        ]);

        DB::beginTransaction();
        try{

            $user = $this->Repository->attachRole($request->all(), $id);

            DB::commit();

            return redirect()->route('user.edit',['id'=>$user->id])->with('success',__('Role Attached Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * Detach User Role
     */
    public function userRoleDetach(Request $request)
    {
        $this->validate($request, [

            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        DB::beginTransaction();
        try{

            $user = $this->Repository->detachRole($request->all());

            DB::commit();

            return redirect()->route('user.edit',['id'=>$user->id])->with('success',__('Role Detached Successfully'));

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('danger',__('Something went Wrong'));

        }
    }

    /**
     * Ger User Logs
     */
    public function logGet(Request $request)
    {
        $log = Activity::with('subject')
            ->join('parts','parts.id','=','activity_log.part_id')
            ->where('activity_log.causer_id', '=', $request->user)
            ->where('activity_log.part_id', '!=',null)
            ->where('activity_log.event_tag', '=', null)
            ->select('activity_log.*', 'parts.part_no as part_no')
            ->orderBy('activity_log.id','DESC')->get();

        $code = view('part.pane.loadLogs')->with('log', $log)->render();

        return response()->json(['success' => true, 'code' => $code]);
    }
}
