<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Email Verification By OTP</title>
      
      <style>
        *{ margin: 0; padding: 0; }
      </style>
    </head>
    <body>
      <div className="text-center fs-4 bg-primary text-white">{{ $name }}</div>
      <div>Thanks for registering with us.</div>
      <div class="fs-1 text-center fw-bold">{{ $code }}</div>
      <div>Use this to verify your email address.</div>
    </body>
  </html>