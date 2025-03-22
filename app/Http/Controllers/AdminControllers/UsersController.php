<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\User;
use Throwable;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-user', 'create-user', 'update-user', 'delete-user']);
        $title = __('USERS');
        return view('admin.users.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ResponseService::noPermissionThenSendJson('create-user');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'status' => 'required',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($validated['phone']);
            $countryCode = '+' . $phoneNumber->getCountryCode();
            $nationalNumber = $phoneNumber->getNationalNumber();
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => 'Invalid phone number format'
                ]
            ], 422);
        }

        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->country_code = $countryCode;
        $user->mobile = $nationalNumber;

        if ($request->hasFile('profile')) {
            $logoPath = $request->file('profile')->store('profile_images', 'public');
            $user->profile = $logoPath;
        }
        $save = $user->save();
        $user->assignRole('user');

        if ($save) {
            return redirect()->route('users.index')->with('success', 'User crated successfully.');
        } else {
            return redirect()->back()->with('error', 'Somthing went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $page = 1, $perPage = 8)
    {
        $status = $request->input('status') ?? '';
        try {
            ResponseService::noPermissionThenSendJson('list-user');

            $perPage = max(1, (int) $perPage);
            $searchQuery = $request->input('search', '');

            // $query = User::select('id', 'name', 'email', 'mobile', 'profile', 'type', 'country_code', 'status', 'deleted_at')->orderBy('id', 'desc');
            $query = User::select('id', 'name', 'email', 'mobile', 'profile', 'type', 'country_code', 'status', 'deleted_at')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->orderBy('id', 'desc');

            if ($status === 'active') {
                $query->where('status', 'active');
            } elseif ($status === 'inactive') {
                $query->where('status', 'inactive');
            } elseif ($status === 'deleted_user') {
                $query->onlyTrashed();
            } else {
                $query->withTrashed()->get();
            }

            if (!empty($searchQuery)) {
                $query->where(function ($q) use ($searchQuery) {
                    $q->where('name', 'like', "%$searchQuery%");
                });
            }

            $users = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'data' => $users->items(),
                'total' => $users->total(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ]);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "UserController -> show");
            return ResponseService::errorResponse('Something Went Wrong');
        }
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
        ResponseService::noPermissionThenSendJson('update-user');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($validated['phone']);
            $countryCode = '+' . $phoneNumber->getCountryCode();
            $nationalNumber = $phoneNumber->getNationalNumber();
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => 'Invalid phone number format'
                ]
            ], 422);
        }

        $user->name = $request->input('name');
        $user->country_code = $countryCode;
        $user->mobile = $nationalNumber;
        $user->status = $request->input('status') ?? 'active';

        if ($request->hasFile('profile')) {
            if ($user->profile && Storage::exists('public/' . $user->profile)) {
                Storage::delete('public/' . $user->profile);
            }

            $logoPath = $request->file('profile')->store('profile_images', 'public');
            $user->profile = $logoPath;
        }

        $user->save();

        return ResponseService::successResponse("User Updated successfully.");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ResponseService::noPermissionThenSendJson('delete-user');
            User::find($id)->delete();
            ResponseService::successResponse("User deleted successfully.");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "PlaceController -> destroyCountry");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function recover($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->restore();
            return response()->json(['message' => 'User recovered successfully.'], 200);
        }
        return response()->json(['message' => 'User not found.'], 404);
    }
}
