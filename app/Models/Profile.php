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
        'data_nascimento',
        'cpf',
        'rg',
        'estado_civil',
        'nacionalidade',
        'endereco_completo',
        'telefone_celular',
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

    /**
     * Verifica se o perfil do médico tem as informações mínimas para se candidatar.
     *
     * @return bool
     */
    public function isReadyToApply(): bool
    {
        // Se o perfil não for de um médico, ele não pode se candidatar.
        if ($this->user_type !== 'medico') {
            return false;
        }

        // Lista de campos essenciais que não podem ser nulos ou vazios.
        $essentialFields = [
            'crm',
            'specialty',
            'data_nascimento',
            'cpf',
            'telefone_celular',
            'endereco_completo',
        ];

        // Itera sobre cada campo essencial
        foreach ($essentialFields as $field) {
            // Se qualquer um dos campos for nulo ou uma string vazia, retorna falso.
            if (empty($this->{$field})) {
                return false;
            }
        }

        // Se passou por todos os campos e nenhum estava vazio, o perfil está pronto.
        return true;
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

}

