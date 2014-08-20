{%- macro error_messages(message, field, type) %}
<div class="alert alert-danger center" role="alert">
    <i class="fa fa-warning"></i> <strong>Error: </strong>{{message}}
</div>
{%- endmacro %}
{% for error in errors %}
    {{ error_messages('type': error.getType(), 'message': error.getMessage(), 'field': error.getField()) }}
{% endfor %}