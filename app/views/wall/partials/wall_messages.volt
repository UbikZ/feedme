<script type="text/x-tmpl" id="tmpl-feeds">
[% for (var i=0; i<o.messages.length; i++) { %]
<div class="feed-element">
    <a href="#" class="pull-left">
    </a>

    <div class="media-body ">
        <strong>[%=o.messages[i].user.firstname%]&nbsp;[%=o.messages[i].user.lastname%]</strong>.
        <br>
        <small class="text-muted">[%=o.messages[i].adddate%]</small>
        <p>[%=o.messages[i].message%]</p>

        <div class="answer">
            [% for (var j=0; j<o.messages[i].answers.length; j++) { %]
            <div class="messages">
                <a href="#" class="pull-left">
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
                <form id="new-message" method="post">
                    <input type="text" class="form-control" placeholder="Write a messsage"/>
                </form>
            </div>
        </div>
    </div>
</div>
[% } %]
</script>