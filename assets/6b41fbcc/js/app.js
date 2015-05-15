$(document).ready(function() {
    /* Profile Main */
    var profileFirstClick = true;
    $('.user-action i').click(function(){
        if(profileFirstClick){
            $('.profiles').slideDown(400); 
            profileFirstClick = false;
        }else{
            $('.profiles').slideUp(400);
            profileFirstClick = true;
        }
    });
    $("a.toggle").click(function(event){
       event.preventDefault(); 
    });
    $(".left ul li").click(function(){
        if($(this).hasClass(".submenu-in")){
            $(this).removeClass(".submenu-in");
            $(this).find('.submenu').slideUp(400);
        }else{
            $(".left ul li").removeClass(".submenu-in");
            $('.submenu').slideUp(200);
            $(this).addClass(".submenu-in");
            $(this).find('.submenu').slideDown(400);
        }
    });
    $('.content').click(function(){
        if(profileFirstClick == false){
            profileFirstClick = true;
            $('.profiles').slideUp(400);
        }
        $('.colors').slideUp(400);
    });
});
function checkCode(value,_imc,_t){
    _imc = _imc||'messCode';
    _t = _t||'';
    var arr = value.split('|');
    if(arr[2] === arr[0]){
        $('#'+_imc).html('<span class="fa" style="color:#1AD20D; font-size:18px" title="Mã không thay đổi">&#xf00c; </span><span style="color:blue">Mã không thay đổi</span>');
    }else{
        $.ajax({
            type:'post',
            data:{
                code:   arr[0],
                typeData:_t,
            },
            url: url + '/' + arr[1] + '/checkCode/' , 
            success:function(data){
                var arrData = data.split('|');
                $('#'+_imc).html(arrData[0]);
            },
        });    
    }   
}