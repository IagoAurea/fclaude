<?php

namespace App\Traits;

trait TranslationTrait
{

    /**
     * @var string
     */
    protected $fileTranslation = 'messages';

    /**
     * Return translation by key
     * @param string $key
     * @param array $attribute
     * @return string|null
     */
    public function translator($key, $attribute = [])
    {
        return trans($this->fileTranslation . '.' .$key, $attribute);
    }
}