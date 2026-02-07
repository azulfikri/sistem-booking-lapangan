<?php

namespace App\Jobs;

use App\Mail\PaymentConfirmation;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPaymentConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $booking;

    /**
     * Create a new job instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->booking->guest_email)
                ->send(new PaymentConfirmation($this->booking));

            Log::info('Payment confirmation email sent', [
                'booking_code' => $this->booking->booking_code,
                'email' => $this->booking->guest_email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email', [
                'booking_code' => $this->booking->booking_code,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    public $tries = 3;
    public $backoff = 60;
}
