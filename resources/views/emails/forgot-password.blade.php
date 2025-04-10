<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            background: #fff;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #007bff;
        }

        p {
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 25px;
            background-color: #1D4ED8;
            /* sama dengan bg-blue-700 */
            color: #fff;
            text-decoration: none;
            border-radius: 0.375rem;
            /* sama dengan rounded-md */
            font-weight: bold;
            transition: background-color 300ms;
        }

        .btn:hover {
            background-color: #1E40AF;
            /* sama dengan hover:bg-blue-800 */
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Password</h2>
        <p>Hai, {{ $user->name }}!</p>
        <p>Kami menerima permintaan untuk mereset password akun Anda. Jika Anda menginginkan perubahan password, silakan
            klik tombol di bawah ini:</p>
        <a href="{{ $resetLink }}"
            style="display: inline-block; margin: 20px 0; padding: 12px 25px; background-color: #1D4ED8; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: bold; transition: background-color 300ms;">
            Reset Password
        </a>

        <p>Jika tombol di atas tidak berfungsi, Anda juga dapat menyalin dan menempelkan tautan berikut ke browser Anda:
        </p>
        <p><a href="{{ $resetLink }}">{{ $resetLink }}</a></p>
        <p>Jika Anda tidak melakukan permintaan ini, abaikan email ini. Keamanan akun Anda adalah prioritas kami.</p>
        <p class="footer">
            Terima kasih,<br>
            Tim {{ $apk ?? 'SMK Negeri 1 Jakarta' }}
        </p>
    </div>
</body>

</html>
