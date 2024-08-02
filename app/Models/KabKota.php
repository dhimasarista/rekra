<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KabKota extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kabkota';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'provinsi_id'
    ];

    public function provinsi(): BelongsTo{
        return $this->belongsTo(Provinsi::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if (!$model->exists) {
                $model->created_at = $model->freshTimestamp();
            }
            $model->updated_at = $model->freshTimestamp();
        });
    }
}
