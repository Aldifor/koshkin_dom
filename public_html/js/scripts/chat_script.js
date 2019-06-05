var type_chat;
var smile_cont = false;
var reg_smile = /<img.[^>]+>/gim;
var reg_smile_id = /%.+%/;
var to_us;
var is_socket = false;

$(document).ready(function(){
    user_id = $('#user_id').attr('data-user');
    if( $_GET('id') != ''){
        to_us = $_GET('id');
        type_chat = 'private';
        // out_content(type_chat, to_us);
    }else if(document.querySelector('#ulm') == null){
        type_chat = 'general';
        // out_content(type_chat,false);
    }
    if ('WebSocket' in window && (typeof WebSocket === 'function' || typeof WebSocket === 'object')) { // supports WebSocket
        socket = new WebSocket('ws://localhost:5432');
        console.log(socket);
        socket.onopen = function(e) {
            is_socket = true;
            if(document.location.pathname == '/communication/private' && !to_us){
                data = {
                    dialog:true,
                    us_id:user_id
                }
            }else{
                data = {
                    init:true,
                    us_id:user_id,
                    to_us:to_us,
                    type:type_chat,
                }
            }
            socket.send(JSON.stringify(data));
        };
        socket.onclose = function(e) {
            is_socket = false;
            console.log('close');
        };
        socket.onmessage = function(e){
            console.log(e);
            $('#outmessage').append(e.data);
            mes_scrol();
            $('#mes-input').text('');
            tooltip('bottom');
        }
    } else { // does not support WebSocket
        is_socket = false;
    }
    if(!is_socket){
        if( $_GET('id') != ''){
            to_us = $_GET('id');
            type_chat = 'private';
            out_content(type_chat, to_us);
        }else if(document.querySelector('#ulm') == null){
            type_chat = 'general';
            out_content(type_chat,false);
        }
    }

    if(document.location.pathname == '/communication/private' && !to_us){
        if(!is_socket){
            getDialog();
        }
    }else{
        out_smiles("standart",false);
    }
});

$('button[name="chats"]').on('click',function(){
    id = this.id;
    if(id == "clan_chat"){
        $('#outmessage').html('');
        type_chat = "gild";
        this.id = 'general_chat';
        $(this).html('В общий чат');
        $('.chat_header').html('Клановый чат');
        out_content(type_chat,false);
    }
    else{
        $('#outmessage').html('');
        type_chat = "general";
        this.id = 'clan_chat';
        $(this).html('В клановый чат');
        $('.chat_header').html('Общий чат');
        out_content(type_chat,false);
    }

})

$('#send').on('click',function(){
    var message = $('#mes-input').html();
    to_us = $_GET('id');
    var matches= false;
    matches = message.match(reg_smile);
    if(matches){
        for(var i = 0; i<matches.length;i++){
            var smile_id = matches[i].match(reg_smile_id);
            message = message.replace(matches[i], smile_id[0]);
        }
    }
// console.log(message);
if(message!=""){
    var data = {
        "message":message,
        "type":type_chat,
        "to_us":to_us
    };
    if(!is_socket){
        $.ajax({
            url: "?r=main/communication", //inp-mes
            type: 'POST',
            async: false,
            data: data,
            success: function (html) {
                $('#outmessage').append(html);
                mes_scrol()
                $('#mes-input').text('');
                tooltip('bottom');
            }
        });
        }
    else{
        socket.send(JSON.stringify(data));
    }
}
})

function getDialog(){
    if(!is_socket){
        $.ajax({
                type: "POST",
                url: "?r=main/communication",
                data: "dialog="+true,
                success: function (html) {
                    if(html!=""){
                        $('#outmessage').html('');
                        $('#outmessage').append(html);
                        mes_scrol();
                        tooltip('bottom');
                        $('.mes-block').on('click', function (e) {
                            window.location.href = "?id="+e.currentTarget['id'];
                        });
                    }
                }
            });
    }
}
function out_message(){
    var mes_divs = document.querySelectorAll('.mes-body');
    if(mes_divs.length != 0){
        var data={
            "type":type_chat,
            "mes_id":mes_divs[mes_divs.length-1].id,
            "to_us":to_us,
        }
        $.ajax({
            type: "POST",
            url: "?r=main/communication",
            data: data,
            success: function (html) {
                // console.log(html);
                if(html!=""){
                    $('#outmessage').append(html);
                    mes_scrol();
                }
                setTimeout(out_message,1000);
            }
        });
    }
}
function out_content(type_chat, to_us){
    var data = {
        'type':type_chat,
        'to_us':to_us,
    };
    $.ajax({
        url: "?r=main/communication",
        type: "POST",
        data: data,
        success: function (html) {
            $('#outmessage').append(html);
            out_message();
            mes_scrol();
            tooltip('bottom');
        }
    });
}
function mes_scrol(){
    var div = document.getElementById('outmessage'); // id div'a
    $('#outmessage').scrollTop(div.scrollHeight-div.offsetHeight);
}

////////////////////////////////smile////////////////////////////////////////////////////////////////////////////////
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
