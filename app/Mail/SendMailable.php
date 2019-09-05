<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name, $userName, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $userName, $password)
    {
       $this->name = $name;
       $this->userName = $userName;
       $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employeeRegistration');
    }
}
