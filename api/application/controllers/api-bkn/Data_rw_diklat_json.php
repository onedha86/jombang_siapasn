<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Data_rw_diklat_json extends REST_Controller {
 
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
            $arrparam= ["ctrl"=>"diklat/id", "value"=>$id];
            $vreturn= $gp->getdataParam($arrparam);
        }
        else
        {
            $arrparam= ["vjenis"=>"rw-diklat", "nip"=>$nip, "lihatdata"=>""];
            $vreturn= $gp->getdata($arrparam);
        }
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
    
    // insert new data to entitas
    function index_post() {
        $bobot=(int) $this->input->post("bobot");  
        $id= $this->input->post("id");  
        $institusiPenyelenggara= $this->input->post("institusiPenyelenggara");
        $jenisKompetensi= $this->input->post("jenisKompetensi");
        $jumlahJam= (int) $this->input->post("jumlahJam");
        $latihanStrukturalId= $this->input->post("latihanStrukturalId");
        $nomor= $this->input->post("nomor");
        $pnsOrangId= $this->input->post("pnsOrangId");
        $tahun= (int)$this->input->post("tahun");
        $tanggal= $this->input->post("tanggal");
        $tanggalSelesai= $this->input->post("tanggalSelesai");
        
        // $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);
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

        $id= $id?$id:null;
      
        $arrData = array(
            "id"=>$id
            , "bobot"=>$bobot
            , "institusiPenyelenggara"=>$institusiPenyelenggara
            , "jenisKompetensi"=>$jenisKompetensi
            , "jumlahJam"=>$jumlahJam
            , "latihanStrukturalId"=>$latihanStrukturalId
            , "nomor"=>$nomor
            , "path"=>$path
            , "pnsOrangId"=>$pnsOrangId
            , "tahun"=>$tahun
            , "tanggal"=>$tanggal
            , "tanggalSelesai"=>$tanggalSelesai
        );

        $jsonData  = json_encode($arrData);
        // print_r($jsonData);exit;

        $arrparam= ["ctrl"=>"diklat/save"];
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