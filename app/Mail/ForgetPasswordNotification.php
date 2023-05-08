<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordNotification extends Mailable  implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $_user;
    protected $_password;
    public function __construct($user, $password)
    {
        $this->_user = $user;
        $this->_password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->_user;
        $password = $this->_password;
        return $this->subject('Password Reset - Midwife at your cervix from MAYC Password Reset')->markdown('mail.forget_password_notification', compact('user', 'password'));
    }
}
