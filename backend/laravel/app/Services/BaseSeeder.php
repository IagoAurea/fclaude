<?php

namespace App\Services;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

abstract class BaseSeeder extends Seeder
{

    public function __construct() {}

     /**
     * @param string|null $directory
     * @return string
     * Return file image random
     */
    protected function getImageRandom($directory = null)
    {
        $path = !is_null($directory)? $directory : '';

        $path_image = public_path() . '/images/' . $path;

        $files = glob($path_image . '/*.*');

        if(!$files) {
            return $path_image . 'default.png';
        }

        $file = array_rand($files ?? 0);

        return $files[$file];
    }

    /**
     * Return file image by directory and name
     * 
     * @param Array $params
     * @return String|NULL
     */
   protected function getImage($params)
    {
        $directory = $params['directory'];

        $name = $params['name'];

        $path_directory = !is_null($directory) ? $directory : '';

        $path_directory_image = $this->pathImages() . $path_directory;

        $files = glob($path_directory_image . '/' . $name . '*');

        return isset($files[0]) ? $files[0] : $this->pathImages() . 'default.png';
    }

    /**
     * @return array|false
     * Return array json content file
     */
    protected function getDataJson(string $name)
    {
        $directory = public_path();

        $file = $directory . "/data/" . $name;

        if(!file_exists($file)) {
            throw new \Exception('Cannot file exists');
        }

        $content = file_get_contents($file);

        if( $content === FALSE )
        {
            return FALSE;
        }

        return json_decode($content, true);
    }

    /**
    * @return string
    * Return path files images
    */
    protected function pathImages()
    {
      return public_path() . '/images/';
    }
}
