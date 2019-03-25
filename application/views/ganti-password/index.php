<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $title?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <?php echo $this->session->flashdata('notif'); ?>
          <div class="box box-primary">
            <!-- form start -->
            <form role="form" action="<?php echo base_url('gantiPassword/updatePassword'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="passLamaLabel">Password Lama</label>
                  <input type="password" class="form-control" name="password_lama" id="password_lama" placeholder="Password Lama" value="" required>
                </div>
                <div class="form-group">
                  <label for="passBaruLabel">Password Baru</label>
                  <input type="password" class="form-control" name="password_baru" id="pass_lama" placeholder="Password Baru" value="" required>
                </div>
                <div class="form-group">
                  <label for="passConfirmLabel">Password Konfirmasi</label>
                  <input type="password" class="form-control" name="password_konfirmasi" id="password_konfirmasi" placeholder="Ketik Ulang Password Baru" value="" required>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Ganti Password</button>
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