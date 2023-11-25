<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'professional_id',
        'patient_document',
        'state_patient',
        'health_history',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($history) {
            $history->code_history = $history->getLastCodeHistory() + 1;
        });
    }

    public function getLastCodeHistory()
    {
        return static::max('code_history') ?? 0;
    }




    /**
     * user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_document', 'document_number');
    }
}
