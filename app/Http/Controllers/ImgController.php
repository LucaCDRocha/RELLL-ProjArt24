<?php

namespace App\Http\Controllers;

use App\Models\Img;
use Illuminate\Http\Request;

class ImgController extends Controller
{
    /*
        Return id
    */
    public static function storeImgTrail($picture)
    {
        try {
            $img = Img::create(['img_path' => ""]);
            $path = "/img/imgTrail/";
            $file_name = "image-Trail-" . $img->id . ".jpg";
            $img->img_path = $path . $file_name;
            $img->save();
            move_uploaded_file($picture, public_path($path . $file_name));
            $img_id = $img->id;
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
            $img = Img::create(['img_path' => "", 'interest_point_id' => $id_IP]);
            $path = "/img/imgInterestPoint/";
            $file_name = "image-IP-" . $img->id . ".jpg";
            $img->img_path = $path . $file_name;
            $img->save();
            move_uploaded_file($picture, public_path($path . $file_name));
            $img_id = $img->id;
            return $img_id;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function updateImgsInterestPoints($pictures, $id)
    {
        $old_pictures = Img::where('interest_point_id', '=', $id);
        for ($i = 0; $i < sizeof($old_pictures); $i++) {
            unlink(public_path($old_pictures[$i]->img_path));
        }
        foreach ($pictures as $picture) {
            ImgController::storeImgInterestPoint($picture, $id);
        }
        return true;
    }
}
