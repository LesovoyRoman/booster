<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\StringHelper;

class ImageController extends Controller
{


    static function storeImg($file, $to, $campaign_id = null, $gift_id = null, $type = 'create', $image = null, $avatar = false, $product = 0)
    {
        if($file !== null) {
            try {
                $path = $file->store($to);

                $avatar ? $is_avatar = 1 : $is_avatar = 0;

                if(Auth::user() || Auth::user('api')){
                    if($type == 'create'){
                        $image = Image::create([
                            'user_id'       => $product === 0 ? Auth::id() : null,
                            'user_api_id'   => $product === 1 ? Auth::user('api')->id : null,
                            'campaign_id'   => $campaign_id,
                            'gift_id'       => $gift_id,
                            'is_avatar'     => $is_avatar,
                            'is_logo'       => !$product,
                            'image_path'    => substr($path, 6),
                            'product'       => $product
                        ]);
                    } else {
                        if($image !== null) {
                            $image->image_path = substr($path, 6);

                            $image->save();
                        }
                    }
                } else {
                    return ['errors' => 'Image owner(user) not found.'];
                }


                if($avatar === true){
                    $user = Auth::User();
                    $user->photo_path = $image->image_path;
                    $user->save();
                }

                return ['response' => $image, 'idCampaign' => $campaign_id, 'idGift' => $gift_id];
            } catch (\Exception $e) {
                return ['exception' => $e->getMessage()];
            }
        } else {
            return ['errors' => 'Error, no file.'];
        }
    }


    static function setUserAvatar($file, $role = 'user', $avatar = true)
    {
        if ($file === null) {
            return response()->json(['errors' => 'File not found!']);
        } else {
            $to = StringHelper::translit('public/' . $role . '/user_id_' . Auth::id() . '/logo/');
            $image = Image::where('user_id', '=', Auth::id())->where('is_avatar', '=', 1)->first();
            if($image == null || $image == []) {
                $image = null;
                $type = 'create';
            } else {
                $type = 'update';
            }

            $store = static::storeImg($file, $to, null, null, $type, $image, $avatar);

            return response()->json(['success' => $store], 200);
        }
    }
}
