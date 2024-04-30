<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Data_rw_cpns_pns_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->library('gapi');
    }
 
    // show data entitas
    function index_get() {
        $vreturn= [];
        $nip= $this->input->get("nip");
        $id= $this->input->get("id");
        $gp= new Gapi();

        if(!empty($id))
        {
            $arrparam= ["vjenis"=>"data-utama", "nip"=>$id, "lihatdata"=>""];
            $vreturn= $gp->getdata($arrparam);
        }
        else
        {
            $arrparam= ["vjenis"=>"data-utama", "nip"=>$nip, "lihatdata"=>""];
            $vreturn= $gp->getdata($arrparam);
        }
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
    
    // insert new data to entitas
    function index_post() {
        $id= $this->input->post('id');
        $pns_orang_id= $this->input->post('pns_orang_id');
        $nomor_sk_cpns= $this->input->post('nomor_sk_cpns');
        $tgl_sk_cpns= $this->input->post('tgl_sk_cpns');
        $kartu_pegawai= $this->input->post('kartu_pegawai');
        $nama_jabatan_angkat_cpns= $this->input->post('nama_jabatan_angkat_cpns');
        $nomor_sk_pns= $this->input->post('nomor_sk_pns');
        $nomor_spmt= $this->input->post('nomor_spmt');
        $nomor_sttpl= $this->input->post('nomor_sttpl');
        $tanggal_dokter_pns= $this->input->post('tanggal_dokter_pns');
        $tgl_sk_pns= $this->input->post('tgl_sk_pns');
        $tgl_sttpl= $this->input->post('tgl_sttpl');
        $tmt_pns= $this->input->post('tmt_pns');

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
            , "pns_orang_id" => $pns_orang_id
            , "nomor_sk_cpns" => $nomor_sk_cpns
            , "tgl_sk_cpns" => $tgl_sk_cpns
            , "kartu_pegawai" => $kartu_pegawai
            , "nama_jabatan_angkat_cpns" => $nama_jabatan_angkat_cpns
            , "nomor_sk_pns" => $nomor_sk_pns
            , "nomor_spmt" => $nomor_spmt
            , "nomor_sttpl" => $nomor_sttpl
            , "tanggal_dokter_pns" => $tanggal_dokter_pns
            , "tgl_sk_pns" => $tgl_sk_pns
            , "tgl_sttpl" => $tgl_sttpl
            , "tmt_pns" => $tmt_pns
            , "path" => $path
        );
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit;

        $arrparam= ["ctrl"=>"cpns/save"];
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