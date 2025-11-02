<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;

    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Comment on Your Post')
                ->view('emails.comment-notification')  
                ->with(['comment' => $this->comment]);
    }
}
