<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bottom Nav with Mood Popup</title>

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding-bottom: 100px;
            background-color: #ccc;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            z-index: 1000;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .nav-item {
            flex: 1;
            text-align: center;
            color: #888;
            font-size: 24px;
            text-decoration: none;
            transition: transform 0.3s ease, color 0.3s ease;
            padding: 8px 0;
        }

        .nav-item i {
            transition: transform 0.3s ease, color 0.3s ease;
            font-size: 24px;
        }

        .nav-item:hover i {
            transform: scale(1.4);
            color: #ff922b;
        }

        .nav-item.active i {
            transform: scale(1.6);
            color: #ff922b;
        }

        /* Mood Popup */
        .mood-popup {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            display: none; /* Hidden by default */
            z-index: 1100;
            gap: 20px;
            justify-content: center;
        }

        .mood-zone {
            padding: 10px 15px;
            border-radius: 30px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            border: 2px solid #666;
            width: 90px;
        }

        .zone-calm {
            background-color: #f8f4ff;
            border-color: purple;
        }

        .zone-excited {
            background-color: #c5f6fa;
            border-color: #3bc9db;
        }

        .zone-sad {
            background-color: #fff3bf;
            border-color: #f59f00;
        }

        .mood-zone span {
            font-size: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

<!-- Mood Popup (Now functional with mood data) -->
<div id="moodPopup" class="mood-popup">
    <div class="mood-zone zone-calm mood-btn" data-mood="calm">
        <span>🧘</span>
        Zone 1 - Calm
    </div>
    <div class="mood-zone zone-excited mood-btn" data-mood="excited">
        <span>😍</span>
        Zone 2 - Excited
    </div>
    <div class="mood-zone zone-sad mood-btn" data-mood="sad">
        <span>😔</span>
        Zone 3 - Sad
    </div>
</div>


<!-- Bottom Nav Bar -->
<div class="bottom-nav">
    <a href="#" class="nav-item {{ request()->is('home') ? 'active' : '' }}" title="Home">
        <i class="bi bi-house"></i>
    </a>
    <a href="#" class="nav-item {{ request()->is('explore') ? 'active' : '' }}" title="Explore">
        <i class="bi bi-triangle"></i>
    </a>
    <a href="javascript:void(0);" id="moodBtn" class="nav-item" title="Mood">
        <i class="bi bi-emoji-smile-fill"></i>
    </a>
    <a href="#" class="nav-item {{ request()->is('tree') ? 'active' : '' }}" title="Tree">
        <i class="bi bi-tree"></i>
    </a>
    <a href="#" class="nav-item {{ request()->is('profile') ? 'active' : '' }}" title="Profile">
        <i class="bi bi-person-circle"></i>
    </a>
</div>
<script>
    const moodBtn = document.getElementById('moodBtn');
    const moodPopup = document.getElementById('moodPopup');

    moodBtn.addEventListener('click', () => {
        moodPopup.style.display = moodPopup.style.display === 'flex' ? 'none' : 'flex';
    });

    document.querySelectorAll(".mood-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            const mood = this.getAttribute("data-mood");

            fetch("{{ url('/mood/save') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mood })
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message);
                moodPopup.style.display = "none";
            });
        });
    });
</script>


</body>
</html>
