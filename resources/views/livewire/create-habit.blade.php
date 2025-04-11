<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #f4f4f4;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 90%;
            max-width: 400px;
        }

        .btn {
            margin-top: 20px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
        }

        .habit-container {
            display: none;
        }

        .category-list, .habit-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .category-item, .habit-item {
            background: #e3f2fd;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .category-item.selected, .habit-item.selected {
            background: #4facfe;
            color: #fff;
        }
        .habit-input {
            padding: 12px;
            border: 2px solid #4A90E2;
            border-radius: 25px;
            font-size: 16px;
            text-align: center;
            outline: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(74, 144, 226, 0.2);
        }

        .habit-input:focus {
            border-color: #2E67B1;
            box-shadow: 0px 4px 15px rgba(74, 144, 226, 0.4);
            background: #F0F8FF;
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
    </style>
</head>
<body>

<div>
    <div class="container" id="categoryScreen">
    <h2>Select a Category</h2>
    <div class="category-list">
    <div class="category-item" data-category="Family" onclick="selectCategory('Family')">Family</div>
        <div class="category-item" data-category="Health" onclick="selectCategory('Health')">Health</div>
        <div class="category-item" data-category="Money" onclick="selectCategory('Money')">Money</div>
        <div class="category-item" data-category="Self Care" onclick="selectCategory('Self Care')">Self Care</div>
        <div class="category-item" data-category="Home Care" onclick="selectCategory('Home Care')">Home Care</div>
        <div class="category-item" data-category="Goals" onclick="selectCategory('Goals')">Goals</div>
        <div class="category-item" data-category="Time" onclick="selectCategory('Time')">Time</div>
    </div>
    <button class="btn" id="toHabits">Continue →</button>
</div>

<div class="container habit-container" id="habitScreen">
<h2 id="habitTitle">Create Your Habit</h2>
<input type="text" id="customHabit" class="habit-input" placeholder="✍️ Create your own habit...">
    <p>(or) Select from the Template</p>
    <div class="habit-list" id="habitList">
    </div>
    <button class="btn" id="saveHabit">Continue →</button>
</div>
<input type="hidden" id="habitId" name="habit_id">

<div id="habitScreen1" class="habit-container habit-screen">
    <h3 class="text-center">Create your habit</h3>
    <p><strong>New Habit</strong></p>
    <p id="savedHabitName"></p>

    <p><strong>Select Days of the Week</strong></p>
    <div id="habitDays">
        <input type="checkbox" class="day-checkbox" value="Monday" checked> Monday
        <input type="checkbox" class="day-checkbox" value="Tuesday" checked> Tuesday
        <input type="checkbox" class="day-checkbox" value="Wednesday" checked> Wednesday
        <input type="checkbox" class="day-checkbox" value="Thursday" checked> Thursday
        <input type="checkbox" class="day-checkbox" value="Friday" checked> Friday
        <input type="checkbox" class="day-checkbox" value="Saturday" checked> Saturday
        <input type="checkbox" class="day-checkbox" value="Sunday" checked> Sunday
    </div>

    <p><strong>Set a time for your goal</strong></p>

    <!-- Time Type Selection -->
    <div>
        <label><input type="radio" name="timeType" value="reminder" checked> Reminder</label>
        <label><input type="radio" name="timeType" value="duration"> Duration</label>
    </div>

    <!-- Time Inputs -->
    <div>
        <input type="time" id="startTime" class="form-control d-inline w-45 time-input" required> to
        <input type="time" id="endTime" class="form-control d-inline w-45 time-input" disabled>
    </div>

    <button id="saveHabitSchedule" class="btn">Create →</button>
</div>
        <div id="successMessageScreen" style="display: none; text-align: center; padding: 20px;">
        <h3 style="color: #28a745; margin-top: 10px;">New Habit Successfully Created</h3>

        <div style="display: flex; align-items: center; justify-content: center;">
            <div class="circle">
                <svg class="progress-ring">
                    <circle cx="45" cy="45" r="40"></circle>
                </svg>
                <div class="checkmark">✔</div>
            </div>
        </div>
            <h4>You have started a 49 week streak.</h4>
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

</div>
<script>
    let selectedHabit = '';
    let selectedCategory = '';

    function selectHabit(habit) {
        selectedHabit = habit;
        document.querySelectorAll('.habit-btn').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        updateSaveButton();
    }

    function selectCategory(category) {
        selectedCategory = category;
        document.querySelectorAll('.category-item').forEach(item => item.classList.remove('active'));
        event.target.classList.add('active');

        document.getElementById('habitTitle').innerText = `Create Your ${category}`;

        updateSaveButton();
    }

    function updateSaveButton() {
        const saveButton = document.getElementById('saveButton');
        if (!saveButton) return; 

        if (selectedHabit && selectedCategory) {
            saveButton.innerHTML = `Save ${selectedCategory} Habit ✅`;
        } 
    }

</script>
<script>
    $(document).ready(function () {
        let selectedCategory = "";
        let selectedHabit = "";

       
        $(".category-item").click(function () {
            $(".category-item").removeClass("selected");
            $(this).addClass("selected");
            selectedCategory = $(this).data("category");
        });

        $("#toHabits").click(function () {
            if (!selectedCategory) {
                toastr.warning("Please select a category!");
                return;
            }

            $("#categoryScreen").hide();
            $("#habitScreen").fadeIn();
            loadHabits(selectedCategory);
        });
   

        // Load habits based on category
        function loadHabits(category) {
            let habitsByCategory = {
                "Family": ["Spend quality time", "Help with chores"],
                "Health": ["Wake up at 4am", "4km walk", "Eat veggies", "Meditate for 1 hour", "Exercise for 1 hour", "Avoid Sweets"],
                "Money": ["Save ₹5000 monthly", "Track daily expenses"],
                "Self Care": ["Journal for 10 min", "Drink 3L water"],
                "Home Care": ["Clean for 20 min", "Organize workspace"],
                "Goals": ["Read 5 pages", "Plan the next day"],
                "Time": ["Limit social media", "Follow a strict schedule"]
            };

            let habitList = $("#habitList");
            habitList.empty();

            habitsByCategory[category].forEach(function (habit) {
                habitList.append(`<div class="habit-item" data-habit="${habit}">${habit}</div>`);
            });

            $(".habit-item").click(function () {
                $(".habit-item").removeClass("selected");
                $(this).addClass("selected");
                selectedHabit = $(this).data("habit");
                $("#customHabit").val(""); 
            });
        }
 

        $("#saveHabit").click(function () {
            let customHabit = $("#customHabit").val();
            let finalHabit = selectedHabit || customHabit;

            if (!finalHabit) {
                toastr.warning("Please enter or select a habit.");
                return;
            }
        
            $("#habitId").val(finalHabit); 

            $.ajax({
                url: "/store-habit",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                    habit: finalHabit,
                    category: selectedCategory
                },
                xhrFields: {
                    withCredentials: true 
                },
                success: function (response) {
                    if (response.success) {
                        $("#savedHabitName").text(finalHabit);
                        $("#habitScreen").hide();
                        $(".habit-screen").fadeIn();
                    } else {
                        toastr.warning("Error saving habit.");
                    }
                },
                error: function () {
                    toastr.warning("An error occurred.");
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function () {
        const startTime = document.getElementById("startTime");
        const endTime = document.getElementById("endTime");
        const timeRadios = document.getElementsByName("timeType");

        function updateTimeFields() {
            const selected = [...timeRadios].find(r => r.checked).value;
            if (selected === "reminder") {
                endTime.disabled = true;
                endTime.required = false;
                startTime.required = true;
            } else {
                endTime.disabled = false;
                endTime.required = true;
                startTime.required = true;
            }
        }

        timeRadios.forEach(radio => radio.addEventListener("change", updateTimeFields));
        updateTimeFields(); // Call on page load
    });
    $('#saveHabitSchedule').click(function () {
        let habitId = $("#habitId").val(); 
        let dates = [];
        $('.day-checkbox:checked').each(function () {
            dates.push($(this).val());
        });

        let startTime = $('#startTime').val();
        let endTime = $('#endTime').val();
        let timeType = $('input[name="timeType"]:checked').val(); 

        if (timeType === "reminder") {
            if (!startTime) {
                toastr.warning("Please select a start time for the reminder.");
                return;
            }
            endTime = null;
        } else if (timeType === "duration") {
            if (!startTime || !endTime) {
                toastr.warning("Please select both start and end times for duration.");
                return;
            }
        }

        $.ajax({
            url: '/store-habit-schedule', 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                habit_id: habitId,
                dates: dates,
                start_time: startTime,
                end_time: endTime,
                timeType: timeType 
            },
            success: function (response) {
                $('#habitScreen1').hide();
                $('#successMessageScreen').fadeIn();
            },
            error: function () {
                toastr.error('Something went wrong. Please try again!');
            }
        });
    });
    $('input[name="timeType"]').change(function () {
        if ($(this).val() === 'duration') {
            $('#endTime').prop('disabled', false);
        } else {
            $('#endTime').prop('disabled', true).val('');
        }
    });

        $("#customHabit").on("input", function () {
            if ($(this).val().trim() !== "") {
                $("#habitList").val(""); 
            }
        });

        $("#habitList").change(function () {
            if ($(this).val() !== "") {
                $("#customHabit").val(""); 
            }
        });
    });
    
</script>
<script>
    $(document).ready(function () {
        $("#continueButton").click(function () {
            $("#successMessageScreen").hide();
            window.location.href = "/activity-tracker";
        });
    });
</script>
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
