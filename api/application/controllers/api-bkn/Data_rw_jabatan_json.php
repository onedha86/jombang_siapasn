<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Data_rw_jabatan_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->library('gapi');
    }
 
    // show data entitas
    function index_get() {
        $nip= $this->input->get("nip");
        $id= $this->input->get("id");
        $reqId= $this->input->get("reqId");
        $m= $this->input->get("m");
        $gp= new Gapi();

        if($m == "hapus" && !empty($reqId))
        {
            $arrparam= ["ctrl"=>"jabatan/delete/".$reqId];
            $vreturn= $gp->getDataDelete($arrparam);
        }
        else
        {
            if(!empty($id))
            {
                $arrparam= ["ctrl"=>"jabatan/id", "value"=>$id];
                $vreturn= $gp->getdataParam($arrparam);
            }
            else
            {
                $arrparam= ["vjenis"=>"rw-jabatan", "nip"=>$nip, "lihatdata"=>""];
                $vreturn= $gp->getdata($arrparam);
            }
        }
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
    }
    
    // insert new data to entitas
    function index_post() {
        $id= $this->input->post("id");  
        $eselonId= $this->input->post("eselonId");
        $instansiId= $this->input->post("instansiId");
        $jabatanFungsionalId= $this->input->post("jabatanFungsionalId");
        $jabatanFungsionalUmumId= $this->input->post("jabatanFungsionalUmumId");
        $jenisJabatan= $this->input->post("jenisJabatan");
        $nomorSk= $this->input->post("nomorSk");
        $pnsId= $this->input->post("pnsId");
        $satuanKerjaId= $this->input->post("satuanKerjaId");
        $tanggalSk= $this->input->post("tanggalSk");
        $tmtJabatan= $this->input->post("tmtJabatan");
        $tmtPelantikan= $this->input->post("tmtPelantikan");
        $unorId= $this->input->post("unorId");
        $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);

        if(empty($eselonId))
            $eselonId= null;
        
        $id= $id?$id:null;

        $arrData = array(
            "id"=>$id
            , "eselonId"=>$eselonId
            , "instansiId"=>$instansiId
            , "jabatanFungsionalId"=>$jabatanFungsionalId?$jabatanFungsionalId:null
            , "jabatanFungsionalUmumId"=>$jabatanFungsionalUmumId?$jabatanFungsionalUmumId:null
            , "jenisJabatan"=>$jenisJabatan
            , "nomorSk"=>$nomorSk
            , "path"=>$path
            , "pnsId"=>$pnsId
            , "satuanKerjaId"=>$satuanKerjaId
            , "tanggalSk"=>$tanggalSk
            , "tmtJabatan"=>$tmtJabatan
            , "tmtPelantikan"=>$tmtPelantikan
            , "unorId"=>$unorId
        );

        $jsonData  = json_encode($arrData);
        // print_r($jsonData);exit;

        $arrparam= ["ctrl"=>"jabatan/save"];
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