<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class UserRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

 
    public $user;
    public $reason;

    public function __construct($user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Membership Rejected')
                    ->view('emails.user_rejected') // Blade view for the email
                    ->with([
                        'user' => $this->user,
                        'reason' => $this->reason,
                    ]);
    }
}
