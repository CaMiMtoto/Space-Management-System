<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;

class Guest
{
    use Notifiable;

    public $name;
    public $email;
    public $phone_number;

    public function __construct($name, $email, $phone_number)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
    }
}

