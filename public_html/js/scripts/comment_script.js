var show = true;
var smile_cont = false;
var reg_smile = /<img.[^>]+>/gim;
var reg_smile_id = /%.+%/;
var to_us;
$(document).ready(function () {
    out_smiles('standart');
});
$('.comment_header').on('click',function(){
    if(show){
        $('.comment_block').show('fast');
        show = false;
    }else{
        $('.comment_block').hide('fast');
        show = true;
    }
})

$('#send').on('click',function(){

    var message = $('#mes-input').html();

    new_id = $_GET('id');

    var matches = false;
    matches = message.match(reg_smile);
    if(matches){
        for(var i = 0; i<matches.length;i++){
            var smile_id = matches[i].match(reg_smile_id);
            message = message.replace(matches[i], smile_id[0]);
        }
        
    }
console.log(message);
if(message!=""){
        var data = {
            "message":message,
            "new_id":new_id
        };
        $.ajax({
            url: "?r=main/new",
            type: 'POST',
            async: false,
            data: data,
            success: function (html) {
                $('#comment_body').append(html);
                mes_scrol();
                $('#comment_body').show('fast');
                $('#mes-input').text('');
                tooltip('bottom');
            }
        });
    }
})
////////////////////////////// smmile /////

$('img[name="smile_type"]').on('click', function(e){
    document.querySelector('.active_smile_type').classList.remove('active_smile_type');
    e.target.classList.add('active_smile_type');

    out_smiles($(this).attr('data-type'));
})
$('#smile_btn').on('click',function(){
    if(!(smile_cont)){
        $('.smile_conteiner').show('fast',function(){
            $('html, body').animate({
                scrollTop: $("#send").offset().top
            }, 500);
        });

        smile_cont = true;
    }else{
        $('.smile_conteiner').hide('fast');
        smile_cont = false;
    }

})
function out_smiles(type_smile){
    $.ajax({
    url: "?r=main/communication",
    type: "POST",
    data: "type_smile="+type_smile,
    success: function (smile) {
        $('#smile_item').html(smile);
        $('div[name="smile"]').on('click',function(){
                $('#mes-input').append($(this).html());
                // $('#mes-input').focus();
        })
    }
});
}
function $_GET(key)  {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}
function mes_scrol(){
    var div = document.getElementById('comment_body'); // id div'a
    $('#comment_body').scrollTop(div.scrollHeight-div.offsetHeight);
}
