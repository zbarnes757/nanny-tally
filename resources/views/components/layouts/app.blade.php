<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Timesheet tracking for nannies and outher household employees">
    <title>NannyTally</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans text-gray-900">

    <main class="container mx-auto px-4 py-8 md:py-12">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800">NannyTally</h1>
            <h2 class="text-xl text-gray-500">Tracking hours for our nanny, Ju</h2>
        </div>

        <div id="main-content">
            {{ $slot }}
        </div>
    </main>

</body>

</html>
