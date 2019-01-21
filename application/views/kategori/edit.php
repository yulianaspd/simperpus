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
            <?php foreach($kategori as $value){ ?>
            <form role="form" action="<?php echo base_url('kategori/update'); ?>" method="POST">
              <div class="box-body">
                 <div class="form-group">
                  <label>Rak ID</label>
                  <select class="form-control" name="rak_id" id="rak_id">
                    <?php foreach($raks as $rak) { ?>
                    <option <?php if($value->rak_id == $rak->id){ echo "selected"; } ?> value="<?php echo $rak->id ?>"><?php echo $rak->kode ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <input type="hidden" name="id" id="id" value="<?php echo $value->id ?>">
                  <label for="kodeLabel">Nama</label>
                  <input type="text" class="form-control" name="nama" id="nama" value="<?php echo $value->nama ?>" placeholder="Nama" required>
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