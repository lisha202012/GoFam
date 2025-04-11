<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>GoFam</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      height: 100vh;
      overflow: hidden;
      font-family: Arial, sans-serif;
    }

    .screen {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      opacity: 0;
      transform: translateX(100%);
    }

    #introScreen {
      position: relative;
      transform: translateX(0%);
      opacity: 1;
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

    .loaderbutton {
      display: none;
      margin-top: 20px;
      width: 50px;
      height: 50px;
      border: 5px solid rgba(255, 75, 43, 0.2);
      border-top-color: var(--main-color);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    
  </style>
</head>
<body>
<section>
    <div class="container">
  <div class="screen" id="introScreen">
    <img src="{{ asset('img/logo-gofam.png') }}" alt="">
    <h3 class="mt-4">Storytelling about the purpose of the app through some sort of animation</h3>
    <button id="continueBtn" class="theme-btn mt-4">Continue</button>
    <div class="loaderbutton" id="loadingSpinner"></div>
  </div>

  <div class="screen" id="loginScreen">
    
    <h3 class="mt-4">Register / Login</h3>
    <p>Welcome to Go Fam! - Let's Create Account</p>
    <div class="profile-circle">+</div>
    <label>Upload your photo</label>
        <button id="registerBtn" class="theme-btn mt-3"><span class="material-symbols-outlined">
            person_add
            </span>Register</button>

            

              <div class="flex mt-3"><label>Already have an Account?</label>
    <button id="loginBtn" class="link-btn ">Login</button>
              </div>
              <div class="divider-container">
                <span class="divider-text">--------Or with email--------</span>
              </div>
    
              <button id="googleLoginBtn" class="theme-btn-black mt-3"> <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;    height: 24px;">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                <path fill="none" d="M0 0h48v48H0z"></path>
                
              </svg> Sign in with Google</button>


    
  </div>

  <div class="screen" id="registerScreen">
    <h3 class="mt-4">Register</h3>
    <input type="file" id="profileImageInput" accept="image/*" style="display: none;">
    <div class="profile-circle" id="profileUpload">+</div>
    <label>Upload your photo</label>
    <form id="registerForm" class="mt-4">
      @csrf
      <input type="text" class="form-control" name="name" placeholder="Full Name" required>
      <input type="email" class="form-control" name="email" placeholder="Email" required>
      <input type="date" class="form-control" name="dob" required>
      <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
          <i class="bi bi-eye"></i>
        </button>
      </div>
      <div class="form-check text-start mt-3">
        <input class="form-check-input" type="checkbox" id="termsCheck" required>
        <label class="form-check-label" for="termsCheck">Agree to the Terms & Conditions</label>
      </div>
      <button type="submit" class="theme-btn mt-3"><span class="material-symbols-outlined">
        person_add
        </span>Register</button>
        <div class="flex mt-3" style="justify-content: center">
            <button id="backToLogin" class="link-btn ">Back to Login</button>
                      </div>



        
    </form>
    
  </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    // Continue → Login Screen
    document.getElementById("continueBtn").addEventListener("click", function () {
      this.style.display = "none";
      document.getElementById("loadingSpinner").style.display = "block";
      setTimeout(() => {
        gsap.to("#introScreen", { x: "-100vw", opacity: 0, duration: 1 });
        gsap.to("#loginScreen", { x: "0", opacity: 1, duration: 1 });
      }, 2000);
    });

    // Login → Register
    document.getElementById("registerBtn").addEventListener("click", function () {
      gsap.to("#loginScreen", { x: "-100vw", opacity: 0, duration: 1 });
      gsap.to("#registerScreen", { x: "0", opacity: 1, duration: 1 });
    });

    // Register → Back to Login
    document.getElementById("backToLogin").addEventListener("click", function () {
      gsap.to("#registerScreen", { x: "100vw", opacity: 0, duration: 1 });
      gsap.to("#loginScreen", { x: "0", opacity: 1, duration: 1 });
    });

    // Login buttons
    document.getElementById("loginBtn").addEventListener("click", () => {
      window.location.href = "{{ route('login') }}";
    });

    document.getElementById("googleLoginBtn").addEventListener("click", () => {
      window.location.href = "{{ route('google.login') }}";
    });

    // Profile upload preview
    document.getElementById("profileUpload").addEventListener("click", () => {
      document.getElementById("profileImageInput").click();
    });

    document.getElementById("profileImageInput").addEventListener("change", function (event) {
      let file = event.target.files[0];
      if (file) {
        let reader = new FileReader();
        reader.onload = function (e) {
          let profileCircle = document.getElementById("profileUpload");
          profileCircle.style.backgroundImage = `url(${e.target.result})`;
          profileCircle.textContent = "";
        };
        reader.readAsDataURL(file);
      }
    });

    // Password toggle
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

    // Register form submit
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
  </script>
</body>
</html>
