<div>
    <form id="new-message" method="post">
        <input name="new-message" type="text" class="form-control" placeholder="Write a message"/>
        <div class="divider"></div>
    </form>
</div>
{% for message in currentUser.messages %}
<div class="feed-element">
    <a href="#" class="pull-left">
        {{image('img', 'class':'image-circle', 'src':message.getUserSrc().getUserPicture().getPath())}}
    </a>

    <div class="media-body ">
        <strong>{{message.getUserSrc().getFirstname()}}&nbsp;{{message.getUserSrc().getLastname()}}</strong>.
        <br>
        <small class="text-muted">{{message.getAdddate()}}</small>
        <p>{{message.getMessage()}}</p>

        <div class="answer">
            {% for answer in message.getAnswers() %}
            <div class="messages">
                <a href="#" class="pull-left">
                    {{image('img', 'class':'image-circle', 'src':answer.getUserSrc().getUserPicture().getPath())}}
                </a>
                <strong>{{answer.getUserSrc().getFirstname()}}&nbsp;{{answer.getUserSrc().getLastname()}}</strong>.
                <small class="text-muted">{{answer.getAdddate()}}</small>
                <p>{{answer.getMessage()}}</p>

            </div>
            {% endfor %}
            <div class="divider"></div>
            <div class="reply">
                <form id="new-message" method="post">
                    <input type="text" class="form-control" placeholder="Write a messsage"/>
                </form>
            </div>
        </div>
    </div>
</div>
{% endfor %}