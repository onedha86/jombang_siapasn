<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class diklat_json extends CI_Controller {

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
    }

    function siapasn_bkn(){

        $this->load->model('DiklatStruktural');
        $this->load->model('CurlData');

        $reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        $diklatstruktural = new DiklatStruktural();
        $diklatstruktural->selectByParams(array("A.DIKLAT_STRUKTURAL_ID"=>$reqRiwayatId));
        $diklatstruktural->firstRow();
   
        $pegawai_id_sapk =$diklatstruktural->getField('PEGAWAI_ID_SAPK');

        // update ke efile
        $idPegawai = $diklatstruktural->getField('PEGAWAI_ID');
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"2");
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
             
        $bobot= 0;
        $institusiPenyelenggara= $diklatstruktural->getField('PENYELENGGARA');
        $jenisKompetensi= null;
        $jumlahJam= $diklatstruktural->getField('JUMLAH_JAM');
        $latihanStrukturalId= $diklatstruktural->getField('DIKLAT_ID');
        $nomor= $diklatstruktural->getField('NO_STTPP');
        $pnsOrangId= $pegawai_id_sapk;
        $tahun= $diklatstruktural->getField('TAHUN');
        $tanggal= $diklatstruktural->getField('TANGGAL_MULAI');
        $tanggalSelesai= $diklatstruktural->getField('TANGGAL_SELESAI');

        $date= new DateTime($tanggal);
        $tanggal= $date->format('d-m-Y');

        $date= new DateTime($tanggalSelesai);
        $tanggalSelesai= $date->format('d-m-Y');
      
        $arrData = array(
            "bobot"=>$bobot
            ,"id"=>$reqBknId
            , "institusiPenyelenggara"=>$institusiPenyelenggara
            , "jenisKompetensi"=>$jenisKompetensi
            , "jumlahJam"=>$jumlahJam
            , "latihanStrukturalId"=>$latihanStrukturalId
            , "nomor"=>$nomor
            , "path"=> json_encode($path)
            , "pnsOrangId"=>$pnsOrangId
            , "tahun"=>$tahun
            , "tanggal"=>$tanggal
            , "tanggalSelesai"=>$tanggalSelesai
        );

        $jsonData= json_encode($arrData);
        $arrData['param']=$jsonData;
        $vurl ='Data_rw_diklat_json';
   
        $set= new CurlData();

        $response= $set->curlpost($vurl,$arrData);
           // print_r($response);exit();
        $returnStatus= $response->result->success;
        $returnId= $response->result->mapData->rwDiklatId;
        $pesan = $response->result->message;
        $simpan="";
        if($returnStatus == "1")
        {
            $reqId= $returnId;
            $simpan=1;

            $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$reqId];
            $this->setidsapk($arrparam);
        }

        if($simpan == "1")
        {
            $arrDataStatus =array("PESAN"=>'Data berhasil disimpan',"code"=>200);
        }
        else
        {
            $arrDataStatus =array("PESAN"=>$pesan,"code"=>400);
        }

        $set = new DiklatStruktural();
        $set->setField("SYNC_ID",$this->LOGIN_PEGAWAI_ID);
        $set->setField("SYNC_NAMA", $this->LOGIN_USER);
        $set->setField("SYNC_STATUS",$statusKirim);
        $set->setField("DIKLAT_STRUKTURAL_ID",$reqRiwayatId);
        $set->updateStatusSync();

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn(){

        $this->load->model('Pegawai');
        $this->load->model('DiklatStruktural');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');

        $settingurlapi= $this->config->config["settingurlapi"];
        $url =  $settingurlapi.'Data_rw_diklat_json?id='.$reqBknId;
        // echo $url;exit;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        // print_r($html);exit;
      
        $arrData = json_decode($html,true);
        // print_r( $arrData);exit;
      
        $arrResult = $arrData['result'];
      
        $id= $arrResult['id'];
        $idPns= $arrResult['idPns'];
        $nipBaru= $arrResult['nipBaru'];
        $nipLama= $arrResult['nipLama'];
        $latihanStrukturalId= $arrResult['latihanStrukturalId'];
        $latihanStrukturalNama= $arrResult['latihanStrukturalNama'];
        $nomor= $arrResult['nomor'];
        $tanggal= $arrResult['tanggal'];
        $tahun= $arrResult['tahun'];

        $tanggalSelesai= $arrResult['tanggalSelesai'];
        $institusiPenyelenggara= $arrResult['institusiPenyelenggara'];
        $path= $arrResult['path'];

        $pegawai = new Pegawai();
        $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$idPns));
        $pegawai->firstRow();
        $idPegawai = $pegawai->getField('PEGAWAI_ID');

        $set = new DiklatStruktural();
        $set->setField('DIKLAT_STRUKTURAL_ID',$reqRiwayatId);
        $set->setField('DIKLAT_ID',ValToNullDB($latihanStrukturalId));
        $set->setField('PEGAWAI_ID',ValToNullDB($idPegawai));
        $set->setField('TAHUN',$tahun);
        $set->setField('JUMLAH_JAM',ValToNullDB($jumlahJam));
        $set->setField('PENYELENGGARA',$institusiPenyelenggara);
        $set->setField('NO_STTPP',$nomor);
        $set->setField('TANGGAL_MULAI',dateToDBCheck($tanggal));
        $set->setField('TANGGAL_SELESAI',dateToDBCheck($tanggalSelesai));
        
        if(empty($reqRiwayatId))
        {
            $set->insertDataBkn();
            $reqRiwayatId= $set->id;
        }
        else
        {
           $set->updateBknData();
        }
        // echo $set->query;exit;

        // update ke efile
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"2");
        $vsycn->cptofile($arrparam);

        $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$id];
        $this->setidsapk($arrparam);

        $arrDataStatus =array("PESAN"=>'Data berhasil disimpan',"code"=>200);
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
        $this->load->model('DiklatStruktural');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new DiklatStruktural();
            $set->setField("DIKLAT_STRUKTURAL_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }

}
?>