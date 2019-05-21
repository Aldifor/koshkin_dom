var new_id;

$('.a-modal').click(function (e) {
    $('.new').html(this.getAttribute('data-title'));
    new_id = this.getAttribute('data-id');
});

$('#mDelNew').click(function (e) {
    news_del(new_id,0);
});
$('#delNew').click(function (e) {
    news_del(new_id,1);
});
$('#restoreNew').click(function (e) {
    news_del(new_id,0,1);
});

function news_del(new_id,del,restore){
        var data = {
            'new_id': new_id,
            'type':del,
            'restore': restore,
        }
        console.log(data);
        $.ajax({
            url: "?r=controller/index",
            type: "POST",
            data: data,
            success:function(data){
                // console.log(data);
                if(!$_GET('id')){
                    // consile.log(document.location.href);
                    window.location.href = document.location.href;
                    // window.location.href = '/';
                }
                else{
                    window.location.href = '/news?deleted   ';
                }
            }
    })
}
function $_GET(key)  {
    var p = window.location.search;
    p = p.match(new RegExp(key + '=([^&=]+)'));
    return p ? p[1] : false;
}