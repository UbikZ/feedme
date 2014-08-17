(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        load: function (urlGet, urlPost, idUser) {
            return this.each(function () {
                var $this = $(this);
                $.get(urlGet, function (data) {
                    var o = JSON.parse(data);
                    if (!o.success) {
                        // todo : create notifs for this
                        console.error('Fail to load wall');
                    } else {
                        $('#count_post').text(o.countPosts);
                        // Render with blueimp (add new syntax to not interfer with volt syntax)
                        tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
                        $render = tmpl("tmpl-feeds", o);
                        $this.find('.messages').html($render);
                        // Post
                        methods.handlePost(urlGet, urlPost, idUser);
                        methods.handleDelete(urlGet, urlPost, idUser);
                    }
                });
            });
        },

        handlePost: function (urlGet, urlPost, idUser) {
            $.each($('form.form-message input.message'), function (i, el) {
                $(this).keypress(function (event) {
                    if (event.which == 13) {
                        event.preventDefault();
                        if ($(this).val() != '') {
                            $.post(urlPost, $(this).parents('form').serialize()).done(function () {
                                $('.feed-activity-list').wall('load', urlGet, urlPost, idUser);
                            });
                            $(this).val('');
                        }
                    }
                });
            });
        },

        handleDelete: function(urlGet, urlPost, idUser) {
            $.each($('.messages .delete a'), function (i, el) {
                $(el).click(function(event) {
                    event.preventDefault();
                    $.get($(this).attr('href'), function(data) {
                        var o = JSON.parse(data);
                        if (!o.success) {
                            // todo : create notifs for this
                            console.error('Fail to delete message');
                        } else {
                            $('.feed-activity-list').wall('load', urlGet, urlPost, idUser);
                        }
                    });
                });
            });
        }
    };

    $.fn.wall = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.wall');
        }
    };
})(jQuery);