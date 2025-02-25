<?php

namespace App\Helpers;

use Modules\Club\Entities\Club;
use App\Traits\ResourceTrait;
use Exception;

class Helper
{
    use ResourceTrait;

    /**
     * Convert object to array
     * @param Object $object
     * @return Array
     */
    public function objectToArray($object)
    {
        return @json_decode(json_encode($object), true);
    }

    /**
     * Sort array of object by field
     * @param String $field
     * @return Array
     */
    public function sortArrayByKey($array, $key, $desc = false)
    {
        if($desc) {
            usort($array,function($a, $b) use($key){
                return $b[$key] <=> $a[$key];
            });
        } else {
            usort($array,function($a, $b) use($key){
                return $a[$key] <=> $b[$key];
            });
        }

        return $array;
    }

    /**
     * Find in array normal or multidimentional
     * @param string $needle
     * @param array $haystack
     * @param string|null $column
     * @return void|int|string
     */
    static public function arrayFind($needle, array $haystack, $column = null)
    {
        if (is_array($haystack[0]) === true) {
            foreach (array_column($haystack, $column) as $key => $value) {
                if (strpos(strtolower($value), strtolower($needle)) !== false) {
                    return $key;
                }
            }
        } else {
            foreach ($haystack as $key => $value) {
                if (strpos(strtolower($value), strtolower($needle)) !== false) {
                    return $key;
                }
            }
        }
    }
    
    /**
     * Converts an string to JSON
     * @param String $string
     * @return Object
     */
    public function stringToJson($string)
    {
        try {
            return json_decode($string);
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Check if a string sent has an array structure.
     * @param String $string
     * @return int|false
     */
    public function validateStringArray ($string)
    {
        return preg_match('/\[(((\"[\.\+\-\\ #0-9]+\"),?\ ?))*\]$/', $string);
    }

    /**
     * Function to be used as an parser from array based strings
     * into real strings
     *
     * @param String $value
     * @param Boolean $removeSpaces
     * @return Array|NULL
     */
    public function stringArrayParser($value, $removeSpaces = true)
    {
        if (!$value) {
            return NULL;
        }

        $replacing_chars = [
            '[', ']', '"',
        ];

        if ($removeSpaces) {
            array_push($replacing_chars, ' ');
        }

        $replaced = str_replace($replacing_chars, '', $value);
        

        return explode(',', $replaced);
    }

    /**
     * Retrieves a class name depending on the item sent
     *
     * @param String $type
     * @return String
     */
    public function parseClassType($type)
    {
        $types = [
            'club' => Club::class,
        ];

        return $types[$type];
    }

    /**
     * Sum time format hours:minutes
     */
    public function sumTimeHoursMinutes($times)
    {
        $minutes = 0;

        foreach ($times as $time) {
            sscanf($time, '%d:%d', $hour, $min);

            $minutes += $hour * 60 + $min;
        }

        if($hours = floor($minutes / 60)) {
            $minutes %= 60;
        }

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Retrieves a text without number
     *
     * @param String $text
     * @return String
     */
    public function textWithoutNumbers($text)
    {
        if(empty($text)){ return $text; }

        return implode(' ',array_filter(explode(' ', preg_replace('/[0-9]+/', '', $text))));
    }

    /**
     * Resize base64 image
     *
     */
    public function resizeBase64img($base64img,$mimeimg,$newwidth,$newheight){
        list($width, $height) = getimagesizefromstring(base64_decode($base64img));
    
        ob_start();
        $temp_thumb = imagecreatetruecolor($newwidth, $newheight);
        imagealphablending( $temp_thumb, false );
        imagesavealpha( $temp_thumb, true );
    
        $source = imagecreatefromstring(base64_decode($base64img));
    
        imagecopyresized($temp_thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    
        switch ($mimeimg) {
            case 'png':
            case 'image/png':
            case 'PNG':
            case 'IMAGE/PNG':
                imagepng($temp_thumb, null);
                break;
            case 'jpg':
            case 'image/jpg':
            case 'jpeg':
            case 'JPEG':
            case 'JPG':
            case 'IMAGE/JPG':
            case 'IMAGE/JPEG':
            case 'image/jpeg':
                imagejpeg($temp_thumb, null);
                break;
            case 'image/gif':
            case 'gif':
            case 'GIT':
            case 'IMAGE/GIF':
                imagegif($temp_thumb, null);
                break;
            default:
                break;
        }
    
        $stream = ob_get_clean();
        $newB64 = base64_encode($stream);
        imagedestroy($temp_thumb);
        imagedestroy($source);

        return $newB64;
    }

    /**
     * Filter unique array
     * @param @array
     *
     */
    public function filterUniqueArray($array)
    {
        return array_map("unserialize", array_unique(array_map("serialize", $array)));
    }
}
