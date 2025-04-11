<div id="successMessageScreen" style="text-align: center; padding: 20px;">
        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="circle">
                <svg class="progress-ring">
                    <circle cx="45" cy="45" r="40"></circle>
                </svg>
                <div class="checkmark">✔</div>
            </div>
        </div>
            <h3 style="color: #28a745; margin-top: 10px;">New Habit Successfully Created</h3>
            <p style="color: #555;">
                Complete all tasks under this category for the entire
                week to collect one stone per week to build
                the Health Mountain.
            </p>
            <button id="continueButton" style="
                background-color: #28a745; 
                color: white; 
                border: none; 
                padding: 10px 20px; 
                border-radius: 5px; 
                cursor: pointer;">
                Continue
            </button>
        </div>
        <style>
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
        </style>
           <script>
        document.addEventListener("DOMContentLoaded", function() {
            const circle = document.querySelector("circle");
            setTimeout(() => {
                circle.style.strokeDashoffset = "0";
            }, 500);
        });
    </script>