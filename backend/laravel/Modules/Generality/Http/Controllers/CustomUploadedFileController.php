<?php

namespace Modules\Generality\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\UploadedFile;

class CustomUploadedFileController extends UploadedFile
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $base64Data;

    public function __construct($base64Data, $originalName)
    {
        $this->base64Data = $base64Data;
        
        parent::__construct(
            $this->getStream(),
            $originalName,
            null,
            null,
            true
        );
    }

    protected function getStream()
    {
        $tempFilePath = tempnam(sys_get_temp_dir(), 'uploadedfile');
        file_put_contents($tempFilePath, base64_decode($this->base64Data));
        return $tempFilePath;
    }
}
