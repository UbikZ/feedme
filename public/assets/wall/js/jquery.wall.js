(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        load: function (url) {
            var urlLoad = url;
            return this.each(function () {
                var $this = $(this);
                $.get(url, function (data) {
                    o = JSON.parse(data);
                    if (!o.success) {
                        console.info('not good');
                    } else {
                        $('#count_post').text(o.countPosts);
                        // Render with blueimp (add new syntax to not interfer with volt syntax)
                        tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
                        $render = tmpl("tmpl-feeds", o);
                        $this.find('.messages').html($render);
                    }
                });
            });
        },

        handlePost: function (url, idUser) {
            var urlPost = url;
            return this.each(function () {
                var $this = $(this);
                $this.find('form input[type=text]').keypress(function (event) {
                    if (event.which == 13) {
                        event.preventDefault();
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