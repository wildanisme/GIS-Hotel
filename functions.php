<?php
error_reporting(~E_NOTICE & ~E_DEPRECATED);
session_start();

include dirname(__FILE__) . '/config.php';
include'includes/ez_sql_core.php';
include'includes/ez_sql_mysqli.php';
$db = new ezSQL_mysqli($config[username], $config[password], $config[database_name], $config[server]);
include'includes/general.php';
include'includes/paging.php';
include'includes/SimpleImage.php';

$mod = $_GET[m];
$act = $_GET[act];

function get_tempat_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT id_tempat, nama_tempat FROM tb_tempat ORDER BY id_tempat");
    foreach($rows as $row){
        if($row->id_tempat==$selected)
            $a.="<option value='$row->id_tempat' selected>$row->nama_tempat</option>";
        else
            $a.="<option value='$row->id_tempat'>$row->nama_tempat</option>";
    }
    return $a;
}

function get_siswa_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT nis, nama_siswa FROM tb_siswa ORDER BY nis");
    foreach($rows as $row){
        if($row->nis==$selected)
            $a.="<option value='$row->nis' selected>$row->nis - $row->nama_siswa</option>";
        else
            $a.="<option value='$row->nis'>$row->nis - $row->nama_siswa</option>";
    }
    return $a;
}

function parse_file_name($file_name)
{
    $x = strtolower($file_name);    
    $x = str_replace(array(' '), '-', $x);
    return $x;
}

function hapus_gambar($ID)
{
    global $db;
    $row = $db->get_row("SELECT gambar FROM tb_tempat WHERE id_tempat='$ID'");
    if($row)
    {
        $file1 = 'assets/images/tempat/' . $row->gambar;
        $file2 = 'assets/images/tempat/small_' . $row->gambar;
        if(is_file($file1))
            unlink($file1);
        if(is_file($file2))
            unlink($file2);    
    }
}

function hapus_galeri($ID)
{
    global $db;
    $row = $db->get_row("SELECT gambar FROM tb_galeri WHERE id_galeri='$ID'");
    if($row)
    {
        $file1 = 'assets/images/galeri/' . $row->gambar;
        $file2 = 'assets/images/galeri/small_' . $row->gambar;
        if(is_file($file1))
            unlink($file1);
        if(is_file($file2))
            unlink($file2);    
    }
}

function get_page($name = '')
{
    global $db;
    return $db->get_row("SELECT * FROM tb_page WHERE nama_page='$name'");
}