<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;


class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
		$user_id = Auth::guard('user')->id();
		$cartItems = Cart::where('user_id', $user_id)->get();
		$cartQuantity = Cart::where('user_id', Auth::guard('user')->id())->sum('quantity');
        return $this->from('duc.d.62cntt@ntu.edu.vn')
                    ->view('emails.contact-form', compact('cartItems', 'cartQuantity'));
    }
}