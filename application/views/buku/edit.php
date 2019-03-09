<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('buku/index'); ?>"><?php echo $parent_title?></a></li>
        <li class="active"> <?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- form start -->
            <?php $buku = $data_buku[0]; ?>
            <form role="form" action="<?php echo base_url('buku/update'); ?>" method="POST">
              <div class="box-body">

                <div class="form-group">
                  <label for="isbnLabel">ISBN</label>
                  <input type="hidden" name="id" value="<?php echo $buku->id ?>">
                  <input type="number" class="form-control" name="isbn" id="isbn" placeholder="ISBN" value="<?php echo $buku->isbn ?>" required>
                </div>

                <div class="form-group">
                  <label for="judulLabel">Judul</label>
                  <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $buku->judul ?>" required>
                </div>

                <div class="form-group">
                  <label for="halamanLabel">Halaman</label>
                  <input type="number" class="form-control" name="halaman" id="halaman" placeholder="Halaman" value="<?php echo $buku->halaman ?>" required>
                </div>

                <div class="form-group">
                  <label for="kodeLabel">Kategori</label>
                    <select class="form-control" name="kategori_id" id="kategori_id">
                      <option value=""  disabled-selected>-Pilih Kategori-</option>
                      <?php foreach($kategori as $value) {?>
                        <option <?php if($value->id == $buku->kategori_id){ echo "selected"; } ?> value="<?php echo $value->id?>"><?php echo $value->nama ?></option>
                      <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                  <label for="penulisLabel">Penulis</label>
                    <select class="form-control" name="penulis_id" id="penulis_id">
                      <option value=""  disabled-selected>-Pilih Penulis-</option>
                      <?php foreach($penulis as $value) {?>
                        <option <?php if($value->id == $buku->penulis_id){ echo "selected"; } ?> value="<?php echo $value->id ?>"><?php echo $value->nama_lengkap ?></option>
                      <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                  <label for="penerbitLabel">Penerbit</label>
                    <select class="form-control" name="penerbit_id" id="penerbit_id">
                      <option value=""  disabled-selected>-Pilih Penerbit-</option>
                      <?php foreach($penerbit as $value) {?>
                        <option <?php if($value->id == $buku->penerbit_id){ echo "selected"; } ?> value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
                      <?php } ?>
                    </select>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->