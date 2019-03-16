<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class LaporanMutasiBuku extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model(['m_auth','m_laporanMutasiPinjam']);
        $this->load->library('pdf');
        if(!$this->m_auth->loggedIn()){
            redirect('auth');
        }
    }

    public function index(){
        $data['title']  = 'Laporan Mutasi Buku';
        $data['icon']   = 'fa fa-retweet';
        $data['uri']    = $this->uri->segment(1);

        $this->load->view('layout/header', $data);
        $this->load->view('laporan-mutasi-buku/index', $data);
        $this->load->view('layout/footer');
    }

    public function ajaxGetMutasiPinjam(){
        $tanggal = $this->input->post('tanggal');
        if($tanggal != [] ){
            $tanggal;
        }else{
            $tanggal = [date('Y-m-d'),date('Y-m-d')];
        }

        $list = $this->m_laporanMutasiPinjam->get_datatables($tanggal);
        $data = array();
        $no = $_POST['start'];
        $ket_status;
        foreach($list as $value){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<b>'.$value->kode.'</b><br>'.$value->nama_lengkap;
            $row[] = $value->judul;
            $row[] = '<div style="color:green">'.date('d-M-Y', strtotime($value->tanggal_pinjam)).'</div> <i class="fa fa-long-arrow-right"></i> <div style="color:red">'.date('d-M-Y',strtotime($value->jatuh_tempo)).' <i>( Perpanjang '.$value->jml_perpanjangan.' x )</i></div>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_laporanMutasiPinjam->count_all($tanggal),
            "recordsFiltered" => $this->m_laporanMutasiPinjam->count_filtered($tanggal),
            "data" => $data
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    
//     function mutasiPinjamPdf($status){
//         if($status == 1){
//             $keterangan = '<b style="color:green;">AKTIF</b>';
//         }else if($status == 0){
//             $keterangan = '<b style="color:red;">TIDAK AKTIF</b>';
//         }
//         $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
//         $pdf->SetTitle('Data Anggota');
//         $pdf->SetSubject('Laporan Data Anggota Perpustakaan');
// // set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
// $pdf->setFooterData(array(0,64,0), array(0,64,128));

// // set header and footer fonts
// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
//         $pdf->SetHeaderMargin(30);
//         $pdf->SetTopMargin(20);
//         $pdf->setFooterMargin(20);
//         $pdf->SetAutoPageBreak(true);
//         $pdf->SetAuthor('SimPerpus');
//         $pdf->SetDisplayMode('real', 'default');
//         $pdf->AddPage();
//         $i=0;
//         $anggota = $this->m_laporanAnggota->downloadPdf($status)->result();
//         $html='<h1 align="center"></h1>
//                 <h3 align="center">DATA ANGGOTA '.$keterangan.'</h3>
//                 <table cellspacing="1" bgcolor="#666666">
//                     <tr bgcolor="#ffffff">
//                         <th width="5%" align="center"><b>NO</b></th>
//                         <th width="35%" align="center"><b>ANGGOTA</b></th>
//                         <th width="25%" align="center"><b>IDENTITAS</b></th>
//                         <th width="35%" align="center"><b>ALAMAT</b></th>
//                     </tr>';
//         foreach ($anggota as $row) 
//             {
//                 $i++;
//                 $html.='<tr bgcolor="#ffffff">
//                             <td align="center">'.$i.'</td>
//                             <td>'
//                                 .' <b>'.$row->kode.'</b><br> '.
//                                 $row->nama_lengkap.' ('.$row->nama_panggilan.')<br> '.
//                                 $row->telepon. 
//                             '</td>
//                             <td>'
//                                 .' <b>( '.$row->jenis_identitas.' )</b><br> '.
//                                 $row->no_identitas.
//                             '</td>
//                             <td> '.$row->alamat.'</td>
//                         </tr>';
//             }
//         $html.='</table>';
//         $pdf->writeHTML($html, true, false, true, false, '');
//         $pdf->Output('data_anggota.pdf', 'I');
//     }
}