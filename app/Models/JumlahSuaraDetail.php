<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class JumlahSuaraDetail extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $table = 'jumlah_suara_details';
    protected $keyType = 'string';

    protected $fillable = [
        "id",
        "note",
        "total_suara_sah",
        "total_suara_tidak_sah",
        "total_sah_tidak_sah",
        "jumlah_suara_id",
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
