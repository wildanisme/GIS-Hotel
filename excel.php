<?php
include 'functions.php';
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=$mod.xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

$file = $mod."_excel.php";
if(file_exists($file))
    include $file; 
if($rows) :
?>
<table border="1">
    <tr>
        <th>No</th>
        <?php                 
        $array = $rows[0];                
        foreach(array_keys($array) as $key):?>
        <th><?=ucwords(str_replace('_', ' ', $key))?></th>
        <?php endforeach?>        
    </tr>
    <?php 
    $no=1;
    foreach($rows as $row):?>
    <tr>
        <td><?=$no++?></td>
        <?php         
        foreach($row as $key=> $value):?>
        <td><?=$value?></td>
        <?php endforeach ?>
    </tr>
    <?php endforeach ?>
</table>
<?php endif;?>
