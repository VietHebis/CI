<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28-May-18
 * Time: 11:47 AM
 */
//tạo ra các link trong admin
 function admin_url($url = '')
{
    return base_url('admin/'.$url);
}