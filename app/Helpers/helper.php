<?php
use App\Models\Theme;
use App\Models\Update;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;
use Aws\S3\S3Client;
use Facebook\WebDriver\Exception\Internal\RuntimeException as InternalRuntimeException;


if (!function_exists('getTheme')) {
    function getTheme()
    {
        try {
            $themeData = Theme::select('slug')->where('is_default', '1')->first();
            return optional($themeData)->slug ?? 'classic';
        } catch (Throwable $e) {
            return "";
        }
    }
}

if (!function_exists('get_system_update_info')) {
    function get_system_update_info()
    {
        $updatePath = Config::get('constants.UPDATE_PATH');
        $updaterPath = $updatePath . 'updater.json';
        $subDirectory = (File::exists($updaterPath) && File::exists($updatePath . 'update/updater.json')) ? 'update/' : '';

        if (File::exists($updaterPath) || File::exists($updatePath . $subDirectory . 'updater.json')) {
            $updaterFilePath = File::exists($updaterPath) ? $updaterPath : $updatePath . $subDirectory . 'updater.json';
            $updaterContents = File::get($updaterFilePath);

            // Check if the file contains valid JSON data
            if (!json_decode($updaterContents)) {
                throw new InternalRuntimeException('Invalid JSON content in updater.json');
            }

            $linesArray = json_decode($updaterContents, true);

            if (!isset($linesArray['version'], $linesArray['previous'], $linesArray['manual_queries'], $linesArray['query_path'])) {
                throw new InternalRuntimeException('Invalid JSON structure in updater.json');
            }
        } else {
            throw new InternalRuntimeException('updater.json does not exist');
        }

        $dbCurrentVersion = Update::latest()->first();
        $data['db_current_version'] = $dbCurrentVersion ? $dbCurrentVersion->version : '1.0.0';
        if ($data['db_current_version'] == $linesArray['version']) {
            $data['updated_error'] = true;
            $data['message'] = 'Oops!. This version is already updated into your system. Try another one.';
            return $data;
        }
        if ($data['db_current_version'] == $linesArray['previous']) {
            $data['file_current_version'] = $linesArray['version'];
        } else {
            $data['sequence_error'] = true;
            $data['message'] = 'Oops!. Update must performed in sequence.';
            return $data;
        }

        $data['query'] = $linesArray['manual_queries'];
        $data['query_path'] = $linesArray['query_path'];

        return $data;
    }
}

if(!function_exists('getFileName')){
    function getFileName($file)
    {
        $fileOriginalName = $file->getClientOriginalName();
        $fileName = preg_replace('/[^A-Za-z0-9\.]/ ', '', $fileOriginalName);
        return time() . '_' . $fileName;
        
    }
}

if(!function_exists('uploadFileS3Bucket')){
    function uploadFileS3Bucket($video_file, $filename, $path, $old_file_name = "")
    {
        if ($old_file_name != "") {
            deleteFileS3Bucket($old_file_name);
        }
        $s3_bucket_name = Setting::where('name','s3_bucket_name')->first();
        $aws_access_key_id = Setting::where('name','aws_access_key_id')->first();
        $aws_secret_access_key = Setting::where('name','aws_secret_access_key')->first();
        $s3Client = new S3Client([
            'region' => env('S3_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => $aws_access_key_id->value,
                'secret' => $aws_secret_access_key->value,
            ],
        ]);

        $result = $s3Client->putObject([
            'Bucket' => $s3_bucket_name->value,
            'Key'    => $path . $filename,
            'SourceFile' => $video_file,
            'ACL' => 'public-read',
        ]);

        $image_url = '';
        if (isset($result['ObjectURL'])) {
            $image_url = $result['ObjectURL'];
        }
        return $image_url;
    }
}


if(!function_exists('deleteFileS3Bucket')){
    function deleteFileS3Bucket($fileName)
    {
        $s3_bucket_name = Setting::where('name','s3_bucket_name')->first();
        $aws_access_key_id = Setting::where('name','aws_access_key_id')->first();
        $aws_secret_access_key = Setting::where('name','aws_secret_access_key')->first();
        $s3Client = new S3Client([
            'region' => env('S3_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => $aws_access_key_id->value,
                'secret' => $aws_secret_access_key->value,
            ],
        ]);

        $s3Client->deleteObject([
            'Bucket' =>  $s3_bucket_name->value,
            'Key'    =>  $fileName
        ]);
    }
}
