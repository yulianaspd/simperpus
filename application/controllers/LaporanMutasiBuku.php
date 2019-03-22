<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class LaporanMutasiBuku extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model([
            'm_auth',
            'm_laporanMutasiPinjam',
            'm_laporanMutasiKembali'
        ]);
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
        $tanggal    = $this->input->post('tanggal');
        $status     = $this->input->post('status');

        if($tanggal != [] ){
            $tanggal;
        }else{
            $tanggal = [date('Y-m-d'),date('Y-m-d')];
        }

        $list = $this->m_laporanMutasiPinjam->get_datatables($tanggal, $status);
        $data = array();
        $no = $_POST['start'];
        $ket_status;
        foreach($list as $value){
            
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<b>'.$value->kode.'</b><br>'.$value->nama_lengkap;
            $row[] = $value->judul;
            $row[] = '<div style="color:black">'.date('d-M-Y', strtotime($value->tanggal_pinjam)).'</div> <i class="fa fa-long-arrow-right"></i> <div style="color:red">'.date('d-M-Y',strtotime($value->jatuh_tempo)).' <i>( Perpanjang '.$value->jml_perpanjangan.' x )</i></div>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_laporanMutasiPinjam->count_all($tanggal, $status),
            "recordsFiltered" => $this->m_laporanMutasiPinjam->count_filtered($tanggal, $status),
            "data" => $data
        );
        //output dalam format JSON
        echo json_encode($output);
    }

     public function ajaxGetMutasiKembali(){
        $tanggal    = $this->input->post('tanggal');
        $status     = $this->input->post('status');

        if($tanggal != [] ){
            $tanggal;
        }else{
            $tanggal = [date('Y-m-d'),date('Y-m-d')];
        }

        $list = $this->m_laporanMutasiKembali->get_datatables($tanggal, $status);
        $data = array();
        $no = $_POST['start'];
        $ket_status;
        foreach($list as $value){
            $date_diff = (strtotime($value->tanggal_kembali) - strtotime($value->jatuh_tempo))/86400;
            if($date_diff > 0){
                $terlambat = '<i class="fa fa-long-arrow-right"></i> <div style="color:red"> Terlambat '.$date_diff." hari</div>";
                $denda = 1000*$date_diff;
            }else{
                $terlambat = "";
                $denda ;
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<b>'.$value->kode.'</b><br>'.$value->nama_lengkap;
            $row[] = $value->judul;
            $row[] = date('d-M-Y', strtotime($value->jatuh_tempo));
            $row[] = date('d-M-Y', strtotime($value->tanggal_kembali)).'<br>'.$terlambat;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_laporanMutasiKembali->count_all($tanggal, $status),
            "recordsFiltered" => $this->m_laporanMutasiKembali->count_filtered($tanggal, $status),
            "data" => $data
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    
    function mutasiPinjamPdf(){
        $tanggal_pinjam = array();
        $tanggal_pinjam[0] = $this->uri->segment(3);
        $tanggal_pinjam[1] = $this->uri->segment(4);
        
        if($tanggal_pinjam == []){
            $tanggal_pinjam[0] = "0000-00-00";
            $tanggal_pinjam[1] = "0000-00-00";
        }
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Laporan Mutasi Pinjam');
        $pdf->SetSubject('Laporan Mutasi Pinjam');
        // set default header data
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        // $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true);
        //$pdf->SetMargins(PDF_MARGIN_LEFT, 40 , PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);
        $pdf->SetAuthor('SimPerpus');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
        $i=0;
        $data_pinjam = $this->m_laporanMutasiPinjam->downloadPdf($tanggal_pinjam)->result();
        $html='<h1 align="center">Laporan Mutasi Pinjam</h1>
                <h3 align="center">'.date('d/m/Y', strtotime($tanggal_pinjam[0])).'  -  '.date('d/m/Y', strtotime($tanggal_pinjam[1])).'</h3>
                <table cellspacing="1" bgcolor="#666666">
                    <tr bgcolor="#ffffff">
                        <th width="5%" align="center"><b>NO</b></th>
                        <th width="25%" align="center"><b>ANGGOTA</b></th>
                        <th width="45%" align="center"><b>JUDUL</b></th>
                        <th width="25%" align="center"><b>TANGGAL PINJAM & JATUH TEMPO</b></th>
                    </tr>';
        foreach ($data_pinjam as $index => $row) 
            {
                $i++;
                $html.='<tr bgcolor="#ffffff">
                            <td align="center">'.$i.'</td>
                            <td><b> '.$row->kode.'</b><br> '.
                                $row->nama_lengkap. 
                            '</td>
                            <td> '.$row->judul.'</td>
                            <td> '
                            .date('d-m-Y', strtotime($row->tanggal_pinjam)).'<br><b> - </b>'.
                            '<div style="color:red"> '.date('d-m-Y',strtotime($row->jatuh_tempo)).' <br><i> ( Perpanjang '.$row->jml_perpanjangan.' x )</i></div>                            
                            </td>
                        </tr>';            
            }
        $html.='</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('data_anggota.pdf', 'I');
    }


}