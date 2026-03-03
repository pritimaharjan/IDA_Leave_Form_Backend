<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leaveApplication;

    public $lineManager;

    public $user;

    public $ccRecipients;

    /**
     * Create a new message instance.
     */
    public function __construct($leaveApplication, $lineManager, $user, $ccRecipients = [])
    {
        Log::debug('LeaveApplicationMail initialized', [
            'leaveApplication' => $leaveApplication,
            'lineManager' => $lineManager,
            'user' => $user,
            'ccRecipients' => $ccRecipients,
        ]);

        $this->leaveApplication = $leaveApplication;
        $this->lineManager = $lineManager;
        $this->ccRecipients = $ccRecipients;
        $this->user = $user;
    }

    public function build()
    {
        return $this->from(
            $this->leaveApplication->user->email,   // employee email
            $this->leaveApplication->user->name     // employee name
        )
            ->to($this->lineManager->email)
            ->cc($this->ccRecipients)
            ->subject('New Leave Application from '.($this->leaveApplication->user->name ?? ''))
            ->view('emails.leave_application')
            ->with([
            'employee_name' => $this->leaveApplication->user->name ?? '',
            'employee_email' => $this->leaveApplication->user->email ?? '',
            'leave_slug' => $this->leaveApplication->leave->slug ?? '',
            'from_date' => $this->leaveApplication->start_date ?? '',
            'to_date' => $this->leaveApplication->end_date ?? '',
            'reason' => $this->leaveApplication->reason ?? '',
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Request Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.leave_request',
        );
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
