<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\Trail;
use Illuminate\Http\Request;
use ValueError;

class ImgController extends Controller
{
    /*
        Return id
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

    /*
        Return id
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

    public static function updateImgsInterestPoints($pictures, $id)
    {
        $old_pictures = Img::where('interest_point_id', '=', $id);

        foreach ($pictures as $picture) {
            if (getimagesize($picture)) {
                ImgController::storeImgInterestPoint($picture, $id);
            } else {
                return false;
            }
        }
        for ($i = 0; $i < sizeof($old_pictures); $i++) {
            unlink(public_path($old_pictures[$i]->img_path));
        }
        return true;
    }

    public static function updateImgTrail($picture, $id)
    {
        dd($picture);
        if (getimagesize($picture)) {
            $trail = Trail::findOrFail($id);
            $old_picture = Img::findOrFail($trail->img_id);
            unlink(public_path($old_picture->img_path));
            $new_img_id = ImgController::storeImgTrail($picture);
            $trail->img_id = $new_img_id;
            return true;
        } else {
            return false;
        }
    }
}
