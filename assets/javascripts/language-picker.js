/** 
 * Created on : 2014.08.24., 5:26:26
 * Author     : Lajos Molnar <lajax.m@gmail.com>
 */
$(document).ready(function () {
    LanguagePicker.init();
});

var LanguagePicker = {
    init: function () {
        $('body').on('click', '.language-picker a', $.proxy(function (event) {
            this.change($(event.currentTarget).attr('href'));
            return false;
        }, this));
    },
    change: function (url) {
        $.get(url, {}, function () {
            document.location.reload();
        });
    }
};