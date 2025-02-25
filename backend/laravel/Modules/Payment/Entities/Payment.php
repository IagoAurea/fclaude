<?php

namespace Modules\Payment\Entities;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Subscription\Entities\Subscription;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'code',
        'amount',
        'status',
        'invoice_pdf_url',
        'user_id',
        'subscription_id',
        'subtotal',
        'tax',
        'invoice_stripe_id',
        'invoice_number'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'total'
    ];

     /**
     * Get the total calculated attribute
     */
    public function getTotalAttribute()
    {
        return (float) $this->subtotal + (float) $this->tax;
    }

     /**
     * Get the user that user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get the user that subscription.
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

}
