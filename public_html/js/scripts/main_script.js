///avtoriz///////
var regem =/.+@.+\..+/;
// function active(el){
//     document.querySelector("#modal_pas_invalid").innerHTML="";
//     el.value = "";
// }
function checkForm(){
    var log = document.querySelector("#modal_log").value;
    var pas = md5(document.querySelector("#modal_pas").value);
    if(log!="" && pas!= ""){
    var session = false;
        $.ajax({
            url: "?r=controller/index",
            type: "POST",
            data: "session="+session+"&login="+log,
            success:function(data){
                //  console.log(data);
                data = jQuery.parseJSON(data);
                if(data != '' && pas == data[0]['password']){
                        session = true;
                    $.ajax({
                        url: "?r=main/index",
                        type: "POST",
                        data: "session="+session+"&login="+log+"&password="+pas,
                        success:function(res){
                            //  console.log(res);
                                window.location.href = document.location.href;
                        }
                    })
                }
                else{
                    document.querySelector("#modal_pas").classList.add("is-invalid");
                    document.querySelector("#modal_pas_invalid").innerHTML = "Логин или пороль не верен";
                }
            }
        })
    }
}
////tooltips///
$(document).ready(function () {
    tooltip('right');
});
function tooltip(position){
    $('div[data-toggle="tooltip"]').tooltip ({
        animated: 'fade',
        placement: position,
        html: true,
    })
}
function $_GET(key)  {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}
 