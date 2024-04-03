<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Data_rw_kursus_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->library('gapi');
    }
 
    // show data entitas
    function index_get() {
        $nip= $this->input->get("nip");
        $id= $this->input->get("id");
        $gp= new Gapi();

        if(!empty($id))
        {
            $arrparam= ["ctrl"=>"kursus/id", "value"=>$id];
            $vreturn= $gp->getdataParam($arrparam);
        }
        else
        {
            $arrparam= ["vjenis"=>"rw-kursus", "nip"=>$nip, "lihatdata"=>""];
            $vreturn= $gp->getdata($arrparam);
        }
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
    
    // insert new data to entitas
    function index_post() {
        $id= $this->input->post('id');
        $instansiId= $this->input->post('instansiId');
        $institusiPenyelenggara= $this->input->post('institusiPenyelenggara');
        $jenisDiklatId= $this->input->post('jenisDiklatId');
        $jenisKursus= $this->input->post('jenisKursus');
        $jenisKursusSertipikat= $this->input->post('jenisKursusSertipikat');
        $jumlahJam= (int)$this->input->post('jumlahJam');
        $lokasiId= $this->input->post('lokasiId');
        $namaKursus= $this->input->post('namaKursus');
        $nomorSertipikat= $this->input->post('nomorSertipikat');
        $pnsOrangId= $this->input->post('pnsOrangId');
        $tahunKursus= (int)$this->input->post('tahunKursus');
        $tanggalKursus= $this->input->post('tanggalKursus');
        $tanggalSelesaiKursus= $this->input->post('tanggalSelesaiKursus');

        $dok_id=$this->input->post('dok_id');
        $dok_nama=$this->input->post('dok_nama');
        $dok_uri=$this->input->post('dok_uri');
        $object=$this->input->post('object');
        $slug=$this->input->post('slug');

        $vpath= json_decode($this->input->post('path'));
        $vd= $vpath[0];
        $vdocid= (string)$vd->dok_id;
        $vdocument= $vd->dok_nama;
        $vbknlink= $vd->dok_uri;

        $dok_id= $vdocid;
        $dok_nama= $vdocument;
        $dok_uri= $vbknlink;
        $object= $vbknlink;
        $slug= $vdocid;

        $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);
        // print_r($path);exit;
            
        $id=$id?$id:null;    

        $arrData = array(
            "id"=>$id
            , "instansiId"=>$instansiId
            , "institusiPenyelenggara"=>$institusiPenyelenggara
            , "jenisDiklatId"=>$jenisDiklatId
            , "jenisKursus"=>$jenisKursus
            , "jenisKursusSertipikat"=>$jenisKursusSertipikat
            , "path"=>$path
            , "jumlahJam"=>$jumlahJam
            , "lokasiId"=>$lokasiId
            , "namaKursus"=>$namaKursus
            , "nomorSertipikat"=>$nomorSertipikat
            , "pnsOrangId"=>$pnsOrangId
            , "tahunKursus"=>$tahunKursus
            , "tanggalKursus"=>$tanggalKursus
            , "tanggalSelesaiKursus"=>$tanggalSelesaiKursus
        );
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit;

        $arrparam= ["ctrl"=>"kursus/save"];
        $gp= new gapi();
        $vreturn= $gp->postdata($arrparam,$jsonData);
        
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}