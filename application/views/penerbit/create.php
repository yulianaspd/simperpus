<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('penerbit/index'); ?>"><?php echo $parent_title?></a></li>
        <li class="active"> <?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <?php echo validation_errors(); ?>
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" action="<?php echo base_url('penerbit/store'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="namaLabel">Nama</label>
                  <?php echo $this->session->flashdata('nama') ?>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label for="alamatLabel">Alamat</label>
                  <?php echo $this->session->flashdata('alamat') ?>
                  <textarea class="form-control" rows="3" cols="10" name="alamat" id="alamat" placeholder="Alamat"></textarea>
                </div>
                <div class="form-group">
                  <label for="teleponLabel">Telepon</label>
                  <?php echo $this->session->flashdata('telepon') ?>
                  <input type="number" class="form-control" name="telepon" id="telepon" placeholder="Telepon">
                </div>
                <div class="form-group">
                  <label for="emailLabel">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email">
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