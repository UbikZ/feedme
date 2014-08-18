(function ($) {
    var methods = {
        init: function () {
            return this.each(function () {
                var $this = $(this);
            });
        },

        search: function () {
            return this.each(function () {
                var $this = $(this);
                $this.keyup(function(event) {
                    var value = $(this).val();
                    $('div.contact-box').each(function() {
                        var $parent = $(this).parent('.box');
                        $parent.toggleClass('hide', $(this).data('keysearch').search(new RegExp(value, 'i')) == -1);
                    });
                });
            });
        }
    };

    $.fn.contact = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.contact');
        }
    };
})(jQuery);