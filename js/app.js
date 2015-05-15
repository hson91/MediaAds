$(document).ready(function() {
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