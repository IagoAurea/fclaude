<?php

namespace Modules\Package\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Modules\User\Services\TaxService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Package\Repositories\AttributePackRepository;
use Modules\Package\Repositories\AttributePackRepository;
use Modules\Package\Http\Requests\ShowDetailPackageRequest;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;
use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;

class PackageController extends BaseController
{
    /**
     * @var object
     */
    protected $packageRepository;

    /**
     * @var object
     */
    protected $taxService;

    /**
     * @var object
     */
    protected $attributesPack;

    public function __construct(
        PackageRepositoryInterface $packageRepository,
        TaxService $taxService,
        AttributePackRepositoryInterface $attributePackRepository
    )
    {
        $this->packageRepository = $packageRepository;
        $this->taxService = $taxService;
        $this->attributesPack = $attributePackRepository;
    }

    /**
    * @OA\Get(
    *       path="/api/v1/packages/subpackages/detail",
    *       tags={"Packages"},
    *       summary="Get detail package with price -
    *       Detalle de paquete con su precio y total por el numero de licencias",
    *       operationId="detail-package-price",
    *       security={{"bearerAuth": {} }},
    *       description="Return detail package with price for number license -
    *       Retorna etalle de paquete con su precio y total por el numero de licencias",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Parameter( ref="#/components/parameters/type" ),
    *       @OA\Parameter( ref="#/components/parameters/subpackage" ),
    *       @OA\Parameter( ref="#/components/parameters/licenses" ),
    *       @OA\Parameter( ref="#/components/parameters/period" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       )
    * )
    */
    /**
     * Display a package with price.
     * @return JsonResponse
     */
    public function showDetailPackage(ShowDetailPackageRequest $request)
    {
        $validate = $request->validated();

        $package = $this->packageRepository->findPackageWithPrice($validate);

        $price = $package->subpackages->first()->prices->first() ?? null;

        if($price) {
            $amount = (float)$request->licenses * (float)$price[$request->period];

            $user = Auth::user();

            $tax = $user->tax;

            $price->amount = number_format($amount, 2);

            $price->tax_user = number_format($this->taxService->calculatedTax($amount, $tax->value), 2);
        }

        return $this->sendResponse($price, 'Detail price package');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/packages",
    *       tags={"Packages"},
    *       summary="Get list Package - Lista de paquetes",
    *       operationId="list-package",
    *       description="Return data list package - Retorna listado de paquetes con su detalle",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       )
    * )
    */
    /**
     * Display a listing of the package.
     * @return Response
     */
    public function index()
    {
        $packages = $this->packageRepository->findAllTranslated();

        return $this->sendResponse($packages, 'List Packages');
    }

    /**
     * Display a listing of the package filtered by the current package price.
     * @return Response
     */
    public function ownIndex()
    {
        $packages = $this->packageRepository->findAllTranslated();

        $subscriptions = Auth::user()->subscriptions;

        $subscription_types = $subscriptions->pluck('package_code')->toArray();
        
        $packages = $packages->filter(function ($package) use ($subscription_types) {
            return in_array($package->code, $subscription_types);
        });

        $packages = $packages->map(function ($package) use ($subscriptions) {
            return $package->subpackages->map(function ($subpackage) use ($subscriptions, $package) {
                $subscription = $subscriptions->where('package_code', $package->code)->first();
                
                return $subpackage->prices->filter(function ($price) use ($subscription) {
                    return $price->name == $subscription->packagePrice->name;
                });
            });
        });

        return $this->sendResponse($packages, 'List Packages');
    }

    /**
     * Display a listing of all attributes.
     * @return Response
     */
    public function showSubpackageAttributes()
    {
        $attributes = $this->attributesPack->findAll();
        // $attributes = $this->packageRepository->findAllTranslated();
        // $attributePack = $attributes->findAll();
        // echo $attributes;

        return $this->sendResponse($attributes, 'List Attributes');
    }
}
