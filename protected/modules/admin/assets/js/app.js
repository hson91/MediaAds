$(document).ready(function(){
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
    
    $('.content').click(function(){
        if(profileFirstClick == false){
            profileFirstClick = true;
            $('.profiles').slideUp(400);
        }
        $('.colors').slideUp(400);
    });
    /* Calendar Main */
    setInterval(function(){
        $('.calendar').html(currentDateTime());
    }, 1000);
    
    
    $('#gototop').click(function(){
        $('html, body').animate({scrollTop : 0},400);
        return false;
    });
});
function currentDateTime(){
    var currentdate = new Date(); 
    var weekday=new Array(7);
    weekday[0]="Sun";
    weekday[1]="Mon";
    weekday[2]="Tue";
    weekday[3]="Wed";
    weekday[4]="Thu";
    weekday[5]="Fri";
    weekday[6]="Sat";
    var datetime = weekday[currentdate.getDay()] + ", "
                + (currentdate.getDate() < 10 ? '0'+ currentdate.getDate() : currentdate.getDate()) + "/"
                + (currentdate.getMonth()+1 < 10 ? '0' + (currentdate.getMonth()+1) : currentdate.getMonth()+1)  + "/" 
                + currentdate.getFullYear() + " - "  
                + (currentdate.getHours() < 10 ? '0' + currentdate.getHours() : currentdate.getHours()) + ":"  
                + (currentdate.getMinutes() < 10 ? '0' + currentdate.getMinutes() : currentdate.getMinutes()) + ":" 
                + (currentdate.getSeconds() < 10 ? '0' + currentdate.getSeconds() : currentdate.getSeconds());
    return datetime;
}
function setCookie(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString()) + "; path=/";
    document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1)
    {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1)
    {
        c_value = null;
    }
    else
    {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1)
        {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start,c_end));
    }
    return c_value;
}