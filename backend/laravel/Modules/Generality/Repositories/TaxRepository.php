<?php

namespace Modules\Generality\Repositories;

use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Generality\Entities\Tax;
use Modules\Generality\Entities\Country;
use Modules\Generality\Entities\Province;
use Modules\Generality\Repositories\Interfaces\TaxRepositoryInterface;


class TaxRepository extends ModelRepository implements TaxRepositoryInterface
{
    /**
     * @var object
    */
    protected $model, $modelC, $modelP ;
    
    public function __construct(Tax $model, Country $modelC, Province $modelP)
    {
        $this->model = $model;
        $this->modelC = $modelC;
        $this->modelP = $modelP;

        parent::__construct($this->model);
    }

    /**
     * Display a listing of taxes with name of city and provinces, respectively.
     * @return Response
     */
    public function listAll()
    {
       $provinces = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();
        $countries = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
        $places = ['provinces' => $provinces, 'countries' => $countries];
        return $places;
    }

    /**
     * Display a tax consult by id tax.(Province). Used in listId.
     * @return Response
     */
    private function listIdProvince($tax_id)
    {
       $province = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->where('taxes.id',$tax_id)
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();
       
        
        return  $province;
    }
    /**
     * Display a tax consult by id tax.(Country). Used in listId.
     * @return Response
     */
    private function listIdCountry($tax_id)
    {
      
        $country = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->where('taxes.id',$tax_id)
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
        
        return  $country;
    }

    /**
     * Display a tax consult by id tax. Only colums from taxes table
     * @return Response
     */
    private function listOnlyTaxId($tax_id)
    {
        $tax = DB::table('taxes')
        ->select('taxable_type')
        ->where('taxes.id',$tax_id)
        ->get();
        return $tax;
    }


    /**
     * Display a tax consult by id tax.
     * @return Response
     */
    public function listId($tax_id)
    {
        if (strrpos($this->listOnlyTaxId($tax_id), 'Country')) {
            return $this->listIdCountry($tax_id);
        }
            return $this->listIdProvince($tax_id);
        
    }


    /**
     * Display a listing of taxes with name of city and provinces, respectively. Actives.
     * @return Response
     */
    public function listActive()
    {
       $provinces = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();
        $countries = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
        $places = ['provinces' => $provinces, 'countries' => $countries];
        return $places;
    }

     /**
     * Display a listing of taxes with name of city and provinces, respectively. Inactives.
     * @return Response
     */
    public function listNoActive()
    {
       $provinces = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->whereNotNull('end_date')
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();
        $countries = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->whereNotNull('end_date')
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
        $places = ['provinces' => $provinces, 'countries' => $countries];
        return $places;
    }

    /**
     * List the tax according to the location(province) and type of the user is false. This function is used in listProvince().
     * @param int $province_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    private function listProvince0($province_id, $is_company)
    {
        $province0 = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->where('type_user', false)
                ->where('provinces.id', $province_id)
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();
       return $province0;
    }

    /**
     * List the tax according to the location(province) and type of the user is True. This function is used in listProvince().
     * @param int $province_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    private function listProvince1($province_id, $is_company )
    {
        $province1 = DB::table('provinces')
                ->select('provinces.*', 'province_translations.name','taxes.*' )
                ->join('province_translations', 'provinces.id', '=', 'province_translations.province_id')
                ->join('taxes', 'provinces.id', '=', 'taxes.taxable_id')
                ->where('province_translations.locale', app()->getLocale())
                ->where('type_user', true)
                ->where('provinces.id', $province_id)
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPEPROVINCE'))
                ->get();

       
                return $province1;
        
    }

    /**
     * List the tax according to the location(province) and type of the user. This function is used in listTaxUser()
     * @param int $province_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    private function listProvince($province_id, $is_company)
    {
        if ($is_company=="true") {
            return $this->listProvince1($province_id, $is_company);
        }
            return $this->listProvince0($province_id, $is_company);
             
    }



    /**
     * List the tax according to the location(country) and type of the user is false. This function is used in listCountry(). 
     * @param int $country_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    private function listCountry0($country_id, $is_company )
    {
        $country0 = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->where('type_user', false)
                ->where('countries.id', $country_id)
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
       

        return $country0;
    }

     /**
     * List the tax according to the location(country) and type of the user is true. This function is used in listCountry(). 
     * @param int $country_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    private function listCountry1($country_id, $is_company )
    {
        $country1 = DB::table('countries')
                ->select('countries.*', 'country_translations.name','taxes.*' )
                ->join('country_translations', 'countries.id', '=', 'country_translations.country_id')
                ->join('taxes', 'countries.id', '=', 'taxes.taxable_id')
                ->where('country_translations.locale', app()->getLocale())
                ->where('type_user', true)
                ->where('countries.id', $country_id)
                ->whereNull('end_date')
                ->whereIn('type', config('constants.TYPECOUNTRY'))
                ->get();
       return $country1;
       
    }


    /**
     * List the tax according to the location(country) and type of the user. This function is used in listTaxUser()
     * @param int $country_id, its value from the user table
     * @param boolean $is_company, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
    */
    private function listCountry($country_id, $is_company)
    {
        if ($is_company=="true") {
            return $this->listCountry1($country_id, $is_company);
        }
            return $this->listCountry0($country_id, $is_company);
        
    }

    /**
     * List the tax according to the location(country/province) and type of the user.
     * @param int $parameters, its contains the next parameters (from Route respective):
     * @param int $country, its value from the user table
     * @param int $province, its value from the user table
     * @param boolean $iscompany, its value from the user table. True: self-employed and business, False: individuals.
     * @return Response
     */
    public function listTaxUser($parameters)
    {
        $province_id = $parameters['province'];
        $country_id = $parameters['country'];
        $is_company = $parameters['iscompany'];

        
        if( (!is_null($province_id)) && ($result=$this->listProvince($province_id, $is_company))){
              return $result;
          }

        return $this->listCountry($country_id, $is_company);
       
    }

    /**
     * Store tax in DB, if type of place is province
     * @return response
     */
   private function storePlaceProvince($taxCreate) {
        $province = $this->modelP->find($taxCreate['taxable_id']);
        return $province->taxes()->create($taxCreate);
    }

    /**
     * Store tax in DB, if type of place is country
     * @return response
     */
    private function storePlaceCountry($taxCreate) {
        $country = $this->modelC->find($taxCreate['taxable_id']);
        return $country->taxes()->create($taxCreate);
    }
    
    /**
     * Update end_date. If the place already has a registered tax, and you want to create a new
     * tax with the same place, you must update the end_date field in the previous record with
     * the date of the previous day of the new record.
     * @return reponse
     */
    private function updateEndDate($taxable_id, $type_user)
    {
        $date_now = date('Y-m-d');
            $date_past = strtotime('-1 days', strtotime($date_now));
            $date_past_formatted = date('Y-m-d', $date_past);

        return DB::table('taxes')
        ->where('taxable_id', $taxable_id)
        ->where('type_user', $type_user)
        ->update(['end_date'=> $date_past_formatted]);
    }



    /**
     * Use createTax to store Tax in Polymorphics relations
     * @param Request $request
     * @return Response
     */
    public function createTax($taxCreate){
        if (in_array($taxCreate['type'], config('constants.TYPEPROVINCE'))) {
            return $this->storePlaceProvince($taxCreate);
        }
        
        return $this->storePlaceCountry($taxCreate);
        
    }
}