<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $products;

    public function __construct(User $user, array $products)
    {
        $this->user = $user;
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('ご購入ありがとうございます。')->view('emails.thanks');
    }
}
