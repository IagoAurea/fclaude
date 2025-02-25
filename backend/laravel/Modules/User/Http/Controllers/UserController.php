<?php

namespace Modules\User\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Modules\User\Cache\UserCache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Modules\User\Services\UserService;
use Modules\Club\Entities\ClubInvitation;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Http\Requests\EditUserRequest;
use Modules\Generality\Services\ResourceService;
use Modules\User\Http\Requests\RegisterUserRequest;
use Modules\Subscription\Services\SubscriptionService;
use Modules\User\Http\Requests\ManagePermissionRequest;
use Modules\User\Http\Requests\AddPaymentMethodRequest;
use Modules\User\Http\Requests\RegisterUserByLicenseRequest;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Payment\Repositories\Interfaces\PaymentRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\BusinessRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubInvitationRepositoryInterface;
use Modules\User\Entities\User;

class UserController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $paymentRepository
     */
    protected $paymentRepository;

    /**
     * @var $businessRepository
     */
    protected $businessRepository;

    /**
     * @var $clubInvitationRepository
     */
    protected $clubInvitationRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * @var $subscriptionService
     */
    protected $subscriptionService;

    /**
     * @var $userCache
     */
    protected $userCache;

    /**
     * @var $role
     */
    protected $role = 'user';

    public function __construct(
        UserRepositoryInterface $userRepository,
        ResourceRepositoryInterface $resourceRepository,
        ClubInvitationRepositoryInterface $clubInvitationRepository,
        PaymentRepositoryInterface $paymentRepository,
        BusinessRepositoryInterface $businessRepository,
        SubscriptionService $subscriptionService,
        ResourceService $resourceService,
        UserService $userService,
        UserCache $userCache
    ) {
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
        $this->clubInvitationRepository = $clubInvitationRepository;
        $this->paymentRepository = $paymentRepository;
        $this->businessRepository = $businessRepository;
        $this->subscriptionService = $subscriptionService;
        $this->resourceService = $resourceService;
        $this->userService = $userService;
        $this->userCache = $userCache;

    }

    /**
     * Register a new user.
     * @param Request $request
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/users/register",
     *  tags={"User"},
     *  summary="Register User",
     *  operationId="user-register",
     *  description="Registers a new user",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/RegisterUserRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            $sendEmail = true;

            if ($request->provider_google_id) {
                $request->merge(['email_verified_at' => now()]);
                $request->merge(['active' => true]);
                $sendEmail = false;
            }

            if ($request->license_invite_token) {
                $user = $this->userService->handleLicenseInvitationRegistry($request->all());
            }

            if ($request->club_invite_token) {
                $request->merge(['email_verified_at' => now()]);
                $request->merge(['active' => true]);
                $sendEmail = false;

                $this->clubInvitationRepository->update([
                    'accepted_at' => Carbon::now(),
                    'expires_at' => null,
                    'status' => ClubInvitation::STATUS_ACTIVE,
                ], ['code' => $request->club_invite_token]);

                $user = $this->userService->handleInvitedUserRegistry($request);
            } else {
                $user = $this->userRepository->create($request->all());
            }

            $user->assignRole($this->role);
            $user->tax;

            $message = trans('user::messages.user_store');

            if ($sendEmail) {
                dispatch(function () use ($user) {
                    event(new Registered($user));
                })->afterResponse();

                $message = trans('user::messages.user_store_verify_email');
            }

            return $this->sendResponse($sendEmail ? null : $user, $message, Response::HTTP_CREATED);

        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Registers a new user with specific license invitation
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/users/license-register",
     *  tags={"User"},
     *  summary="Register With License Code",
     *  operationId="user-store-with-license",
     *  description="Registers a new user with license ionvitation",
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/RegisterUserByLicenseRequest"
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function registerByLicense(RegisterUserByLicenseRequest $request)
    {
        try {
            $user = $this->userService->handleLicenseInvitationRegistry($request->all());

            $user->assignRole($this->role);

            event(new Registered($user));

            return $this->sendResponse($user, $this->translator('user_create'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Get data profile user authenticate
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/users/profile",
     *   tags={"User"},
     *   summary="Get data user authenticate - Retorna datos del usuario autenticado",
     *   operationId="user-profile",
     *   description="Return data user profile - Retorna datos de perfil de usuario",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function profile()
    {
        try {
            $user = $this->userCache->profileUser();

            return $this->sendResponse($user, 'User data');
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving user', $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *       path="/api/v1/users/edit/{user_id}",
     *       tags={"User"},
     *       summary="Edit Data user profile - Edita perfil del usuario",
     *       operationId="user-edit-profile",
     *       description="Edit data user profile - Edita datos del perfil del usuario",
     *       security={{"bearerAuth": {} }},
     *       @OA\Parameter( ref="#/components/parameters/_locale" ),
     *       @OA\Parameter( ref="#/components/parameters/user_id" ),
     *       @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *           mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/EditUserRequest")
     *         )
     *       ),
     *       @OA\Response(
     *           response=200,
     *           ref="#/components/responses/reponseSuccess"
     *       ),
     *       @OA\Response(
     *           response=422,
     *           ref="#/components/responses/unprocessableEntity"
     *       ),
     *       @OA\Response(
     *           response="401",
     *           ref="#/components/responses/notAuthenticated"
     *       )
     * )
     */
    /**
     * Update data profile user authenticate
     * @param Request $request
     * @return Response
     */
    public function update(EditUserRequest $request, $user_id)
    {
        try {
            $update = $this->userService->update($user_id, $request);

            $this->userCache->deleteUserData($user_id);

            return $this->sendResponse($update, $this->translator('user_update'));

        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Method used to get all permissions related to the user
     *
     * @return Response
     */
    public function getPermissions()
    {
        try {
            $user = Auth::user();

            return $this->sendResponse($user->entityPermissions, 'User permissions data');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Method use to store / delete permissions depending on the data sent
     *
     * @return Response
     */
    public function managePermissions(ManagePermissionRequest $request)
    {
        try {
            // Returning message
            $manageType = '';

            // Get the entity class
            $entityClass = $this->userService->resolvePermissionClass($request->entity);

            // Find the related user
            $user = $this->userRepository->findOneBy([
                'id' => $request->user_id,
            ]);

            // Get the existent permission
            $existentPermission = $user->searchEntityPermission(
                $request->permission,
                $request->entity_id,
                $entityClass
            );

            // Manage the permission depending of its existance
            $manageType = $existentPermission ? 'revoke' : 'assign';

            // Send the process to the permission management
            $user->manageEntityPermission(
                $request->permission,
                $request->entity_id,
                $entityClass,
                $manageType
            );

            // Returning data
            $data = [
                'manage_type' => $manageType,
                'permissions' => $user->entityPermissions
            ];

            $this->userCache->deleteUserData($request->user_id);

            return $this->sendResponse($data, $this->translator('user_update'));
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Method used to remove user only test development
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        try {
            $user = $this->userRepository->findOneBy(['email' => $request->email]);

            if (!$user) {
                return $this->sendError('Error', 'User not found', Response::HTTP_NOT_FOUND);
            }

            $this->userRepository->delete($user->id);

            $this->userRepository->update(['email' => Str::random(10)], $user);

            $this->userCache->deleteUserData($user->id);

            return $this->sendResponse(null, 'User deleted');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Add payment method user authenticate
     * @return Response
     *
     * @OA\Post(
     *   path="/api/v1/users/payment-method",
     *   tags={"User"},
     *   summary="Add data payment method user authenticate - Agrega datos de metodo de pago usuario autenticado",
     *   operationId="user-add=payment-method",
     *   description="Add data user payment method - Agrega datos de metodo de pago  de usuario",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          ref="#/components/schemas/AddPaymentMethodRequest"
     *      )
     *  ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function addPaymentMethod(AddPaymentMethodRequest $request)
    {
        $user = Auth::user();

        try {
            $add = $this->subscriptionService->assignMethodPayment($user, $request->payment_method_token);

            $user->updateDefaultPaymentMethod($request->payment_method_token);

            $this->userCache->deleteUserData($user->id);

            return $this->sendResponse($add, $this->translator('user_add_payment_method'));

        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Get data payment method user authenticate
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/users/payment-method",
     *   tags={"User"},
     *   summary="Get data payment method user authenticate - Retorna datos de metodo de pago usuario autenticado",
     *   operationId="user-payment-method",
     *   description="Return data user payment method - Retorna datos de metodo de pago  de usuario",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function getPaymentMethod()
    {
        $user = Auth::user();

        try {
            $paymentsMethod = $user->paymentMethods();

            $userPaymentMethod = $paymentsMethod->first() ?? null;

            return $this->sendResponse($userPaymentMethod, 'User payment method');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Delete payment method user authenticate
     * @return Response
     *
     * @OA\Delete(
     *   path="/api/v1/users/payment-method",
     *   tags={"User"},
     *   summary="Delete payment method user authenticate - Elimina metodo de pago usuario autenticado",
     *   operationId="user-delete-payment-method",
     *   description="Delete user payment method - Elimina de metodo de pago  de usuario",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function deletePaymentMethod()
    {
        $user = Auth::user();

        try {
            $user->deletePaymentMethods();

            $this->userCache->deleteUserData($user->id);

            return $this->sendResponse(null, $this->translator('user_delete_payment_method'));
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Get data invoices user authenticate
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/users/invoices",
     *   tags={"User"},
     *   summary="Get data invoices user authenticate - Retorna datos de facturas usuario autenticado",
     *   operationId="user-invoices",
     *   description="Return data user invoices - Retorna datos de facturas  de usuario",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function getInvoices()
    {
        try {
            $invoices = $this->paymentRepository->findBy(['user_id' => Auth::id()]);

            return $this->sendResponse($invoices, 'List invoices');
        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Returns an exercise pdf
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/users/invoices/{code}/pdf",
     *  tags={"User"},
     *  summary="PDF invoice user - PDF de factura de usuario, enviar el campo invoice_number como code",
     *  operationId="invoice-user-pdf",
     *  description="Returns PDF invoice user, send field invoice_number by code -
     *  Retorna PDF de factura de usuario, enviar el campo invoice_number como code",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(ref="#/components/parameters/_locale"),
     *  @OA\Parameter(ref="#/components/parameters/code"),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function generateInvoicePdf($invoice_number)
    {
        $invoice = $this->paymentRepository->findOneBy(['invoice_number' => $invoice_number]);

        $invoice->user;

        if (!$invoice) {
            return $this->sendError('Error', 'Invoice not found', Response::HTTP_NOT_FOUND);
        }

        $user = Auth::id();

        if ($user !== $invoice->user_id) {
            return $this->sendError('Error', 'Invoice not user', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $business = $this->businessRepository->findOneBy(['id' => 1]);

        Carbon::setlocale(app()->getLocale());

        try {
            $dompdf = App::make('dompdf.wrapper');
            $pdf = $dompdf->loadView('user::invoice', compact(['invoice', 'business']));

            return new Response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' =>
                    'attachment; filename="' . sprintf('invoice-%s.pdf', $invoice->invoice_number) . '"',
                'Content-Length' => null,
            ]);
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by retrieving pdf invoice user',
                $exception->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    // public function list(ListUserRequest $request)
    // {
    //     // Obtener los parámetros de paginación
    //     $perPage = $request->input('per_page', 10); // Valor por defecto: 10
    //     $page = $request->input('page', 1); // Valor por defecto: 1

    //     // Obtener los usuarios paginados
    //     $users = User::paginate($perPage);

    //     return response()->json([
    //         'message' => 'hola',
    //         'data' => $users,
    //     ]);
    // }

    
    /**
     * Get data payment method user authenticate
     * @return Response
     *
     * @OA\Get(
     *   path="/api/v1/users/search",
     *   tags={"User"},
     *   summary="Search users",
     *   operationId="user-search",
     *   description="Return user data",
     *   security={{"bearerAuth": {} }},
     *   @OA\Parameter( ref="#/components/parameters/_locale" ),
     *   @OA\Parameter(
     *     name="query",
     *     in="query",
     *     required=false,
     *     @OA\Schema(type="string"),
     *     description="Search query"
     *   ),
     *   @OA\Response(
     *       response=200,
     *       ref="#/components/responses/reponseSuccess"
     *   ),
     *   @OA\Response(
     *       response="401",
     *       ref="#/components/responses/notAuthenticated"
     *   )
     * )
     */
    public function userSearch(Request $request)
    {
        $query = $request->input('query');

        // Validar el input
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        // Realizar la búsqueda
        $users = User::where('full_name', 'like', '%' . $query . '%')->orWhere('email', 'like', "%$query%")
            ->paginate(10);

        return $this->sendResponse($users, "Resultado de la busqueda");
    }
}
