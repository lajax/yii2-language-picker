/** 
 * Created on : 2014.08.24., 5:26:26
 * Author     : Lajos Molnar <lajax.m@gmail.com>
 */
$(document).ready(function () {
    LanguagePicker.init();
});

var LanguagePicker = {
    init: function () {
        this.render();
        $('body').on('click', '.language-picker ul a', $.proxy(function (event) {
            this.change($(event.currentTarget).attr('href'));
            return false;
        }, this));
        $('body').on('click', '.language-picker.dropdown-list a', function () {
            $(this).parent().find('ul').toggleClass('active');
        });
        $('body').on('mouseout', '.language-picker.dropdown-list', function () {
            $(this).find('ul').removeClass('active');
        });
    },
    change: function (url) {
        $.get(url, {}, function () {
            document.location.reload();
        });
    },
    render: function () {
        var height = $(window).height();
        $('.language-picker.dropdown-list').each(function () {
            var containerHeight = Math.round($(this).height() / 2.5);
            var listHeight = $(this).find('ul').height();
            var top = $(this).position().top;
            if ((top + listHeight > height) && (top - height > 0)) {
                $(this).addClass('dropup-list')
                        .removeClass('dropdown-list')
                        .find('ul')
                        .css({top: -(listHeight + containerHeight)});
            }
        });
    }
};