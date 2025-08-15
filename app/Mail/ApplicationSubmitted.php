<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;
use Illuminate\Support\Facades\Storage;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $lots = is_array($this->application->lots)
            ? $this->application->lots
            : json_decode($this->application->lots, true) ?? [];

        $email = $this->subject('New Application - Bethany Memorial Park')
                     ->view('emails.application_submitted')
                     ->with([
                         'application' => $this->application,
                         'lots' => $lots,
                     ]);

        // Attach the uploaded file if it exists and is readable
        if ($this->application->file_path && Storage::exists($this->application->file_path)) {
            $fileExtension = pathinfo($this->application->file_path, PATHINFO_EXTENSION);
            $fileName = 'Application_Document.' . $fileExtension;
            $email->attachFromStorage($this->application->file_path, $fileName, [
                'mime' => Storage::mimeType($this->application->file_path),
            ]);
        }

        return $email;
    }
}