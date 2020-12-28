<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ImportUsersRequest;

class UsersController extends Controller
{
	protected function idRoles($request)
	{
		$temp = null;
		$ids = [];
		if ($request->boolean('students')) {
			$temp = Role::where('name', 'Estudiante');
		}
		if ($request->boolean('teachers')) {
			if ($temp == null) {
				$temp = Role::where('name', 'Docente');
			} else {
				$temp = $temp->orWhere('name', 'Docente');
			}
		}
		if ($temp != null) {
			$roles = $temp->get();
			foreach ($roles as $role) {
				array_push($ids, $role->id);
			}
		}
		return $ids;
	}
	
	protected function createUserQuery(Request $request, $ids)
	{
		$users = null;
		if(count($ids)>0){
			$users = User::orderBy('users.id','desc')->whereHas('roles',function ($query) use($ids){
				return $query->whereIn('role_id',$ids);
			});
		}else{
			$users = User::orderBy('users.id','desc');
		}
		return $users;
	}

	public function getUsers(Request $request)
	{
		$users = null;
		$ids = $this->idRoles($request);
		$users = $this->createUserQuery($request,$ids);
		if(!empty($request->search)){
			$s = mb_strtoupper($request->search);
			if(count($ids)>0){
				$users->where('users.firstname', 'LIKE', "%{$s}%")->orWhere('users.lastname', 'LIKE', "%{$s}%");
			}else{
				$users->where('firstname', 'LIKE', "%{$s}%")->orWhere('lastname', 'LIKE', "%{$s}%");
			}
		}
		return response()->json($users->paginate(20));
	}
	public function getTeachers(Request $request)
	{
		$users = User::orderBy('users.id','desc')->whereHas('roles',function ($query){
			return $query->where('role_id',3);
		})->get();	
		return response()->json([
			'data'=>$users
		]);
	}
	public function postUser(CreateUserRequest $request)
	{
		$user = new User;
		$user->firstname =mb_strtoupper($request->firstname);
		$user->lastname = mb_strtoupper($request->lastname); 
		$user->password = bcrypt('password');
		$user->active=true;
		$user->email=$request->email;
		$user->cell_phone=$request->phone;
		$user->save();
		return response()->json(['data'=>$user]);
	}
	public function putUser(Request $request,$user_id)
	{
		$user = User::findOrFail($user_id);
		$user->firstname = mb_strtoupper($request->firstname);
		$user->lastname = mb_strtoupper($request->lastname);
		$user->email=$request->email;
		$user->cell_phone=$request->phone;
		$user->save();
		return response()->json([
			'data'=>$user
		]);
	}
	public function putUserActive(Request $request,$user_id)
	{
		$user = User::findOrFail($user_id);
		$user->active = !$user->active;
		$user->save();
		return response()->json([
			'data'=>$user
		]);
	}
	public function deleteUser(Request $request,$user_id)
	{
		$user = User::findOrFail($user_id);
		$user->delete();
		return response()->json([]);
	}
	public function postImportUsers(ImportUsersRequest $request)
	{
		$file = $request->import_users;
	}
}