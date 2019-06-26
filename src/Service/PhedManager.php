<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 20/03/19
 * Time: 21:45
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhedManager
{
    private $uploadUrl;
    private $uploadKey;


    const ADD_END_POINT = 'filebrowser/index/add';
    const LIST_END_POINT = 'filebrowser/index';

    public function __construct($uploadServer, $uploadKey)
    {
        $this->uploadUrl = $uploadServer;
        $this->uploadKey = $uploadKey;
    }

    public function getUrl($endPoint, $params = [])
    {
        $params['access_token'] = $this->uploadKey;

        return $this->uploadUrl . '/' . $endPoint . '?' . $this->buildParamsStr($params);
    }

    private function buildParamsStr($params)
    {
        $paramsArray = [];
        foreach ($params as $key => $param) {
            $paramsArray[] = $key . '=' . urlencode($param);
        }

        return implode('&', $paramsArray);
    }

    public function sendUploadedFile(UploadedFile $file, $directoryPath, $fileName = null)
    {
        if (!$fileName) {
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->guessExtension();
        } else {
            $fileName .= '.' . $file->guessExtension();
        }
        return $this->sendFile($file, $directoryPath, $fileName);
    }

    public function sendFile(File $file, $directoryPath, $fileName)
    {
        $file->move(sys_get_temp_dir(), $fileName);
        $target_url = $this->getUrl(self::ADD_END_POINT);
        if (function_exists('curl_file_create')) { // php 5.5+
            $cFile = curl_file_create(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName);
        } else { //
            $cFile = '@' . realpath(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $fileName);
        }
        $post = array(
            'parent_folder' => $directoryPath,
            'file' => $cFile,
            'is_folder' => 0,
            'access_token' => $this->uploadKey
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);


        // $errors = curl_error($ch);
        // $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        unlink(sys_get_temp_dir().DIRECTORY_SEPARATOR.$fileName);

        return json_decode($result);
    }


}
