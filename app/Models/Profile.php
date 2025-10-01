<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Adicione esta linha
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Plantao;

class Profile extends Model
{
    use HasFactory; // E esta linha

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_type',
        'crm',
        'specialty',
        'hospital_name',
        'cnpj',
        'address',
        'phone_number',
    ];

    /**
    * Get the user that owns the profile.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the plantoes for the hospital profile.
     */
    public function plantoes()
    {
    return $this->hasMany(Plantao::class);
    }

    public function candidacies()
    {
        return $this->belongsToMany(Plantao::class, 'plantao_profile');
    }

}

