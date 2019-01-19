<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('rak/index'); ?>"><?php echo $parent_title?></a></li>
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
            <?php foreach($rak as $value){ ?>
            <form role="form" action="<?php echo base_url('rak/update'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <input type="hidden" name="id" id="id" value="<?php echo $value->id ?>">
                  <label for="kodeLabel">Kode</label>
                  <?php echo $this->session->flashdata('form_kode') ?>
                  <input type="text" class="form-control" name="kode" id="kode" value="<?php echo $value->kode ?>" placeholder="Kode" required>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
              </div>
            </form>
            <?php } ?>
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