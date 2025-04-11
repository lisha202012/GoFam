<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>GoFam</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #f8f9fa;
        overflow: hidden;
        margin: 0;
    }
    #introScreen {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 80%;
        max-width: 400px;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
    }
    #loginScreen, #registerScreen {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100vh;
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        background: white;
        padding: 20px;
    }
        .btn-custom {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
            box-shadow: 0 0 10px rgba(255, 75, 43, 0.5);
        }
        .btn-custom:hover {
            box-shadow: 0 0 20px rgba(255, 75, 43, 0.8);
            transform: scale(1.05);
        }
        .btn-custom:active {
            transform: scale(0.95);
        }
        #registerScreen {
            width: 30% !important;
            opacity: 0;
            transform: translateX(118%);
            text-align: center;
            height: 90vh; 
            overflow-y: auto; 
            padding: 20px;
        }
        #loginScreen, #registerScreen {
            width: 100%;
            opacity: 0;
            transform: translateX(100%);
            text-align: center;
        }
        .loader {
            display: none; /* Initially hidden */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 9999;
        }
        .loaderbutton {
            display: none;
            margin: 20px auto;
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 75, 43, 0.2);
            border-radius: 50%;
            border-top-color: #ff4b2b;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .profile-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 2px dashed #aaa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            color: #666;
            margin: 20px auto;
            cursor: pointer;
            background: #f1f1f1;
            overflow: hidden;
            background-size: cover; 
            background-position: center; 
        }

    </style>
</head>
<body>
<div>
    <div class="container" id="introScreen">
        <p>✨Storytelling about the purpose of the app through some sort of animation✨</p>
        <button id="continueBtn" class="btn btn-custom mt-4">🚀 Continue →</button>
        <div class="loaderbutton" id="loadingSpinner"></div>
    </div>

    <div class="container" id="loginScreen">
        <h2>Register / Login</h2>
        <div class="">+</div>
        <p>Upload your photo</p>
        <button id="registerBtn" class="btn btn-outline-dark mt-3">Register →</button>
        <button id="loginBtn" class="btn btn-outline-dark mt-3">Login →</button>
        <button id="googleLoginBtn" class="btn btn-outline-dark mt-3">Google Login →</button>
    </div>
    <div class="loader" id="otpLoader" style="display: none;"></div>
    <div class="container" id="registerScreen" style="display: none;">
        <h2>Register</h2>
        <input type="file" name="profile_image" id="profileImageInput" accept="image/*" style="display: none;">
        <div class="profile-circle" id="profileUpload" name="profile_image">+</div>
        <p>Upload your photo</p>
        <form id="registerForm">
        @csrf
            <input type="text" class="form-control" name="name" placeholder="Full Name" required><br>
            <input type="email" class="form-control" name="email" placeholder="Email" required><br>
            <input type="date" class="form-control" name="dob" required><br>
            <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" name="password" placeholder="Password" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye"></i>
                </button>
            </div>            
            <div class="form-check text-start mt-3">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">Agree to the Terms & Conditions</label>
            </div>
            <button type="submit" class="btn btn-custom mt-3">Register →</button>
            </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        gsap.to("#introScreen", { opacity: 1, duration: 1.5, ease: "power2.inOut" });
        document.getElementById("continueBtn").addEventListener("click", function() {
            document.getElementById("continueBtn").style.display = "none";
            document.getElementById("loadingSpinner").style.display = "block";
            setTimeout(() => {
                gsap.to("#introScreen", { x: "-100vw", opacity: 0, duration: 1, ease: "power2.inOut" });
                gsap.to("#loginScreen", { x: "0vw", opacity: 1, duration: 1, ease: "power2.inOut", delay: 0.5,height: "100vh" });
            }, 2000);
        });
        
        document.getElementById("registerBtn").addEventListener("click", function() {
            gsap.to("#loginScreen", { x: "-100vw", opacity: 0, duration: 1, ease: "power2.inOut" });
            gsap.to("#registerScreen", { display: "block", opacity: 1, duration: 1, ease: "power2.inOut", delay: 0.5 });
        });
    </script>
    <script>
        document.getElementById('loginBtn').addEventListener('click', function () {
            window.location.href = "{{ route('login') }}";
        });
        document.getElementById('googleLoginBtn').addEventListener('click', function () {
            window.location.href = "{{ route('google.login') }}";
        });
    </script>
    <script>
       document.getElementById("profileUpload").addEventListener("click", function() {
                document.getElementById("profileImageInput").click();
            });

        document.getElementById("profileImageInput").addEventListener("change", function(event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let profileCircle = document.getElementById("profileUpload");
                    profileCircle.style.backgroundImage = `url(${e.target.result})`;
                    profileCircle.textContent = ""; // Remove the '+' sign
                };
                reader.readAsDataURL(file);
            }
        });

        </script>
        <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#registerForm").on("submit", function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                let profileImage = $("#profileImageInput")[0].files[0];
                if (profileImage) {
                    formData.append("profile_image", profileImage);
                }
                $(".loader").show();
                $.ajax({
                    url: "/send-otp",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                         $(".loader").hide(); 
                        toastr.success(response.message, "Success");
                        window.location.href = "/otp-verification";
                    },
                    error: function (xhr) {
                        $(".loader").hide();
                        toastr.error(xhr.responseJSON.message, "Error");
                    }
                });
            });

            $("#verifyOtp").on("click", function () {
                let otp = $("#otpInput").val();

                $.ajax({
                    url: "/verify-otp",
                    type: "POST",
                    data: { otp: otp, _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        toastr.success(response.message, "Success");
                        setTimeout(() => {
                            window.location.href = response.redirect; 
                        }, 2000);
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error, "Invalid OTP");
                    }
                });
            });


            $("#togglePassword").click(function () {
                let passwordField = $("#password");
                let icon = $(this).find("i");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    icon.removeClass("bi-eye").addClass("bi-eye-slash");
                } else {
                    passwordField.attr("type", "password");
                    icon.removeClass("bi-eye-slash").addClass("bi-eye");
                }
            });
            });
        </script>
</body>
</html>
