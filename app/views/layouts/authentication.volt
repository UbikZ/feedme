<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ assets.outputJs('global-js') }}
    {{ assets.outputCss('global-css') }}
</head>
<body class="gray-bg">
<div>
    <div class="middle-container text-center login animated fadeInDown">
        {{ content() }}
    </div>
</div>
</body>
</html>
