<?php

namespace App\Models;

use App\Enum\SubmissionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;

class Submission extends Model
{
    /** @use HasFactory<\Database\Factories\SubmissionFactory> */
    use HasFactory, HasLocks;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => SubmissionStatusEnum::class,
    ];

    /**
     * Get the user that owns the Submission
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin that owns the Submission
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
}
