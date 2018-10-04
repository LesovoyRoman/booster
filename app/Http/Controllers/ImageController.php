<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{


    static function storeImg($file, $to, $campaign_id = null, $gift_id = null, $type = 'create', $image = null)
    {
        if($file !== null) {
            try {
                $path = $file->store($to);

                if($type == 'create'){
                    $image = Image::create([
                        'user_id'       => Auth::id(),
                        'campaign_id'   => $campaign_id,
                        'gift_id'       => $gift_id,
                        'is_avatar'     => 0,
                        'is_logo'       => 1,
                        'image_path'    => substr($path, 6),
                    ]);
                } else {
                    if($image !== null) {
                        $image->image_path = substr($path, 6);

                        $image->save();
                    }
                }

                return response()->json(['response' => $image, 'idCampaign' => $campaign_id, 'idGift' => $gift_id], 200);
            } catch (\Exception $e) {
                return response()->json(['exception' => $e->getMessage()]);
            }
        } else {
            return response()->json('Error, no file.');
        }
    }
}
