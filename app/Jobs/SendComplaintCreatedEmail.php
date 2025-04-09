<?php

namespace App\Jobs;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendComplaintCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $complaint;
    protected $imagePaths;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, Complaint $complaint, $imagePaths)
    {
        $this->user = $user;
        $this->complaint = $complaint;
        $this->imagePaths = $imagePaths;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Kirim email menggunakan Mail::send
        Mail::send('emails.complaint-created', [
            'user'         => $this->user,
            'complaint'    => $this->complaint,
            'beforeImages' => $this->imagePaths,
        ], function ($message) {
            $message->to($this->user->email)
                ->subject('Pengaduan Anda Berhasil Dikirim');
        });
    }
}
