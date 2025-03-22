<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Throwable;

class RoleController extends Controller
{
    /**
     * @var array|string[]
     */
    private array $reserveRole;

    public function __construct() {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);

        $this->reserveRole = [
            'Admin',
            'User'
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-role', 'create-role', 'edit-role', 'delete-role']);
        $roles = Role::orderBy('id', 'DESC')->get();
        $title = __('ROLE_MANAGEMENTS');
        $pre_title = __('ADMIN_USER');
        return view('admin.roles.index', compact('roles','title','pre_title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ResponseService::noPermissionThenRedirect('create-role');
        $permissions = Permission::select('name')->get();
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $permission= $permission['name'];
            $parts = explode('-', $permission);
            $groupName = strtolower(array_shift($parts));
            $shortName = implode(' ', $parts);
            
            if (!isset($groupedPermissions[$groupName])) {
                $groupedPermissions[$groupName] = [];
            }
            
            $groupedPermissions[$groupName][] = (object)[
                'name' => $permission,
                'short_name' => $shortName,
                'id' => uniqid()
            ];
        }

        $groupedPermissions = (object)$groupedPermissions;
        $title =__('CREATE_ROLE');
        $pre_title =__('ROLE_MANAGEMENTS');
        return view('admin.roles.create', compact('groupedPermissions','title','pre_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenRedirect('create-role');
        $validator = Validator::make($request->all(), [
            'name'       => 'required|unique:roles,name',
            'permission' => 'required|array'
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {

            if (in_array($request->name, $this->reserveRole, true)) {
                ResponseService::errorResponse($request->name . " " . trans("is not a valid Role name Because it's Reserved Role"));
            }
            DB::beginTransaction();
            $role = Role::create(['name' => $request->input('name'), 'custom_role' => 1]);
            $role->syncPermissions($request->input('permission'));
            DB::commit();
            ResponseService::successResponse(trans('Role created Successfully'));
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e, "Role Controller -> store");
            ResponseService::errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        ResponseService::noPermissionThenRedirect('list-role');
       
        $getData = Role::select('id','name')->where('custom_role', 1)->get();

        return DataTables::of($getData)
        ->addColumn('no', function () {
            static $index = 1;
            return $index++;
        })
        ->addColumn('action', function ($row) {
            $operate = '';

            if (Gate::allows('role-edit')) {
                $operate .= "<a href='" . route('roles.edit', $row->id) . "' class='btn text-primary btn-sm' data-bs-toggle='tooltip' title='Edit'><i class='fa fa-pen'></i></a> &nbsp; ";
            }
            
            if ($row->custom_role != 0 && Gate::allows('role-delete')) {
                $operate .= "<a href='" . route('roles.destroy', $row->id) . "' class='btn text-danger btn-sm delete-form' data-bs-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>";
            }

            return $operate;
        })
        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        ResponseService::noPermissionThenRedirect('edit-role');
        $role = Role::findOrFail($id);
        $permissions = Permission::select('name')->get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $permission= $permission['name'];
            $parts = explode('-', $permission);
            $groupName = strtolower(array_shift($parts));
            $shortName = implode(' ', $parts);
            
            if (!isset($groupedPermissions[$groupName])) {
                $groupedPermissions[$groupName] = [];
            }
            
            $groupedPermissions[$groupName][] = (object)[
                'name' => $permission,
                'short_name' => $shortName,
                'id' => uniqid()
            ];
        }

        $groupedPermissions = (object)$groupedPermissions;
        $title =__('EDIT_ROLE');
        $pre_title =__('ROLE_MANAGEMENTS');
        return view('admin.roles.edit', compact('role', 'groupedPermissions', 'rolePermissions','title','pre_title' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ResponseService::noPermissionThenRedirect('edit-role');
        $validator = Validator::make($request->all(), ['name' => 'required', 'permission' => 'required']);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            DB::beginTransaction();
            if (in_array($request->name, $this->reserveRole, true)) {
                ResponseService::errorResponse($request->name . " " . trans("is not a valid Role name Because it's Reserved Role"));
            }
            $role = Role::findOrFail($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));
            DB::commit();
            ResponseService::successResponse('Data Updated Successfully');
        } catch (Throwable $th) {
            DB::rollBack();
            ResponseService::logErrorResponse($th, "RoleController -> update");
            ResponseService::errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('delete-role');
            $role = Role::withCount('users')->findOrFail($id);
            if ($role->users_count) {
                ResponseService::errorResponse('cannot_delete_because_data_is_associated_with_other_data');
            } else {
                Role::findOrFail($id)->delete();
                ResponseService::successResponse('Data Deleted Successfully');
            }
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e);
            ResponseService::errorResponse();
        }
    }

    public function list($id){
        ResponseService::noPermissionThenRedirect('role-list');
        $role = Role::findOrFail($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $id)->get();

        return view('roles.show', compact('role', 'rolePermissions'));
    }
}
