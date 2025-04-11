<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar - Habits & Mood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .calendar-day {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-size: 14px;
            font-weight: bold;
            margin: 5px auto;
            cursor: pointer;
            position: relative;
        }

        .calendar-day .habit-count {
            font-size: 12px;
            color: white;
            background-color: #28a745;
            padding: 2px 6px;
            border-radius: 20px;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        .calendar-day .mood-emoji {
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button id="prevMonth" class="btn btn-outline-primary">&larr;</button>
        <h2 id="currentMonth" class="text-center fw-bold mb-0"></h2>
        <button id="nextMonth" class="btn btn-outline-primary">&rarr;</button>
    </div>

    <div class="row text-center fw-bold bg-light py-2">
        <div class="col">Sun</div>
        <div class="col">Mon</div>
        <div class="col">Tue</div>
        <div class="col">Wed</div>
        <div class="col">Thu</div>
        <div class="col">Fri</div>
        <div class="col">Sat</div>
    </div>

    <div id="calendar" class="row g-2"></div>
</div>

<script>
    let currentDate = new Date();

    document.addEventListener("DOMContentLoaded", function () {
        renderCalendar(currentDate);

        document.getElementById("prevMonth").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        });

        document.getElementById("nextMonth").addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        });
    });

    async function renderCalendar(date) {
        const calendar = document.getElementById("calendar");
        calendar.innerHTML = "";

        const month = date.getMonth();
        const year = date.getFullYear();
        document.getElementById("currentMonth").innerText = `${date.toLocaleString("default", { month: "long" })} ${year}`;

        const firstDayIndex = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const habitsRes = await fetch(`/get-habit-count?month=${month + 1}&year=${year}`);
        const habitData = await habitsRes.json();
        const habitsByDay = {};
        habitData.habits.forEach(habit => {
            habitsByDay[habit.day_name] = habit.count;
        });

        const moodRes = await fetch("/mood/fetch");
        const moodData = await moodRes.json();
        const moodMap = {};
        moodData.forEach(item => {
            moodMap[item.date] = item.emoji;
        });

        let dayCounter = 0;
        let row = document.createElement("div");
        row.className = "row g-2 justify-content-start";

        for (let i = 0; i < firstDayIndex; i++) {
            row.appendChild(document.createElement("div")).className = "col";
            dayCounter++;
        }

        for (let day = 1; day <= totalDays; day++) {
            const dayCol = document.createElement("div");
            dayCol.className = "col";

            const cell = document.createElement("div");
            cell.className = "calendar-day";
            cell.innerHTML = `<div>${day}</div>`;

            const currentDay = new Date(year, month, day);
            const dayName = currentDay.toLocaleString("en-US", { weekday: "long" });
            const fullDate = currentDay.toISOString().slice(0, 10);

            if (habitsByDay[dayName]) {
                const badge = document.createElement("span");
                badge.className = "habit-count";
                badge.innerText = habitsByDay[dayName];
                cell.appendChild(badge);
                cell.addEventListener("click", () => {
                    window.location.href = `/habit-tracker?day=${dayName}`;
                });
            }

            if (moodMap[fullDate]) {
                const emoji = document.createElement("div");
                emoji.className = "mood-emoji";
                emoji.innerText = moodMap[fullDate];
                cell.appendChild(emoji);
            }

            dayCol.appendChild(cell);
            row.appendChild(dayCol);
            dayCounter++;

            if (dayCounter % 7 === 0) {
                calendar.appendChild(row);
                row = document.createElement("div");
                row.className = "row g-2 justify-content-start";
            }
        }

        if (dayCounter % 7 !== 0) {
            const remaining = 7 - (dayCounter % 7);
            for (let i = 0; i < remaining; i++) {
                row.appendChild(document.createElement("div")).className = "col";
            }
            calendar.appendChild(row);
        }
    }
</script>
</body>
</html>

@include('components.layouts.footer')
