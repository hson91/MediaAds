(function($){
    $.fn.extend({
        mbAlias: function(options) {
            var defaults = {
                target: '#alias'
            }
            var options =  $.extend(defaults, options);
            return this.each(function() {
                $(this).keyup(function(){
                    $(options.target).val($(this).val().toAlias());
                });
            });
        }
    });
})(jQuery);