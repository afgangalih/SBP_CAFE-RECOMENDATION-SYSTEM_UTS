<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ngafein')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            DEFAULT: '#b87c39',
                            dark: '#9a662e',
                            light: '#c8a87a',
                            subtle: '#fdf8f3',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#fcfcfc] text-gray-800 font-sans">

    @include('components.layout.user.navbar')
 
     <main class="pb-20">
         @yield('content')
     </main>
 
     @include('components.layout.user.footer')

    @stack('scripts')
</body>
</html>
