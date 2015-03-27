/** 
 * Created on : 2014.08.24., 5:26:26
 * Author     : Lajos Molnar <lajax.m@gmail.com>
 */
$(document).ready(function () {
    LanguagePicker.init();
});

var LanguagePicker = {
    init: function () {
        $('body').on('click', '.language-picker ul a', $.proxy(function (event) {
            this.change($(event.currentTarget).attr('href'));
            return false;
        }, this));
        $('body').on('click', '.language-picker.dropdown-list a', function () {
            $(this).parent().find('ul').toggleClass('active');
        });
        $('body').on('mouseout', '.language-picker.dropdown-list', function() {
            $(this).find('ul').removeClass('active');
        });
    },
    change: function (url) {
        $.get(url, {}, function () {
            document.location.reload();
        });
    }
};