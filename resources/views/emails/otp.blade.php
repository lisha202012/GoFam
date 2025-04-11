<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoFam - OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            max-width: 500px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            background: #f1f1f1;
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('img/gofam-logo.png') }}" alt="GoFam Logo" class="logo">
        <h2>GoFam OTP Verification</h2>
        <p>Your OTP Code is:</p>
        <div class="otp">{{ $otp }}</div>
        <p>Please enter this code to verify your email.</p>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">© {{ date('Y') }} GoFam. All rights reserved.</div>
    </div>
</body>
</html>
