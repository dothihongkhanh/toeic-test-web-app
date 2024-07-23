<?php

namespace App\Mail;

use App\Models\Exam;
use App\Models\QuestionChild;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailUpdateQuestion extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $exam;
    protected $child;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Exam $exam, QuestionChild $child)
    {
        $this->user = $user;
        $this->exam = $exam;
        $this->child = $child;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Mail Update Question',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content())->view('client.email.email-notify-update')->with(['user' => $this->user, 'exam' => $this->exam, 'child' => $this->child]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
