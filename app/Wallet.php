<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property int $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Wallet whereUserId($value)
 * @mixin \Eloquent
 */
class Wallet extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
