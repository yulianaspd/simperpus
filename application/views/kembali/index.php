<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/css/jquery.dataTables.min.css')?>" rel="stylesheet">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/all.css')?>">

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
            <form id="form-pinjam" role="form" action="#">
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
            <form id="form-pinjam" role="form" action="#">
              <div class="box-body">  
                <table class="table table-striped">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th></th>
                      <th></th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>KODE</td>
                      <input type="hidden" id="anggota_id" value="">
                      <td class="text-right kode"></td>
                    </tr>
                    <tr>
                      <td>2.</td>
                      <td>NAMA LENGKAP <?php echo $this->session->userdata('id') ?></td>
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
                  
                  <br>
                  <br>
                  <!-- <div class="table-responsive"> -->
                    <table id="table-pinjam" class="table table-bordered table-striped" style="width:100%">
                       <thead>
                            <tr>
                              <th>
                                <div class="checkbox">
                                  <label><input type="checkbox" class="icheckbox_flat-blue" id="check-all" value=""></label>
                                </div>
                              </th>
                              <th>No</th>
                              <th>Judul</th>
                              <th>Tanggal Pinjam</th>
                              <th>Jatuh Tempo</th>
                              <th>Terlambat</th>
                              <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                          
                        </tbody>
                        <tfoot>
                            <tr>
                              <th colspan="6"><h3>TOTAL DENDA</h3></th>
                              
                              <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="total_denda_footer"></div>
              </div>
                <!-- /.box-body -->
              <div class="box-footer">
                <button type="button" class="btn btn-success pull-right" id="btn-proses"><i class="fa fa-rocket"></i> Proses</button>
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

<div class="modal fade" id="modal-confirm-list-kembali" role="dialog" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><center><span class="fa fa-question-circle"></span> List Buku embali</center></h4>
            </div>
            <form action="#">
                <div class="modal-body">
                  <table class="table table-striped">
                    <thead>
                      <th></th>
                      <th></th>
                    </thead>
                    <tr>
                      <td>Jumlah Buku</td>
                      <td class="text-right jml_buku"></td>
                    </tr>
                    <tr>
                      <td>Total Denda</td>
                      <td class="text-right total_denda"></td>
                    </tr>
                  </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-rocket"></span> Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

 
<!-- DataTables -->
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
  var table;
  const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  });

  $(document).ready(function(){
    
    $("#box-buku").hide();
    //datatables
    table = $('#table-pinjam').DataTable({ 
        "processing": true, 
        "serverSide": true, 
        "pagination": false,
        "searching": false,
        "lengthChange": false,
        "order": [], 
        
        "ajax": {
            "url": "<?php echo base_url('kembali/ajaxGetPinjam')?>",
            "type": "POST",
            "data": function (data) {
                      data.anggota_id = $('#anggota_id').val();
                  }
        },
        // "drawCallback": function(){
        //    $('input[type="checkbox"]').iCheck({
        //       checkboxClass: 'icheckbox_flat-blue'
        //    });
        // },
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 6 ).footer() ).html(
                '<h3>'+formatter.format(total)+'</h3>' 
            );
        },
        "columnDefs": [
          { 
            "targets": [ 0 ], 
            "orderable": false, 
          },
          { 
            "targets": [ 5 ], 
            "visible": true,
            "orderable": false,
            "searchable": false
          },
          {
          "targets": [ 6 ],
            "orderable": false,
            "searchable": false  
          }
        ],  
    });

 }); 

function clearForm(){
    $("#anggota_id").val('');
    $(".kode").html('');
    $(".nama_lengkap").html('');
    $(".alamat").html('');
    $(".telepon").html('');
    $("#box-buku").slideUp(); 
    $("#kode").prop('disabled', false);
    table.ajax.reload();
  }

  $("#btn-cek-anggota").click(function(){
    var kode = $("#kode").val();
      $.ajax({
          type: "POST",
          dataType: 'JSON',
          data:{
                kode : kode
              },
          url:"<?php echo base_url('kembali/showAnggota'); ?>",
          success: function (data) {
                 
            if(data.keterangan != 'NOK'){
              $("#anggota_id").val(data.anggota.id);
              $(".kode").html('<b>'+data.anggota.kode +'</b>');
              $(".nama_lengkap").html('<b>'+data.anggota.nama_lengkap +'</b>');
              $(".alamat").html('<b>'+data.anggota.alamat +'</b>');
              $(".telepon").html('<b>'+data.anggota.telepon +'</b>');
              $("#box-buku").slideDown(); 
              $("#kode").prop('disabled', true);
              $("#btn-cek-anggota").attr('disabled','disabled');
              table.ajax.reload();
              console.log(table.ajax.json().total_denda); 
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

   $("#btn-proses").click(function(){

        var buku_id = $.map(table.data(), function (item) {
                              return item[1]
                      });
        var total_data = $("#table-pinjam_wrapper").find('input[name="pinjam_detail_id"]:checked').length;
        if(total_data == 0){
            alert("Data belum dipilih !");
        }else{
            $("#modal-confirm-list-kembali").modal('show');
            $(".jml_buku").text(total_data);
            
            var arr_proses = [];
            $.map(table.data(), function (item) {
                var arr = [];
                arr['id'] = item[7];
                arr['denda'] = item[6];
                return arr_proses.push(arr);
            });
            var total_denda = 0;
            var rowcollection =  table.$("input[name='pinjam_detail_id']:checked");
            rowcollection.each(function(index,elem){
              var checkbox_value = $(elem).val();
              var arr_denda = arr_proses.find( function(item) { 
                return item['id'] == checkbox_value 
              });
              var res = arr_denda['denda'].replace(",", "");
              total_denda += parseInt(res,10);
            });
             $(".total_denda").text(total_denda);
        }  
    });  

 // $('#btn-proses').click(function(e) {
 //    numberNotChecked = $("#table-pinjam_wrapper .pinjam_detail_id").attr('checked').length;
 //    console.log(numberNotChecked);
      // var anggota_id  = $("#anggota_id").val();
      // var user_id     = "<?php echo $this->session->userdata('id') ?>";

      // $.ajax({
      //   type: "POST",
      //   dataType:"JSON",
      //   url: "<?php echo base_url('pinjam/store'); ?>",
      //   data: {
      //     user_id:user_id,
      //     anggota_id:anggota_id
      //   },
      //   success: function(data){
      //     var pinjam_id = data.result_pinjam.id;
      //     var buku_id = $.map(table.data(), function (item) {
      //                       return item[1]
      //                   });
      //      $.ajax({
      //         type: "POST",
      //         dataType:"JSON",
      //         url:"<?php echo base_url('pinjam/storeDetail'); ?>",
      //         data:{
      //           buku_id:buku_id,
      //           pinjam_id:pinjam_id
      //         },
      //         success: function(data){
      //           clearForm();
      //           swal({
      //             title: "success!",
      //             icon: "success",
      //           });
      //         },
      //         error:function(data){
      //           console.log(data);
      //         }
      //      })
      //   },
      //   error:function(data){
      //    console.log(data);
      //   }
      // }) 
  //});

  $("#check-all").on('change', function(){
    if(this.checked) {
      console.log('hahah');
      $("#table-pinjam_wrapper ,input:checkbox").not(this).prop('checked', this.checked);
    }else{
      $("#table-pinjam_wrapper ,input:checkbox").not(this).prop('checked', false);
    }
  }); 
</script>