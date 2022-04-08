<?php

namespace App\Service;

/**
 * Class CurlCallService.
 */
class CurlCallService
{
    /**
     * @param int $id
     *
     * @return array|null
     */
    public function getElementFormationById(int $id): ?array
    {
        $ch = curl_init();

//        curl_setopt($ch, CURLOPT_URL, 'https://127.0.0.1:8000/api/element_formations/'.$id);
        curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.25:81/api/element_formations/'.$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = [];
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:'.curl_error($ch);
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}
