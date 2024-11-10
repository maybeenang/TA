<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet"
        />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.30.0/tocbot.css" />
        <!--select2 css-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- Scripts -->
        @vite(["resources/css/luvi-ui.css", "resources/css/app.css", "resources/js/app.js"])

        @livewireStyles
        @routes
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-200">
            <!-- Page Content -->
            <main class="mx-auto min-h-screen max-w-screen-2xl bg-white" x-data>
                @include("layouts.header")

                @include("layouts.navigation")

                <div class="flex flex-col gap-4 p-4 md:flex-row">
                    @include("layouts.sidebar")

                    <section class="min-w-0 flex-1 space-y-2">
                        {{ Breadcrumbs::render() }}
                        {{ $slot }}
                    </section>
                </div>
            </main>
        </div>
        @livewireScripts

        <!--tocbot (table of content tenaga pengajar edit)-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tocbot/4.30.0/tocbot.min.js"></script>

        <script
            src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
            crossorigin="anonymous"
        ></script>
        <!--select2 js-->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        @stack("scripts")
    </body>
</html>
