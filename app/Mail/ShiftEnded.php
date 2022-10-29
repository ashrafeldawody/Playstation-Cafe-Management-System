<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShiftEnded extends Mailable
{
    use Queueable, SerializesModels;
    protected $shift;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shift)
    {
        $this->shift = $shift;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $shift = $this->shift;
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('تم انهاء الشيفت')
            ->view('emails.shift-ended', compact('shift'));
    }
}
