<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
Class LaporanDenda extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model(['m_auth','m_laporanDenda']);
        $this->load->library('pdf');
        if(!$this->m_auth->loggedIn()){
            redirect('auth');
        }else if($this->session->userdata('hak_akses') != 1){
            show_404();
        }
    }

    public function index(){
        $data['title']  = 'Laporan Denda';
        $data['icon']   = 'fa fa-money';
        $data['uri']    = $this->uri->segment(1);

        $this->load->view('layout/header', $data);
        $this->load->view('laporan-denda/index', $data);
        $this->load->view('layout/footer');
    }

    public function ajaxGetDenda(){
        $tanggal_kembali = $this->input->post('tanggal_kembali');
        if($tanggal_kembali != [] ){
            $tanggal_kembali;
        }else{
            $tanggal_kembali = [date('Y-m-d'),date('Y-m-d')];
        }

        $list = $this->m_laporanDenda->get_datatables($tanggal_kembali);
        $data = array();
        $no = $_POST['start'];
        $ket_status;
        foreach($list as $value){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date('d-M-Y', strtotime($value->tanggal_kembali));
            $row[] = number_format($value->denda);

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_laporanDenda->count_all($tanggal_kembali),
            "recordsFiltered" => $this->m_laporanDenda->count_filtered($tanggal_kembali),
            "data" => $data,
            "tanggal_kembali" => $tanggal_kembali,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    
    function downloadPdf(){
        $tanggal_kembali = array();
        $tanggal_kembali[0] = $this->uri->segment(3);
        $tanggal_kembali[1] = $this->uri->segment(4);
        $total_denda = 0;

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('laporan Denda');
        $pdf->SetSubject('Laporan Denda');
        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        $pdf->SetHeaderMargin(10);
        $pdf->SetTopMargin(10);
        $pdf->setFooterMargin(10);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('SimPerpus');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
        $i=0;
        $denda = $this->m_laporanDenda->downloadPdf($tanggal_kembali)->result();
        $html='<h1 align="center">Laporan Denda Perpustakaan</h1>
                <h4 align="center">'.date('d/m/Y', strtotime($tanggal_kembali[0])).' - '.date('d/m/Y', strtotime($tanggal_kembali[1])).'</h4>
                <table cellspacing="1" bgcolor="#666666">
                    <tr bgcolor="#ffffff">
                        <th width="20%" align="center"><b>NO</b></th>
                        <th width="40%" align="center"><b>Tanggal</b></th>
                        <th width="40%" align="center"><b>Denda</b></th>    
                    </tr>';
        foreach ($denda as $row) 
            {
                $i++;
                $html.='<tr bgcolor="#ffffff">
                            <td align="center">'.$i.'</td>
                            <td> '.date('d-M-Y', strtotime($row->tanggal_kembali)).'</td>
                            <td align="right"> '. number_format($row->denda).'</td>
                        </tr>';
                $total_denda += $row->denda;
            }

        $html.='
            <tr bgcolor="#ffffff">
                <th colspan="2" align="left" style="color:red;">TOTAL</th>
                <th width="40%" align="right" style="color:red;"><b>'.number_format($total_denda).'</b></th>    
            </tr>
        </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('data_anggota.pdf', 'I');
    }
}