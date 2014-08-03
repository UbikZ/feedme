(function ($) {
    var methods = {
        init:function () {
            return this.each(function () {
                var $this = $(this),
                    $toggle = true;

                $this.find('li.active').has('ul').children('ul').addClass('collapse in');
                $this.find('li').not('.active').has('ul').children('ul').addClass('collapse');

                $this.find('li').has('ul').children('a').on('click', function (e) {
                    e.preventDefault();

                    $(this).parent('li').toggleClass('active').children('ul').collapse('toggle');

                    if ($toggle) {
                        $(this).parent('li').siblings().removeClass('active').children('ul.in').collapse('hide');
                    }
                });
            });
        }
    };

    $.fn.menu = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.menu');
        }
    };
})(jQuery);