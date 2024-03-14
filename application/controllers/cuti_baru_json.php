<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class cuti_baru_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//kauth
		if (!$this->kauth->getInstance()->hasIdentity())
		{
			// trow to unauthenticated page!
			//redirect('Login');
		}       
		$this->db->query("SET DATESTYLE TO PostgreSQL,European;");
		/* GLOBAL VARIABLE */
		$this->LOGIN_USER= $this->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$this->LOGIN_LEVEL= $this->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$this->SATUAN_KERJA_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_ID;
		$this->SATUAN_KERJA_BKD_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_BKD_ID;
		$this->LOGIN_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$this->LOGIN_PEGAWAI_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;
	}

	function settingadd()
	{
		$this->load->model("base-cuti/CutiUrutan");
		
		$reqMenuId= $this->input->post("reqMenuId");
		$reqUrutan= $this->input->post("reqUrutan");
		$reqUserLoginId= $this->input->post("reqUserLoginId");

		foreach ($reqMenuId as $key => $value) 
		{
			$set= new CutiUrutan();
			$set->setField("USER_LOGIN_ID", ValToNullDB($reqUserLoginId[$key]));
			$set->setField("URUTAN", ValToNullDB($reqUrutan[$key]));
			$set->setField("MENU_ID", $reqMenuId[$key]);
			$set->update();
			// echo $set->query;exit;
			unset($set);
		}

	  	echo "yyyData berhasil disimpan.";
	}

	function cariuserlogin()
	{
		$this->load->model("base-cuti/CutiUrutan");
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		if(empty($search_term))
		{
			$search_term = isset($_GET['term']) ? $_GET['term'] : "";
		}
		
		$set = new CutiUrutan();

		$statement.= " AND (UPPER(A1.NIP_BARU) LIKE '".strtoupper($search_term)."%' OR UPPER(A1.NAMA_LENGKAP) LIKE '".strtoupper($search_term)."%' OR UPPER(A2.LOGIN_USER) LIKE '".strtoupper($search_term)."%') ";
		
		$set->selectuserlogin(array(), 70, 0, $statement);
		// echo $set->query;exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$pegawaiinfo= $set->getField("NAMA_LENGKAP")." (".$set->getField("NIP_BARU").")";
			$arr_json[$i]['id'] = $set->getField("USER_LOGIN_ID");
			$arr_json[$i]['label'] = $set->getField("LOGIN_USER");
			$arr_json[$i]['pegawaiinfo'] = $pegawaiinfo;
			$arr_json[$i]['desc'] = $set->getField("LOGIN_USER")."<br/><label style='font-size:12px'>".$pegawaiinfo."</label>";
			$i++;
		}
		echo json_encode($arr_json);		
		
	}
	
	function cari_pegawai_karpeg()
	{
		$this->load->model("base-cuti/PendidikanRiwayat");
		$this->load->model('base-cuti/SatuanKerja');
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		if(empty($search_term))
		{
			$search_term = isset($_GET['term']) ? $_GET['term'] : "";
		}
		
		$reqId= $this->input->get("reqId");
		$reqJenis= $this->input->get("reqJenis");
        $reqMode= $this->input->get("reqMode");
        $cekquery= $this->input->get("c");
		
		$set= new PendidikanRiwayat();
		$statement= " AND A.STATUS IS NULL";
		$statement.= " AND UPPER(A.NIP_BARU) LIKE '%".strtoupper(str_replace(" ", "", $search_term))."%' ";
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		if($reqSatuanKerjaId == ""){}
		else
		{
			$skerja= new SatuanKerja();
			$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
			unset($skerja);
			//echo $reqSatuanKerjaId;exit;
			$statement.= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
			//$statement.= " AND ( A.SATUAN_KERJA_ID = ANY( AMBIL_ID_SATUAN_KERJA_TREE_ARRAY(".$reqSatuanKerjaId.") ) OR A.SATUAN_KERJA_ID = ".$reqSatuanKerjaId." )";
		}

		/*$statement.= "
		AND A.PEGAWAI_ID NOT IN 
		(
			SELECT PEGAWAI_ID
			FROM persuratan.SURAT_MASUK_PEGAWAI WHERE JENIS_ID = 4
			AND SATUAN_KERJA_PEGAWAI_USULAN_ID IN (".$reqSatuanKerjaId.")
			AND (STATUS_BERKAS NOT IN (10) OR STATUS_BERKAS IS NULL OR (STATUS_BERKAS = 10 AND (STATUS_SURAT_KELUAR NOT IN (88) OR STATUS_SURAT_KELUAR IS NULL )))
		)";*/
		
		// AND SATUAN_KERJA_PARENT_ID > 0
		//data dinas
		/*if($reqMode == "1")
		{
			$statement.= " 
			AND A.SATUAN_KERJA_ID IN
			(
			SELECT SATUAN_KERJA_ID FROM SATUAN_KERJA A WHERE TIPE_ID = 1
			AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")
			)";
		}*/
		
		$set->selectByParamsPegawai(array(), 10, 0, $statement);

		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			$arr_json[$i]['label'] = $set->getField("NIP_BARU");
			$arr_json[$i]['desc'] = $set->getField("NIP_BARU")."<br/><label style='font-size:12px'>".$set->getField("NAMA_LENGKAP")."</label>";
			$arr_json[$i]['satuankerjaid'] = $set->getField("SATUAN_KERJA_ID");
			$arr_json[$i]['satuankerjanama'] = $set->getField("SATUAN_KERJA_NAMA");
			$arr_json[$i]['jabatanriwayatid'] = $set->getField("JABATAN_RIWAYAT_ID");
			$arr_json[$i]['jabatannama'] = $set->getField("JABATAN_NAMA");
			$arr_json[$i]['pendidikanriwayatid'] = $set->getField("PENDIDIKAN_RIWAYAT_ID");
			$arr_json[$i]['gajiriwayatid'] = $set->getField("GAJI_RIWAYAT_ID");
			$arr_json[$i]['pangkatriwayatid'] = $set->getField("PANGKAT_RIWAYAT_ID");
			$arr_json[$i]['namapegawai'] = $set->getField("NAMA_LENGKAP");
			$arr_json[$i]['pangkatkode'] = $set->getField("PANGKAT_KODE");
			$arr_json[$i]['kartupegawailama'] = $set->getField("KARTU_PEGAWAI");
			$arr_json[$i]['tmtcpns'] = $set->getField("TMT_CPNS");
			$arr_json[$i]['tmtpns'] = $set->getField("TMT_PNS");
			$arr_json[$i]['masakerjatahun'] = $set->getField("MASA_KERJA_TAHUN");
			$arr_json[$i]['masakerjabulan'] = $set->getField("MASA_KERJA_BULAN");

			$i++;
		}
		echo json_encode($arr_json);
	}

	function cari_pegawai_global()
	{
		$this->load->model("base-cuti/PendidikanRiwayat");
		$this->load->model('base-cuti/SatuanKerja');
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		if(empty($search_term))
		{
			$search_term = isset($_GET['term']) ? $_GET['term'] : "";
		}
		
		$reqId= $this->input->get("reqId");
		$reqJenis= $this->input->get("reqJenis");
        $reqMode= $this->input->get("reqMode");
		
		$set= new PendidikanRiwayat();
		$statement= " AND A.STATUS IS NULL";
		$statement.= " AND UPPER(A.NIP_BARU) LIKE '%".strtoupper(str_replace(" ", "", $search_term))."%' ";
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		// AND SATUAN_KERJA_PARENT_ID > 0
		//data dinas
		if($reqMode == "1")
		{
			// $statement.= " 
			// AND A.SATUAN_KERJA_ID IN
			// (
			// SELECT SATUAN_KERJA_ID FROM SATUAN_KERJA A WHERE TIPE_ID = 1
			// AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")
			// )";
		}
		
		$set->selectByParamsPegawai(array(), 10, 0, $statement);

		// echo $this->db->last_query();exit;
		//echo $set->query;exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			$arr_json[$i]['label'] = $set->getField("NIP_BARU");
			$arr_json[$i]['desc'] = $set->getField("NIP_BARU")."<br/><label style='font-size:12px'>".$set->getField("NAMA_LENGKAP")."</label>";
			$arr_json[$i]['satuankerjaid'] = $set->getField("SATUAN_KERJA_ID");
			$arr_json[$i]['satuankerjanama'] = $set->getField("SATUAN_KERJA_NAMA");
			$arr_json[$i]['jabatanriwayatid'] = $set->getField("JABATAN_RIWAYAT_ID");
			$arr_json[$i]['jabatannama'] = $set->getField("JABATAN_NAMA");
			$arr_json[$i]['pendidikanriwayatid'] = $set->getField("PENDIDIKAN_RIWAYAT_ID");
			$arr_json[$i]['gajiriwayatid'] = $set->getField("GAJI_RIWAYAT_ID");
			$arr_json[$i]['pangkatriwayatid'] = $set->getField("PANGKAT_RIWAYAT_ID");
			$arr_json[$i]['namapegawai'] = $set->getField("NAMA_LENGKAP");
			$arr_json[$i]['pangkatkode'] = $set->getField("PANGKAT_KODE");
			$arr_json[$i]['kartupegawailama'] = $set->getField("KARTU_PEGAWAI");
			$arr_json[$i]['tmtcpns'] = $set->getField("TMT_CPNS");
			$arr_json[$i]['tmtpns'] = $set->getField("TMT_PNS");
			$arr_json[$i]['masakerjatahun'] = $set->getField("MASA_KERJA_TAHUN");
			$arr_json[$i]['masakerjabulan'] = $set->getField("MASA_KERJA_BULAN");

			$i++;
		}
		echo json_encode($arr_json);
	}

	function check_sebelum_sisa_cuti(){
		$this->load->model('base-cuti/Cuti');
		$reqTahun = $this->input->get('reqTahun');
		$reqJenis = $this->input->get('reqJenis');
		$reqId = $this->input->get('reqId');
		$set= new Cuti();
	
		/*if($reqJenis !='1'){
			 $reqJenis='99';
		}*/
		// CARI DATA TAHUNAN
		$statementLevel= " AND A.JENIS_CUTI = 1 AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')";
		$set->selectByParams(array(), -1, -1, $statementLevel." AND A.PEGAWAI_ID = ".$reqId);
		$arrData= $set->rowResult;

		$arrDataValue= array();
		$arrDataFieldColomn =array();

		// ParamCutiTahunan
		$defaultLamaCuti = 12;
		$arrDataCutiTahunan =  multi_array_search($arrData,
			array(  
				'jenis_cuti'=>$reqJenis,
			)
		);
		// print_r($arrDataCutiTahunan);exit;

		foreach ($arrDataCutiTahunan as $value) {
			 $arrDataValue[$value['tahun_mulai']] +=ifZero2($arrDataValue[$value['tahun_mulai']]) + $value['lama'];
			// code...
		}
		// print_r($arrDataValue);exit;

		$arrDataCutiBesar= multi_array_search($arrData,
			array(  
				'jenis_cuti'=>2,
				'tahun_mulai'=>$reqTahun,
			)
		);
	
		$reqCutiBesar  ='TIDAK';
		if(count($arrDataCutiBesar) > 0){
			$reqCutiBesar='YA';
		}

		$vquery= "SELECT 
		SUM(LAMA) rowcount
		FROM cuti_usulan
		WHERE 1=1
		AND STATUS_BERKAS > 0 AND STATUS_BERKAS < 10
		AND TO_CHAR(TANGGAL_KIRIM, 'YYYY') = '".$reqTahun."'
		AND PEGAWAI_ID = ".$reqId;
		$jumlah_cuti_tahunan_sebelum_valid= $this->db->query($vquery)->row()->rowcount;
		// echo $jumlah_cuti_tahunan_sebelum_valid;exit;

		$arrDataModel= array('H',"H1","H2");
		$j=0;
		for($i=$reqTahun; $i> count($arrDataModel); $i--)
		{
			// KURANG AMBIL DATA SESUAI TAHUN MUNDUR TAHUNAN
			$reqLamaCuti = ifZero2($arrDataValue[$i]);
			if($arrDataModel[$j]=='H2')
			{
				$defaultLamaCuti = 6;
				if($reqLamaCuti > 6)
				{
					$defaultLamaCuti = 12;
				}
			}
			else if($arrDataModel[$j]=='H1')
			{
				$defaultLamaCuti = 6;
				if($reqLamaCuti > 6)
				{
					$defaultLamaCuti = 12;
				}
			}
			$arrDataFieldColomn[$arrDataModel[$j]]['LAMA_CUTI']= ifZero2($arrDataValue[$i]);
			$arrDataFieldColomn[$arrDataModel[$j]]['SISA_CUTI']= $defaultLamaCuti - ifZero2($arrDataValue[$i]);

			$j++;	
		}
		
		$reqValueN = ifZero2($arrDataValue[($reqTahun-1)]);
			$defaultLamaCuti = 12 + $arrDataFieldColomn['H1']['SISA_CUTI'];

		// KALAU DI BAWAH 6, MAKA MAKSIMAL AMBIL 6 HARI SAJA
		if($reqValueN > 6)
		{
			$defaultLamaCuti = ($defaultLamaCuti - $arrDataFieldColomn['H1']['LAMA_CUTI']);
		}
		
		$arrDataFieldColomn['H']['LAMA_CUTI']= ifZero2($arrDataValue[$reqTahun]);
		$arrDataFieldColomn['H']['SISA_CUTI']= $defaultLamaCuti - ifZero2($arrDataValue[$reqTahun]) - $jumlah_cuti_tahunan_sebelum_valid;
		$arrDataFieldColomn['CUTI_BESAR']= $reqCutiBesar;
		echo json_encode($arrDataFieldColomn);
	}

	function check_sisa_cuti(){
		$this->load->model('base-cuti/Cuti');
		$reqTahun = $this->input->get('reqTahun');
		$reqJenis = $this->input->get('reqJenis');
		$reqId = $this->input->get('reqId');
		$set= new Cuti();

		// AND TO_CHAR(A.TANGGAL_MULAI,'YYYY') = '2022' 
		// CARI DATA TAHUNAN
		$statementLevel= " AND A.JENIS_CUTI = 1 AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')";
		$set->selectByParams(array(), -1, -1, $statementLevel." AND A.PEGAWAI_ID = ".$reqId);
		$arrData= $set->rowResult;
		// print_r($arrData);exit;

		$arrDataValue= array();
		$arrDataFieldColomn =array();

		// ParamCutiTahunan
		$defaultLamaCuti = 12;
		$arrDataCutiTahunan =  multi_array_search($arrData,
			array(  
				'jenis_cuti' => 1,
			)
		);
		// print_r($arrDataCutiTahunan);exit;

		foreach ($arrDataCutiTahunan as $value) 
		{
			$arrDataValue[$value['tahun_mulai']]+= $value['lama'];
		}
		// print_r($arrDataValue);exit;

		$arrDataCutiBesar= multi_array_search($arrData,
			array(  
				'jenis_cuti'=>2,
				'tahun_mulai'=>$reqTahun,
			)
		);
	
		$reqCutiBesar  ='TIDAK';
		if(count($arrDataCutiBesar) > 0){
			$reqCutiBesar='YA';
		}

		$vquery= "SELECT 
		SUM(LAMA) rowcount
		FROM cuti_usulan
		WHERE 1=1
		AND STATUS_BERKAS > 0 AND STATUS_BERKAS < 4
		AND TO_CHAR(TANGGAL_KIRIM, 'YYYY') = '".$reqTahun."'
		AND PEGAWAI_ID = ".$reqId;
		$jumlah_cuti_tahunan_sebelum_valid= $this->db->query($vquery)->row()->rowcount;
		// echo $jumlah_cuti_tahunan_sebelum_valid;exit;

		$arrDataModel= array(
			array("j"=>'H', "t"=>$reqTahun)
			, array("j"=>'H1', "t"=>$reqTahun-1)
			, array("j"=>'H2', "t"=>$reqTahun-2)
		);
		// print_r($arrDataModel);exit;

		foreach ($arrDataModel as $key => $value)
		{
			$vtahun= $value["t"];
			$vlabel= $value["j"];

			$reqLamaCuti= ifZero2($arrDataValue[$vtahun]);
			// echo $key.";".$vtahun.";".$reqLamaCuti."\n";

			// KALAU DI BAWAH 6, MAKA MAKSIMAL AMBIL 6 HARI SAJA
			if($vlabel == "H")
			{
				$sisacuti= 12 - $reqLamaCuti;
			}
			else
			{
				$sisacuti= 6;
				if($reqLamaCuti >= 6)
				{
					$sisacuti= 12 - $reqLamaCuti;
				}
			}

			$arrDataFieldColomn[$vlabel]['LAMA_CUTI']= $reqLamaCuti;
			$arrDataFieldColomn[$vlabel]['SISA_CUTI']= $sisacuti;
		}
		// print_r($arrDataFieldColomn);exit;
		$arrDataFieldColomn['CUTI_BELUM_PROSES']= ifZero2($jumlah_cuti_tahunan_sebelum_valid);
		$arrDataFieldColomn['CUTI_BESAR']= $reqCutiBesar;
		echo json_encode($arrDataFieldColomn);
	}

	function add(){
		$this->load->library('globalfilepegawai');
		$this->load->model("base-cuti/CutiUsulan");

		$reqStatusBerkas= $this->input->post('reqStatusBerkas');
		$reqRowId= $this->input->post('reqRowId');
		$cekquery= $this->input->post('cekquery');

		$infopesan= "Data berhasil disimpan.";
		if($reqStatusBerkas == 1)
			$infopesan= "Data berhasil dikirim.";
		else if($reqStatusBerkas == 0 && !empty($reqRowId))
		{
			$setdetil= new CutiUsulan();
			$setdetil->selectdata(array(), -1, -1, " AND A.CUTI_USULAN_ID = ".$reqRowId);
			$setdetil->firstRow();
			$vstatusberkas= $setdetil->getField("STATUS_BERKAS");
			if($vstatusberkas == 1)
			{
				$infopesan= "Data berhasil batal dikirim.";
			}
		}

		if($reqStatusBerkas > 0)
		{
			// validasi untuk file
			$reqLinkFile= $_FILES['reqLinkFile'];
			// print_r($reqLinkFile);exit;

			// untuk validasi required file
			$validasifilerequired= new globalfilepegawai();
			$vpost= $this->input->post();
			$vinforequired= $validasifilerequired->validasifilerequired($vpost, $reqLinkFile);
			if(!empty($vinforequired))
			{
				echo "xxx-".$vinforequired;
				exit;
			}
		}
		
		$reqId= $this->input->post('reqId');
		$reqSatuanKerjaId= $this->input->post('reqSatuanKerjaId');
		$reqJabatanRiwayatId= $this->input->post('reqJabatanRiwayatId');
		$reqPangkatRiwayatId= $this->input->post('reqPangkatRiwayatId');
		$reqJenis= $this->input->post('reqJenis');
		$reqAlasanJenis= $this->input->post('reqAlasanJenis');
		$reqTglMulai= $this->input->post('reqTglMulai');
		$reqTglSelesai= $this->input->post('reqTglSelesai');
		$reqStatusCutiBesar= $this->input->post('reqStatusCutiBesar');
		$reqJenisDurasi= $this->input->post('reqJenisDurasi');
		$reqKeteranganDetil= $this->input->post('reqKeteranganDetil');

		$reqPegawaiAtasanId= $this->input->post('reqPegawaiAtasanId');
		$reqNipAtasan= $this->input->post('reqNipAtasan');
		$reqNamaAtasan= $this->input->post('reqNamaAtasan');

		$reqPegawaiKepalaId= $this->input->post('reqPegawaiKepalaId');
		$reqNipKepala= $this->input->post('reqNipKepala');
		$reqNamaKepala= $this->input->post('reqNamaKepala');

		$reqLamaDurasi= $this->input->post('reqLamaDurasi');
		$reqLamaHari= $this->input->post('reqLamaHari');
		$reqSatuanKerjaAsalId= $this->SATUAN_KERJA_ID;

		$reqH2= $this->input->post('reqH2');
		$reqSisaH2= $this->input->post('reqSisaH2');
		$reqH1= $this->input->post('reqH1');
		$reqSisaH1= $this->input->post('reqSisaH1');
		$reqH= $this->input->post('reqH');
		$reqSisaH= $this->input->post('reqSisaH');

		// kalau lebih dari 1 maka reset data
		if($reqStatusBerkas < 1)
		{
			$reqH2= $reqSisaH2= $reqH1= $reqSisaH1= $reqH= $reqSisaH= "";
		}

		$set= new CutiUsulan();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("STATUS_BERKAS", $reqStatusBerkas);
		$set->setField("PEGAWAI_ID", ValToNullDB($reqId));
		$set->setField("SATUAN_KERJA_ID", ValToNullDB($reqSatuanKerjaId));
		$set->setField("JABATAN_RIWAYAT_ID", ValToNullDB($reqJabatanRiwayatId));
		$set->setField("PANGKAT_RIWAYAT_ID", ValToNullDB($reqId));
		$set->setField("JENIS_CUTI_ID", ValToNullDB($reqJenis));
		$set->setField("JENIS_CUTI_DETAIL_ID", ValToNullDB($reqAlasanJenis));
		$set->setField("JENIS_CUTI_DURASI_ID", ValToNullDB($reqJenisDurasi));
		$set->setField("KETERANGAN_DETIL", setQuote($reqKeteranganDetil, '1'));
		$set->setField("LAMA_HARI", ValToNullDB($reqLamaDurasi));
	    $set->setField("LAMA", ValToNullDB($reqLamaHari));
		//$set->setField("LAMA", ValToNullDB($req));
		$set->setField("PEGAWAI_ATASAN_ID", ValToNullDB($reqPegawaiAtasanId));
		$set->setField("NIP_ATASAN", setQuote($reqNipAtasan, '1'));
		$set->setField("NAMA_ATASAN", setQuote($reqNamaAtasan, '1'));
		$set->setField("PEGAWAI_KEPALA_ID", ValToNullDB($reqPegawaiKepalaId));
		$set->setField("NIP_KEPALA", setQuote($reqNipKepala, '1'));
		$set->setField("NAMA_KEPALA", setQuote($reqNamaKepala, '1'));

		$set->setField("TANGGAL_MULAI", dateToDBCheck($reqTglMulai));
		$set->setField("TANGGAL_SELESAI", dateToDBCheck($reqTglSelesai));

		$set->setField("SATUAN_KERJA_ASAL_ID", ValToNullDB($reqSatuanKerjaAsalId));

		$set->setField("LAMA_CUTI_N2", ValToNullDB($reqH2));
		$set->setField("SISA_CUTI_N2", ValToNullDB($reqSisaH2));
		$set->setField("LAMA_CUTI_N1", ValToNullDB($reqH1));
		$set->setField("SISA_CUTI_N1", ValToNullDB($reqSisaH1));
		$set->setField("LAMA_CUTI_N", ValToNullDB($reqH));
		$set->setField("SISA_CUTI_N", ValToNullDB($reqSisaH));

		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));

		$infosimpan= "";
		if(empty($reqRowId))
		{
			if($set->insert())
			{
				$reqRowId= $set->id;
				$infosimpan= "1";
			}
		}
		else
		{
			if($set->update())
			{
				$infosimpan= "1";
			}
		}

		if(!empty($cekquery))
		{
			echo $set->errorMsg;exit;
			echo $set->query;exit;
		}

		if($infosimpan == "1")
		{
			// untuk simpan file
			$vpost= $this->input->post();
			$vsimpanfilepegawai= new globalfilepegawai();
			$vsimpanfilepegawai->simpanfilepegawai($vpost, $reqRowId, $reqLinkFile);
			
			echo $reqRowId."-".$infopesan;
		}
		else
		{
			echo "xxx-Data gagal disimpan.";	
		}

		// $sql =$this->db->last_query();
		/*if ( ! $this->db->simple_query($sql))
		{
       
			 $errMess = $this->db->_error_message();
			 echo $errMess;
    	}*/

		/*$nexId = $this->db->query('select count(cuti_baru_id) rowcount from cuti_baru')->row()->rowcount +1;
		$data = array(
			'cuti_baru_id' => $nexId,
			'pegawai_id' =>$reqPegawaiId,
			'jenis_cuti_id' =>$reqJenis,
			'jenis_cuti_detail_id' =>$reqAlasanJenis,
			'jenis_cuti_durasi_id' =>$reqJenisDurasi,
			'tanggal_mulai' =>$reqTglMulai,
			'tanggal_selesai' =>$reqTglSelesai,
			'lama_hari' =>$reqLamaDurasi,	
			'lama' =>$reqLamaHari,	
			'atasan_id' =>$reqNipAtasan2,
			'kepala_id' =>$reqNipKepala2,
		);

		if(empty($reqId))
		{
			$data['last_create_date']=date('d-m-Y H:i:s');
			$data['last_create_user']=$this->LOGIN_ID;
			$this->db->insert('cuti_baru', $data);
		}
		else
		{
			$data['cuti_baru_id']=$reqId;
			$data['last_update_date']=date('d-m-Y H:i:s');
			$data['last_update_user']=$this->LOGIN_ID;
			$this->db->where('cuti_baru_id',$reqId);
			$this->db->update('cuti_baru',$data);
		}
		echo $this->db->last_query();*/
	}

	function addpilihpenandatangan(){
		$this->load->model("base-cuti/CutiUsulan");

		$reqStatusBerkas= $this->input->post('reqStatusBerkas');
		$reqStatusSebelumBerkas= $this->input->post('reqStatusSebelumBerkas');
		$reqRowId= $this->input->post('reqRowId');
		$reqPegawaiPenandaTanganId= $this->input->post('reqPegawaiPenandaTanganId');

		$infopesan= "Data berhasil disimpan.";
		if($reqStatusBerkas !== $reqStatusSebelumBerkas)
		{
			if($reqStatusBerkas == 2)
			{
				$infopesan= "Data berhasil dikirim ke verifikator.";
			}

			else if($reqStatusBerkas == 3)
			{
				$infopesan= "Data berhasil dikirim ke TTE Surat Cuti.";
			}
		}
		// echo $reqStatusBerkas;exit;

		$set= new CutiUsulan();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("STATUS_BERKAS", $reqStatusBerkas);
		$set->setField("MENU_PENANDA_TANGAN_ID", $reqPegawaiPenandaTanganId);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));

		$infosimpan= "";
		if($set->updateverifikatorapproval())
		{
			$infosimpan= "1";
		}

		if($infosimpan == "1")
		{
			echo $reqRowId."-".$infopesan;
		}
		else
		{
			echo "xxx-Data gagal disimpan.";	
		}
	}

	function addbatal(){
		$this->load->model("base-cuti/CutiUsulan");

		$reqStatusBerkas= $this->input->post('reqStatusBerkas');
		$reqStatusSebelumBerkas= $this->input->post('reqStatusSebelumBerkas');
		$reqRowId= $this->input->post('reqRowId');
		$reqPegawaiPenandaTanganId= $this->input->post('reqPegawaiPenandaTanganId');

		$infopesan= "Data berhasil disimpan.";
		if($reqStatusBerkas !== $reqStatusSebelumBerkas)
		{
			if($reqStatusBerkas == 0)
			{
				$infopesan= "Data berhasil di batal kirim ke verifikator.";
			}
			else if($reqStatusBerkas == 1)
			{
				$infopesan= "Data berhasil di batal kirim ke Approbval.";
			}
			else if($reqStatusBerkas == 2)
			{
				$infopesan= "Data berhasil di batal kirim ke TTE Surat Cuti.";
			}
		}
		// echo $reqStatusBerkas;exit;

		$set= new CutiUsulan();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("STATUS_BERKAS", $reqStatusBerkas);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));

		$infosimpan= "";
		if($set->updatestatus())
		{
			$infosimpan= "1";
		}

		if($infosimpan == "1")
		{
			echo $reqRowId."-".$infopesan;
		}
		else
		{
			echo "xxx-Data gagal disimpan.";	
		}
	}

	function token_tte()
	{
		$this->load->library('globalteken');
		$vfpeg= new globalteken();

		$reqId= $this->input->get("reqId");
		$reqPassphrase= $this->input->get("reqPassphrase");

		$reqJenis= "cuti-".$reqId;
		$arrparam= array("reqId"=>$reqId, "reqJenis"=>$reqJenis, "reqPassphrase"=>$reqPassphrase);
		$infosimpan= $vfpeg->settoken($arrparam);
		// print_r($infosimpan);exit;
		$status= $infosimpan["status"];
		$info= $infosimpan["info"];

		if($status == "1")
		{
			echo "###Data berhasil teken.";
		}
		else
		{
			// echo "xxx###".$info;
			echo "xxx###Data gagal di teken.";
		}
	}

	function turun_status()
	{
		$this->load->model('base-cuti/CutiUsulanTurunStatus');
		$reqRowId= $this->input->post("reqRowId");
		$reqKeterangan= $this->input->post("reqKeterangan");
		
		$set= new CutiUsulanTurunStatus();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("KETERANGAN", $reqKeterangan);
		$set->setField("POSISI_MENU_ID", "130103");
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		if($set->insert())
			echo $reqRowId."-Data berhasil di turun status";
		else 
			echo "xxx-Data gagal disimpan.";
	}

	function tms_tolak()
	{
		$this->load->model('base-cuti/CutiUsulanTmsTolak');
		$reqRowId= $this->input->post("reqRowId");
		$reqJenis= $this->input->post("reqJenis");
		$reqKeterangan= $this->input->post("reqKeterangan");
		
		$set= new CutiUsulanTmsTolak();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("KETERANGAN", $reqKeterangan);
		$set->setField("JENIS", $reqJenis);
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");

		$infopesan= "Data berhasil di TMS";
		if($reqJenis == "tolak")
			$infopesan= "Data berhasil di Tolak";

		if($set->insert())
			echo $reqRowId."-".$infopesan;
		else 
			echo "xxx-Data gagal disimpan.";
	}

	function status_tms()
	{
		$this->load->model('base-cuti/CutiUsulanTurunStatus');
		
		$reqRowId= $this->input->get("reqRowId");
		$reqStatusTms= $this->input->get("reqStatusTms");
		
		$set= new CutiUsulanTurunStatus();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("STATUS_TMS", ValToNullDB($reqStatusTms));
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		if($set->statusPegawaiTms())
			echo $reqId."-Data berhasil di TMS kan.";
		else 
			echo "xxx-Data gagal disimpan.";
	}

	function status_tolak()
	{
		$this->load->model('base-cuti/CutiUsulan');
		
		$reqRowId= $this->input->get("reqRowId");
		
		$set= new CutiUsulan();
		$set->setField("CUTI_USULAN_ID", $reqRowId);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		if($set->statustolak())
			echo $reqId."-Data berhasil di tolak.";
		else 
			echo "xxx-Data gagal disimpan.";
	}

	function monitoring() 
	{
		$this->load->model('persuratan/SuratMasukBkd');
		$this->load->model("base-cuti/CutiUsulan");

		$set = new CutiUsulan();
		$reqJenis= $this->input->get("reqJenis");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("NIP_BARU", "NAMA_LENGKAP", "JENIS_CUTI_NAMA", "INFO_TANGGAL", "INFO_PROSES", "CUTI_USULAN_ID");
		$aColumnsAlias = $aColumns;

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc ") == 0)
					{
						$sOrder .=" asc , ";
					}else
					{
						$sOrder .=" desc , ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY NOMOR desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LG.LAST_DATE DESC ";
			}
			// echo $sOrder;exit;
		}
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}
		
		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 

		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}
		
		//kalau admin cari satuan kerja aktif n status kelompok pegawai usul 1
		if($this->LOGIN_LEVEL == 99)
		{
			$set_detil= new SuratMasukBkd();
			$reqSatuanKerjaId= $set_detil->getCountByParamsSatuanKerjaIdSurat();
		}
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		$tempLoginLevel= $this->LOGIN_LEVEL;
		if($reqSatuanKerjaId == ""){}
		else
		{
			if($tempLoginLevel == 99){}
			else
			$statement= " AND A.SATUAN_KERJA_ASAL_ID = ".$reqSatuanKerjaId;
		}
		
		if($reqJenis == ""){}
		else
		{
			$statement.= " AND A.JENIS_ID = ".$reqJenis;
		}

		// echo $tempLoginLevel;exit();
		
		$searchJson = "  AND (UPPER(P.NAMA_LENGKAP) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getcountmonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getcountmonitoring(array(), $statement.$searchJson);
		
		$set->selectmonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		// echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$vid= $set->getField("CUTI_USULAN_ID");
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "INFO_TANGGAL")
				{
					// $row[] = getFormattedDate($set->getField("TANGGAL_MULAI"))." s/d ".getFormattedDate($set->getField("TANGGAL_SELESAI"));
					$row[] = getFormattedDate($set->getField("TANGGAL_MULAI"));
				}
				else if($aColumns[$i] == "AKSI")
				{
					$row[] = '';
					/*if($tempLoginLevel == 99)
					{
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}
					else
					{
						if($set->getField("STATUS_KIRIM") == "1")
						$row[] = '';
						else
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}*/
				}
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function inputdinas() 
	{
		$this->load->model('persuratan/SuratMasukBkd');
		$this->load->model("base-cuti/CutiUsulan");

		$set = new CutiUsulan();
		$reqJenis= $this->input->get("reqJenis");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("NOMOR", "NIP_BARU", "NAMA_LENGKAP", "POSISI_MENU_INFO", "AKSI", "STATUS_PERNAH_TURUN", "CUTI_USULAN_ID");
		$aColumnsAlias = $aColumns;

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc ") == 0)
					{
						$sOrder .=" asc , ";
					}else
					{
						$sOrder .=" desc , ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY NOMOR desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LG.LAST_DATE DESC ";
			}
			// echo $sOrder;exit;
		}
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}
		
		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 

		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}
		
		//kalau admin cari satuan kerja aktif n status kelompok pegawai usul 1
		if($this->LOGIN_LEVEL == 99)
		{
			$set_detil= new SuratMasukBkd();
			$reqSatuanKerjaId= $set_detil->getCountByParamsSatuanKerjaIdSurat();
		}
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		$statement= "";
		$tempLoginLevel= $this->LOGIN_LEVEL;
		if($reqSatuanKerjaId == ""){}
		else
		{
			if($tempLoginLevel == 99){}
			else
			$statement= " AND A.SATUAN_KERJA_ASAL_ID = ".$reqSatuanKerjaId;
		}

		// $statement.= " AND A.STATUS_BERKAS NOT IN (99)";
		$searchJson = "  AND (UPPER(P.NAMA_LENGKAP) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getcountmonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getcountmonitoring(array(), $statement.$searchJson);
		
		$set->selectmonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		// echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$vid= $set->getField("CUTI_USULAN_ID");
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "INFO_TANGGAL")
				{
					$row[] = getFormattedDate($set->getField("TANGGAL_MULAI"))." s/d ".getFormattedDate($set->getField("TANGGAL_SELESAI"));
				}
				else if($aColumns[$i] == "STATUS_PERNAH_TURUN")
				{
					$vreturn= "";
					if($set->getField("STATUS_PERNAH_TURUN") == "1")
					{
						if($set->getField("STATUS_KEMBALI") == "1")
						$vreturn= 1;
						else
						$vreturn= 2;
					}

					$row[] = $vreturn;
				}
				else if($aColumns[$i] == "AKSI")
				{
					$row[] = '';
					/*if($tempLoginLevel == 99)
					{
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}
					else
					{
						if($set->getField("STATUS_KIRIM") == "1")
						$row[] = '';
						else
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}*/
				}
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function verifikasi() 
	{
		$this->load->model('persuratan/SuratMasukBkd');
		$this->load->model("base-cuti/CutiUsulan");

		$set = new CutiUsulan();
		$reqJenis= $this->input->get("reqJenis");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("NOMOR", "NIP_BARU", "NAMA_LENGKAP", "POSISI_MENU_INFO", "AKSI", "STATUS_PERNAH_TURUN", "CUTI_USULAN_ID");
		$aColumnsAlias = $aColumns;

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc ") == 0)
					{
						$sOrder .=" asc , ";
					}else
					{
						$sOrder .=" desc , ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY NOMOR desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LG.LAST_DATE DESC ";
			}
			// echo $sOrder;exit;
		}
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}
		
		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 

		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}
		
		//kalau admin cari satuan kerja aktif n status kelompok pegawai usul 1
		if($this->LOGIN_LEVEL == 99)
		{
			$set_detil= new SuratMasukBkd();
			$reqSatuanKerjaId= $set_detil->getCountByParamsSatuanKerjaIdSurat();
		}
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		$tempLoginLevel= $this->LOGIN_LEVEL;
		if($reqSatuanKerjaId == ""){}
		else
		{
			if($tempLoginLevel == 99){}
			else
			$statement= " AND A.SATUAN_KERJA_ASAL_ID = ".$reqSatuanKerjaId;
		}
		
		$statement.= " AND A.STATUS_BERKAS >= 1";
		
		$searchJson = "  AND (UPPER(P.NAMA_LENGKAP) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getcountmonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getcountmonitoring(array(), $statement.$searchJson);
		
		$set->selectmonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		// echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$vid= $set->getField("CUTI_USULAN_ID");
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "INFO_TANGGAL")
				{
					$row[] = getFormattedDate($set->getField("TANGGAL_MULAI"))." s/d ".getFormattedDate($set->getField("TANGGAL_SELESAI"));
				}
				else if($aColumns[$i] == "STATUS_PERNAH_TURUN")
				{
					$vreturn= "";
					if($set->getField("STATUS_PERNAH_TURUN") == "1")
					{
						if($set->getField("STATUS_KEMBALI") == "1")
						$vreturn= 1;
						else
						$vreturn= 2;
					}

					$row[] = $vreturn;
				}
				else if($aColumns[$i] == "AKSI")
				{
					$row[] = '';
					/*if($tempLoginLevel == 99)
					{
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}
					else
					{
						if($set->getField("STATUS_KIRIM") == "1")
						$row[] = '';
						else
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}*/
				}
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function dataapproval() 
	{
		$this->load->model('persuratan/SuratMasukBkd');
		$this->load->model("base-cuti/CutiUsulan");

		$set = new CutiUsulan();
		$reqJenis= $this->input->get("reqJenis");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("NOMOR", "NIP_BARU", "NAMA_LENGKAP", "POSISI_MENU_INFO", "AKSI", "STATUS_PERNAH_TURUN", "CUTI_USULAN_ID");
		$aColumnsAlias = $aColumns;

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc ") == 0)
					{
						$sOrder .=" asc , ";
					}else
					{
						$sOrder .=" desc , ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY NOMOR desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LG.LAST_DATE DESC ";
			}
			// echo $sOrder;exit;
		}
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}
		
		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 

		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}
		
		//kalau admin cari satuan kerja aktif n status kelompok pegawai usul 1
		if($this->LOGIN_LEVEL == 99)
		{
			$set_detil= new SuratMasukBkd();
			$reqSatuanKerjaId= $set_detil->getCountByParamsSatuanKerjaIdSurat();
		}
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		$tempLoginLevel= $this->LOGIN_LEVEL;
		if($reqSatuanKerjaId == ""){}
		else
		{
			if($tempLoginLevel == 99){}
			else
			$statement= " AND A.SATUAN_KERJA_ASAL_ID = ".$reqSatuanKerjaId;
		}
		
		$statement.= " AND A.STATUS_BERKAS >= 2";
		
		$searchJson = "  AND (UPPER(P.NAMA_LENGKAP) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getcountmonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getcountmonitoring(array(), $statement.$searchJson);
		
		$set->selectmonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		// echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$vid= $set->getField("CUTI_USULAN_ID");
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "INFO_TANGGAL")
				{
					$row[] = getFormattedDate($set->getField("TANGGAL_MULAI"))." s/d ".getFormattedDate($set->getField("TANGGAL_SELESAI"));
				}
				else if($aColumns[$i] == "STATUS_PERNAH_TURUN")
				{
					$vreturn= "";
					if($set->getField("STATUS_PERNAH_TURUN") == "1")
					{
						if($set->getField("STATUS_KEMBALI") == "1")
						$vreturn= 1;
						else
						$vreturn= 2;
					}

					$row[] = $vreturn;
				}
				else if($aColumns[$i] == "AKSI")
				{
					$row[] = '';
					/*if($tempLoginLevel == 99)
					{
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}
					else
					{
						if($set->getField("STATUS_KIRIM") == "1")
						$row[] = '';
						else
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}*/
				}
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	function datateken() 
	{
		$this->load->model('persuratan/SuratMasukBkd');
		$this->load->model("base-cuti/CutiUsulan");

		$set = new CutiUsulan();
		$m= $this->input->get("m");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);

		$aColumns = array("NOMOR", "NIP_BARU", "NAMA_LENGKAP", "POSISI_MENU_INFO", "AKSI", "STATUS_PERNAH_TURUN", "CUTI_USULAN_ID");
		$aColumnsAlias = $aColumns;

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = " ORDER BY ";
			 
			//Go over all sorting cols
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				//If need to sort by current col
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					//Add to the order by clause
					$sOrder .= $aColumnsAlias[ intval( $_GET['iSortCol_'.$i] ) ];
					 
					//Determine if it is sorted asc or desc
					if (strcasecmp(( $_GET['sSortDir_'.$i] ), "asc ") == 0)
					{
						$sOrder .=" asc , ";
					}else
					{
						$sOrder .=" desc , ";
					}
				}
			}
			
			 
			//Remove the last space / comma
			$sOrder = substr_replace( $sOrder, "", -2 );
			
			//Check if there is an order by clause
			if ( trim($sOrder) == "ORDER BY NOMOR desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY LG.LAST_DATE DESC ";
			}
			// echo $sOrder;exit;
		}
		 
		/*
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables.
		 */
		$sWhere = "";
		$nWhereGenearalCount = 0;
		if (isset($_GET['sSearch']))
		{
			$sWhereGenearal = $_GET['sSearch'];
		}
		else
		{
			$sWhereGenearal = '';
		}
		
		if ( $_GET['sSearch'] != "" )
		{
			//Set a default where clause in order for the where clause not to fail
			//in cases where there are no searchable cols at all.
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumnsAlias)+1 ; $i++ )
			{
				//If current col has a search param
				if ( $_GET['bSearchable_'.$i] == "true" )
				{
					//Add the search to the where clause
					$sWhere .= $aColumnsAlias[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
					$nWhereGenearalCount += 1;
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		 

		/* Individual column filtering */
		$sWhereSpecificArray = array();
		$sWhereSpecificArrayCount = 0;
		for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
		{
			if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
			{
				//If there was no where clause
				if ( $sWhere == "" )
				{
					$sWhere = "AND ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				 
				//Add the clause of the specific col to the where clause
				$sWhere .= $aColumnsAlias[$i]." LIKE '%' || :whereSpecificParam".$sWhereSpecificArrayCount." || '%' ";
				 
				//Inc sWhereSpecificArrayCount. It is needed for the bind var.
				//We could just do count($sWhereSpecificArray) - but that would be less efficient.
				$sWhereSpecificArrayCount++;
				 
				//Add current search param to the array for later use (binding).
				$sWhereSpecificArray[] =  $_GET['sSearch_'.$i];
				 
			}
		}
		 
		//If there is still no where clause - set a general - always true where clause
		if ( $sWhere == "" )
		{
			$sWhere = " AND 1=1";
		}
		//Bind variables.
		if ( isset( $_GET['iDisplayStart'] ))
		{
			$dsplyStart = $_GET['iDisplayStart'];
		}
		else{
			$dsplyStart = 0;
		}
		 
		if ( isset( $_GET['iDisplayLength'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$dsplyRange = $_GET['iDisplayLength'];
			if ($dsplyRange > (2147483645 - intval($dsplyStart)))
			{
				$dsplyRange = 2147483645;
			}
			else
			{
				$dsplyRange = intval($dsplyRange);
			}
		}
		else
		{
			$dsplyRange = 2147483645;
		}
		
		//kalau admin cari satuan kerja aktif n status kelompok pegawai usul 1
		if($this->LOGIN_LEVEL == 99)
		{
			$set_detil= new SuratMasukBkd();
			$reqSatuanKerjaId= $set_detil->getCountByParamsSatuanKerjaIdSurat();
		}
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		
		$tempLoginLevel= $this->LOGIN_LEVEL;
		if($reqSatuanKerjaId == ""){}
		else
		{
			if($tempLoginLevel == 99){}
			else
			$statement= " AND A.SATUAN_KERJA_ASAL_ID = ".$reqSatuanKerjaId;
		}
		
		if(!empty($m))
		{
			$statement.= " AND A.MENU_PENANDA_TANGAN_ID = '".$m."'";
		}

		$statement.= " AND A.STATUS_BERKAS >= 3";
		
		$searchJson = "  AND (UPPER(P.NAMA_LENGKAP) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getcountmonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getcountmonitoring(array(), $statement.$searchJson);
		
		$set->selectmonitoring(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		// echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$vid= $set->getField("CUTI_USULAN_ID");
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "INFO_TANGGAL")
				{
					$row[] = getFormattedDate($set->getField("TANGGAL_MULAI"))." s/d ".getFormattedDate($set->getField("TANGGAL_SELESAI"));
				}
				else if($aColumns[$i] == "STATUS_PERNAH_TURUN")
				{
					$vreturn= "";
					if($set->getField("STATUS_PERNAH_TURUN") == "1")
					{
						if($set->getField("STATUS_KEMBALI") == "1")
						$vreturn= 1;
						else
						$vreturn= 2;
					}

					$row[] = $vreturn;
				}
				else if($aColumns[$i] == "AKSI")
				{
					$row[] = '';
					/*if($tempLoginLevel == 99)
					{
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}
					else
					{
						if($set->getField("STATUS_KIRIM") == "1")
						$row[] = '';
						else
						$row[] = '<a href="javascript:void(0)" onclick="hapusdata(\''.$vid.'\')" class="round waves-effect waves-light red white-text" title="Hapus" ><i class="mdi-action-delete"></i></a>';
					}*/
				}
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

}
?>