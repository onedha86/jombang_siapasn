<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class skp22_json extends CI_Controller {

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

        $this->load->model('PenilaianSkp');
        $this->load->model('CurlData');

        $reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        $set = new PenilaianSkp();
        $set->selectByParams(array("A.PENILAIAN_SKP_ID"=>$reqRiwayatId));
        $set->firstRow();
         
        $penilaianSkpId= $set->getField('PENILAIAN_SKP_ID');
        $pnsDinilaiOrang= $set->getField('PEGAWAI_ID_SAPK');
        $tahun= $set->getField('TAHUN');
        $penilaiNama= $set->getField('PEGAWAI_PEJABAT_PENILAI_NAMA');
        $penilaiNipNrp= $set->getField('PEGAWAI_PEJABAT_PENILAI_NIP');
        $kuadranKinerjaNilai= 1;
        $statusPenilai= $set->getField('PEGAWAI_PEJABAT_PENILAI_ID');
        $statusPenilai= $statusPenilai?'ASN':'NON ASN';
        $perilakuKerjaNilai= $set->getField('NILAI_HASIL_PERILAKU');
        $penilaiUnorNama= $set->getField('PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA');
        $penilaiJabatan= $set->getField('PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA');
        $penilaiGolongan= $set->getField('PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID');
        $hasilKinerjaNilai= $set->getField('NILAI_HASIL_KERJA');
        // $hasilKinerjaNilai=3;
        // $perilakuKerjaNilai=3;
        // $hasilKinerjaNilai=$hasilKinerjaNilai?$hasilKinerjaNilai:0;

        // update ke efile
        $idPegawai = $set->getField('PEGAWAI_ID');
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"4");
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
            , "hasilKinerjaNilai"=>$hasilKinerjaNilai
            , "kuadranKinerjaNilai"=>$kuadranKinerjaNilai
            , "path"=> json_encode($path)
            , "penilaiGolongan"=>$penilaiGolongan
            , "penilaiJabatan"=>$penilaiJabatan
            , "penilaiNama"=>$penilaiNama
            , "penilaiNipNrp"=>$penilaiNipNrp
            , "penilaiUnorNama"=>$penilaiUnorNama
            , "perilakuKerjaNilai"=>$perilakuKerjaNilai
            , "pnsDinilaiOrang"=>$pnsDinilaiOrang
            , "statusPenilai"=>$statusPenilai
            , "tahun"=>$tahun
        );
        
        $jsonData= json_encode($arrData);
        $arrData['param']=$jsonData;
        $vurl ='Data_rw_skp22_json';

        $set= new CurlData();
        $response= $set->curlpost($vurl,$arrData);
        // print_r($response);exit();
        $returnStatus= $response->result->success;
        $returnId= $response->result->mapData;
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

        // update sesuai table
        $set= new PenilaianSkp();
        $set->setField("SYNC_ID", $this->USER_LOGIN_ID);
        $set->setField("SYNC_NAMA", $this->LOGIN_USER);
        $set->setField("SYNC_STATUS", $statusKirim);
        $set->setField("PENILAIAN_SKP_ID", $reqRiwayatId);
        $set->updateStatusSync();

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn(){

        $this->load->model('Pegawai');
        $this->load->model('PenilaianSkp');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');

        $settingurlapi= $this->config->config["settingurlapi"];
        $url =  $settingurlapi.'Data_rw_skp22_json?id='.$reqBknId;
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
        $hasilKinerja= $arrResult['hasilKinerja'];
        $hasilKinerjaNilai= $arrResult['hasilKinerjaNilai'];
        $kuadranKinerja= $arrResult['kuadranKinerja'];
        $KuadranKinerjaNilai= $arrResult['KuadranKinerjaNilai'];
        $namaPenilai= $arrResult['namaPenilai'];
        $nipNrpPenilai= $arrResult['nipNrpPenilai'];
        $penilaiGolonganId= $arrResult['penilaiGolonganId'];
        $penilaiJabatanNm= $arrResult['penilaiJabatanNm'];
        $penilaiUnorNm= $arrResult['penilaiUnorNm'];
        $perilakuKerja= $arrResult['perilakuKerja'];
        $PerilakuKerjaNilai= $arrResult['PerilakuKerjaNilai'];
        $pnsDinilaiId= $arrResult['pnsDinilaiId'];
        $statusPenilai= $arrResult['statusPenilai'];
        $tahun= $arrResult['tahun'];
        $path= $arrResult['path'];

        $pegawai = new Pegawai();
        $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$pnsDinilaiId));
        $pegawai->firstRow();
        $idPegawai = $pegawai->getField('PEGAWAI_ID');

        $dataASN = array();
        $dataASN['ASN']=1;
        $statusPenilai =$dataASN[$statusPenilai];

        $set = new PenilaianSkp();
        $set->setField('PENILAIAN_SKP_ID',$reqRiwayatId);
        $set->setField('PEGAWAI_ID',ValToNullDB($idPegawai));
        $set->setField('TAHUN',$tahun);
        $set->setField('PEGAWAI_PEJABAT_PENILAI_NIP',ValToNullDB($nipNrpPenilai));
        $set->setField('PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID',ValToNullDB($penilaiGolonganId));
        $set->setField('PEGAWAI_PEJABAT_PENILAI_NAMA',ValToNullDB($namaPenilai));
        $set->setField('PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA',ValToNullDB($penilaiJabatanNm));
        $set->setField('PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA',ValToNullDB($penilaiUnorNm));
        $set->setField('PEGAWAI_PEJABAT_PENILAI_ID',ValToNullDB($statusPenilai));
        $set->setField('NILAI_HASIL_PERILAKU',ValToNullDB($PerilakuKerjaNilai));
        $set->setField('NILAI_HASIL_KERJA',ValToNullDB($hasilKinerjaNilai));
        
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
        $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"4");
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
        $this->load->model('PenilaianSkp');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new PenilaianSkp();
            $set->setField("PENILAIAN_SKP_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }

}
?>