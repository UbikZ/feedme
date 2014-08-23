<script type="text/x-tmpl" id="tmpl-messages">
[% for (var i=0; i<o.messages.length; i++) { %]
<div class="feed-element">
    <a href="#" class="pull-left">
        <img class="image-circle" src="[%=o.baseUri%][%=o.messages[i].user.picture.path%]" />
    </a>

    <div class="media-body ">
        <strong>[%=o.messages[i
        ].user.firstname%]&nbsp;[%=o.messages[i].user.lastname%]</strong>.
        <div class="pull-right">
            [% if (o.allowDelete) { %]
            <div class="delete">
                <a href="[%=o.baseUri%]wall/delete/[%=o.messages[i].id%]"><i class="fa fa-times"></i></a>
            </div>
            [% } %]
            <i class="fa fa-comments"></i>&nbsp;<strong>[%=o.messages[i].answers.length%]</strong>
        </div>
        <br>
        <small class="text-muted">[%=o.messages[i].adddate%]</small>
        <p>[%=o.messages[i].message%]</p>
        <div class="answer">
            [% for (var j=0; j<o.messages[i].answers.length; j++) { %]
            <div class="messages">
                <a href="#" class="pull-left">
                    <img class="image-circle" src="[%=o.baseUri%][%=o.messages[i].answers[j].user.picture.path%]" />
                </a>
                <strong>
                    [%=o.messages[i].answers[j].user.firstname%]&nbsp;
                    [%=o.messages[i].answers[j].user.lastname%]
                </strong>.
                <small class="text-muted">[%=o.messages[i].answers[j].adddate%]</small>
                <p>[%=o.messages[i].answers[j].message%]</p>
            </div>
            [% } %]
            <div class="divider"></div>
            <div class="reply">
                <form class="form-message" method="post">
                    <input type="hidden" name="idMessageSrc" value="[%=o.messages[i].id%]"/>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-reply"></i></span>
                        <input type="text" name="message" class="form-control message" placeholder="Reply to [%=o.messages[i].user.firstname%]"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
[% } %]

</script>