<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;

class Plantao extends Model
{
    use HasFactory;

    /**
     * O nome da tabela associada com o model.
     *
     * @var string
     */
    protected $table = 'plantoes'; // <-- ADICIONE ESTA LINHA

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'specialty',
        'date',
        'start_time',
        'end_time',
        'remuneration',
        'details',
        'status',               
        'approved_profile_id', 
    ];

    public function candidates()
    {
        return $this->belongsToMany(Profile::class, 'plantao_profile');
    }

    public function approvedProfile()
    {
        return $this->belongsTo(Profile::class, 'approved_profile_id');
    }


}

