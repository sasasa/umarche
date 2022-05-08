<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\ProductForMail;

class OrderedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $user;

    public function __construct(ProductForMail $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('商品が注文されました。')->view('emails.ordered');
    }
}
