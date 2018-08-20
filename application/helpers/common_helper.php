<?php

function dbQueryField($field, $table, $whereArray = array(), $notWhereArray = array()) {

    $CI = & get_instance();
    parsesArrayIntoWhere($whereArray);
    parsesArrayIntoNotWhere($notWhereArray);
    $res = $CI->db->select($field)->get($table)->row();
    return $res->$field;
}

function recordExists($username,$table="")
{
    $CI = & get_instance();
    $res= $CI->db->select('username')->where('username',$username)->get('tweets')->row();
    if(count($res)==1)
    {
        return true;
    }
    else
    {
        return false;
    }
}


?>