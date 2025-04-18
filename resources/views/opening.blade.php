<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opening Screen</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            flex-direction: column;
        }
        .container {
            max-width: 300px;
            text-align: center;
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
            cursor: pointer;
        }
        .btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div x-data="{ showHabit: false }">
                        <div class="container" x-show="!showHabit">
                            <h2>Opening Screen</h2>
                            <p>Storytelling about the purpose of the app through some sort of animation comes here</p>
                            <button class="btn" @click="showHabit = true">Continue →</button>
                        </div>
                
                        <div x-show="showHabit">
                            <livewire:create-habit />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    @livewireScripts
</body>
</html>
