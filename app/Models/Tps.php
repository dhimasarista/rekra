<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Tps extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'tps';
    protected $fillable = [
        'name',
        "kelurahan_id"
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

    public function kelurahan(): BelongsTo {
        return $this->belongsTo(Kelurahan::class);
    }
    // Method untuk mengambil Tps beserta kelurahan, kecamatan dan kabkota nya.
    public function tpsWithDetail() {
        return self::select(
            'tps.*',
            'kelurahan.name as kelurahan_name',
            'kecamatan.name as kecamatan_name',
            'kabkota.name as kabkota_name',
            'kabkota.id as kabkota_id',
        )
        ->join('kelurahan', 'tps.kelurahan_id', '=', 'kelurahan.id')
        ->join('kecamatan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
        ->join('kabkota', 'kecamatan.kabkota_id', '=', 'kabkota.id');
    }
}
