<?php

namespace App\Http\Controllers\AdminControllers;

use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Services\ResponseService;
use App\Services\CachingService;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Rules\JsonFile;
use Throwable;

class LanguageController extends Controller
{

    private string $uploadFolder;
    const SOMTHING_WENT_WRONG = 'Something Went Wrong';
    const APPLICATION_JSON = 'Something Went Wrong';
    const NULLABLE_JSON = 'nullable|mimes:json';

    public function __construct() {
        $this->uploadFolder = "language";
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        ResponseService::noAnyPermissionThenRedirect(['list-language', 'create-language', 'update-language', 'delete-language']);
        return view('admin.settings.language');
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
        ResponseService::noPermissionThenRedirect('create-language');
        $validator = Validator::make($request->all(), [
            'name'            => 'required',
            'name_in_english' => 'required|regex:/^[\pL\s]+$/u',
            'code'            => 'required|unique:languages,code',
            'rtl'             => 'nullable',
            'app_file'        => ['required', new JsonFile()],
            'panel_file'      => ['required', new JsonFile()],
            'web_file'        => ['required', new JsonFile()],
            'image'           => 'required|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $data = $request->all();
            $data['rtl'] = $request->rtl == "on";

            if ($request->hasFile('panel_file')) {
                $data['panel_file'] = FileService::uploadLanguageFile($request->file('panel_file'), $request->code);
            }

            if ($request->hasFile('app_file')) {
                $data['app_file'] = FileService::uploadLanguageFile($request->file('app_file'), $request->code . "_app");
            }

            if ($request->hasFile('web_file')) {
                $data['web_file'] = FileService::uploadLanguageFile($request->file('web_file'), $request->code . "_web");
            }

            if ($request->hasFile('image')) {
                $data['image'] = FileService::upload($request->file('image'), $this->uploadFolder);
            }

            Language::create($data);
            CachingService::removeCache(config('constants.CACHE.LANGUAGE'));
            ResponseService::successResponse('Language Successfully Added');
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th, "Language Controller -> Store");
            ResponseService::errorResponse(self::SOMTHING_WENT_WRONG);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        ResponseService::noPermissionThenRedirect('list-language');
        $getData = Language::get();
        
        return DataTables::of($getData)
        ->addColumn('action', function ($getData) {
          if($getData->code !== 'en'){
                $data = "<a href='" . route('language.edit', $getData->id) . "' class='btn text-primary btn-sm edit_btn set-form-url' data-bs-target='#editModal' data-bs-toggle='modal' title='Edit'> <i class='fa fa-pen'></i></a> &nbsp; " .
                "<a href='" . route('language.destroy', $getData->id) . "' class='btn text-danger btn-sm delete-form delete-form-reload' data-bs-toggle='tooltip' title='Delete'> <i class='fa fa-trash'></i> </a>";
                }else{
                    $data = '';
                }
            return $data;
        })->make(true);
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
        ResponseService::noPermissionThenRedirect('update-language');
        $validator = Validator::make($request->all(), [
            'name'            => 'required',
            'name_in_english' => 'required|regex:/^[\pL\s]+$/u',
            'code'            => 'required|unique:languages,code,' . $id,
            'rtl'             => 'required|boolean',
            'app_file'        => self::NULLABLE_JSON,
            'panel_file'      => self::NULLABLE_JSON,
            'web_file'        => self::NULLABLE_JSON,
            'image'           => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $language = Language::findOrFail($id);
            $data = $request->all();
            if ($request->hasFile('app_file')) {
                $data['app_file'] = FileService::uploadLanguageFile($request->file('app_file'), $language->code . "_app");
            }
            if ($request->hasFile('panel_file')) {
                $data['panel_file'] = FileService::uploadLanguageFile($request->file('panel_file'), $language->code);
            }

            if ($request->hasFile('web_file')) {
                $data['web_file'] = FileService::uploadLanguageFile($request->file('web_file'), $language->code);
            }

            if ($request->hasFile('image')) {
                $data['image'] = FileService::replace($request->file('image'), $this->uploadFolder, $language->getRawOriginal('image'));
            }
            $language->update($data);
            CachingService::removeCache(config('constants.CACHE.LANGUAGE'));
            ResponseService::successResponse('Language Updated successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Language Controller --> update");
            ResponseService::errorResponse(self::SOMTHING_WENT_WRONG);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
                ResponseService::noPermissionThenRedirect('delete-language');
              
                    $language = Language::findOrFail($id);
                    $language->delete();

                FileService::deleteLanguageFile($language->app_file);
                FileService::deleteLanguageFile($language->panel_file);
                FileService::deleteLanguageFile($language->web_file);
                FileService::delete($language->getRawOriginal('image'));
            CachingService::removeCache(config('constants.CACHE.LANGUAGE'));
            ResponseService::successResponse('Language Deleted successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th, "Language Controller --> Destroy");
            ResponseService::errorResponse(self::SOMTHING_WENT_WRONG);
        }
    }


    public function setLanguage($languageCode) {
        $language = Language::where('code', $languageCode)->first();
        if (!empty($language)) {
            Session::put('locale', $language->code);
            Session::put('language', (object)$language->toArray());
            Session::save();
            app()->setLocale($language->code);
        }
        return redirect()->back();
    }

    public function downloadPanelFile() {
        return Response::download(base_path("resources/lang/en.json"), 'panel.json', [
            'Content-Type' => self::APPLICATION_JSON,
        ]);
    }

    public function downloadAppFile() {
        return Response::download(base_path("resources/lang/en_app.json"), 'app.json', [
            'Content-Type' => self::APPLICATION_JSON,
        ]);
    }

    public function downloadWebFile() {
        return Response::download(base_path("resources/lang/en_web.json"), 'web.json', [
            'Content-Type' => self::APPLICATION_JSON,
        ]);
    }
}
