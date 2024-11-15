<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Document</title>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @vite(["resources/css/luvi-ui.css", "resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="font-serif">
        @include("pdfs.sampul")
        @pageBreak
        @include("pdfs.hal1")
        @pageBreak
        @include("pdfs.hal2")
        @pageBreak
        @include("pdfs.hal2-2")
    </body>
</html>
