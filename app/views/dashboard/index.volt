<div id="wrapper">
    {% include "partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "partials/header" with ['auth': auth] %}
        {% include "partials/express" with ['auth': auth] %}
        <div class="wrapper wrapper-content animated fadeInRight">
            {% include "partials/board" with ['auth': auth] %}
        </div>
    </div>
</div>