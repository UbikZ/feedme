<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ get_title() }}
    {{ assets.outputJs('global-js') }}
    {{ assets.outputCss('global-css') }}
    {{ assets.outputCss('dash-css') }}
    {{ assets.outputJs('dash-js') }}
</head>
<body>
{{ content() }}
</body>
</html>
