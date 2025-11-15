<?php

namespace App\Models;

use App\Enum\SubmissionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Submission extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\SubmissionFactory> */
    use HasFactory, HasLocks, InteractsWithMedia, LogsActivity;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'uuid',     ];

    // only the `updated` event will get logged automatically
    protected static $recordEvents = ['updated'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => SubmissionStatusEnum::class,
    ];

    /**
     * Register the media collections
     */
    public function registerMediaCollections(): void
    {

        $this->addMediaCollection('submission')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);

    }

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['receipt_number', 'status', 'note'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($submission) {

            if (! $submission->uuid) {
                do {
                    $uuid = Str::uuid();
                } while (Submission::where('uuid', $uuid)->exists());

                $submission->uuid = $uuid;
            }
        });
    }
}
