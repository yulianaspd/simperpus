<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('kategori/index'); ?>"><?php echo $parent_title?></a></li>
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
            <form role="form" action="<?php echo base_url('kategori/store'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="kodeLabel">Rak ID</label>
                    <?php echo $this->session->flashdata('rak_id') ?>
                    <select class="form-control" name="rak_id" id="rak_id">
                      <option value=""  disabled-selected>-Pilih ID Rak-</option>
                      <?php foreach($rak as $value) {?>
                      <option value="<?php echo $value->id ?>"><?php echo $value->kode ?></option>
                      <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                  <label for="kodeLabel">Nama</label>
                  <?php echo $this->session->flashdata('nama') ?>
                  <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
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