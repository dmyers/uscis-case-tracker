<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    @include('favicon')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script>
    window.App = {!! collect(compact('case_ids'))->toJson() !!};
    </script>
</head>
<body>
    <div id="app" class="mt-3 mt-md-5 mb-3 mb-md-5">
        <div class="container">
            <case-list />
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
