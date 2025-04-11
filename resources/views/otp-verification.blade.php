<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f4f4f4;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 320px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 { color: #333; }

        .otp-input {
            width: 45px;
            height: 45px;
            font-size: 22px;
            text-align: center;
            margin: 5px;
            border: 2px solid #ccc;
            border-radius: 5px;
        }

        .otp-input:focus {
            border-color: #007bff;
            outline: none;
        }

        .error-message {
            color: red;
            display: none;
            font-size: 14px;
            margin-top: 10px;
        }

        .btn {
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Enter OTP</h2>
    <p>OTP has been sent to your registered email.</p>

    <form id="otpForm">
        <div>
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
            <input type="text" class="otp-input" maxlength="1">
        </div>

        <p class="error-message">Invalid OTP. Please try again.</p>

        <button type="submit" class="btn">Verify & Continue →</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $(".otp-input").on("keyup", function (e) {
            if ($(this).val().length === 1) {
                $(this).next(".otp-input").focus();
            }
        });

        // 📌 Enable OTP Paste Support
        $(".otp-input").on("paste", function (e) {
            let data = e.originalEvent.clipboardData.getData("text");
            let otpArray = data.split("");
            if (otpArray.length === 6) {
                $(".otp-input").each(function (index) {
                    $(this).val(otpArray[index]);
                });
                //$("#otpForm").trigger("submit");
            }
        });

        $("#otpForm").on("submit", function (e) {
            e.preventDefault();

            let otp = "";
            $(".otp-input").each(function () {
                otp += $(this).val();
            });

            $(".btn").text("Verifying...").attr("disabled", true);

            // 📌 Verify OTP via AJAX
            $.ajax({
                url: "/verify-otp",
                type: "POST",
                data: { otp: otp, _token: "{{ csrf_token() }}" },
                success: function (response) {
                    window.location.href = "/dashboard";
                },
                error: function () {
                    $(".error-message").show();
                    $(".otp-input").val("").first().focus();
                    $(".btn").text("Verify & Continue →").attr("disabled", false);
                }
            });
        });

        // 📌 Auto-fetch OTP (For supported browsers, only for SMS)
        if ("OTPCredential" in window) {
            navigator.credentials.get({
                otp: { transport: ["sms"] },
            }).then(otp => {
                let otpArray = otp.code.split("");
                $(".otp-input").each(function (index) {
                    $(this).val(otpArray[index]);
                });
                $("#otpForm").trigger("submit");
            }).catch(err => console.log("OTP Auto-Fetch Error:", err));
        }
    });
</script>

</body>
</html>
