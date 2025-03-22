<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['adminuser-list', 'adminuser-create', 'adminuser-update', 'adminuser-delete']);
        $roles = Role::where('custom_role', 1)->get();
        $title = __('ADMIN');
        return view('admin.admin.index', compact('roles','title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ResponseService::noPermissionThenRedirect('adminuser-create');
        $roles = Role::where('custom_role', 1)->get();
        return view('admin.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('adminuser-create');
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'role'     => 'required'
        ]);

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->syncRoles($request->role);
            DB::commit();
            ResponseService::successResponse('User created Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "AdminUserController --> store");
            ResponseService::errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        ResponseService::noPermissionThenRedirect('adminuser-list');
        define('LINK_PREFIX', "<a href='");
        
        $getData = User::withTrashed()->with('roles')->orderBy('id','DESC')->orderBy('id','DESC')->whereHas('roles', function ($q) {
            $q->where('custom_role', 1);
        });

        return DataTables::eloquent($getData)
            ->addColumn('action', function ($user) {
                $operate = '';
                if (Gate::allows('role-edit')) {
                    $operate .= LINK_PREFIX. route('admin-users.update', $user->id) . "' class='btn text-primary btn-sm' title=;'Edit' data-bs-target='#editModal' data-bs-toggle='modal' id=".$user->id." onClick=''><i class='fa fa-pen'></i></a> &nbsp; ";
                    $operate .= LINK_PREFIX. route('admin-user.change-password', $user->id) . "' class='btn text-primary btn-sm' title='Change Password' data-bs-target='#resetPasswordModel' data-bs-toggle='modal' ><i class='fa fa-key'></i></a> &nbsp; ";
                }
    
                if (Gate::allows('role-delete')) {
                    $operate .= LINK_PREFIX. route('admin-users.destroy', $user->id) . "' class='btn text-danger btn-sm delete-form' data-bs-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>";
                }
                
                return $operate;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ResponseService::noPermissionThenRedirect('adminuser-u');
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            $user = User::withTrashed()->findOrFail($id);
            $user->update([
                ...$request->all()
            ]);

            $oldRole = $user->roles;
            if ($oldRole[0]->id !== $request->role_id) {
                $newRole = Role::findById($request->role_id);
                $user->removeRole($oldRole[0]);
                $user->assignRole($newRole);
            }

            DB::commit();
            ResponseService::successResponse('User Update Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "AdminUserController --> update");
            ResponseService::errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('adminuser-delete');
            User::withTrashed()->findOrFail($id)->forceDelete();
            ResponseService::successResponse('User Delete Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "AdminUserController --> delete");
            ResponseService::errorResponse();
        }
    }

    public function changePassword(Request $request, $id) {
        ResponseService::noPermissionThenRedirect('adminuser-edit');
        $validator = Validator::make($request->all(), [
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            User::findOrFail($id)->update(['password' => Hash::make($request->confirm_password)]);
            ResponseService::successResponse('Password Reset Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "AdminUserController -> changePassword");
            ResponseService::errorResponse();
        }

    }

    public function updateFCMID(Request $request) {
        $user = User::find($request->id);
        $user->fcm_id = $request->token;
        $user->save();
    }
}
