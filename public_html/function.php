<?php
function dd($arr, $die = false){
    echo'<pre>'.print_r($arr,true).'</pre>';
    if($die)die;

}
