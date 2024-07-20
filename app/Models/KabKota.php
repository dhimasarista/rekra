<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KabKota extends Model
{
    use HasFactory;
    protected $table = 'kabkota';
    protected $fillable = [
        'name',
    ];

    public function provinsi(): BelongsTo{
        return $this->belongsTo(Provinsi::class);
    }
}
