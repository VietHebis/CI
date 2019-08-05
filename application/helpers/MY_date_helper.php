<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 06/07/18
 * Time: 5:04 CH
 *
 * Lấy ngày đăng tin (int)
 * $time: int
 * $fulltiem: lấy đủ ngày giờ
 */
function get_date($time, $fulltime = true)
{
    $format = '%d-%m-%Y';
    if ($fulltime)
    {
        $format = $format.'-%H:%i:%s';
    }
    $date = mdate($format,$time);
    return $date;
}