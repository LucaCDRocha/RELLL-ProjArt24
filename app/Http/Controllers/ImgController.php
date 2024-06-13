<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\Trail;
use Illuminate\Http\Request;
use ValueError;

class ImgController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public static function storeImgTrail($picture)
    {
        try {
            $img_id = false;
            if (getimagesize($picture)) {
                $img = Img::create(['img_path' => ""]);
                $path = "/img/imgTrail/";
                $file_name = "image-Trail-" . $img->id . ".jpg";
                $img->img_path = $path . $file_name;
                $img->save();
                move_uploaded_file($picture, public_path($path . $file_name));
                $img_id = $img->id;
            }
            return $img_id;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public static function storeImgInterestPoint($picture, $id_IP)
    {
        try {
            $img_id = false;
            if (getimagesize($picture)) {
                $img = Img::create(['img_path' => "", 'interest_point_id' => $id_IP]);
                $path = "/img/imgInterestPoint/";
                $file_name = "image-IP-" . $img->id . ".jpg";
                $img->img_path = $path . $file_name;
                $img->save();
                move_uploaded_file($picture, public_path($path . $file_name));
                $img_id = $img->id;
            }

            return $img_id;
        } catch (ValueError $e) {
            return null;
        }
    }

    /**
     * Update images of an interest point
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public static function updateImgsInterestPoints($pictures, $id)
    {
        $old_pictures = Img::where('interest_point_id', '=', $id)->get();
        foreach ($pictures as $picture) {
            if (getimagesize($picture)) {
                ImgController::storeImgInterestPoint($picture, $id);
            } else {
                return false;
            }
        }

        for ($i = 0; $i < sizeof($old_pictures); $i++) {
            $old_pictures[$i]->update(['interest_point_id' => null]);
            if (!str_contains($old_pictures[$i], "https")) {
                unlink(public_path($old_pictures[$i]->img_path));
            }
        }
        return true;
    }

    /**
     * Update image of an interest point
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public static function updateImgTrail($picture, $id)
    {
        if (getimagesize($picture)) {
            $trail = Trail::findOrFail($id);
            $old_picture = Img::findOrFail($trail->img_id);

            if (!filter_var($old_picture->img_path, FILTER_VALIDATE_URL)) {
                unlink(public_path($old_picture->img_path));
            }
            $new_img_id = ImgController::storeImgTrail($picture);
            $trail->img_id = $new_img_id;
            $trail->save();
            return true;
        } else {
            return false;
        }
    }
}
