<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");


 
class Data_rw_angkakredit_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->library('gapi');
    }
 
    // show data entitas
	function index_get() {
        $nip= $this->input->get("nip");
        $reqId = $this->input->get("id");
        $gp= new gapi();       
        if(!empty($nip)){
            $arrparam= ["vjenis"=>"rw-angkakredit", "nip"=>$nip];
            $vreturn= $gp->getdata($arrparam);
        }else if (!empty( $reqId)) {
            $arrparam= ["ctrl"=>"angkakredit/id", "value"=>$reqId];
            $vreturn= $gp->getdataParam($arrparam);
        }
      
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
	
    // insert new data to entitas
     function index_post() {
     
        $bulanMulaiPenailan = $this->input->post('bulanMulaiPenailan');
        $bulanSelesaiPenailan = $this->input->post('bulanSelesaiPenailan');
        $id = $this->input->post('id');
        $isAngkaKreditPertama = $this->input->post('isAngkaKreditPertama');
        $isIntegrasi = $this->input->post('isIntegrasi');
        $isKonversi = $this->input->post('isKonversi');
        $kreditBaruTotal = $this->input->post('kreditBaruTotal');
        $kreditPenunjangBaru = $this->input->post('kreditPenunjangBaru');
        $kreditUtamaBaru = $this->input->post('kreditUtamaBaru');  
        $nomorSk = $this->input->post('nomorSk');
        $pnsId = $this->input->post('pnsId');
        $rwJabatanId = $this->input->post('rwJabatanId');
        $tahunMulaiPenailan = $this->input->post('tahunMulaiPenailan');
        $tahunSelesaiPenailan = $this->input->post('tahunSelesaiPenailan');
        $tanggalSk = $this->input->post('tanggalSk');

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
        
        $id= $id?$id:null;
        $isAngkaKreditPertama=$isAngkaKreditPertama?$isAngkaKreditPertama:null;
        $isIntegrasi=$isIntegrasi?$isIntegrasi:null;
        $isKonversi=$isKonversi?$isKonversi:null;
         
         $arrData = array(
            "bulanMulaiPenailan"=>$bulanMulaiPenailan
            , "bulanSelesaiPenailan"=>$bulanSelesaiPenailan
            , "id"=>$reqBknId
            , "isAngkaKreditPertama"=>$isAngkaKreditPertama
            , "isIntegrasi"=>$isIntegrasi
            , "isKonversi"=>$isKonversi
            , "kreditBaruTotal"=>$kreditBaruTotal
            , "kreditPenunjangBaru"=>$kreditPenunjangBaru
            , "kreditUtamaBaru"=>$kreditUtamaBaru
            , "nomorSk"=>$nomorSk
            , "path"=>$path
            , "pnsId"=>$pnsId
            , "rwJabatanId"=>$rwJabatanId
            , "tahunMulaiPenailan"=>$tahunMulaiPenailan
            , "tahunSelesaiPenailan"=>$tahunSelesaiPenailan
            , "tanggalSk"=>$tanggalSk
          );

        $jsonData  = json_encode($arrData);
        // print_r($jsonData);

        $arrparam= ["ctrl"=>"angkakredit/save"];
        $gp= new gapi();
        $vreturn= $gp->postdata($arrparam,$jsonData);
        
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {    
   
      $id = $this->uri->segment('3','');
      
      $arrparam= ["ctrl"=>"angkakredit/delete/".$id];
      $gp= new gapi();
      $vreturn= $gp->getDataDelete($arrparam);
      $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' =>$vreturn ));

    }
 
}