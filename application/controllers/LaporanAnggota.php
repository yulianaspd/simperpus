<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
Class LaporanAnggota extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->library('pdf');
    }
    
    function index(){
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Daftar Produk');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
        $i=0;
        $anggota = $this->db->get('anggota')->result();
        $html='<h1><u>Sistem Informasi Perpustakaan</u></h1>
                <h3>Data Anggota</h3>
                <table cellspacing="1" bgcolor="#666666">
                    <tr bgcolor="#ffffff">
                        <th width="5%" align="center">No</th>
                        <th width="35%" align="center">Nama Lengkap</th>
                        <th width="25%" align="center">Telepon</th>
                        <th width="35%" align="center">Alamat</th>
                    </tr>';
        foreach ($anggota as $row) 
            {
                $i++;
                $html.='<tr bgcolor="#ffffff">
                            <td align="center">'.$i.'</td>
                            <td>'.$row->nama_lengkap. '</td>
                            <td>'.$row->telepon.'</td>
                            <td align="right">'.$row->alamat.'</td>
                        </tr>';
            }
        $html.='</table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('data_anggota.pdf', 'I');
    }
}