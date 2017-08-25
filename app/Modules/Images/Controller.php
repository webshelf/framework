<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 17/07/2016
 * Time: 18:04.
 */

namespace App\Modules\Image;

use Illuminate\Http\Request;
use App\Classes\ImageUploader;
use App\Http\Controllers\DashboardController;

/**
 * Class Controller.
 */
class Controller extends DashboardController
{
    // upload image path absolute to website public folder.
    private $upload_dir = 'uploads/';

    /**
     * Upload images with ajax call.
     *
     * @param Request $request
     * @param $path
     * @return \Illuminate\Http\JsonResponse
     * @internal param Request $data
     */
    public function ajaxSingleUpload(Request $request, $path)
    {
        if ($request->hasFile('image')) {
            $upload = new ImageUploader();

            if ($path) { // if a path is set, then it MUST be uploads.
                $uploaded = $upload->image($request->file('image'))->to($this->upload_dir.$path)->process();
            } else {      // no path means, first layer of website. (ex. favicon)
                $uploaded = $upload->image($request->file('image'))->process();
            }

            return response()->json($uploaded['url']);
        }

        return response()->json(['error' => 'Unable to handle the image upload']);
    }
}
