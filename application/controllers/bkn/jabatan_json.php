<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class jabatan_json extends CI_Controller {

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
        
        $this->load->model('JabatanRiwayat');
        $this->load->model('SatuanKerja');
        $this->load->model('JabatanFu');
        $this->load->model('JabatanFt');
        
        $this->load->model('CurlData');

		$reqRiwayatId= $this->input->get('reqRiwayatId');
        $reqBknId= $this->input->get('reqBknId');

        // Data SIAPANS 
        $set= new JabatanRiwayat();
        $set->selectByParams(array(), -1, -1," AND A.JABATAN_RIWAYAT_ID = ".$reqRiwayatId);        
        $set->firstRow();
        $jabatanRiwayatId= $set->getField("JABATAN_RIWAYAT_ID");
        $pegawai_id_sapk= $set->getField("PEGAWAI_ID_SAPK");
        $eselonId= $set->getField("ESELON_ID");
        $nomorSk= $set->getField("NO_SK");
        $date= new DateTime($set->getField("TANGGAL_SK"));
        $tanggalSk= dateToPageCheck($date->format('Y-m-d'));
        $date= new DateTime($set->getField("TMT_JABATAN"));
        $tmtJabatan= dateToPageCheck($date->format('Y-m-d'));
        $date= new DateTime($set->getField("TANGGAL_PELANTIKAN"));
        $tmtPelantikan= dateToPageCheck($date->format('Y-m-d'));
        $jenisJabatan= $set->getField("JENIS_JABATAN_ID");
        $satuanKerjaId= $set->getField("SATKER_ID");
        $jabatanFungsionalId= $set->getField("JABATAN_FT_ID");
        $jabatanFungsionalUmumId= $set->getField("JABATAN_FU_ID");
      
        $satuankerja = new SatuanKerja();
        $satuankerja->selectByParams(array("A.SATUAN_KERJA_ID"=>$satuanKerjaId));
        $satuankerja->firstRow();
        $instansiSapk =$satuankerja->getField("ID_SAPK");
        $satuanKerjaInduk_Id =$satuankerja->getField("SATUAN_KERJA_INDUK_ID");

        $satuankerja = new SatuanKerja();
        $satuankerja->selectByParams(array("A.SATUAN_KERJA_ID"=>$satuanKerjaInduk_Id));
        $satuankerja->firstRow();
        $instansiIndukSapk =$satuankerja->getField("ID_SAPK");

        $satuankerja = new JabatanFu();
        $satuankerja->selectByParams(array("A.JABATAN_FU_ID"=>$jabatanFungsionalUmumId));
        $satuankerja->firstRow();
        $instansiFuSapk =$satuankerja->getField("ID_DATA");
        // $instansiFuSapk =$satuankerja->getField("ID_DATA");

        $satuankerja = new JabatanFt();
        $satuankerja->selectByParams(array("A.JABATAN_FT_ID"=>$jabatanFungsionalId));
        $satuankerja->firstRow();
        $instansiFTSapk =$satuankerja->getField("ID_DATA");

        $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);

        $sql = " SELECT * FROM INSTANSI WHERE instansi_id = '1' ";
        $row = $this->db->query($sql)->row();


        // $instansiId = 'A5EB03E23CD0F6A0E040640A040252AD';
        // $instansiIndukSapk='A5EB03E24217F6A0E040640A040252AD';

        $instansiId = $row->instansiid_bkn;
        $instansiIndukSapk= $row->satuankerjaid_bkn;

        $jenisJabatan= 1;
        if(!empty($jabatanFungsionalId))
            $jenisJabatan= 2;
        else if(!empty($jabatanFungsionalUmumId))
            $jenisJabatan= 4;

        $arrData = array(
            "id"=>$reqBknId
            , "eselonId"=>$eselonId
            , "instansiId"=>$instansiId
            , "jabatanFungsionalId"=>$instansiFTSapk
            , "jabatanFungsionalUmumId"=>$instansiFuSapk
            , "jenisJabatan"=>$jenisJabatan
            , "nomorSk"=>$nomorSk
            , "path"=>$path
            , "pnsId"=>$pegawai_id_sapk
            , "satuanKerjaId"=>$instansiIndukSapk
            , "tanggalSk"=>$tanggalSk
            , "tmtJabatan"=>$tmtJabatan
            , "tmtPelantikan"=>$tmtPelantikan
            , "unorId"=>$instansiSapk
        );
        
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit;

        $arrData['param']=$jsonData;
        $vurl ='Data_rw_jabatan_json';

        $set= new CurlData();
        $response= $set->curlpost($vurl,$arrData);
        // print_r($response);exit();
		$returnStatus= $response->result->success;
		$returnId= $response->result->mapData->rwJabatanId;
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

        echo json_encode( $arrDataStatus,true);
	}

    function delete_bkn(){
        $this->load->model('base-api/DataCombo');
        $this->load->model('JabatanRiwayat');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');

        // untuk reset riwayat
        if(!empty($reqRiwayatId))
        {
            $berhasil= "";
            $set= new JabatanRiwayat();
            $set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
            $set->setField("LAST_USER", $this->LOGIN_USER);
            $set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
            $set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
            $set->setField("LAST_DATE", "NOW()");
            $set->setField("JABATAN_RIWAYAT_ID", $reqRiwayatId);
            $set->setField("STATUS", "1");
            if($set->updateStatus())
            {
                $berhasil= "1";
                $arrparam= ["reqRiwayatId"=>$reqRiwayatId, "id"=>""];
                $this->setidsapk($arrparam);
            }
        }

        // untuk reset riwayat
        if(!empty($reqBknId))
        {
            $berhasil= "";

            $set= new DataCombo();
            $arrparam= ["id"=>$reqBknId, "m"=>"hapus", "vurl"=>"Data_rw_jabatan_json"];
            $set= new DataCombo();
            $set->selectdata($arrparam, "");
        }

        if($berhasil == "1")
        {
          $arrDataStatus =array("PESAN"=>'Data berhasil di hapus',"code"=>200);
          if(!empty($reqRiwayatId))
          {
            $this->reset_siapasn();
          }
        }
        else
        {
          $arrDataStatus =array("PESAN"=>$pesan,"code"=>400);
        }

        echo json_encode( $arrDataStatus,true);
    }

    function bkn_siapasn(){

        $this->load->model('Pegawai');
        $this->load->model('JabatanRiwayat');
        $this->load->model('JabatanFu');
        $this->load->model('JabatanFt');
        $this->load->model('SatuanKerja');

        $reqBknId= $this->input->get('reqBknId');
        $reqRiwayatId= $this->input->get('reqRiwayatId');

        $settingurlapi= $this->config->config["settingurlapi"];
        $url =  $settingurlapi.'Data_rw_jabatan_json?id='.$reqBknId;
        // echo $url;

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $html= file_get_contents($url, false, stream_context_create($arrContextOptions));
        
        $arrData = json_decode($html,true);
        // print_r( $arrData);exit;
      
        $arrResult = $arrData['result'];

        $id= $arrResult['id'];
        $idPns= $arrResult['idPns'];
        $nipBaru= $arrResult['nipBaru'];
        $nipLama= $arrResult['nipLama'];
        $jenisJabatan= $arrResult['jenisJabatan'];
        $instansiKerjaId= $arrResult['instansiKerjaId'];
        $instansiKerjaNama= $arrResult['instansiKerjaNama'];
        $satuanKerjaId= $arrResult['satuanKerjaId'];
        $unorId= $arrResult['unorId'];
        $unorNama= $arrResult['unorNama'];
        $unorIndukId= $arrResult['unorIndukId'];
        $unorIndukNama= $arrResult['unorIndukNama'];
        $eselon= $arrResult['eselon'];
        $eselonId= $arrResult['eselonId'];
        $jabatanFungsionalId= $arrResult['jabatanFungsionalId'];
        $jabatanFungsionalNama= $arrResult['jabatanFungsionalNama'];
        $jabatanFungsionalUmumId= $arrResult['jabatanFungsionalUmumId'];
        $jabatanFungsionalUmumNama= $arrResult['jabatanFungsionalUmumNama'];
        $tmtJabatan= $arrResult['tmtJabatan'];
        $nomorSk= $arrResult['nomorSk'];
        $tanggalSk= $arrResult['tanggalSk'];
        $namaUnor= $arrResult['namaUnor'];
        $namaJabatan= $arrResult['namaJabatan'];
        $tmtPelantikan= $arrResult['tmtPelantikan'];

        $pegawai = new Pegawai();
        $pegawai->selectByParams(array("A.PEGAWAI_ID_SAPK"=>$idPns));
        $pegawai->firstRow();
        $idPegawai= $pegawai->getField('PEGAWAI_ID');
        // $reqStatusMutasi= $pegawai->getField("STATUS_MUTASI");

        $satuankerja = new SatuanKerja();
        $satuankerja->selectByParams(array("A.ID_SAPK"=>$unorId));
        $satuankerja->firstRow();
        // echo $satuankerja->query;exit;
        $instansiSapk= $satuankerja->getField("ID_SAPK");
        $satuanKerjaId= $satuankerja->getField("SATUAN_KERJA_ID");

        // kalau satuan kerja dengan id sapk kosong, cari by nama
        // if(empty($satuanKerjaId) && !empty($unorNama))
        // {
        //     $satuankerja = new SatuanKerja();
        //     $satuankerja->selectByParams(array("UPPER(A.NAMA)"=>strtoupper($unorNama)));
        //     $satuankerja->firstRow();
        //     // echo $satuankerja->query;exit;
        //     $instansiSapk= $satuankerja->getField("ID_SAPK");
        //     $satuanKerjaId= $satuankerja->getField("SATUAN_KERJA_ID");
        // }

         if(empty($satuanKerjaId) )
         {
            $reqStatusMutasi='1';
            $unorIndukNama = $unorIndukNama?' - '.$unorIndukNama:'';
            $unorNama =  $unorNama.$unorIndukNama;
         }   


        $satuankerja = new JabatanFu();
        $satuankerja->selectByParams(array("A.ID_DATA"=>$jabatanFungsionalUmumId));
        $satuankerja->firstRow();
        $instansiFuSapk= $satuankerja->getField("JABATAN_FU_ID");
        $namaFuSapk= $satuankerja->getField("NAMA");

        $satuankerja = new JabatanFt();
        $satuankerja->selectByParams(array("A.ID_DATA"=>$jabatanFungsionalId));
        $satuankerja->firstRow();
        $instansiFTSapk= $satuankerja->getField("JABATAN_FT_ID");
        $fttipepegawaiid= $satuankerja->getField("TIPE_PEGAWAI_ID");
        $namaFTSapk= $satuankerja->getField("NAMA");

        $jenisJabatan= 1;
        $reqTipePegawaiId= 11;
        $tmteselon= $tmtJabatan;
        if(!empty($jabatanFungsionalId))
        {
            $jenisJabatan= 3;
            $reqTipePegawaiId= $fttipepegawaiid;
            $tmteselon= "";
            $namaJabatan= $namaFTSapk;
        }
        else if(!empty($jabatanFungsionalUmumId))
        {
            $jenisJabatan= 2;
            $reqTipePegawaiId= 12;
            $tmteselon= "";
            $namaJabatan= $namaFuSapk;
        }

        $set = new JabatanRiwayat();
        $set->setField('JABATAN_RIWAYAT_ID',$reqRiwayatId);
        $set->setField('PEGAWAI_ID',$idPegawai);
        $set->setField('JENIS_JABATAN_ID',$jenisJabatan);
        $set->setField('TIPE_PEGAWAI_ID',ValToNullDB($reqTipePegawaiId));
        $set->setField('SATKER_ID',ValToNullDB($satuanKerjaId));
        $set->setField('JABATAN_FU_ID',ValToNullDB($instansiFuSapk));
        $set->setField('JABATAN_FT_ID',ValToNullDB($instansiFTSapk));
        $set->setField('ESELON_ID',ValToNullDB($eselonId));
        $set->setField('NO_SK',$nomorSk);
        $set->setField('TANGGAL_SK',dateToDBCheck($tanggalSk));
        $set->setField('TMT_JABATAN',dateToDBCheck($tmtJabatan));
        $set->setField('TMT_ESELON',dateToDBCheck($tmteselon));
        $set->setField('NAMA',$namaJabatan);
        $set->setField('TANGGAL_PELANTIKAN',dateToDBCheck($tmtPelantikan));
        $set->setField('SATKER_NAMA',$unorNama);
        $set->setField('IS_MANUAL',ValToNullDB($reqStatusMutasi));

        if(empty($reqRiwayatId))
        {
            $set->insertDataBkn();
            $reqRiwayatId= $set->id;
        }
        else
        {
            $set->updateBknData();
        }

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
        $this->load->model('JabatanRiwayat');

        $reqRiwayatId= $arrparam["reqRiwayatId"];
        $id= $arrparam["id"];

        if(!empty($reqRiwayatId))
        {
            $set= new JabatanRiwayat();
            $set->setField("JABATAN_RIWAYAT_ID", $reqRiwayatId);
            $set->setField("ID_SAPK", $id);
            $set->updateIdSapk();
        }

        return "1";
    }

}
?>