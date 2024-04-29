<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class cpns_pns_json extends CI_Controller {

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
        $this->load->model('SkCpnsPnsBkn');
        $this->load->model('CurlData');

        $reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        // Data SIAPANS 
        $set= new SkCpnsPnsBkn();
        $set->selectByParams(array(), -1, -1," AND A.PEGAWAI_ID = ".$reqRiwayatId);
        // echo $set->query;exit;
        $set->firstRow();
        $pns_orang_id= $set->getField("PEGAWAI_ID_SAPK");
        $nomor_sk_cpns= $set->getField("NOMOR_SK_CPNS");
        $tgl_sk_cpns= dateToPageCheck($set->getField("TGL_SK_CPNS"));
        $kartu_pegawai= $set->getField("KARTU_PEGAWAI");
        $nama_jabatan_angkat_cpns= $set->getField("NAMA_JABATAN_ANGKAT_CPNS");
        $nomor_sk_pns= $set->getField("NOMOR_SK_PNS");
        $nomor_spmt= $set->getField("NOMOR_SPMT");
        $nomor_sttpl= $set->getField("NOMOR_STTPL");
        $tanggal_dokter_pns= dateToPageCheck($set->getField("TANGGAL_DOKTER_PNS"));
        $tgl_sk_pns= dateToPageCheck($set->getField("TGL_SK_PNS"));
        $tgl_sttpl= dateToPageCheck($set->getField("TGL_STTPL"));
        $tmt_pns= dateToPageCheck($set->getField("TMT_PNS"));

        // update ke efile
        // $idPegawai = $pns_orang_id;
        $ambilfiledata= [];
        /*$this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"3");
        $ambilfiledata= $vsycn->uptofile($arrparam);*/
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
            "id"=>""
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
            , "path"=> json_encode($path)
        );
        // print_r($arrData);exit;
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit();

        $arrData['param']= $jsonData;
        $vurl= 'Data_rw_cpns_pns_json';
        $set= new CurlData();
        $response= $set->curlpost($vurl,$arrData);
        // print_r($response);exit();
        $returnStatus= $response->result->code;
        $returnId= $response->result->data;

        $simpan="";
        $statusKirim="GAGAL";
        if($returnStatus == "1")
        {
            $reqId= $returnId;
            $simpan= 1;
            $statusKirim="SUKSES";
            $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$reqId];
            // print_r($arrparam);exit;
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
        $set= new SkCpnsPnsBkn();
        $set->setField("SYNC_ID", $this->USER_LOGIN_ID);
        $set->setField("SYNC_NAMA", $this->LOGIN_USER);
        $set->setField("SYNC_STATUS", $statusKirim);
        $set->setField("PEGAWAI_ID", $reqRiwayatId);
        $set->updateStatusSync();

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn()
    {
        $this->load->model('Pegawai');
        $this->load->model('SkCpnsPnsBkn');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');
        
        $settingurlapi= $this->config->config["settingurlapi"];
        $url= $settingurlapi.'Data_rw_cpns_pns_json?id='.$reqBknId;
        // echo $url;exit;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
      
        $arrData= json_decode($html,true);
        // print_r($arrData);exit;
        $arrResult= $arrData['result'];
        // print_r($arrResult);exit;

        $statementpegawai= " AND A.PEGAWAI_ID = ".$reqRiwayatId;
        $setdetil= new SkCpnsPnsBkn();
        $setdetil->selectcpns(array(), -1,-1, $statementpegawai);
        $setdetil->firstRow();
        $vcpnsid= $setdetil->getField("SK_CPNS_ID");

        $setdetil= new SkCpnsPnsBkn();
        $setdetil->selectpns(array(), -1,-1, $statementpegawai);
        $setdetil->firstRow();
        $vpnsid= $setdetil->getField("SK_PNS_ID");

        // echo $vcpnsid."-".$vpnsid;exit;

        $nomorskcpns= $arrResult["nomorSkCpns"];
        $tglskcpns= $arrResult["tglSkCpns"];
        $nospmt= $arrResult["noSpmt"];

        $set= new SkCpnsPnsBkn();
        $set->setField("PEGAWAI_ID", $reqRiwayatId);
        $set->setField("NO_SK", $nomorskcpns);
        $set->setField("TANGGAL_SK", dateToDBCheck($tglskcpns));
        $set->setField("SPMT_NOMOR", $nospmt);
        $set->setField("SK_CPNS_ID", $vcpnsid);

        if(empty($vcpnsid))
        {
            if($set->insertCpnsDataBkn())
            {
                $id= $reqBknId;
            }
        }
        else
        {
            if($set->updateCpnsDataBkn())
            {
                $id= $reqBknId;
            }
        }

        $nomorskpns= $arrResult["nomorSkPns"];
        $tglskpns= $arrResult["tglSkPns"];
        $tmtpns= $arrResult["tmtPns"];
        $nomorsttpl= $arrResult["nomorSttpl"];
        $tglsttpl= $arrResult["tglSttpl"];

        $set= new SkCpnsPnsBkn();
        $set->setField("PEGAWAI_ID", $reqRiwayatId);
        $set->setField("NO_SK", $nomorskpns);
        $set->setField("TANGGAL_SK", dateToDBCheck($tglskpns));
        $set->setField("TMT_PNS", dateToDBCheck($tmtpns));
        $set->setField("NO_PRAJAB", $nomorsttpl);
        $set->setField("TANGGAL_PRAJAB", dateToDBCheck($tglsttpl));
        $set->setField("SK_PNS_ID", $vpnsid);

        if(empty($vpnsid))
        {
            if($set->insertPnsDataBkn())
            {
                $id= $reqBknId;
            }

        }
        else
        {
            if($set->updatePnsDataBkn())
            {
                $id= $reqBknId;
            }
        }

        // update ke efile
        $this->load->library('globalfilesycnbkn');
        // $vsycn= new globalfilesycnbkn();
        // $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"3");
        // $vsycn->cptofile($arrparam);

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
        $this->load->model('SkCpnsPnsBkn');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new SkCpnsPnsBkn();
            $set->setField("PEGAWAI_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }
}
?>