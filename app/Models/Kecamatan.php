<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Kecamatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'kecamatan';
    protected $fillable = [
        'name',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            /**
             * Memeriksa dan membuat primary key menjadi unique id
            */
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid7();
            }
        });
    }

    public function kabkota(): BelongsTo{
        return $this->belongsTo(KabKota::class);
    }
}
