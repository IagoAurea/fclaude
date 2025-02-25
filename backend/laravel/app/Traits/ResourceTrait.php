<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait ResourceTrait
{
    private $numberCharacterRandomName = 16;

    /**
     * Return url temporary download file
     * @param string $filePath
     * @return string|boolean
     */
    public function downloadResource($filePath)
    {
        $hasFile = Storage::exists($filePath);

        if (!$hasFile) { return false; }

        return Storage::download($filePath);
    }

    /**
     * Return array data of resource
     * @param string $directory
     * @param object $file
     * @param string $name
     * @return array
     */
    public function uploadResource($directory, $file, $name = null)
    {
        $dataResource = [
            'directory' => $directory,
            'file' => $file,
            'name' => $name
        ];

        $url = (string) $this->typeStorage(gettype($file), $dataResource);

        return [
            'url' => $url,
            'mime_type' => Storage::mimeType($url),
            'size' => Storage::size($url)
        ];
    }

    /**
     * Return array data of resource
     * @param string $file
     * @return mixed
     */
    public function deleteResource($file)
    {
        $hasFile = Storage::exists($file);

        if (!$hasFile) { return false; }

        return Storage::delete($file);
    }

    /**
     * Return url data of resource
     * @param string|boolean $type
     * @param array $dataResource
     * @return string|boolean
     */
    protected function typeStorage($type, $dataResource)
    {
        if ($type === 'string' && $this->isBase64($dataResource['file'])) {
            $imageData = base64_decode(Arr::last(explode(',', $dataResource['file'])));

            $name = $dataResource['name'] ?? Str::random($this->numberCharacterRandomName);

            $extension = $this->getExtensionBase64($dataResource['file']);

            $imagePath = sprintf('%s/%s.%s', $dataResource['directory'], $name, $extension);

            Storage::put($imagePath, $imageData);

            return $imagePath;
        }

        if ($type === 'string') {
            return Storage::put($dataResource['directory'], new File($dataResource['file']));
        }

        if ($dataResource['name']) {
            return Storage::putFileAs($dataResource['directory'], $dataResource['file'], $dataResource['name']);
        }

        return Storage::putFile($dataResource['directory'], $dataResource['file']);
    }

    /**
     * Validate if string is base64 image
     * 
     * @param $string
     * @return bool
     */
    protected function isBase64($string)
    {
        return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', Arr::last(explode(',', $string)));
    }

    /**
     * Obtain extension from base64
     */
    protected function getExtensionBase64($base64)
    {
        return explode('/', explode(':', substr($base64, 0, strpos($base64, ';')))[1])[1];
    }
}