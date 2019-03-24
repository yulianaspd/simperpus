<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span class="<?php echo $icon; ?>"></span> <?php echo $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard/index'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('user/index'); ?>"><?php echo $parent_title?></a></li>
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
            <form role="form" action="<?php echo base_url('user/update'); ?>" method="POST">
              <div class="box-body">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-8">
                      <label for="namaLengkapLabel">Nama Lengkap</label>
                      <input type="hidden" name="id" value="<?php echo $user[0]->id;?>">
                      <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $user[0]->nama_lengkap;?>">
                    </div>
                    <div class="col-md-4">
                      <label for="panggilanLabel">Panggilan</label>
                      <input type="text" class="form-control" name="panggilan" id="panggilan" placeholder="Panggilan" value="<?php echo $user[0]->panggilan;?>">
                    </div>
                  </div>
                </div>
                 <div class="form-group">
                  <label for="jenisKelaminLabel">Jenis Kelamin</label>
                  <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                    <?php foreach ($jenis_kelamin as $key_jk => $value_jk){ ?>
                      <option value="<?php echo $key_jk ?>" <?php if($user[0]->status == $key_jk){ echo "selected"; } ?>><?php echo $value_jk; ?></option>
                    <?php } ?>
                  </select>
                </div>
                 <div class="form-group">
                  <label for="alamatLabel">Alamat</label>            
                  <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat"><?php echo $user[0]->alamat;?></textarea>
                </div>
                <div class="form-group">
                  <label for="emailLabel">Email</label>                  
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $user[0]->email;?>">
                </div>
                <div class="form-group">
                  <label for="teleponLabel">Telepon</label>                
                  <input type="number" class="form-control" name="telepon" id="telepon" placeholder="Telepon" value="<?php echo $user[0]->telepon;?>">
                </div>
                <div class="form-group">
                  <label for="statusLabel">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="" disabled selected>-Pilih Status-</option>
                    <?php foreach ($status as $key => $value){ ?>
                      <option value="<?php echo $key ?>" <?php if($user[0]->status == $key){ echo "selected"; } ?>><?php echo $value; ?></option>
                    <?php } ?>
                  </select>
                </div>
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