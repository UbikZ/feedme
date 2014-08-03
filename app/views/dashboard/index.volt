<div id="wrapper">
    {% include "dashboard/partials/menu" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {% include "dashboard/partials/header" with ['auth': auth] %}
        My Content
    </div>
</div>