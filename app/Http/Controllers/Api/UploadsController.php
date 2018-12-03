<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function avatar(Request $request, ImageUploadHandler $uploader)
    {
        $user = $this->user();

        $result = $uploader->save($request->file, 'avatars');

        $user->update(['avatar' => $result['path']]);

        return $this->response->item($user, new UserTransformer());
    }
}
