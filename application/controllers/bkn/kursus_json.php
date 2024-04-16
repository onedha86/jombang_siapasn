<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class kursus_json extends CI_Controller {

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
         $this->load->model('DiklatKursus');
         $this->load->model('CurlData');
         $reqTanggalMulai = $this->input->get('reqTanggalMulai');   
         $reqTanggalSelesai = $this->input->get('reqTanggalSelesai');   
         $diklat_kursus = new DiklatKursus();
          
         // $diklat_kursus->selectByParams(array(),-1,-1," AND TO_CHAR(A.TANGGAL_MULAI,'YYYY')::INT >= ". $reqTahunMulai." AND TO_CHAR(A.TANGGAL_MULAI,'YYYY')::INT <= ".$reqTahunSelesai);
        $diklat_kursus->selectByParams(array(),-1,-1," AND  ( A.TANGGAL_MULAI BETWEEN '".$reqTanggalMulai."' AND '".$reqTanggalSelesai."' ) AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') ");
        $arrDataValue =  $diklat_kursus->rowResult;
        // print_r($arrDataValue);exit;
        $arrDataIdRiwayat = array();
         foreach ($arrDataValue as $value) {
            $reqRiwayatId = $value['diklat_kursus_id'];
           
            $reqBknId = $value['id_sapk'];

            $diklatkursusid= $value["diklat_kursus_id"];
            $tipekursusid= $value["tipe_kursus_id"];
            $nama= $value["nama"];
            $jeniskursusnama= $value["jenis_kursus_nama"];
            $penyelenggara= $value["ref_instansi_nama"];
            $tahun= $value["tahun"];
            $nosertifikat=$value["no_sertifikat"];
            $tempat= $value["tempat"];
            $tanggalmulai= dateToPageCheck($value["tanggal_mulai"]);
            $tanggalselesai= dateToPageCheck($value["tanggal_selesai"]);
            $TANGGAL_SERTIFIKAT= dateToPageCheck($value["tanggal_sertifikat"]);
            $jumlahjam= $value["jumlah_jam"];
            $pegawai_id_sapk= $value["pegawai_id_sapk"];

            $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);

            $sql = " SELECT * FROM INSTANSI WHERE instansi_id = '1' ";
            $row = $this->db->query($sql)->row();
            $instansiId = $row->instansiid_bkn;

            $arrData = array(
                "id"=>$reqBknId
                , "instansiId"=>$instansiId
                , "institusiPenyelenggara"=>$penyelenggara
                , "jenisDiklatId"=>$tipekursusid
                , "jenisKursus"=>$jenisKursus
                , "jenisKursusSertipikat"=>$jeniskursusnama
                , "jumlahJam"=>$jumlahjam
                , "lokasiId"=>null
                , "namaKursus"=>$nama
                , "nomorSertipikat"=>$nosertifikat
                , "path"=>$path
                , "pnsOrangId"=>$pegawai_id_sapk
                , "tahunKursus"=>$tahun
                , "tanggalKursus"=>$tanggalmulai
                , "tanggalSelesaiKursus"=>$tanggalselesai
            );
        
            $jsonData= json_encode($arrData);

            $arrData['param']= $jsonData;
            $vurl= 'Data_rw_kursus_json';
            $set= new CurlData();
            $response= $set->curlpost($vurl,$arrData);
            $returnStatus= $response->status;
            $returnId= $response->result->mapData->rwKursusId;

            if($returnStatus == "success")
            {
                $reqId= $returnId;
                $simpan=1;
                array_push($arrDataIdRiwayat, $reqRiwayatId);
                $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>$reqId];
                $this->setidsapk($arrparam);
            }
        
        }

        $arrDataStatus =array("PESAN"=>'Data berhasil di proses ',"code"=>200,"diklat_kursus_id"=>$arrDataIdRiwayat);
        echo json_encode( $arrDataStatus,true);
    }

    function siapasn_bkn()
    {
        $this->load->model('DiklatKursus');
        $this->load->model('CurlData');

        $reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        // Data SIAPANS 
        $set= new DiklatKursus();
        $set->selectByParams(array(), -1, -1," AND A.DIKLAT_KURSUS_ID = ".$reqRiwayatId);
        // echo  $set->query;exit;
        $set->firstRow();
        $diklatkursusid= $set->getField("DIKLAT_KURSUS_ID");
        $tipekursusid= $set->getField("TIPE_KURSUS_ID");
        $nama= $set->getField("NAMA");
        $jeniskursusnama= $set->getField("JENIS_KURSUS_NAMA");
        $penyelenggara= $set->getField("REF_INSTANSI_NAMA");
        $tahun= $set->getField("TAHUN");
        $nosertifikat= $set->getField("NO_SERTIFIKAT");
        $tempat= $set->getField("TEMPAT");
        $tanggalmulai= dateToPageCheck($set->getField("TANGGAL_MULAI"));
        $tanggalselesai= dateToPageCheck($set->getField("TANGGAL_SELESAI"));
        $TANGGAL_SERTIFIKAT= dateToPageCheck($set->getField("TANGGAL_SERTIFIKAT"));
        $jumlahjam= $set->getField("JUMLAH_JAM");
        $pegawai_id_sapk= $set->getField("PEGAWAI_ID_SAPK");

        // update ke efile
        $idPegawai = $set->getField('PEGAWAI_ID');
        $this->load->library('globalfilesycnbkn');
        $vsycn= new globalfilesycnbkn();
        $arrparam= array("pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"1");
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

        $sql = " SELECT * FROM INSTANSI WHERE instansi_id = '1' ";
        $row = $this->db->query($sql)->row();

        // $instansiId = 'A5EB03E23CD0F6A0E040640A040252AD';
        // $instansiIndukSapk='A5EB03E24217F6A0E040640A040252AD';

        $instansiId = $row->instansiid_bkn;

        $arrData = array(
            "id"=>$reqBknId
            , "instansiId"=>$instansiId
            , "institusiPenyelenggara"=>$penyelenggara
            , "jenisDiklatId"=>$tipekursusid
            , "jenisKursus"=>$jenisKursus
            , "jenisKursusSertipikat"=>$jeniskursusnama
            , "jumlahJam"=>$jumlahjam
            , "lokasiId"=>null
            , "namaKursus"=>$nama
            , "nomorSertipikat"=>$nosertifikat
            , "path"=> json_encode($path)
            , "pnsOrangId"=>$pegawai_id_sapk
            , "tahunKursus"=>$tahun
            , "tanggalKursus"=>$tanggalmulai
            , "tanggalSelesaiKursus"=>$tanggalselesai
        );
        // print_r($arrData);exit;
        
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit();

        $arrData['param']= $jsonData;
        $vurl= 'Data_rw_kursus_json';
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
        $set= new DiklatKursus();
        $set->setField("SYNC_ID", $this->USER_LOGIN_ID);
        $set->setField("SYNC_NAMA", $this->LOGIN_USER);
        $set->setField("SYNC_STATUS", $statusKirim);
        $set->setField("DIKLAT_KURSUS_ID", $reqRiwayatId);
        $set->updateStatusSync();

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn()
    {
        $this->load->model('Pegawai');
        $this->load->model('DiklatKursus');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');
        
        $settingurlapi= $this->config->config["settingurlapi"];
        $url= $settingurlapi.'Data_rw_kursus_json?id='.$reqBknId;
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

        $id= $arrResult['id'];
        $idPns= $arrResult['idPns'];
        $nipBaru= $arrResult['nipBaru'];
        $nipLama= $arrResult['nipLama'];
        $jenisKursusNama= $arrResult['jenisKursusNama'];
        $jenisKursusSertifikat= $arrResult['jenisKursusSertifikat'];
        $institusiPenyelenggara= $arrResult['institusiPenyelenggara'];
        $jenisKursusId= $arrResult['jenisKursusId'];
        $jumlahJam= $arrResult['jumlahJam'];
        $namaKursus= $arrResult['namaKursus'];
        $noSertipikat= $arrResult['noSertipikat'];
        $tahunKursus= $arrResult['tahunKursus'];
        $tanggalKursus= $arrResult['tanggalKursus'];
        $tanggalSelesaiKursus= $arrResult['tanggalSelesaiKursus'];
        if(empty($tanggalSelesaiKursus))
            $tanggalSelesaiKursus= $tanggalKursus;
        $jenisDiklatId= $arrResult['jenisDiklatId'];
        $path= $arrResult['path'];

        $pegawai = new Pegawai();
        $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$idPns));
        $pegawai->firstRow();
        $idPegawai = $pegawai->getField('PEGAWAI_ID');

        if(!empty($jenisDiklatId))
        {
            $statementdetil= " AND A.TIPE_KURSUS_ID = ".$jenisDiklatId;
            $setdetil= new DiklatKursus();
            $setdetil->selecttipekursus(array(), -1,-1, $statementdetil);
            $setdetil->firstRow();
            $jenisKursusSertifikat= $setdetil->getField("NAMA");
        }

        if(!empty($jenisKursusSertifikat))
        {
            $statementdetil= " AND UPPER(A.NAMA) = '".strtoupper($jenisKursusSertifikat)."'" ;
            $setdetil= new DiklatKursus();
            $setdetil->selecttipekursus(array(), -1,-1, $statementdetil);
            $setdetil->firstRow();
            $jenisDiklatId= $setdetil->getField("TIPE_KURSUS_ID");
        }
        
        if(!empty($jenisKursusId))
        {
            $sql = " SELECT * from sapk.ref_jenis_kursus where ref_jenis_kursus_id_sapk='".$jenisKursusId."' ";
            $jenisKursusIdx = $this->db->query($sql)->row()->ref_jenis_kursus_id;
        }

        $set= new DiklatKursus();
        $set->setField("DIKLAT_KURSUS_ID", $reqRiwayatId);    
        $set->setField("PEGAWAI_ID",$idPegawai);
        $set->setField('TIPE_KURSUS_ID', ValToNullDB($jenisDiklatId));
        
        $set->setField("NAMA",$namaKursus);
        $set->setField("REF_JENIS_KURSUS_ID",ValToNullDB($jenisKursusIdx));
        $set->setField("JENIS_KURSUS_NAMA",$jenisKursusSertifikat);
        $set->setField("TAHUN",$tahunKursus);
        $set->setField("NO_SERTIFIKAT",$noSertipikat);
        // $set->setField("TEMPAT",$);
        $set->setField("TANGGAL_MULAI",dateToDBCheck($tanggalKursus));
        $set->setField("TANGGAL_SELESAI",dateToDBCheck($tanggalSelesaiKursus));
        $set->setField("TANGGAL_SERTIFIKAT",dateToDBCheck($tanggalKursus));      
        $set->setField('REF_INSTANSI_NAMA', setQuote($institusiPenyelenggara, '1'));
        $set->setField("JUMLAH_JAM", ValToNullDB(dotToNo($jumlahJam)));
        
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
        $arrparam= array("vpath"=>$path, "pegawaiid"=>$idPegawai, "rowid"=>$reqRiwayatId, "refid"=>"1");
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
        $this->load->model('DiklatKursus');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new DiklatKursus();
            $set->setField("DIKLAT_KURSUS_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }
}
?>