<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bem-vindo ao Sistema - Suas Credenciais de Acesso')
                    ->view('emails.user-registration')
                    ->with([
                        'user' => $this->user,
                        'password' => $this->password,
                    ]);
    }
}