<?php

namespace App;

use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $wallet_id
 * @property float $amount
 * @property string $type
 * @property bool $accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereWalletId($value)
 * @mixin \Eloquent
 * @property string $uuid
 * @property int $sender_wallet_id
 * @property int $destination_wallet_id
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereDestinationWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereSenderWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereUuid($value)
 */
class Transaction extends Model
{

    const STATUS_PENDING = 'pending';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMMITTED = 'committed';

    protected $primaryKey = null;
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_wallet_id',
        'destination_wallet_id',
        'amount',
        'status',
    ];

    /**
     * Generate UUID
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid();
        });
    }

    /**
     * @return BelongsTo
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
