<div>
    <h1 class="logo">FeedMe</h1>

    <h3>Welcome to FeedMe</h3>

    <p>Login in. To see it in action.</p>

    {{ form("/sign-in", "method":"post", "class":"m-t") }}
    <div class="form-group">
        {{ text_field("username", "class":"form-control", "placeholder":"Username", "required":"") }}
    </div>
    <div class="form-group">
        {{ text_field("password", "class":"form-control", "placeholder":"Password", "required":"") }}
    </div>
    {{ submit_button("Login", "class":"btn btn-primary block btn-block m-b") }}
    {{ endform() }}
</div>