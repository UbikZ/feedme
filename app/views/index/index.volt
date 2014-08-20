<div>
    <h1 class="logo">Feed<small>me</small></h1>

    <h3>Welcome <strong>Guest</strong></h3>

    <p>Just log-in to manage your feeds.</p>

    {{ flash.output() }}
    {{ form("session/login", "method":"post") }}
    <div class="form-group">
        {{ text_field("email", "class":"form-control", "placeholder":"E-mail", "required":"") }}
    </div>
    <div class="form-group">
        {{ password_field("password", "class":"form-control", "placeholder":"Password", "required":"") }}
    </div>
    {{ submit_button("Login", "class":"btn btn-primary block btn-block") }}
    {{ endform() }}
</div>
