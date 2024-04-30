<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class angkakredit_json extends CI_Controller {

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
    $this->load->model('Pak');  
    $this->load->model('JabatanRiwayat');  

    $this->load->model('CurlData');
    $reqRiwayatId= $this->input->get('reqRiwayatId');
    $reqBknId= $this->input->get('reqBknId');

    $set= new Pak();
    $set->selectByParams(array("A.PAK_ID"=>$reqRiwayatId));
    $set->firstRow();
    // echo $this->db->last_query();
    $tanggalSk= $set->getField('TANGGAL_SK');
    $nomorSk= $set->getField('NO_SK');
    $pnsId= $set->getField('PEGAWAI_ID_SAPK');
    $rwJabatanId= $set->getField('ID_DATA_FT');
    $tahunMulaiPenailan= $set->getField('TAHUN_MULAI');
    $tahunSelesaiPenailan= $set->getField('TAHUN_SELESAI');
    $kreditUtamaBaru= $set->getField('KREDIT_UTAMA');   
    $kreditPenunjangBaru= $set->getField('KREDIT_PENUNJANG');   
    $kreditBaruTotal= $set->getField('TOTAL_KREDIT');   
    $isAngkaKreditPertama= $set->getField('PAK_AWAL');   
    $isIntegrasi= $set->getField('PAK_INTERGRASI');  
    $isKonversi= $set->getField('PAK_KONVERSI');   
    $bulanMulaiPenailan= $set->getField('BULAN_MULAI');   
    $bulanSelesaiPenailan= $set->getField('BULAN_SELESAI'); 

    $reqJabatanFt = $set->getField('JABATAN_FT_ID'); 
    $reqJabatanFt =  $reqJabatanFt? $reqJabatanFt:'-9';
    $sql= " SELECT id_sapk FROM jabatan_riwayat WHERE jabatan_ft_id = '".$reqJabatanFt."' ";         
    $row= $this->db->query($sql)->row(); 
    $rwJabatanId =$row->id_sapk;

    $tanggalSks = explode('-', $tanggalSk);
    $tanggalSk = $tanggalSks[2].'-'.$tanggalSks[1].'-'.$tanggalSks[0];

    $arrparam= ["isAngkaKreditPertama"=>$isAngkaKreditPertama, "isIntegrasi"=>$isIntegrasi, "isKonversi"=>$isKonversi];
    $refid= $this->setkodekhusus($arrparam);

    // update ke efile
    $idPegawai = $set->getField('PEGAWAI_ID');
    $this->load->library('globalfilesycnbkn');
    $vsycn= new globalfilesycnbkn();
    $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>$refid);
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
      , "path"=> json_encode($path)
      , "pnsId"=>$pnsId
      , "rwJabatanId"=>$rwJabatanId
      , "tahunMulaiPenailan"=>$tahunMulaiPenailan
      , "tahunSelesaiPenailan"=>$tahunSelesaiPenailan
      , "tanggalSk"=>$tanggalSk
    );
    $jsonData= json_encode($arrData);

    $arrData['param']=$jsonData;
    $vurl ='Data_rw_angkakredit_json';
    // print_r($arrData);exit;
    $set= new CurlData();
    $response= $set->curlpost($vurl,$arrData);

    $returnStatus= $response->result->success;
    $returnId= $response->result->mapData->rwAngkaKreditId;
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
    $set= new Pak();
    $set->setField("SYNC_ID", $this->USER_LOGIN_ID);
    $set->setField("SYNC_NAMA", $this->LOGIN_USER);
    $set->setField("SYNC_STATUS", $statusKirim);
    $set->setField("PAK_ID", $reqRiwayatId);
    $set->updateStatusSync();

    echo json_encode( $arrDataStatus,true);
  }

  function delete_bkn(){
    $this->load->model('base-api/DataCombo');
    $reqBknId= $this->input->get('reqBknId');      

    $set= new DataCombo();
    $vurl ='Data_rw_angkakredit_json/'.$reqBknId;            
    $set= new CurlData();
    $response= $set->curlDelete($vurl,$arrData);   

    $returnStatus= $response->result->success;      
    $pesan = $response->result->message;
    if($returnStatus == "1")
    {
      $arrDataStatus =array("PESAN"=>'Data berhasil di hapus',"code"=>200);
      $this->reset_siapasn();
    }
    else
    {
      $arrDataStatus =array("PESAN"=>$pesan,"code"=>400);
    }

    echo json_encode( $arrDataStatus,true);
  }

  function bkn_siapasn(){

    $this->load->model('Pegawai');
    $this->load->model('Pak');

    $this->load->model('base-api/InfoData');
    $this->load->model('base-api/DataCombo');

    $reqBknId= $this->input->get('reqBknId');
    $reqRiwayatId= $this->input->get('reqRiwayatId');
    $infonipbaru=$this->input->get('reqNip');

    $settingurlapi= $this->config->config["settingurlapi"];
    $url =  $settingurlapi.'Data_rw_angkakredit_json?id='.$reqBknId;
    $arrContextOptions=array(
      "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
      ),
    );

    $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
    $arrData = json_decode($html,true);
    $arrResult= $arrData['result'];
    // print_r($arrResult);exit;

    $id= $arrResult['id'];
    $pns= $arrResult["pns"];
    $nomorSk= $arrResult["nomorSk"];
    $tanggalSk= $arrResult["tanggalSk"];
    $bulanMulaiPenailan= $arrResult["bulanMulaiPenailan"];
    $tahunMulaiPenailan= $arrResult["tahunMulaiPenailan"];
    $bulanSelesaiPenailan= $arrResult["bulanSelesaiPenailan"];
    $tahunSelesaiPenailan= $arrResult["tahunSelesaiPenailan"];
    $kreditUtamaBaru= $arrResult["kreditUtamaBaru"];
    $kreditPenunjangBaru= $arrResult["kreditPenunjangBaru"];
    $kreditBaruTotal= $arrResult["kreditBaruTotal"];
    $rwJabatan= $arrResult["rwJabatan"];
    $namaJabatan= $arrResult["namaJabatan"];
    $isAngkaKreditPertama= $arrResult["isAngkaKreditPertama"];
    $isIntegrasi= $arrResult["isIntegrasi"];
    $isKonversi= $arrResult["isKonversi"];
    $path= $arrResult["path"];

    /*$reqFormatMulai= $tahunMulaiPenailan.'-'.$bulanMulaiPenailan.'-'."01";
    $dateAwal= date_create( $reqFormatMulai);
    $reqTanggalMulai= date_format($dateAwal,"d-m-Y");       

    $reqFormatSelesai= $bulanSelesaiPenailan.'-'.$tahunSelesaiPenailan.'-'."01";
    $dateSelesai= date_create( $reqFormatSelesai);      
    $reqTanggalSelesai= date_format($dateSelesai,"t-m-Y");*/

    $reqTanggalMulai= "01-".generateZeroDate($bulanMulaiPenailan,2)."-".$tahunMulaiPenailan;
    $infoperiode= $tahunSelesaiPenailan."-".generateZeroDate($bulanSelesaiPenailan,2);
    $reqTanggalSelesai= getDay(date("Y-m-t",strtotime($infoperiode)))."-".generateZeroDate($bulanSelesaiPenailan,2)."-".$tahunSelesaiPenailan;

    $pegawai = new Pegawai();
    $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$pns));
    $pegawai->firstRow();
    $idPegawai = $pegawai->getField('PEGAWAI_ID');

    if(!empty($rwJabatan))
    {
      $sql = " SELECT * from jabatan_ft where id_data='".$rwJabatan."' ";
      $jabatanftid = $this->db->query($sql)->row()->jabatan_ft_id;
    }

    $set = new Pak();
    $set->setField('PAK_ID',$reqRiwayatId);
    $set->setField('PEGAWAI_ID',ValToNullDB($idPegawai));
    $set->setField('NO_SK',setQuote($nomorSk));
    $set->setField('JABATAN_FT_ID',ValToNullDB($jabatanftid));
    $set->setField('TANGGAL_SK',dateToDBCheck($tanggalSk));
    $set->setField('KREDIT_UTAMA',ValToNullDB($kreditUtamaBaru));
    $set->setField('KREDIT_PENUNJANG',ValToNullDB($kreditPenunjangBaru));
    $set->setField('TOTAL_KREDIT',ValToNullDB($kreditBaruTotal));
    $set->setField('PAK_AWAL',ValToNullDB($isAngkaKreditPertama));
    $set->setField('TANGGAL_MULAI',dateToDBCheck($reqTanggalMulai));
    $set->setField('TANGGAL_SELESAI',dateToDBCheck($reqTanggalSelesai));
    $set->setField('PAK_INTERGRASI',ValToNullDB($isIntegrasi));
    $set->setField('PAK_KONVERSI',ValToNullDB($isKonversi));
    $set->setField('BULAN_MULAI',ValToNullDB($bulanMulaiPenailan));
    $set->setField('TAHUN_MULAI',ValToNullDB($tahunMulaiPenailan));
    $set->setField('BULAN_SELESAI',ValToNullDB($bulanSelesaiPenailan));
    $set->setField('TAHUN_SELESAI',ValToNullDB($tahunSelesaiPenailan));
    
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

    $arrparam= ["isAngkaKreditPertama"=>$isAngkaKreditPertama, "isIntegrasi"=>$isIntegrasi, "isKonversi"=>$isKonversi];
    $refid= $this->setkodekhusus($arrparam);

    // update ke efile
    $this->load->library('globalfilesycnbkn');
    $vsycn= new globalfilesycnbkn();
    $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>$refid);
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
    $this->load->model('Pak');

    $reqRiwayatId= $arrparam["reqRiwayatId"];
    $id= $arrparam["id"];

    if(!empty($reqRiwayatId))
    {
      $set= new Pak();
      $set->setField("PAK_ID", $reqRiwayatId);
      $set->setField("ID_SAPK", $id);
      $set->updateIdSapk();
    }

    return "1";
  }

  function setkodekhusus($arrparam)
  {
    $isAngkaKreditPertama= $arrparam["isAngkaKreditPertama"];
    $isIntegrasi= $arrparam["isIntegrasi"];
    $isKonversi= $arrparam["isKonversi"];

    if($isKonversi == 1)
      return "5";
    else if($isIntegrasi == 1)
      return "6";
    else if($isAngkaKreditPertama == 1)
      return "7";
    else
      return "-1";
  }

}
?>