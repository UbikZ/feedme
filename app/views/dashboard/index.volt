<div id="wrapper">
    {% include "dashboard/partials/menu" with ['auth': auth] %}
    {% include "dashboard/partials/header" with ['auth': auth] %}
    <div id="page-wrapper" class="gray-bg">
        {{ content() }}
    </div>
</div>