<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Modules\Club\Entities\Club;
use Laravel\Passport\HasApiTokens;
use Modules\Player\Entities\Player;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Modules\Generality\Entities\Tax;
use Modules\User\Entities\Permission;
use Modules\User\Services\TaxService;
use Modules\Staff\Entities\StaffUser;
use Modules\User\Services\UserService;
use Spatie\Permission\Traits\HasRoles;
use Modules\Injury\Entities\InjuryRfd;
use Modules\Exercise\Entities\Exercise;
use Modules\Activity\Entities\Activity;
use Modules\Evaluation\Entities\Rubric;
use Modules\Fisiotherapy\Entities\File;
use Illuminate\Notifications\Notifiable;
use Modules\Generality\Entities\Country;
use Modules\Tutorship\Entities\Tutorship;
use Modules\Generality\Entities\Resource;
use Modules\Generality\Entities\Province;
use Modules\Subscription\Entities\License;
use Modules\Test\Entities\TestApplication;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Modules\Training\Entities\ExerciseSession;
use Modules\Subscription\Entities\Subscription;
use Modules\Nutrition\Entities\NutritionalSheet;
use Modules\Psychology\Entities\PsychologyReport;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *      title="User",
 *      description="User model",
 *      @OA\Xml( name="User"),
 *      @OA\Property( title="Email", property="email", description="Email", format="email", example="user@example.com" ),
 *      @OA\Property( title="Full Name", property="full_name", description="Full name user", format="string", example="John Doe" ),
 *      @OA\Property( title="Username", property="username", description="Username user", format="string", example="JohnDoe" ),
 *      @OA\Property( title="Password", property="password", description="password", format="password", example="Anypass12345$" ),
 *      @OA\Property( title="Password Confirmation", property="password_confirmation", description="confirmation password", format="password", example="Anypass12345$" ),
 *      @OA\Property( title="Country", property="country_id", description="Country", format="int64", example="1" ),
 *      @OA\Property( title="Province", property="province_id", description="Province", format="int64", example="10" ),
 *      @OA\Property( title="City", property="city", description="City", format="string", example="Alcoi" ),
 *      @OA\Property( title="Zipcode", property="zipcode", description="Zip Code", format="string", example="33066" ),
 *      @OA\Property( title="Phone", property="phone", description="Phone", format="array", example="[+34424445456]" ),
 *      @OA\Property( title="Mobile Phone", property="mobile_phone", description="Mobile Phone", format="array", example="[+34424445456]" ),
 *      @OA\Property( title="Is Company", property="is_company", description="Is company", format="boolean", example="true" ),
 *      @OA\Property( title="Company Name", property="company_name", description="Company Name", format="string", example="Comany Test" ),
 *      @OA\Property( title="Company Number", property="company_idnumber", description="Company Number", format="string", example="12345" ),
 *      @OA\Property( title="Company VAT", property="company_vat", description="Company VAT", format="string", example="VAT12345" ),
 *      @OA\Property( title="Company Address", property="company_address", description="Company Address", format="string", example="España Alcoi" ),
 *      @OA\Property( title="Company City", property="company_city", description="Company city", format="string", example="Alcoi" ),
 *      @OA\Property( title="Company Zip Code", property="company_zipcode", description="Company zip code", format="string", example="33068" ),
 *      @OA\Property( title="Company Phone", property="company_phone", description="Company phone", format="string", example="+34ssd33068" ),
 *      @OA\Property( title="Provider Google", property="provider_google_id", description="Provider Google Id", format="string", example="Adsds343fd64f" ),
 *      @OA\Property( title="Logo", property="image", description="Logo User", format="string", example="/images/users/logo.png" ),
 *      @OA\Property( title="Cover", property="cover", description="Cover User", format="string", example="/images/users/cover.png" ),
 *      @OA\Property(property="created_at", ref="#/components/schemas/BaseModel/properties/created_at"),
 *      @OA\Property(property="updated_at", ref="#/components/schemas/BaseModel/properties/updated_at"),
 *      @OA\Property(property="deleted_at", ref="#/components/schemas/BaseModel/properties/deleted_at")
 * )
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasRoles, HasApiTokens, Billable;

    protected $guard_name = "api";

    const GENDER_UNDEFINED = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const GENDER_IDENTITY_NOT_BINARY = 0;
    const GENDER_IDENTITY_MAN = 1;
    const GENDER_IDENTITY_WOMAN = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $with = ['image'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'password',
        'email',
        'active',
        'gender',
        'gender_identity_id',
        'dni',
        'username',
        'address',
        'country_id',
        'province_id',
        'city',
        'zipcode',
        'phone',
        'mobile_phone',
        'is_company',
        'company_name',
        'company_idnumber',
        'company_vat',
        'company_address',
        'company_city',
        'company_zipcode',
        'company_phone',
        'user_type',
        'image_id',
        'cover_id',
        'taxes_id',
        'provider_google_id',
        'email_verified_at',
        'vat_verified_at',
        'vat_valid'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone' => 'array',
        'mobile_phone' => 'array',
        'trial_ends_at' => 'datetime'
    ];

    /**
     * The attributes types.
     *
     * @var array
     */
    protected $attributes = [
        'gender' => 0,
    ];

    /**
     * Function boot model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->country_id) {
                $model->taxes_id = $model->assignTax($model);
            }

            if ($model->company_vat) {
                $model->vat_valid = $model->isVatValid($model);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty(['email_verified_at', 'country_id', 'province_id', 'is_company'])) {
                $model->taxes_id = $model->assignTax($model);
            }

            if ($model->isDirty(['company_vat'])) {
                $model->vat_valid = $model->isVatValid($model);
            }
        });
    }

    /**
     * The tax rates that should apply to the customer's subscriptions.
     *
     * @return array<int, string>
     */
    public function taxRates()
    {
        $tax = $this->tax;

        if ($tax) {
            return [$tax->stripe_tax_id];
        }
    }

    /**
     * Valid VAT user
     *
     * @param @model
     */
    private function isVatValid($model)
    {
        $userService = resolve(UserService::class);

        return $userService->validateVat($model);
    }

    /**
     * Assign tax to user
     *
     * @param @model
     */
    private function assignTax($model)
    {
        $taxService = resolve(TaxService::class);

        return $taxService->validateTax($model);
    }

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Set the user's username.
     *
     * @param string $value
     * @return void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * Get gender types
     * @return array
     */
    public static function getGenderTypes()
    {
        return [
            // [
            //     "id" => self::GENDER_UNDEFINED,
            //     "code" => 'undefined',
            // ],
            [
                "id" => self::GENDER_MALE,
                "code" => 'male',
            ],
            [
                "id" => self::GENDER_FEMALE,
                "code" => 'female',
            ],
        ];
    }

    /**
     * Get gender identity types
     * @return array
     */
    public static function getGenderIdentityTypes()
    {
        return [
            [
                "id" => self::GENDER_IDENTITY_NOT_BINARY,
                "code" => 'not_binary',
            ],
            [
                "id" => self::GENDER_IDENTITY_MAN,
                "code" => 'man',
            ],
            [
                "id" => self::GENDER_IDENTITY_WOMAN,
                "code" => 'woman',
            ],
        ];
    }

    /**
     * Generate token authorization
     *
     * @return string $tokenUser
     */
    public function generateToken($remember)
    {
        $tokenUser = $this->createToken('API');

        $date = Carbon::now();

        $expires = $date->addMinutes(config('session.lifetime'));

        if ($remember) {
            $expires = $date->addWeeks('4');
        }

        $token = $tokenUser->token;
        $token->expires_at = $expires;
        $token->save();

        return $tokenUser;
    }

    /**
     * Adds or deeletes a permission relationship linked to the user model
     * depending on the parameters sent to the function
     *
     * @param string|int $permission id or name of the permission
     * @param int $entityId is the id of the entity related to the user permission
     * @param string $operation is the type of operation to be executed
     *
     * @return void
     */
    public function manageEntityPermission($permission, $entityId, $entityClass, $operation)
    {
        // Set the querying var to a null
        $permissionId = null;

        // Check if the permission given by parameter is an integer
        if (is_int($permission)) {
            $permissionId = $permission;
        } else {
            // Otherwise, search it on the model and retrieve the id
            $permissionId = Permission::where('name', $permission)->first()->id;
        }

        // Build the data array to be sent to the permission static call
        $permData = [
            'permission_id' => $permissionId,
            'model_id' => $this->id,
            'entity_id' => $entityId,
            'entity_type' => $entityClass,
        ];

        // Do the assignment
        if ($operation == 'assign') {
            return Permission::assign($permData);
        }

        // In other case, just unasign it
        return Permission::unassign($permData);
    }

    /**
     * Search an user permission relationship depending on the data
     * sent.
     *
     * @param string|int $permission id or name of the permission
     * @param int $entityId is the id of the entity related to the user permission
     *
     * @return void
     */
    public function searchEntityPermission($permission, $entityId, $entityClass)
    {
        // Set the querying var to a null
        $permissionId = null;

        // Check if the permission given by parameter is an integer
        if (is_int($permission)) {
            $permissionId = $permission;
        } else {
            // Otherwise, search it on the model and retrieve the id
            $permissionId = Permission::where('name', $permission)->first()->id;
        }

        // In other case, just unasign it
        return Permission::search([
            'permission_id' => $permissionId,
            'model_id' => $this->id,
            'entity_id' => $entityId,
            'entity_type' => $entityClass
        ])->first();
    }

    /**
     * Adds multiple permissions to the current user
     *
     * @return void
     */
    public function assignMultiplePermissions($permissionNames, $entityId, $entityClass)
    {
        return Permission::bulkAssign($permissionNames, $this->id, $entityId, $entityClass);
    }

    /**
     * Get the user that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the user that owns the image.
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'taxes_id', 'id');
    }

    /**
     * Get the user that owns the cover.
     */
    public function cover()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get all related permissions related to the model
     */
    public function entityPermissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id')
            ->withPivot('entity_id');
    }

    /**
     * Get all the clubs owned by the user
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    /**
     * Get the user with subscription active.
     *
     * @return object
     */
    public function subscriptionActive()
    {
        return $this->hasOne(Subscription::class)
            ->select([
                'id',
                'name',
                'stripe_status',
                'quantity',
                'trial_ends_at',
                'package_price_id',
                'interval',
                'amount',
                'created_at',
                'updated_at'
            ])
            ->with([
                'packagePrice' => function ($query) {
                    $query->with('subpackage');
                }
            ])
            ->whereNull('ends_at');
    }

    /**
     * Retrieve all the licenses the user has related
     *
     * @return array
     */
    public function activeLicenses()
    {
        return $this->hasMany(License::class)
            ->with(['subscription'])
            ->where('status', 'active');
    }

    /**
     * Returns the related player value from the user
     *
     * @return object
     */
    public function player()
    {
        return $this->hasOne(Player::class);
    }

    /**
     * Retrieves all the activities the user has done by itself
     *
     * @return array
     */
    public function activities()
    {
        return $this->hasMany(Activity::class)
            ->with('activity_type')
            ->orderBy('date', 'desc');
    }

    /**
     * Get the related team staff
     *
     * @return object
     */
    public function teamStaff()
    {
        return $this->hasOne(StaffUser::class);
    }

    /**
     * Get the related subscription items to the user
     *
     * @return array
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->with(['packagePrice'])
            ->whereNull('ends_at');
    }

    /**
     * Get only the subscription items with related licenses
     *
     * @return array
     */
    public function subscriptionsWithLicenses()
    {
        return $this->hasMany(Subscription::class)
            ->with(['licenses'])
            ->whereNull('ends_at');
    }

    /**
     * Returns the related country object
     *
     * @return Object
     */
    public function country()
    {
        return $this->belongsTo(Country::class)
            ->select('id')
            ->withTranslation(app()->getLocale());
    }

    /**
     * Returns the related province object
     *
     * @return Object
     */
    public function province()
    {
        return $this->belongsTo(Province::class)
            ->select('id')
            ->withTranslation(app()->getLocale());
    }

    /**
     * Searchs first active subscription by type parameter sent by using
     * self eloquent model builder
     *
     * @param string $type 'sport' | 'teacher'
     * @return object|null
     */
    public function activeSubscriptionByType($type = 'sport')
    {
        return $this->subscriptions->where('package_code', $type)
            ->first();
    }

    /**
     * This PHP function returns a collection of exercises associated with a user.
     *
     * @return A relationship between the current model and the Exercise model, where the current model
     * is the parent and the Exercise model is the child. The relationship is defined by the foreign
     * key 'user_id' in the Exercise model, which references the primary key of the current model.
     */
    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'user_id');
    }

    /**
     * This function returns a collection of exercise sessions associated with a user.
     *
     * @return A relationship between the current model and the ExerciseSession model, where the
     * current model is the parent and ExerciseSession is the child. The relationship is defined as a
     * "hasMany" relationship, meaning that the current model can have multiple ExerciseSession
     * instances associated with it. The relationship is established based on the "user_id" foreign key
     * in the ExerciseSession table, which references the "id" primary key in
     */
    public function sessionExercises()
    {
        return $this->hasMany(ExerciseSession::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of nutritional sheets associated with a user.
     *
     * @return A relationship between the current model and the NutritionalSheet model, where the
     * current model has many NutritionalSheet instances associated with it through the 'user_id'
     * foreign key.
     */
    public function nutritionSheets()
    {
        return $this->hasMany(NutritionalSheet::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of effort recovery records associated with a user.
     *
     * @return The `effortsRecovery()` function returns a `hasMany` relationship between the current
     * object and the `EffortRecovery` model, where the foreign key `user_id` in the `EffortRecovery`
     * table references the primary key of the current object.
     */
    public function effortsRecovery()
    {
        return $this->hasMany(EffortRecovery::class, 'user_id');
    }

    /**
     * This function returns a collection of injury prevention records associated with a user.
     *
     * @return A relationship between the current model and the InjuryPrevention model, where the
     * current model has many InjuryPrevention instances associated with it through the 'user_id'
     * foreign key.
     */
    public function injuriesPrevention()
    {
        return $this->hasMany(InjuryPrevention::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of psychology reports associated with a user.
     *
     * @return A relationship between the current model and the PsychologyReport model, where the
     * current model has many PsychologyReport instances associated with it through the 'user_id'
     * foreign key.
     */
    public function psychologies()
    {
        return $this->hasMany(PsychologyReport::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of files associated with a user in a Fisiotherapy
     * context.
     *
     * @return A relationship between the current model and the File model, where the current model has
     * many files associated with it through the 'user_id' foreign key.
     */
    public function filesFisiotherapy()
    {
        return $this->hasMany(File::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of InjuryRfd objects associated with a user ID.
     *
     * @return A relationship between the current model and the InjuryRfd model, where the current
     * model has many InjuryRfd instances associated with it through the 'user_id' foreign key.
     */
    public function injuriesRfd()
    {
        return $this->hasMany(InjuryRfd::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of test applications associated with a user.
     *
     * @return A relationship between the current model and the TestApplication model, where the
     * current model is the parent and TestApplication is the child. The relationship is defined by the
     * foreign key 'user_id' in the TestApplication table, which references the primary key of the
     * current model. The relationship is defined as a "has many" relationship, meaning that the
     * current model can have multiple TestApplication records associated with it
     */
    public function tests()
    {
        return $this->hasMany(TestApplication::class, 'user_id');
    }

    /**
     * This PHP function returns a collection of Rubric objects associated with a user.
     *
     * @return A relationship between the current model and the Rubric model, where the current model
     * has many Rubric instances associated with it, based on the 'user_id' foreign key.
     */
    public function rubrics()
    {
        return $this->hasMany(Rubric::class, 'user_id');
    }

    /**
     * This function returns a collection of tutorships associated with a user.
     *
     * @return A relationship between the current model and the Tutorship model, where the current
     * model has many Tutorships with a foreign key of 'user_id'.
     */
    public function tutorships()
    {
        return $this->hasMany(Tutorship::class, 'user_id');
    }
}
