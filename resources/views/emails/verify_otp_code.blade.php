<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification By OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <p className="text-center text-3xl bg-slate-100 text-white">{{ $name }}</p>
    <p>Thanks for registering with us.</p>
    <h1 class="text-6xl text-center">{{ $code }}</h1>
    <p>Use this to verify your email address.</p>
  </body>
  </html>