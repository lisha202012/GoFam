<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            text-align: center;
            flex-direction: column;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .circle {
            width: 90px;
            height: 90px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .progress-ring {
            position: absolute;
            width: 100%;
            height: 100%;
        }
        circle {
            fill: none;
            stroke-width: 6;
            stroke: #4CAF50;
            stroke-dasharray: 283;
            stroke-dashoffset: 283;
            stroke-linecap: round;  /* Fixes sharp edges */
            transition: stroke-dashoffset 1.5s ease-in-out;
        }
        .checkmark {
            font-size: 40px;
            color: #4CAF50;
            font-weight: bold;
            opacity: 0;
            position: absolute;
            animation: fadeIn 0.5s ease-in-out forwards;
            animation-delay: 1.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid black;
            border-radius: 20px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            color: black;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
<!--<a href="{{ route('logout') }}" class="btn btn-danger">Logout</a>-->

    <div class="container">
        <h1>You have successfully created your account</h1>
        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="circle">
                <svg class="progress-ring">
                    <circle cx="45" cy="45" r="40"></circle>
                </svg>
                <div class="checkmark">✔</div>
            </div>
        </div>
        <a href="{{ route('opening') }}" class="btn">Let’s Start →</a>
        </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const circle = document.querySelector("circle");
            setTimeout(() => {
                circle.style.strokeDashoffset = "0";
            }, 500);
        });
    </script>

</body>
</html>
