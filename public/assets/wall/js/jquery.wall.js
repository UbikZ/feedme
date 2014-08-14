(function ($) {
    var methods = {
        init:function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        loadWall:function (url) {
            var urlLoad = url;
            return this.each(function () {
                var $this = $(this);
                $.get(url, function(data) {
                    o = JSON.parse(data);
                    if (!o.success) {
                        console.info('not good');
                    } else {
                        $('#count_post').text(o.countPosts);
                        // Render with blueimp
                        tmpl.regexp = /([\s'\\])(?!(?:[^[]|\[(?!%))*%\])|(?:\[%(=|#)([\s\S]+?)%\])|(\[%)|(%\])/g;
                        $render = tmpl("tmpl-feeds", o);
                        $this.find('.messages').html($render);
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