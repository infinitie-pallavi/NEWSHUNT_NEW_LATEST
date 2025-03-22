<?php

namespace App\Http\Controllers\AdminControllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use App\Models\Channel;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Location\Facades\Location;

class DashboardController extends Controller
{
    const DATE_CREATED_AT = 'DATE(created_at)';
    const QUERY_SELECT_DATA = 'COUNT(*) as count, DATE(created_at) as date';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(!Auth::check())
        {
            return redirect()->route('admin.login');
        }
        $currentYear = date('Y');
        $currentMonth = date('n');
        $selectedYear = $request->input('year', $currentYear);
        $selectedMonth = $request->input('month', $currentMonth);
        $availableYears = range($currentYear - 5, $currentYear);

        $user_count = User::count();
        $channel_count = Channel::count();
        $post_count = Post::count();
        $topic_count = Topic::count();
        
        $monthlyData = $this->getMonthlyData($selectedYear, $selectedMonth);
        $recentUsers = User::latest()->take(5)->get();
        $recentPost = Post::select('posts.id', 'posts.image', 'posts.view_count',
        'channels.name as channel_name', 'channels.logo as channel_logo',
        'topics.name as topic_name', 'posts.title', 'posts.favorite',
        'posts.description', 'posts.status', 'posts.publish_date')
        ->join('channels', 'posts.channel_id', 'channels.id')
        ->join('topics', 'posts.topic_id', 'topics.id')->orderBy('publish_date', 'desc')->take(5)->get()->map(function ($item) {
            $item->publish_date = Carbon::parse($item->publish_date)->diffForHumans();

            return $item;
        });
       
        $data = compact(
        'user_count',
        'channel_count',
        'post_count',
        'topic_count',
        'selectedMonth',
        'availableYears',
        'selectedYear',
        'recentUsers',
        'recentPost',
        'monthlyData'
        );
        return view('admin.Dashboard',$data);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    /**
     * Get Monthly Data
     */
    private function getMonthlyData($year, $month)
    {
        // Initialize start and end dates for the month
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        // Fetch daily counts for each model
        $dailyData = [
            'users' => User::selectRaw(self::QUERY_SELECT_DATA)
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->groupByRaw(self::DATE_CREATED_AT)
                            ->get(),

            'Channels' => Channel::selectRaw(self::QUERY_SELECT_DATA)
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->groupByRaw(self::DATE_CREATED_AT)
                            ->get(),

            'comments' => Post::selectRaw(self::QUERY_SELECT_DATA)
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->groupByRaw(self::DATE_CREATED_AT)
                            ->get(),

            'UserVideoLike' => Favorite::selectRaw(self::QUERY_SELECT_DATA)
                            ->whereBetween('created_at', [$startDate, $endDate])
                            ->groupByRaw(self::DATE_CREATED_AT)
                            ->get(),
        ];

        // Initialize formatted data arrays
        $formattedData = [
            'labels' => [],
            'users' => [],
            'Channels' => [],
            'comments' => [],
            'UserVideoLike' => [],
        ];

        // Iterate over each day of the month
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $formattedDate = $currentDate->format('Y-m-d');
            $formattedData['labels'][] = $currentDate->format('d M');

            // Populate the counts for each model, defaulting to 0 if no data is available
            $formattedData['users'][] = $dailyData['users']->firstWhere('date', $formattedDate)->count ?? 0;
            $formattedData['Channels'][] = $dailyData['Channels']->firstWhere('date', $formattedDate)->count ?? 0;
            $formattedData['comments'][] = $dailyData['comments']->firstWhere('date', $formattedDate)->count ?? 0;
            $formattedData['UserVideoLike'][] = $dailyData['UserVideoLike']->firstWhere('date', $formattedDate)->count ?? 0;

            $currentDate->addDay();
        }

        return $formattedData;
    }
    /**
     * Get Month Year Data
     */

    public function getMonthYearData($year, $month)
    {
        $monthlyData = $this->getMonthlyData($year, $month);
        return response()->json($monthlyData);
    }

    public function changePassword()
    {
        return view('admin.models.change-password');
    }
    public function changePasswordUpdate(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password'     => 'required',
            'new_password'     => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            if (!Hash::check($request->old_password, Auth::user()->password)) {
                ResponseService::errorResponse("Incorrect old password");
            }
            $user->password = Hash::make($request->confirm_password);
            $user->update();
            ResponseService::successResponse('Password Change Successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "DashboardController --> changePasswordUpdate");
            ResponseService::errorResponse();
        }


    }

    public function changeProfile()
    {
        return view('admin.models.change-profile');
    }

        public function changeProfileUpdate(Request $request) {
        try {


            $user_id = Auth::user()->id;
            $user = User::find($user_id);
            
            $user->name = $request->name;
            if(isset($request->password)){
                $password = Hash::make($request->password);
                $user->password = $password;
            }
    
            if ($request->hasFile('profile')) {
                if ($user->profile && Storage::exists('public/' . $user->profile)) {
                    Storage::delete('public/' . $user->profile);
                }
    
                $logoPath = $request->file('profile')->store('profile_images', 'public');
                $user->profile = $logoPath;
            }
            $user->update();
    
            return response()->json(['error' => false, 'message' => "Profile Updated Successfully"]);
        } catch (Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
