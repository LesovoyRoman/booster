<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreateAssistantEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $data;

     public function __construct($data)
     {
         $this->data = $data;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
     {
         $subject = $this->data['subject'];
         return $this->view('emails.createAssistantEmail', $this->data)
                    ->from('boostys@gmail.com', 'BOOSTYS')
                    ->subject($subject);

     }
}
