<div class="page-header">
    <h1>Tempat</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">        
        <form class="form-inline">
            <input type="hidden" name="m" value="tempat" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="<?=$_GET['q']?>" />            
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>            
                <a class="btn btn-primary" href="?m=tempat_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
                <a class="btn btn-primary" href="?m=tempat_list"><span class="glyphicon glyphicon-eye-open"></span>  Lihat Peta</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr class="nw">
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Tempat</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $q = esc_field($_GET['q']);
                
        $sql = "SELECT * FROM tb_tempat WHERE nama_tempat LIKE '%$q%' ORDER BY id_tempat";
        $rows = $db->get_results($sql);
        
        foreach($rows as $row):?>
        <tr>
            <td><?=++$no?></td>
            <td><img class="thumbnail" height="60" src="assets/images/tempat/small_<?=$row->gambar?>" /></td>
            <td><?=$row->nama_tempat?></td>
            <td><?=$row->lat?></td>
            <td><?=$row->lng?></td>
            <td><?=$row->lokasi?></td>
            <td class="nw">
                <a class="btn btn-xs btn-warning" href="?m=tempat_ubah&ID=<?=$row->id_tempat?>"><span class="glyphicon glyphicon-edit"></span></a>
                <a class="btn btn-xs btn-danger" href="aksi.php?act=tempat_hapus&ID=<?=$row->id_tempat?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                <a class="btn btn-xs btn-danger" href="?m=tempat_detail&ID=<?=$row->id_tempat?>" ><span class="glyphicon glyphicon-eye-open"></span></a>
            </td>
        </tr>
        <?php endforeach;    ?>
        </table>
    </div>
</div>