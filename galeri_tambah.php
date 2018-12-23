<div class="page-header">
    <h1>Tambah Gambar</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=galeri_tambah" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tempat <span class="text-danger">*</span></label>
                <select class="form-control" name="id_tempat">
                    <?=get_tempat_option($_POST[id_tempat])?>
                </select>
            </div>
            <div class="form-group">
                <label>Gambar <span class="text-danger">*</span></label>
                <input class="form-control" type="file" name="gambar"/>
            </div>
            <div class="form-group">
                <label>Nama Galeri</label>
                <input class="form-control" type="text" name="nama_galeri" value="<?=$_POST[nama_galeri]?>"/>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea class="mce" name="ket_galeri"><?=$_POST['ket_galeri']?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=galeri"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>