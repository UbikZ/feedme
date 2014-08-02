<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEEDME | Dashboard</title>
</head>
<body class="gray-bg">
<div>
    {{ partial('partials/header') }}
    <div>
        {{ content() }}
    </div>
    {{ partial('partials/footer') }}
</div>
</body>
</html>