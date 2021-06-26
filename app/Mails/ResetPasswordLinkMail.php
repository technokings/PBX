<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * @TODO Probably remove
 */
class ResetPasswordLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            // TODO: If recivers will be more then 1  
            // 'email' => $this->to,
        ], false));

        $body = $this->markdown('emails.password.reset')
            ->subject(__('Password reset has been requested at :domain', ['domain' => $this->user->domain->getAttribute('domain_name')]))
            ->with([
                'user' => $this->user,
                // 'url' => \Request::root() . '/reset-password/?token=' . $this->token,
                'url' => $url,
            ]);

        return $body;
    }
}