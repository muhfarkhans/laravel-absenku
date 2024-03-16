<?php

namespace App\Services;

use Http;

class BiznetFaceRecog
{
    protected $url;

    protected $token;

    protected $arrBody = ['trx_id' => 'alphanumericalstring2000'];

    public function __construct()
    {
        $this->url = env('BIZNETGIO_FR_URL');
        $this->token = env('BIZNETGIO_FR_TOKEN');
    }

    public function counterHit()
    {
        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($this->arrBody))
            ->get($this->url . '/risetai/face-api/client/get-counters');

        return $response->json();
    }

    public function getGalleries()
    {
        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($this->arrBody))
            ->get($this->url . '/risetai/face-api/facegallery/my-facegalleries');

        return $response->json();
    }

    public function createGalleries(string $faceGalleryId)
    {
        $body = $this->arrBody;
        $body['facegallery_id'] = $faceGalleryId;

        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($body))
            ->post($this->url . '/risetai/face-api/facegallery/create-facegallery');

        return $response->json();
    }

    public function deleteGalleries(string $faceGalleryId)
    {
        $body = $this->arrBody;
        $body['facegallery_id'] = $faceGalleryId;

        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($body))
            ->delete($this->url . '/risetai/face-api/facegallery/create-facegallery');

        return $response->json();
    }

    public function getFaces(string $faceGalleryId)
    {
        $body = $this->arrBody;
        $body['facegallery_id'] = $faceGalleryId;

        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($body))
            ->get($this->url . '/risetai/face-api/facegallery/list-faces');

        return $response->json();
    }

    public function enrollFace(string $faceGalleryId, string $userId, string $userName, string $image)
    {
        $body = $this->arrBody;
        $body['user_id'] = $userId;
        $body['user_name'] = $userName;
        $body['facegallery_id'] = $faceGalleryId;
        $body['image'] = $image;

        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($body))
            ->post($this->url . '/risetai/face-api/facegallery/enroll-face');

        return $response->json();
    }

    public function verifyFace(string $faceGalleryId, string $userId, string $userName, string $image)
    {
        $body = $this->arrBody;
        $body['user_id'] = $userId;
        $body['user_name'] = $userName;
        $body['facegallery_id'] = $faceGalleryId;
        $body['image'] = $image;

        $response = Http::withHeaders(['Accesstoken' => $this->token])
            ->withBody(json_encode($body))
            ->post($this->url . '/risetai/face-api/facegallery/verify-face');

        return $response->json();
    }
}