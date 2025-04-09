<?php

namespace App\Jobs;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendResponseNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $complaint;
    protected $newStatus;
    protected $feedback;
    protected $responseTime;
    protected $afterImages;
    protected $complaintLink;

    /**
     * Buat instance job.
     */
    public function __construct($user, Complaint $complaint, $newStatus, $feedback, $responseTime, $afterImages, $complaintLink)
    {
        $this->user = $user;
        $this->complaint = $complaint;
        $this->newStatus = $newStatus;
        $this->feedback = $feedback;
        $this->responseTime = $responseTime;
        $this->afterImages = $afterImages;
        $this->complaintLink = $complaintLink;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::send('emails.complaint-response', [
            'user'          => $this->user,
            'complaint'     => $this->complaint,
            'newStatus'     => $this->newStatus,
            'feedback'      => $this->feedback,
            'response_time' => $this->responseTime,
            'afterImages'   => $this->afterImages,
            'complaintLink' => $this->complaintLink,
        ], function ($message) {
            $message->to($this->user->email)
                ->subject('Pengaduan Anda Diperbarui');
        });
    }
}
