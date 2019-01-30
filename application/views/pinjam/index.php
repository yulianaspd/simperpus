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
          <div class="box box-primary">
            <!-- form start -->
            <form id="form-pinjam" role="form" action="#" method="POST">
              <div class="box-body">
                <label>Kode Anggota</label>
                <div class="input-group input-group-md">
                  <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode Anggota">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info btn-flat" id="btn-cek-anggota"><i class="fa fa-refresh"></i></button>
                    </span>
                </div>
              </div>
                <!-- /.box-body -->
            </form>
          </div>
          <!-- /.box -->

          <div class="box box-primary" id="box-buku">
            <!-- form start -->
            <form id="form-pinjam" role="form" action="#" method="POST">
              <div class="box-body">
                
                <div class="row">
                  <div class="col-md-6">
                    <table class="table table-striped">
                        <tr>
                          <th style="width: 10px">#</th>
                          <th></th>
                          <th></th>
                        </tr>
                        <tr>
                          <td>1.</td>
                          <td>KODE</td>
                          <td class="text-right kode"></td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <td>NAMA LENGKAP</td>
                          <td class="text-right nama_lengkap"></td>
                        </tr>
                        <tr>
                          <td>3.</td>
                          <td>Alamat</td>
                          <td class="text-right alamat"></td>
                        </tr>
                        <tr>
                          <td>4.</td>
                          <td>TELEPON</td>
                          <td class="text-right telepon"></td>
                        </tr>
                      </table>
                  </div>
                  <div class="col-md-6">
                    <label>INPUT BUKU</label>
                    <div class="input-group input-group-sm">
                      <input type="text" id="isbn" name="isbn" class="form-control" placeholder="ISBN">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
                      </span>
                    </div>
                    <div class="table-responsive">
                      <table id="table-buku" class="table table-bordered table-striped nowrap">
                         <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Judul</th>
                                  <th></th>
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>No</th>
                                  <th>Judul</th>
                                  <th></th>
                              </tr>
                          </tfoot>
                      </table>
                    </div>

                  </div>
                </div>
                
              </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-rocket"></i> Proses</button>
              </div>
            </form>
          </div>

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 

<script>
  $(document).ready(function(){
    
    $("#box-buku").hide();

    $("#btn-cek-anggota").click(function(){
      var kode = $("#kode").val();
        $.ajax({
            type: "POST",
            dataType: 'JSON',
            data:{
                  kode : kode
                },
            url:"<?php echo base_url('pinjam/showAnggota'); ?>",
            success: function (data) {
                   
              if(data.keterangan != 'NOK'){
                $(".kode").html('<b>'+data.anggota.kode +'</b>');
                $(".nama_lengkap").html('<b>'+data.anggota.nama_lengkap +'</b>');
                $(".alamat").html('<b>'+data.anggota.alamat +'</b>');
                $(".telepon").html('<b>'+data.anggota.telepon +'</b>');
                $("#box-buku").slideDown(); 
              }else{
                 $("#box-buku").slideUp();
                alert(data.error);
              }   
            },
            error: function(data){
              console.log(data);
            }
        });     
    });

  });
</script>