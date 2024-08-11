<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provinsi extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'provinsi';
    protected $fillable = [
        'name',
    ];

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
    public function kabkota()
    {
        return $this->hasMany(KabKota::class, 'provinsi_id');
    }
}
