<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class penghargaan_json extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        //kauth
        if (!$this->kauth->getInstance()->hasIdentity())
        {
            // trow to unauthenticated page!
            //redirect('Login');
        }       
        
        /* GLOBAL VARIABLE */
        $this->LOGIN_USER= $this->kauth->getInstance()->getIdentity()->LOGIN_USER;
        $this->LOGIN_LEVEL= $this->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
        $this->LOGIN_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_ID;
        $this->LOGIN_PEGAWAI_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;
        $this->USER_LOGIN_ID= $this->kauth->getInstance()->getIdentity()->USER_LOGIN_ID;
    }

    function kirim_data_all_siapan_bkn(){
    }

    function siapasn_bkn()
    {
        $this->load->model('Penghargaan');
        $this->load->model('CurlData');

        $reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        // Data SIAPANS 
        $set= new Penghargaan();
        $set->selectByParams(array(), -1, -1," AND A.PENGHARGAAN_ID = ".$reqRiwayatId);
        // echo $set->query;exit;
        $set->firstRow();
        $skNomor= $set->getField("NO_SK");
        $skDate= dateToPageCheck($set->getField("TANGGAL_SK"));
        $tahun= $set->getField("TAHUN");
        $hargaId= $set->getField("REF_PENGHARGAAN_ID_SAPK");
        $pegawai_id_sapk= $set->getField("PEGAWAI_ID_SAPK");

        // update ke efile
        $idPegawai = $set->getField('PEGAWAI_ID');
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"3");
        $ambilfiledata= $vsycn->uptofile($arrparam);
        // print_r($ambilfiledata);exit;

        // $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);
        $path= [];
        foreach ($ambilfiledata as $kd => $vd) 
        {
            $vdocid= $vd->dok_id;
            $vdocument= $vd->dok_nama;
            $vbknlink= $vd->dok_uri;

            $arrdata= [];
            $arrdata["dok_id"]= $vdocid;
            $arrdata["dok_nama"]= $vdocument;
            $arrdata["dok_uri"]= $vbknlink;
            $arrdata["object"]= $vbknlink;
            $arrdata["slug"]= $vdocid;
            array_push($path, $arrdata);
        }
        // print_r($path);exit;

        $arrData = array(
            "id"=>$reqBknId
            , "hargaId"=>$hargaId
            , "skDate"=>$skDate
            , "skNomor"=>$skNomor
            , "tahun"=>$tahun
            , "path"=> json_encode($path)
            , "pnsOrangId"=>$pegawai_id_sapk
        );
        // print_r($arrData);exit;
        
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit();

        $arrData['param']= $jsonData;
        $vurl= 'Data_rw_penghargaan_json';
        $set= new CurlData();
        $response= $set->curlpost($vurl,$arrData);
        // print_r($response);exit();
        $returnStatus= $response->status;
        $returnId= $response->result->mapData->rwKursusId;

        $simpan="";
        $statusKirim="GAGAL";
        if($returnStatus == "success")
        {
            $reqId= $returnId;
            $simpan=1;
            $statusKirim="SUKSES";
            $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$reqId];
            $this->setidsapk($arrparam);
        }

        if($simpan == "1")
        {
            $arrDataStatus =array("PESAN"=>'Data berhasil disimpan',"code"=>200);
        }
        else
        {
            $arrDataStatus =array("PESAN"=>'Data gagal disimpan',"code"=>400);
        }

        // update sesuai table
        $set= new Penghargaan();
        $set->setField("SYNC_ID", $this->USER_LOGIN_ID);
        $set->setField("SYNC_NAMA", $this->LOGIN_USER);
        $set->setField("SYNC_STATUS", $statusKirim);
        $set->setField("PENGHARGAAN_ID", $reqRiwayatId);
        $set->updateStatusSync();

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn()
    {
        $this->load->model('Pegawai');
        $this->load->model('Penghargaan');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');
        
        $settingurlapi= $this->config->config["settingurlapi"];
        $url= $settingurlapi.'Data_rw_penghargaan_json?id='.$reqBknId;
        // echo $url;exit;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
      
        $arrData= json_decode($html,true);
      
        $arrResult= $arrData['result'];
        $id= $arrResult['ID'];
        $idPns= $arrResult['pnsOrangId'];
        $hargaId= $arrResult['hargaId'];
        $skDate= $arrResult['skDate'];
        $skNomor= $arrResult['skNomor'];
        $tahun= $arrResult['tahun'];
        $path= $arrResult['path'];

        $pegawai = new Pegawai();
        $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$idPns));
        $pegawai->firstRow();
        $idPegawai= $pegawai->getField('PEGAWAI_ID');

        $refpenghargaanid= "";
        if(!empty($hargaId))
        {
            $sql= " select ref_penghargaan_id vgetid from sapk.ref_penghargaan where ref_penghargaan_id_sapk = '".$hargaId."' ";
            $refpenghargaanid= $this->db->query($sql)->row()->vgetid;
        }

        $set= new Penghargaan();
        $set->setField("PENGHARGAAN_ID", $reqRiwayatId);    
        $set->setField("PEGAWAI_ID", $idPegawai);

        $set->setField("NO_SK", $skNomor);  
        $set->setField("TANGGAL_SK", dateToDBCheck($skDate)); 
        $set->setField("TAHUN", ValToNullDB($tahun));
        $set->setField("REF_PENGHARGAAN_ID", ValToNullDB($refpenghargaanid));

        if(empty($reqRiwayatId))
        {
            $set->insertDataBkn();
            $reqRiwayatId= $set->id;
        }
        else
        {
            $set->updateDataBkn();
        }

        // update ke efile
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"3");
        $vsycn->cptofile($arrparam);

        $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$id];
        $this->setidsapk($arrparam);

        $arrDataStatus= array("PESAN"=>'Data berhasil disimpan',"code"=>200);
        echo json_encode( $arrDataStatus,true);
    }

    function reset_siapasn()
    {
        $reqRiwayatId= $this->input->get('reqRiwayatId');

        $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>""];
        $this->setidsapk($arrparam);

        $arrDataStatus= array("PESAN"=>'Data berhasil reset',"code"=>200);
        echo json_encode( $arrDataStatus,true);
    }

    function setidsapk($arrparam)
    {
        $this->load->model('Penghargaan');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new Penghargaan();
            $set->setField("PENGHARGAAN_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }
}
?>