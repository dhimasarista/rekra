<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class Tps extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tps';
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

    public function kelurahan(): BelongsTo {
        return $this->belongsTo(Kelurahan::class);
    }
}