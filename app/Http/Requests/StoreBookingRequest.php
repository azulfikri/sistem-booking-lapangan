<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public booking, no auth required
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'field_id' => ['required', 'exists:fields,id'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'integer', 'min:1', 'max:8'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:20'],
            'guest_email' => ['required', 'email', 'max:255'],
            'payment_method' => ['required', 'in:transfer,cash,midtrans'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'field_id.required' => 'Lapangan wajib dipilih.',
            'field_id.exists' => 'Lapangan tidak ditemukan.',
            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.date' => 'Format tanggal tidak valid.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'start_time.date_format' => 'Format jam harus HH:MM (contoh: 14:00).',
            'duration.required' => 'Durasi wajib diisi.',
            'duration.integer' => 'Durasi harus berupa angka.',
            'duration.min' => 'Durasi minimal 1 jam.',
            'duration.max' => 'Durasi maksimal 8 jam.',
            'guest_name.required' => 'Nama wajib diisi.',
            'guest_name.max' => 'Nama maksimal 255 karakter.',
            'guest_phone.required' => 'Nomor telepon wajib diisi.',
            'guest_phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'guest_email.required' => 'Email wajib diisi.',
            'guest_email.email' => 'Format email tidak valid.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'notes.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Jam operasional validation (06:00 - 22:00)
        if ($this->start_time) {
            $hour = (int) substr($this->start_time, 0, 2);
            
            if ($hour < 6 || $hour >= 22) {
                $this->merge([
                    'start_time' => null, // Force validation to fail
                ]);
            }
        }
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'field_id' => 'lapangan',
            'booking_date' => 'tanggal booking',
            'start_time' => 'jam mulai',
            'duration' => 'durasi',
            'guest_name' => 'nama',
            'guest_phone' => 'nomor telepon',
            'guest_email' => 'email',
            'payment_method' => 'metode pembayaran',
            'notes' => 'catatan',
        ];
    }
}
