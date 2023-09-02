<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Wallet;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Mockery\Exception;
use function Laravel\Prompts\error;

class PostController extends Controller
{
    use ApiResponser;

    public function __construct(Request $request)
    {

        $this->request = $request;

    }

    public function createPost(Request $request)
    {
        try {
            $params = json_decode($request->getContent());
            if (empty($params->title)) {
                return $this->errorResponse('Title cannot be empty', 400, false);
            }
            if (empty($params->blog_message)) {
                return $this->errorResponse('Message cannot be empty', 400, false);
            }
            if (empty($params->blog_photo_url)) {
                return $this->errorResponse('Photo URL cannot be empty', 400, false);
            }
            Post::insert([
                'title' => $params->title,
                'blog_message' => $params->blog_message,
                'photo_url' => $params->blog_photo_url,


            ]);
            return $this->successResponse('Inserted blog', 200, true);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 400, false);
        }
    }

    public function getPost($id)
    {
        try {

            $fetch = Post::query()->where('id', $id)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Cannot find blog', 400, false);
            }
            return $this->successResponse($fetch, 200, true);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 200, true);
        }
    }

    public function updatePost(Request $request)
    {
        try {
            $params = json_decode($request->getContent());
            if (empty($params->id)) {
                return $this->errorResponse('Id cannot be empty', 400, false);
            }
            if (empty($params->title)) {
                return $this->errorResponse('Title cannot be empty', 400, false);
            }
            if (empty($params->blog_message)) {
                return $this->errorResponse('Message cannot be empty', 400, false);
            }
            if (empty($params->blog_photo_url)) {
                return $this->errorResponse('Photo URL cannot be empty', 400, false);
            }
            $fetch = Post::query()->where('id', $params->id)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Cannot find blog', 400, false);
            }
             Post::query()->where('id', $params->id)->update(
                ['title' => $params->title,
                    'blog_message' => $params->blog_message,
                    'photo_url' => $params->blog_photo_url,]
            );
            return $this->successResponse('Successfully edited post', 200, true);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 200, true);
        }
    }

    public function deletePost($id)
    {
        try {

            $fetch = Post::query()->where('id', $id)->first();
            if (is_null($fetch)) {
                return $this->errorResponse('Cannot find blog', 400, false);
            }
            Post::query()->where('id', $id)->delete();
            return $this->successResponse('Deleted blog '.$id, 200, true);

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 200, true);
        }
    }


}
