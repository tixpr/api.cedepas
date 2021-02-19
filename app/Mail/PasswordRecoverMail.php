<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRecoverMail extends Mailable
{
	use Queueable, SerializesModels;
	public $token;
	public $user;
	public $base_url="http://localhost:3000/#/password_recovery/";
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($user, $token)
	{
		$this->token = $token;
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->view('emails.password_recovery');
	}
}
