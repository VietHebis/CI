<?php 
 function public_url($url = "")
{
	return base_url('assets/'.$url);
}
function upload_url($url = "")
{
    return base_url('upload/'.$url);
}
function pre($list, $exit = false)
{
    echo '<pre>';
    print_r($list);
    if($exit){
        die();
    }
}
 ?>