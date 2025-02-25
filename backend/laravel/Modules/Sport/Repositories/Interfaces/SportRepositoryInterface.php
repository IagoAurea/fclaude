<?php

namespace  Modules\Sport\Repositories\Interfaces;

interface SportRepositoryInterface
{
    /**
     * Returns the list of sports translated
     *
     * @var array
     */
    public function findAllTranslated();

    /**
     * Returns the list of sport codes
     *
     * @var array
     */
    public function getSportCodes();

    /**
     * Updates the field_image attribute
     *
     * @return bool
     */
    public function updateFieldImage($code, $value);

    /**
     * Retrieves a list of sports depending on the type sent
     * 
     * @var boolean|integer|string
     * @return array
     */
    public function findByScouting($type);
}