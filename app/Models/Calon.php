<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Calon extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'calon';
    protected $fillable = [
        "code",
        "calon_name",
        "wakil_name",
        "level",
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
}