<?php

namespace Modules\User\Services;

use Exception;
use Modules\Generality\Entities\Country;
use Modules\Generality\Entities\Province;
use Modules\Generality\Repositories\Interfaces\TaxRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;

class TaxService
{
    const SPAIN = 'es';
    const CANARY_ID = 3785;
    const TENERIFE_ID = 3808;
    const COUNTRY_ID_DEFAULT = 239;

    /**
     * @var $countryRepository
     */
    protected $countryRepository;

    /**
     * @var $taxRepository
     */
    protected $taxRepository;

    /**
     * Instance a new service class.
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        TaxRepositoryInterface $taxRepository
    )
    {
        $this->countryRepository = $countryRepository;
        $this->taxRepository = $taxRepository;
    }

    /**
     * Calculate tax of amount
     */
    public function calculatedTax($amount, $tax)
    {
        return $amount * $tax / 100;
    }

    /**
     * Validate tax user and company
     */
    public function validateTax($model)
    {
        $country = $this->countryRepository->findOneBy(['id' => $model->country_id]);
        
        $isCompany = $model->is_company == 'true' ? 1 : 0;
        $isCountryUE = (boolean) $country->belongs_ue;
        $tax = null;

        if ($country->iso2 == self::SPAIN) {
            $tax = $this->taxApplySpain($model, $country, $isCompany);
        } elseif ($isCountryUE && !$isCompany) {
            $tax = $this->getTaxesApply(Country::class, $country->id);
        } else {
            $tax = $this->getTaxesApply(Country::class, self::COUNTRY_ID_DEFAULT, $isCompany);
        }

        return $tax->id;
    }

    private function taxApplySpain($model, $country, $isCompany)
    {
        $tax = null;

        if ($model->province_id == self::CANARY_ID) {
            $tax = $this->getTaxesApply(Province::class, self::CANARY_ID, $isCompany);
        } elseif ($model->province_id == self::TENERIFE_ID) {
            $tax = $this->getTaxesApply(Province::class, self::TENERIFE_ID, $isCompany);
        } else {
            $tax = $isCompany ?
                $this->getTaxesApply(Country::class, self::COUNTRY_ID_DEFAULT, $isCompany) :
                $this->getTaxesApply(Country::class, $country->id);
        }

        return $tax;
    }

    private function getTaxesApply($model, $id, $typeUser = null)
    {
        $fieldQuery = [
            'taxable_id' => $id,
            'taxable_type' => $model
        ];

        if (!is_null($typeUser)) {
            $fieldQuery['type_user'] = $typeUser;
        }

        return $this->taxRepository->findOneBy($fieldQuery );
    }
}
