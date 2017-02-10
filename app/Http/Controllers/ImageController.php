<?php

namespace App\Http\Controllers;

use App\Images\Image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\ServerFactory;
use Webpatser\Uuid\Uuid;

class ImageController extends Controller
{
    public function show(Request $request, $path)
    {
        ini_set('memory_limit','256M');

        $server = ServerFactory::create([
            'source' => Storage::getDriver(),
            'cache' => storage_path('app/.cache'), // cached files should ideally be stored locally
        ]);

        return $server->outputImage($path, $request->all());
    }

    public function store(Request $request)
    {
        if ($request->file('file')->isValid()) {

            $user = User::where('uuid', $request->get('user'))->firstOrFail();

            $upload = $request->file('file');

            $image = new Image;

            /*
             * This approach is problematic as it does not
             * pass the mime-type to S3 buckets:
             *
             * $image->file_name = $upload->store('uploads/' . site('uuid');
             */

            $image->file_name = $this->store_upload($upload, config('shortform.upload-prefix') . '/' . $user->uuid . '/' . date('Ymd'));
            $image->original_name = $upload->getClientOriginalName();
            $image->mime_type = $upload->getClientMimeType();

            $user->images()->save($image);

            if($request->has('preview_parameters'))
            {
                parse_str($request->get('preview_parameters'), $parameters);
                $image->preview = $image->getPath($parameters);
            }

            return $image;
        }
    }

    /**
     * Sets the correct Content Type when uploading to S3
     */
    private function store_upload($upload, $path = '')
    {
        $file_name = $path . '/' . Uuid::generate(4) . '.' . $upload->getClientOriginalExtension();

        $stream = fopen($upload->getRealPath(), 'r+');

        Storage::getDriver()->put(
            $file_name,
            $stream,
            [
                'ContentType' => $upload->getClientMimeType()
            ]
        );

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $file_name;
    }
}
