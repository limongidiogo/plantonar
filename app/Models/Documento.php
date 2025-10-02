<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'tipo_documento',
        'caminho_arquivo',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
