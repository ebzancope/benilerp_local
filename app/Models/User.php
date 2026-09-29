<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\AssignOp\Mod;
use App\Models\colaboradores;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
        protected $fillable = [
            'name',
            'email',
            'password',
            'photo',
            'access_level',
            'approved',
            'login_count',
            'last_login',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function colaborador()
    {
        return $this->hasMany(Colaboradores::class);
    }


    public function usuarios()
    {
        return $this->hasMany(Usuarios::class);
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }


    public function Abastecimento()
    {
        return $this->hasMany(view_abastecimento::class);
    }


    public function equipamentos()
    {
        return $this->hasMany(Equipamentos::class);
    }

    public function boletos()
    {
        return $this->hasMany(Boletos::class);
    }

    public function despesas()
    {
        return $this->hasMany(Despesas::class);
    }

    public function relatorios()
    {
        return $this->hasMany(Relatorios::class);
    }
    public function almoxarifado()
    {
        return $this->hasMany(Almoxarifado::class);
    }
    public function clieforne()
    {
        return $this->hasMany(Clieforne::class);
    }

    // Adicione estes métodos ao seu model User

protected $casts = [
    'approved' => 'boolean',
    'last_login' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'email_verified_at' => 'datetime',
];

// Acessor para status de aprovação
public function getStatusAttribute()
{
    return $this->approved ? 'Aprovado' : 'Aguardando Aprovação';
}

// Acessor para nível de acesso formatado
public function getAccessLevelNameAttribute()
{
    $levels = [
        1 => 'Usuário',
        2 => 'Administrador',
        3 => 'Super Admin'
    ];

    return $levels[$this->access_level] ?? 'Desconhecido';
}
}
