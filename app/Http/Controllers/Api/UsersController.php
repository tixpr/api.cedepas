<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\User;
use App\Models\Role;

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
			$users = User::orderBy('users.id','asc')->whereHas('roles',function ($query) use($ids){
				return $query->whereIn('role_id',$ids);
			});
			if ($request->boolean('enableds')) {
				$users->where('users.active', true);
			}
			if ($request->boolean('disableds')) {
				$users->where('users.active', false);
			}
		}else{
			$users = User::orderBy('users.id','asc');
			if ($request->boolean('enableds')) {
				$users->where('active', true);
			}
			if ($request->boolean('disableds')) {
				$users->where('active', false);
			}
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
				$users->where('users.name', 'LIKE', "%{$s}%");
			}else{
				$users->where('name', 'LIKE', "%{$s}%");
			}
		}
		return response()->json($users->paginate(20));
	}
	public function postCreateUser(Request $request)
	{
		User::create([
			'name'=>mb_strtoupper($request->name),
			'password'=>bcrypt($request->password),
			'email'=>$request->email,
			'phone'=>$request->phone
		]);
		return response()->json(['message'=>'Usuario registrado']);
	}
	public function postImportUsers(Request $request)
	{
		$file = $request->import_users;
	}
}