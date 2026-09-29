<?php
// app/Mail/UserRegistrationMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bem-vindo ao ERP - Suas Credenciais de Acesso')
            ->view('emails.user-registration')
            ->with([
                'name' => $this->user->name,
                'email' => $this->user->email,
                'password' => $this->password,
                'loginUrl' => url('/login')
            ]);
    }
}
