var type = 'all' ;
var seldata;
var suc_ok = false;
var checkb = false;
$(document).ready(function () {
    ajax(type);
    
});
$('#option_us').change(function(event){
    var sort = event.target.value;
    if(sort == 0) {
        type = 'all';
        }
    if(sort == 1) {
        type = 'new';
        }
    if(sort == 2) {
        type = "admitn't";
        }
    if(sort == 3) {
        type = "party";
        }
    if(sort == 4) {
        type = "guest";
        }
    if(sort == 5) {
        type = "admit";
        }
    ajax(type);
})


function ajax(type){
    $.ajax({
        url:'?r=admin/list-users',
        type:'POST',
        data:'type='+type+"&output=1",
        success: function(data){
            // console.log(data);
            $('#us_table').html(data);
            $('[data-toggle="tooltip"]').tooltip({
                animated: 'fade',
                placement: 'bottom',
                html: true,
            })
            $('div[name="item"]').click(function (event) {
                var elements = $('div[name="item"]');
                for(var i = 0; i<elements.length;i++){
                    elements[i].classList.remove("active-item-us");
                }
                $(this).addClass("active-item-us");
            })

            $('.list-item').change(function (event) {
                    // console.log(event.target.value,event.target.id,event.target.name);
                $('input[id='+event.target.id+']').prop('checked',true);
                checkb = true;
            })
        }
    })
}

$('#send').click(function(event){
    // alert(type);
    if(checkb){
        up_ajax();
        if(suc_ok){
        $('#success').show("fast");
        hideDiv(suc_ok);
        ajax(type);
        }
        else{
            $('#danger').show("fast");
            hideDiv(suc_ok);
            ajax(type);
        }
    }
})
function up_ajax(){
    var check = document.getElementsByTagName('input');
    var selects = document.getElementsByClassName('list-item');

    $.each(check, function(i,item){
        if ($('input[id="'+item['id']+'"]').is(':checked')){
            seldata = "id="+item.id+'&type='+type+"&output=0";
            $.each(selects, function(i,sel_item){
                if(sel_item.id == item['id']){
                    seldata+="&"+sel_item.name+"="+sel_item.value;
            }
            })
            // console.log(seldata);
            $.ajax({
                    url: '?r=admin/list-users',
                    type: 'POST',
                    data: seldata,
                    async: false,
                    success:function(resp){
                        console.log(resp);
                        if((resp)){
                            suc_ok = true;
                        }
                        else{
                            suc_ok = false;
                        }
                    }
                })
                checkb = false;
        }
    })
}

$('#cancell').click(function(){
    ajax(type);
})
function hideDiv(){
    setTimeout(function(){
        if(suc_ok){
            $('#success').hide("fast");
        }else{
            $('#danger').hide("fast");
        }
        }, 2000);
}
////tooltips///
