$(document).ready(function(){   
    $('.status').click(function(){
        var currentID = $(this).attr('id');
        $('body').css('cursor', 'wait');
        $.ajax({
            type:'get',
            url:$(this).attr('href')+'?ajax=1',
            success:function(data){
                console.log(data);
                $('body').css('cursor', 'default');
                data = $.parseJSON(data);
                if(data['status'] == 1){
                    $('#'+currentID).html('&#xf06e;');
                }else{
                    $('#'+currentID).html('&#xf070;');
                }
                if(typeof(data['update']) != "undefined"){
                    $.fn.yiiGridView.update('data-grid');
                }
            }
        });
        return false; 
    });
});