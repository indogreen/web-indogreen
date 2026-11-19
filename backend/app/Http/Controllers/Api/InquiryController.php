<?php

namespace App\Http\Controllers\Api;

use App\Enums\InquiryStatus;
use App\Http\Requests\StoreInquiryRequest;
use App\Mail\InquiryReceivedMail;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Solution;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class InquiryController extends BaseApiController
{
    /**
     * Store new customer inquiry and dispatch queued notification email.
     */
    public function store(StoreInquiryRequest $request): JsonResponse
    {
        // 1. Honeypot check: bot otomatis yang mengisi field tersembunyi ditolak secara senyap
        if (! empty($request->input('website_url'))) {
            return $this->respondOk([
                'inquiry_id' => 0,
                'received_at' => now()->toIso8601String(),
            ], 'Permohonan konsultasi Anda berhasil dikirimkan. Tim sales engineering PT. Indogreen akan segera menghubungi Anda.', null, 201);
        }

        // 2. Resolve product_id dari product_slug jika disediakan
        $productId = $request->input('product_id');
        if (blank($productId) && $slug = $request->input('product_slug')) {
            $productId = Product::where('slug', $slug)->value('id');
        }

        // 3. Resolve solution_id dari solution_slug jika disediakan
        $solutionId = $request->input('solution_id');
        if (blank($solutionId) && $slug = $request->input('solution_slug')) {
            $solutionId = Solution::where('slug', $slug)->value('id');
        }

        // 4. Hash IP address untuk anonimitas & kepatuhan privasi data
        $rawIp = (string) ($request->ip() ?: '127.0.0.1');
        $ipHash = hash('sha256', $rawIp.config('app.key'));

        // 5. Simpan ke database
        $inquiry = Inquiry::create([
            'full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'phone_whatsapp' => $request->input('phone_whatsapp'),
            'company_organization' => $request->input('company_organization'),
            'product_id' => $productId,
            'solution_id' => $solutionId,
            'subject' => $request->input('subject'),
            'message_content' => $request->input('message_content'),
            'consent' => $request->boolean('consent'),
            'status' => InquiryStatus::PENDING,
            'ip_address' => substr($ipHash, 0, 45),
            'ip_hash' => $ipHash,
            'user_agent' => $request->userAgent(),
        ]);

        // 6. Kirim email notifikasi via queued Mailable
        $settings = SiteSetting::first();
        $recipient = $settings?->email ?: config('mail.from.address', config('app.admin_email', 'info@indogreen.id'));

        if (! empty($recipient)) {
            Mail::to($recipient)->queue(new InquiryReceivedMail($inquiry));
        }

        return $this->respondOk([
            'inquiry_id' => $inquiry->id,
            'received_at' => $inquiry->created_at?->toIso8601String() ?? now()->toIso8601String(),
        ], 'Permohonan konsultasi Anda berhasil dikirimkan. Tim sales engineering PT. Indogreen akan segera menghubungi Anda.', null, 201);
    }
}
