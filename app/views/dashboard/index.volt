<div id="wrapper">
    {% include "dashboard/partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "dashboard/partials/header" with ['auth': auth] %}
        {% include "dashboard/partials/express" with ['auth': auth] %}
        {% include "dashboard/partials/board" with ['auth': auth] %}
    </div>
</div>