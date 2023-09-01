<?php

namespace App\Repositories\user;

use App\Models\LocationGroup;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserLocation;
use Composer\DependencyResolver\Request;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface {

    // model property on class instances
    public $model;

    // Constructor to bind model to repo
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return User::get();
//        return $this->model->join('model_has_roles','model_has_roles.model_id','=','users.id')
//            ->join('roles','roles.id','=','model_has_roles.role_id')
//            ->select('users.*','roles.name as role')->get();
    }

    // Get Role
    public function getRole($ids)
    {
        return Role::whereNotIn('id', $ids)->get();
    }

    // Store user to Database
    public function store(array $data)
    {
        $password = bcrypt($data['password']);
        if(count($data['activelocation'])>1){
            // check the index of default group in an array
            $indeOfDefaultInArray=array_search($data['defaultlocation'][0],$data['activelocation']);
            //removing default from active group array
             if($indeOfDefaultInArray!=0){
            array_splice($data['activelocation'],$indeOfDefaultInArray, $indeOfDefaultInArray);
            // adding default group at begning of active group array so it's come at top in user location table
            array_unshift($data['activelocation'],$data['defaultlocation'][0]);
              }
            }

        $user = User::create([

            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $password
        ]);

        UserInfo::create([

            'user_id' => $user->id
        ]);

        if (isset($data['activelocation'])) {

            for ($i = 0; $i < count($data['activelocation']); $i++) {
                    if($data['activelocation'][$i] == $data['defaultlocation'][0]) {
                        $default=1;
                    }else{
                        $default=0;
                    }


                UserLocation::create([
                            'user_id' => $user->id,
                            'location_group_id' => $data['activelocation'][$i],
                            'default' => $default
                        ]);

            }
        }

        $user->assignRole($data['role']);

        return $user;
    }

    // Get User Detail ById
    public function getById($id)
    {
        return $this->model->join('model_has_roles','model_has_roles.model_id','=','users.id')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->select('users.*','roles.name as role','roles.id as role_id')
            ->where('users.id','=',$id)->first();
    }

    // Update User Detail in Database
    public function update(array $data, $id)
    {
        $user = $this->model->find($id);
        if(count($data['activelocation'])>1){
        // check the index of default group in an array
        $indeOfDefaultInArray=array_search($data['defaultlocation'][0],$data['activelocation']);
            //removing default from active group array
         if($indeOfDefaultInArray!=0){
        array_splice($data['activelocation'],$indeOfDefaultInArray, $indeOfDefaultInArray);
        // adding default group at begning of active group array so it's come at top in user location table
        array_unshift($data['activelocation'],$data['defaultlocation'][0]);
          }
        }
        if(isset($data['password'])) {
            $password = bcrypt($data['password']);
        } else {
            $password = $user->password;
        }

        User::where('id', $user->id)->update([

            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $password
        ]);

        UserLocation::where('user_id', $user->id)->delete();

        if (isset($data['activelocation'])) {

            for ($i = 0; $i < count($data['activelocation']); $i++) {
                    if($data['activelocation'][$i] == $data['defaultlocation'][0]) {
                        $default=1;
                    }else{
                        $default=0;
                    }


                UserLocation::create([
                            'user_id' => $user->id,
                            'location_group_id' => $data['activelocation'][$i],
                            'default' => $default
                        ]);

            }
        }

        $user->assignRole($data['role']);

        return $user;
    }

    // Destroy User in Database
    public function destroy(array $data)
    {
        return $this->model->find($data['user_id'])->delete();
    }

    // Get Location Group List
    public function getGroup()
    {
        return LocationGroup::get();
    }

    // Get Location Detail By ID
    public function getLocation($location)
    {
        return LocationGroup::where('id', $location)->first();
    }

    public function selectedDestroy(array $data)
    {
//        dd($data['user_ids']);
        $ids = explode(',', $data['user_ids']);
        $this->model->whereIn('id', $ids)->delete();
    }

    // Update User Information
    public function userInformation(array $data, $id)
    {
        $user = $this->model->find($id);

        if(isset($data['password'])) {
            $password = bcrypt($data['password']);
        } else {
            $password = $user->password;
        }

        User::where('id', $user->id)->update([

            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $password,
            'type' => $data['type']
        ]);

        return $user;
    }

    // Update User Location
    public function userLocation(array $data, $id)
    {
        $user = $this->model->find($id);

        if(count($data['activelocation'])>1){
            // check the index of default group in an array
            $indeOfDefaultInArray=array_search($data['defaultlocation'][0],$data['activelocation']);
            //removing default from active group array
            if($indeOfDefaultInArray!=0){
                array_splice($data['activelocation'],$indeOfDefaultInArray, $indeOfDefaultInArray);
                // adding default group at begning of active group array so it's come at top in user location table
                array_unshift($data['activelocation'],$data['defaultlocation'][0]);
            }
        }

        UserLocation::where('user_id', $user->id)->delete();

        if (isset($data['activelocation'])) {

            for ($i = 0; $i < count($data['activelocation']); $i++) {
                if($data['activelocation'][$i] == $data['defaultlocation'][0]) {
                    $default=1;
                }else{
                    $default=0;
                }


                UserLocation::create([
                    'user_id' => $user->id,
                    'location_group_id' => $data['activelocation'][$i],
                    'default' => $default
                ]);

            }
        }

        return $user;
    }

    // Role Attachment
    public function attachRole(array $data, $id)
    {
        $user = $this->model->find($id);

        $user->assignRole($data['role']);

        return $user;
    }

    // Detach User Role
    public function detachRole(array $data)
    {
        $user = $this->model->find($data['user_id']);

        $user->removeRole($data['role_id']);

        return $user;
    }
}
