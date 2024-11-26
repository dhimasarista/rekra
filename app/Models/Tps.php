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
    public function jumlahSuaraDetails()
    {
        return $this->hasMany(JumlahSuaraDetail::class, 'tps_id');
    }

    public function calon()
    {
        return $this->belongsToMany(Calon::class, 'jumlah_suara_details', 'tps_id', 'calon_id')
            ->withPivot('amount');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }
    // Method untuk mengambil Tps beserta kelurahan, kecamatan dan kabkota nya.
    public function tpsWithDetail()
    {
        return self::select(
            'tps.*',
            'kelurahan.id as kelurahan_id',
            'kelurahan.name as kelurahan_name',
            'kecamatan.id as kecamatan_id',
            'kecamatan.name as kecamatan_name',
            'kabkota.id as kabkota_id',
            'kabkota.name as kabkota_name',
            'provinsi.id as provinsi_id',
            'provinsi.name as provinsi_name',
        )
            ->join('kelurahan', 'tps.kelurahan_id', '=', 'kelurahan.id')
            ->join('kecamatan', 'kelurahan.kecamatan_id', '=', 'kecamatan.id')
            ->join('kabkota', 'kecamatan.kabkota_id', '=', 'kabkota.id')
            ->join('provinsi', 'kabkota.provinsi_id', '=', 'provinsi.id');
    }
}
