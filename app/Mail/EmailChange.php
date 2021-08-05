<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailChange extends Mailable
{
    use Queueable, SerializesModels;

    private $change;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($change)
    {
        $this->change = $change;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::findOrFail($this->change->user_id);
        return $this->subject('Change Email')->markdown('emails.change')->with([
            'user' => $user,
            'token' => $this->change->token,
            'email' => $this->change->email
        ]);
    }
}
