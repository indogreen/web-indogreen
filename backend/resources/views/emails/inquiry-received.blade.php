<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Inquiry Baru</title>
</head>
<body style="font-family: sans-serif; line-height: 1.5; color: #333333; padding: 20px;">
    <h2>Pemberitahuan Inquiry Masuk — Website PT. Indogreen</h2>
    <p>Terdapat permohonan konsultasi / penawaran baru dari website:</p>

    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold; width: 200px;">Nama Pengirim</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->full_name }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Alamat Email</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->email }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Telepon / WhatsApp</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->phone_whatsapp ?: '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Perusahaan / Instansi</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->company_organization ?: '-' }}</td>
        </tr>
        @if ($inquiry->product)
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Produk Terkait</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->product->name }}</td>
        </tr>
        @endif
        @if ($inquiry->solution)
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Solusi Terkait</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->solution->name }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Subjek</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->subject }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Pesan / Kebutuhan</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{!! nl2br(e($inquiry->message_content)) !!}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Waktu Masuk</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $inquiry->created_at->format('d M Y H:i:s') }} WIB</td>
        </tr>
    </table>

    <p style="margin-top: 25px; font-size: 13px; color: #777777;">
        Email ini dikirim secara otomatis oleh sistem notifikasi website PT. Indogreen Technology And Management.
    </p>
</body>
</html>
