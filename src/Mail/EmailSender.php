<?php

namespace DaltonMcCleery\LaravelQuickStart\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSender extends Mailable
{
	use Queueable, SerializesModels;

	// Public attributes are accessible in mail views automatically
	public $subject, $body, $view;

	/**
	 * Create a new message instance.
	 *
	 * @param $subject
	 * @param $view
	 * @param $body
	 */
	public function __construct($subject, $body, $view)
	{
		$this->subject = $subject;
		$this->body = $body;
		$this->view = $view;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->from(env('MAIL_FROM_ADDRESS'))->view('emails.'.$this->view);
	}
}
