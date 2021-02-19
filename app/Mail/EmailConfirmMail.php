<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmMail extends Mailable
{
	use Queueable, SerializesModels;

	public $user;
	public $uuid;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($user, $uuid)
	{
		$this->user = $user;
		$this->uuid = $uuid;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('Confirme su correo')->view('emails.email_confirm');
	}
}
