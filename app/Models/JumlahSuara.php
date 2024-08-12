<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class JumlahSuara extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $table = 'jumlah_suara';
    protected $keyType = 'string';

    protected $fillable = [
        "amount",
        "note",
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
        static::saving(function ($model) {
            if (!$model->exists) {
                $model->created_at = $model->freshTimestamp();
            }
            $model->updated_at = $model->freshTimestamp();
        });
    }

    public function tps(): BelongsTo {
        return $this->belongsTo(Tps::class);
    }
    public function calon(): BelongsTo {
        return $this->belongsTo(Calon::class);
    }
}
