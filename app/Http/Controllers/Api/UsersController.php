<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\GlobalVar;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserInfoResource;

class UsersController extends Controller
{
	public function activeRegister()
	{
		$register = GlobalVar::findOrFail('register');
		$register->value_boolean = !$register->value_boolean;
		$register->save();
		return response()->json([
			'register' => $register->value_boolean,
		]);
	}

	public function getRegister()
	{
		$register = GlobalVar::where('name', 'register')->firstOrFail();
		return response()->json([
			'register' => $register->value_boolean,
		]);
	}

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
		if (count($ids) > 0) {
			$users = User::orderBy('users.id', 'desc')->whereHas('roles', function ($query) use ($ids) {
				return $query->whereIn('role_id', $ids);
			});
		} else {
			$users = User::orderBy('users.id', 'desc');
		}
		return $users;
	}

	public function getUsers(Request $request)
	{
		$users = null;
		$ids = $this->idRoles($request);
		$users = $this->createUserQuery($request, $ids);
		if (!empty($request->search)) {
			if (count($ids) > 0) {
				$users->where('users.firstname', 'LIKE', "%{$request->search}%")->orWhere('users.lastname', 'LIKE', "%{$request->search}%");
			} else {
				$users->where('firstname', 'LIKE', "%{$request->search}%")->orWhere('lastname', 'LIKE', "%{$request->search}%");
			}
		}
		return UserInfoResource::collection($users->paginate(20));
	}
	public function getTeachers(Request $request)
	{
		$teacher_role = Role::where('name', 'Docente')->firstOrFail();
		$users = User::orderBy('users.id', 'desc')->whereHas('roles', function ($query) use ($teacher_role) {
			return $query->where('role_id', $teacher_role->id);
		})->get();
		return UserInfoResource::collection($users);
	}
	private function editUserRoles($user, $teacher, $student)
	{
		$roles = $user->roles;
		$is_teacher = false;
		$is_student = false;
		foreach ($roles as $role) {
			if ($role->name === "Docente") {
				$is_teacher = true;
			}
			if ($role->name === "Estudiante") {
				$is_student = true;
			}
		}
		$teacher_role = Role::where('name', "Docente")->firstOrFail();
		if ($teacher && !$is_teacher) {
			$user->roles()->attach($teacher_role->id);
		} else if (!$teacher && $is_teacher) {
			$user->roles()->detach($teacher_role->id);
		}
		$student_role = Role::where('name', "Estudiante")->firstOrFail();
		if ($student && !$is_student) {
			$user->roles()->attach($student_role->id);
		} else if (!$student && $is_student) {
			$user->roles()->detach($student_role->id);
		}
	}
	public function postUser(CreateUserRequest $request)
	{
		$user = User::create([
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'password' => bcrypt('password'),
			'active' => true,
			'email' => $request->email,
			'phone' => $request->phone,
		]);
		$this->editUserRoles($user, $request->boolean('teacher'), $request->boolean('student'));
		return new UserInfoResource($user);
	}
	public function putUser(Request $request, $user_id)
	{
		$user = User::findOrFail($user_id);
		$user->update([
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'email' => $request->email,
			'phone' => $request->phone,
		]);
		$this->editUserRoles($user, $request->boolean('teacher'), $request->boolean('student'));
		return new UserInfoResource($user);
	}
	public function putUserActive(Request $request, $user_id)
	{
		$user = User::findOrFail($user_id);
		$user->update([
			'active' => !$user->active
		]);
		return new UserInfoResource($user);
	}
	public function deleteUser(Request $request, $user_id)
	{
		$user = User::findOrFail($user_id);
		$user->delete();
		return response()->json([]);
	}
}
