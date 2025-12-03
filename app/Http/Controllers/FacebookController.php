<?php

namespace App\Http\Controllers;

use Facebook\Facebook;

class FacebookController extends Controller
{
   public function postText()
{
    try {

        $fb = new Facebook([
            'app_id' => env('FB_APP_ID'),
            'app_secret' => env('FB_APP_SECRET'),
            'default_graph_version' => 'v17.0',
        ]);

        $response = $fb->post(
            '/me/feed',
            ['message' => 'Hello from Lumen Facebook Poster!'],
            env('FACEBOOK_ACCESS_TOKEN')
        );

        return $response->getDecodedBody();

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}


    public function postImage()
    {
        $fb = new Facebook([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v17.0',
        ]);

        try {
            $response = $fb->post(
                '/me/photos',
                [
                    'source' => $fb->fileToUpload(storage_path('app/test.jpg')),
                    'caption' => 'Image posted from Lumen!'
                ],
                config('services.facebook.access_token')
            );

            return $response->getDecodedBody();

        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
