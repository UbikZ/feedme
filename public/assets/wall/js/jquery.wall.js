(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        load: function (urlGet, urlPost, idUser) {
            var urlLoad = urlGet;
            var urlPost = urlPost;
            return this.each(function () {
                var $this = $(this);
                $.get(urlLoad, function (data) {
                    o = JSON.parse(data);
                    if (!o.success) {
                        console.info('not good');
                    } else {
                        $('#count_post').text(o.countPosts);
                        // Render with blueimp (add new syntax to not interfer with volt syntax)
                        tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
                        $render = tmpl("tmpl-feeds", o);
                        $this.find('.messages').html($render);
                        // Post
                        methods.handlePost(urlPost, urlGet, idUser);
                    }
                });
            });
        },

        handlePost: function (url, urlGet, idUser) {
            $.each($('form.form-message input.message'), function (i, el) {
                $(this).keypress(function (event) {
                    if (event.which == 13) {
                        event.preventDefault();
                        $.post(url, $(this).parent('form').serialize()).done(function () {
                            $('.feed-activity-list').wall('load', urlGet, url, idUser);
                        });
                    }
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