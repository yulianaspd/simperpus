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
            <form role="form" action="<?php echo base_url('buku/store'); ?>" method="POST">
              <div class="box-body">

                <div class="form-group">
                  <label for="isbnLabel">ISBN</label>
                  <?php echo $this->session->flashdata('isbn') ?>
                  <input type="number" class="form-control" name="isbn" id="isbn" placeholder="ISBN" value="<?php echo $this->session->flashdata('isbn_value') ?>">
                </div>

                <div class="form-group">
                  <label for="judulLabel">Judul</label>
                  <?php echo $this->session->flashdata('judul') ?>
                  <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $this->session->flashdata('judul_value') ?>">
                </div>

                <div class="form-group">
                  <label for="halamanLabel">Halaman</label>
                  <?php echo $this->session->flashdata('halaman') ?>
                  <input type="number" class="form-control" name="halaman" id="halaman" placeholder="Halaman" value="<?php echo $this->session->flashdata('halaman_value')?>">
                </div>

                <div class="form-group">
                  <label for="kodeLabel">Kategori</label>
                    <?php echo $this->session->flashdata('kategori_id') ?>
                    <select class="form-control" name="kategori_id" id="kategori_id">
                      <option value=""  disabled-selected>-Pilih Kategori-</option>
                      <?php foreach($kategori as $value) {?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
                      <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                  <label for="penulisLabel">Penulis</label>
                    <?php echo $this->session->flashdata('penulis_id') ?>
                    <select class="form-control" name="penulis_id" id="penulis_id">
                      <option value=""  disabled-selected>-Pilih Penulis-</option>
                      <?php foreach($penulis as $value) {?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
                      <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                  <label for="penerbitLabel">Penerbit</label>
                    <?php echo $this->session->flashdata('penerbit_id') ?>
                    <select class="form-control" name="penerbit_id" id="penerbit_id">
                      <option value=""  disabled-selected>-Pilih Penerbit-</option>
                      <?php foreach($penerbit as $value) {?>
                        <option value="<?php echo $value->id ?>"><?php echo $value->nama ?></option>
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