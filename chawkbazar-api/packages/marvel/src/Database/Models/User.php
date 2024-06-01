<?php

namespace Marvel\Database\Models;

use App\Enums\RoleType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Marvel\Enums\OrderStatus;
use Marvel\Enums\PaymentStatus;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;


    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'shop_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['email_verified'];

    protected static function boot()
    {
        parent::boot();
        // Order by updated_at desc
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc');
        });
    }

    public function getEmailVerifiedAttribute(): bool
    {
        return $this->hasVerifiedEmail();
    }


    /**
     * @return HasMany
     */
    public function address(): HasMany
    {
        return $this->hasMany(Address::class, 'customer_id');
    }

    /**
     * @return HasMany
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id')->with(['products.variation_options', 'reviews']);
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'customer_id');
    }

    /**
     * @return HasOne
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id');
    }

    /**
     * @return HasMany
     */
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'owner_id');
    }

    /**
     * @return HasMany
     */
    public function refunds(): HasMany
    {
        return $this->hasMany(Shop::class, 'customer_id');
    }

    /**
     * @return BelongsTo
     */
    public function managed_shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * @return HasMany
     */
    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class, 'user_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function ordered_files(): HasMany
    {
        return $this->hasMany(OrderedFile::class, 'customer_id');
    }

    /**
     * Follow shop
     *
     * @return BelongsToMany
     */
    public function follow_shops(): BelongsToMany
    {
        return $this->belongsToMany(Shop::class, 'user_shop');
    }


    /**
     * Follow shop
     *
     * @return HasMany
     */
    public function payment_gateways(): HasMany
    {
        return $this->HasMany(PaymentGateway::class, 'user_id');
    }

    /**
     * faqs
     *
     * @return HasMany
     */
    public function faqs(): HasMany
    {
        return $this->HasMany(Faqs::class);
    }

    /**
     * terms and conditions
     *
     * @return HasMany
     */
    public function terms_and_conditions(): HasMany
    {
        return $this->HasMany(TermsAndConditions::class);
    }

    /**
     * coupons
     *
     * @return HasMany
     */
    public function coupon(): HasMany
    {
        return $this->HasMany(Coupon::class);
    }

    public function loadLastOrder()
    {
        $data = $this->orders()->whereNull('parent_id')
            ->where('order_status', OrderStatus::COMPLETED)
            ->latest()->first();
        $this->setRelation('last_order', $data);

        return $this;
    }
}
