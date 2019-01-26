<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('penulis/index'); ?>"><?php echo $parent_title?></a></li>
        <li class="active"><?php echo $title?></li>
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
            <?php $value = $penulis[0]; ?>
            <form role="form" action="<?php echo base_url('penulis/update'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <label for="namaLengkapLabel">Nama Lengkap</label>
                  <?php echo $this->session->flashdata('nama_lengkap') ?>
                  <input type="hidden" name="id" id="id" value="<?php echo $value->id ?>">
                  <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $value->nama_lengkap ?>" required>
                </div>
                <div class="form-group">
                  <label for="namaAliasLabel">Nama Alias</label>
                  <?php echo $this->session->flashdata('nama_alias') ?>
                  <input type="text" class="form-control" name="nama_alias" id="nama_alias" placeholder="Nama Alias" value="<?php echo $value->nama_alias ?>" required>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
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