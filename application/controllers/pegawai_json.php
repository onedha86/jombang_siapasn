<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/encrypt.func.php");

class pegawai_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		// echo "asd";exit();
		//kauth
		if (!$this->kauth->getInstance()->hasIdentity())
		{
			$callfunction= $this->uri->segment(2, "");
			// echo $callfunction;exit;

			if($callfunction == "dekripdata" || $callfunction == "enkripdata"){}
			else
			{
				// trow to unauthenticated page!
				redirect('app');
			}
		}       
		
		/* GLOBAL VARIABLE */
		$this->USER_GROUP= $this->kauth->getInstance()->getIdentity()->USER_GROUP;
		$this->LOGIN_USER= $this->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$this->LOGIN_LEVEL= $this->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$this->SATUAN_KERJA_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_ID;
		$this->SATUAN_KERJA_TIPE= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_TIPE;
		$this->SATUAN_KERJA_BKD_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_BKD_ID;
		$this->LOGIN_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$this->LOGIN_PEGAWAI_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;
		$this->STATUS_SATUAN_KERJA_BKD= $this->kauth->getInstance()->getIdentity()->STATUS_SATUAN_KERJA_BKD;
	}
		
	function json() 
	{
		$this->load->model('Pegawai');
		$this->load->model('SatuanKerja');

		$set = new Pegawai();
		
		$reqSatuanKerjaId= $this->input->get("reqSatuanKerjaId");
		$reqSatuanKerjaTeknisId= $tempSatuanKerjaId= $reqSatuanKerjaId;

		$reqStatusPegawaiId= $this->input->get("reqStatusPegawaiId");
		$cekquery= $this->input->get("c");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		
		$aColumns = array("PEGAWAI_INFO", "NIP_BARU_LAMA", "NAMA_LENGKAP", "GOL_TMT", "JABATAN_TMT_ESELON", "SATUAN_KERJA_NAMA", "SATUAN_KERJA_INDUK", "STATUS_BERLAKU", "PEGAWAI_ID");
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
			if ( trim($sOrder) == "ORDER BY PEGAWAI_INFO desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				// $sOrder = " ORDER BY JAB_RIW.ESELON_ID ASC, PANG_RIW.PANGKAT_ID DESC, PANG_RIW.TMT_PANGKAT ASC";
				$sOrder = " ORDER BY A.ESELON_ID ASC, A.PANGKAT_ID DESC, A.TMT_PANGKAT ASC";
				 
			}
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
		
		if($reqSatuanKerjaId == "")
		{
			$tempSatuanKerjaId= $reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}
		// echo $reqSatuanKerjaId;exit();
		

		// "Dinas Pendidikan"
		// $reqSatuanKerjaId=83;

		// "Badan Kepegawaian Daerah, Pendidikan dan Pelatihan"
		// $reqSatuanKerjaId=66;

		// "DINAS PENDIDIKAN"
		// $reqSatuanKerjaId=16;
		// $statement.= " AND A.PEGAWAI_ID = 6317";
		$statementAktif= "";
		if($reqSatuanKerjaId == "")
		{
			if(isStrContain(strtoupper($this->USER_GROUP), "TEKNIS") == "1" || $this->STATUS_SATUAN_KERJA_BKD == 1)
			{
				$statementAktif= " AND EXISTS(
				SELECT 1 FROM SATUAN_KERJA S WHERE 1=1 AND COALESCE(MASA_BERLAKU_AWAL,CURRENT_DATE) <= CURRENT_DATE AND COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE) >= COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE)
				AND A.SATUAN_KERJA_ID = S.SATUAN_KERJA_ID
				)";
			}
		}
		else
		{
			$statementAktif= " AND EXISTS(
			SELECT 1 FROM SATUAN_KERJA S WHERE 1=1 AND COALESCE(MASA_BERLAKU_AWAL,CURRENT_DATE) <= CURRENT_DATE AND COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE) >= COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE)
			AND A.SATUAN_KERJA_ID = S.SATUAN_KERJA_ID
			)";
			
			if(isStrContain(strtoupper($this->USER_GROUP), "TEKNIS") == "1" || $this->STATUS_SATUAN_KERJA_BKD == 1)
			{
				if(isStrContain(strtoupper($this->USER_GROUP), "TEKNIS") == "1" && $reqSatuanKerjaTeknisId == ""){}
				else
				{
					$reqSatuanKerjaId= "";
					if($tempSatuanKerjaId == ""){}
					else
					{
						$reqSatuanKerjaId= $tempSatuanKerjaId;
						$skerja= new SatuanKerja();
						$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
						unset($skerja);
						//echo $reqSatuanKerjaId;exit;
						$statement= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
					}
				}
			}
			else
			{
				// echo $reqSatuanKerjaId;exit();
				// echo $this->SATUAN_KERJA_TIPE;exit();
				$skerja= new SatuanKerja();
				// if($this->SATUAN_KERJA_TIPE == "1")
				// {
				// 	$reqSatuanKerjaId= $skerja->getSatuanKerjaTipe($reqSatuanKerjaId, $this->SATUAN_KERJA_TIPE);
				// }
				// else
				// {
					$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
				// }
				// echo $skerja->query;exit();
				unset($skerja);
				// echo $reqSatuanKerjaId;exit;
				$statement= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
				//$statement= " AND ( A.SATUAN_KERJA_ID = ANY( AMBIL_ID_SATUAN_KERJA_TREE_ARRAY(".$reqSatuanKerjaId.") ) OR A.SATUAN_KERJA_ID = ".$reqSatuanKerjaId." )";
			}
		}
		// echo $statement;exit();

		if($reqStatusPegawaiId == ""){}
		else if($reqStatusPegawaiId == "126")
		{
			$statement.= " AND A.STATUS_PEGAWAI_ID IN (1,2,6)";
		}
		else if($reqStatusPegawaiId == "12")
		{
			$statement.= " AND A.STATUS_PEGAWAI_ID IN (1,2)";
		}
		else if($reqStatusPegawaiId == "hk")
		{
			$statement.= " AND EXISTS(SELECT 1 FROM HUKUMAN_TERAKHIR WHERE CURRENT_DATE <= G.TANGGAL_AKHIR AND CURRENT_DATE >= G.TANGGAL_MULAI)";
		}
		else if($reqStatusPegawaiId == "pk")
		{
			$statement.= " AND EXISTS(SELECT 1 FROM HUKUMAN_TERAKHIR WHERE CURRENT_DATE >= G.TANGGAL_AKHIR)";
		}
		else if(isStrContain($reqStatusPegawaiId, "spk"))
		{
			$reqStatusPegawaiId= str_replace("spk", "", $reqStatusPegawaiId);
			$statement.= " AND A.PEGAWAI_ID IN (SELECT B.PEGAWAI_ID FROM STATUS_PEGAWAI_KEDUDUKAN A INNER JOIN PEGAWAI B ON A.STATUS_PEGAWAI_ID = B.STATUS_PEGAWAI_ID WHERE A.STATUS_PEGAWAI_KEDUDUKAN_ID = ".$reqStatusPegawaiId.")";
		}
		else
		{
			$statement.= " AND A.STATUS_PEGAWAI_ID = ".$reqStatusPegawaiId;
		}
		
		// $_GET['sSearch']= "196105041985091001";
		// echo $statement;exit;
		$searchJson= " AND (UPPER(A.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_LAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(A.NIP_BARU) LIKE '%".strtoupper($_GET['sSearch'])."%') ";
		$allRecord = $set->getCountByParamsMonitoring(array(), $statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getCountByParamsMonitoring(array(), $statement.$searchJson);

		if($cekquery == "jml")
		{
			echo $set->query;exit;
		}
		
		$set->selectByParamsMonitoringPegawai(array(), $dsplyRange, $dsplyStart, $statement.$searchJson, $sOrder);
		if(!empty($cekquery))
		{
			echo $set->query;exit;
		}
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($set->getField($aColumns[$i]));
				else if($aColumns[$i] == "PEGAWAI_INFO")
				{
					$tempPath= $set->getField("PATH");
					if($tempPath == "")
					$tempPath= "images/foto-profile.jpg";
					
					// $row[] = $tempPath;
					// $row[] = '<img src="'.$tempPath.'" style="width:100%;height:100%" />';
					$row[] = '<img src="'.$tempPath.'" style="width:60px;height:90px" />';
					// $row[] = '';
					// $row[] = '<img src="'.$tempPath.'" style="width:70%;height:20vh" />';
					// $row[] = '<img src="'.$tempPath.'" style="width:100px;height:120px" />';
					// $row[] = '<img src="'.$tempPath.'" style="width:10px;height:12px" />';
				}
				else if($aColumns[$i] == "NIP_BARU_LAMA")
					$row[] = $set->getField("NIP_BARU")."<br/>".$set->getField("NIP_LAMA");
				else if($aColumns[$i] == "GOL_TMT")
					$row[] = $set->getField("PANGKAT_RIWAYAT_KODE")."<br/>".dateToPageCheck($set->getField("PANGKAT_RIWAYAT_TMT"));
				else if($aColumns[$i] == "JABATAN_TMT_ESELON")
					$row[] = $set->getField("JABATAN_RIWAYAT_NAMA")."<br/>".dateTimeToPageCheck($set->getField("JABATAN_RIWAYAT_TMT"))."<br/>".$set->getField("JABATAN_RIWAYAT_ESELON");
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	function add()
	{
		$this->load->model('Pegawai');
		
		$set = new Pegawai();
		
		$reqId = $this->input->post("reqId");
		$reqMode = $this->input->post("reqMode");
		$reqStatus = $this->input->post("reqStatus");
		$reqSatuanKerjaId = $this->input->post("reqSatuanKerjaId");
		$reqJenisPegawai = $this->input->post("reqJenisPegawai");
		$reqTipePegawai = $this->input->post("reqTipePegawai");
		$reqStatusPegawai = $this->input->post("reqStatusPegawai");
		$reqNipLama = $this->input->post("reqNipLama");
		$reqNipBaru = $this->input->post("reqNipBaru");
		$reqNama = $this->input->post("reqNama");
		$reqGelarDepan = $this->input->post("reqGelarDepan");
		$reqGelarBelakang = $this->input->post("reqGelarBelakang");
		$reqTempatLahir = $this->input->post("reqTempatLahir");
		$reqTanggalLahir = $this->input->post("reqTanggalLahir");
		$reqJenisKelamin = $this->input->post("reqJenisKelamin");
		$reqStatusKawin = $this->input->post("reqStatusKawin");
		$reqSukuBangsa = $this->input->post("reqSukuBangsa");
		$reqGolonganDarah = $this->input->post("reqGolonganDarah");
		$reqEmail = $this->input->post("reqEmail");
		$reqAlamat = $this->input->post("reqAlamat");
		$reqRt = $this->input->post("reqRt");
		$reqRw = $this->input->post("reqRw");
		$reqKodePos = $this->input->post("reqKodePos");
		$reqTelepon = $this->input->post("reqTelepon");
		$reqHp = $this->input->post("reqHp");
		$reqKartuPegawai = $this->input->post("reqKartuPegawai");
		$reqAskes = $this->input->post("reqAskes");
		$reqTaspen = $this->input->post("reqTaspen");
		$reqNpwp = $this->input->post("reqNpwp");
		$reqNik = $this->input->post("reqNik");
		$reqNoRekening = $this->input->post("reqNoRekening");
		$reqSkKonversiNip = $this->input->post("reqSkKonversiNip");
		$reqBank = $this->input->post("reqBank");
		$reqAgama = $this->input->post("reqAgama");
		$reqPegawaiKedudukanNama = $this->input->post("reqPegawaiKedudukanNama");
		$reqUrut= $this->input->post("reqUrut");
		$reqNoKk= $this->input->post("reqNoKk");
		$reqNoRakBerkas= $this->input->post("reqNoRakBerkas");
		$reqTeleponKantor= $this->input->post("reqTeleponKantor");
		$reqFacebook= $this->input->post("reqFacebook");
		$reqTwitter= $this->input->post("reqTwitter");
		$reqWhatsApp= $this->input->post("reqWhatsApp");
		$reqTelegram= $this->input->post("reqTelegram");
		$reqKeterangan1= $this->input->post("reqKeterangan1");
		$reqKeterangan2= $this->input->post("reqKeterangan2");

		$reqDesaId= $this->input->post("reqDesaId");
		$reqKecamatanId= $this->input->post("reqKecamatanId");
		$reqKabupatenId= $this->input->post("reqKabupatenId");
		$reqPropinsiId= $this->input->post("reqPropinsiId");

		$reqJenisPegawaiId= $this->input->post("reqJenisPegawaiId");
		$reqBpjs= $this->input->post("reqBpjs");
		$reqBpjsTanggal= $this->input->post("reqBpjsTanggal");
		$reqNpwpTanggal= $this->input->post("reqNpwpTanggal");
		$reqAlamatKeterangan= $this->input->post("reqAlamatKeterangan");

		$reqEmailKantor= $this->input->post("reqEmailKantor");
		$reqRekeningNama= $this->input->post("reqRekeningNama");
		$reqGajiPokok= $this->input->post("reqGajiPokok");
		$reqTunjangan= $this->input->post("reqTunjangan");
		$reqTunjanganKeluarga= $this->input->post("reqTunjanganKeluarga");
		$reqGajiBersih= $this->input->post("reqGajiBersih");
		$reqStatusMutasi= $this->input->post("reqStatusMutasi");
		$reqTmtMutasi= $this->input->post("reqTmtMutasi");
		$reqInstansiSebelum= $this->input->post("reqInstansiSebelum");

		$set->setField('EMAIL_KANTOR', $reqEmailKantor);
		$set->setField('REKENING_NAMA', $reqRekeningNama);
		$set->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqGajiPokok)));
		$set->setField("TUNJANGAN", ValToNullDB(dotToNo($reqTunjangan)));
		$set->setField("TUNJANGAN_KELUARGA", ValToNullDB(dotToNo($reqTunjanganKeluarga)));
		$set->setField("GAJI_BERSIH", ValToNullDB(dotToNo($reqGajiBersih)));
		$set->setField('STATUS_MUTASI', ValToNullDB($reqStatusMutasi));
		$set->setField('TMT_MUTASI', dateToDBCheck($reqTmtMutasi));
		$set->setField('INSTANSI_SEBELUM', $reqInstansiSebelum);

		$reqTanggalLahir= substr($reqNipBaru,6,2)."-".substr($reqNipBaru,4,2)."-".substr($reqNipBaru,0,4);
		$set->setField('SATUAN_KERJA_ID', $reqSatuanKerjaId);
		$set->setField('NIP_LAMA', $reqNipLama);
		$set->setField('NIP_BARU', $reqNipBaru);
		$set->setField('NAMA', $reqNama);
		$set->setField('GELAR_DEPAN', $reqGelarDepan);
		$set->setField('GELAR_BELAKANG', $reqGelarBelakang);
		$set->setField('TEMPAT_LAHIR', $reqTempatLahir);
		$set->setField('TANGGAL_LAHIR', dateToDBCheck($reqTanggalLahir));
		$set->setField('JENIS_KELAMIN', $reqJenisKelamin);
		$set->setField('STATUS_KAWIN', $reqStatusKawin);
		$set->setField('SUKU_BANGSA', $reqSukuBangsa);
		$set->setField('GOLONGAN_DARAH', $reqGolonganDarah);
		$set->setField('EMAIL', $reqEmail);
		$set->setField('ALAMAT', $reqAlamat);
		$set->setField('RT', $reqRt);
		$set->setField('RW', $reqRw);
		$set->setField('KODEPOS', $reqKodePos);
		$set->setField('TELEPON', $reqTelepon);
		$set->setField('HP', $reqHp);
		$set->setField('KARTU_PEGAWAI', $reqKartuPegawai);
		$set->setField('ASKES', $reqAskes);
		$set->setField('TASPEN', $reqTaspen);
		$set->setField('NPWP', $reqNpwp);
		$set->setField('NIK', $reqNik);
		$set->setField('NO_REKENING', $reqNoRekening);
		$set->setField('SK_KONVERSI_NIP', $reqSkKonversiNip);
		$set->setField('BANK_ID', ValToNullDB($reqBank));
		$set->setField('AGAMA_ID', $reqAgama);
		$set->setField('KEDUDUKAN', $reqPegawaiKedudukanNama);
		$set->setField('NO_URUT', $reqUrut);
		$set->setField('NO_KK', $reqNoKk);
		$set->setField('NO_RAK_BERKAS', $reqNoRakBerkas);
		$set->setField('TELEPON_KANTOR', $reqTeleponKantor);
		$set->setField('FACEBOOK', $reqFacebook);
		$set->setField('TWITTER', $reqTwitter);
		$set->setField('WHATSAPP', $reqWhatsApp);
		$set->setField('TELEGRAM', $reqTelegram);
		$set->setField('KETERANGAN_1', $reqKeterangan1);
		$set->setField('KETERANGAN_2', $reqKeterangan2);
		
		$set->setField('PROPINSI_ID', ValToNullDB($reqPropinsiId));
		$set->setField('KABUPATEN_ID', ValToNullDB($reqKabupatenId));
		$set->setField('KECAMATAN_ID', ValToNullDB($reqKecamatanId));
		$set->setField('DESA_ID', ValToNullDB($reqDesaId));

		$set->setField('JENIS_PEGAWAI_ID', ValToNullDB($reqJenisPegawaiId));

		$set->setField('BPJS', $reqBpjs);
		$set->setField('BPJS_TANGGAL', dateToDBCheck($reqBpjsTanggal));
		$set->setField('NPWP_TANGGAL', dateToDBCheck($reqNpwpTanggal));
		$set->setField('ALAMAT_KETERANGAN', $reqAlamatKeterangan);
		
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set->setField("LAST_DATE", "NOW()");
		
		if($reqMode == "insert")
		{
			if($set->insert())
			{
				$reqId= $set->id;
				echo $reqId."-Data berhasil disimpan.";
			}
			else
				echo "xxx-Data gagal disimpan.";
		}
		else
		{
			$set->setField('PEGAWAI_ID', $reqId); 
			if($set->update())
			{
				echo $reqId."-Data berhasil disimpan.";
			}
			else
				echo "xxx-Data gagal disimpan.";
		}
		// echo $set->query;exit;
		
	}
	
	function delete()
	{
		$this->load->model('Pegawai');
		$set = new Pegawai();
		
		$reqId =  $this->input->get('reqId');
		$set->setField("PEGAWAI_ID", $reqId);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set->setField("LAST_DATE", "NOW()");
		
		if($set->delete())
			$arrJson["PESAN"] = "Data berhasil dihapus.";
		else
			$arrJson["PESAN"] = "Data gagal dihapus.";		
		
		echo json_encode($arrJson);
	}
	
	function auto() 
	{
		$this->load->model("Pegawai");
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		if(empty($search_term))
		{
			$search_term = isset($_GET['term']) ? $_GET['term'] : "";
		}
		
		$set = new Pegawai();
		
		//$statement= " AND A.STATUS IS NULL";
		//$statement.= " AND UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' ";
		$statement.= " AND (UPPER(A.NIP_BARU) LIKE '".strtoupper($search_term)."%' OR UPPER(A.NAMA) LIKE '".strtoupper($search_term)."%') ";
		
		$set->selectByParamsSimple(array(), 70, 0, $statement);
		//echo $set->query;exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			//$arr_json[$i]['label'] = $set->getField("NAMA");
			$arr_json[$i]['label'] = $set->getField("NIP_BARU");
			$arr_json[$i]['desc'] = $set->getField("NIP_BARU")."<br/><label style='font-size:12px'>".$set->getField("NAMA")."</label>";
			$i++;
		}
		echo json_encode($arr_json);		
		
	}
	
	function combo() 
	{
		$this->load->model("Eselon");
		$set = new Eselon();
		
		$set->selectByParams();
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("BANK_ID");
			$arr_json[$i]['text'] = $set->getField("NAMA");	
			$i++;
		}
		echo json_encode($arr_json);		
		
	}	

	function log() 
	{
		$this->load->model('PegawaiLog');

		$set = new PegawaiLog();
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		
		$aColumns = array("INFO_LOG", "LAST_USER", "LAST_DATE", "STATUS_NAMA", "PEGAWAI_ID");
		$aColumnsAlias = array("INFO_LOG", "LAST_USER", "LAST_DATE", "STATUS_NAMA", "PEGAWAI_ID");

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
			if ( trim($sOrder) == "ORDER BY INFO_LOG desc" )
			{
				/*
				* If there is no order by clause - ORDER BY INDEX COLUMN!!! DON'T DELETE IT!
				* If there is no order by clause there might be bugs in table display.
				* No order by clause means that the db is not responsible for the data ordering,
				* which means that the same row can be displayed in two pages - while
				* another row will not be displayed at all.
				*/
				$sOrder = " ORDER BY A.LAST_DATE ASC ";
				 
			}
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
		
		// $searchJson = "  AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getCountByParams(array());
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getCountByParams(array(), $searchJson);
		
		$set->selectByParams(array(), $dsplyRange, $dsplyStart, $searchJson, $sOrder);
		//echo $set->query;exit;
		/* Output */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $allRecord,
			"iTotalDisplayRecords" => $allRecordFilter,
			"aaData" => array()
		);
		 
		while($set->nextRow())
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "TANGGAL")
					$row[] = getFormattedDate($set->getField($aColumns[$i]));
				else if($aColumns[$i] == "PEGAWAI_INFO")
					//$row[] = truncate($set->getField($aColumns[$i]), 5)."...";
					$row[] = '<img src="images/foto-profile.jpg" />';
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	function set_info_pegawai_nama_data()
	{
		$this->load->model('Pegawai');

		$set = new Pegawai();
		$reqId= $this->input->get("reqId");
		
		$statement= " AND A.PEGAWAI_ID = ".$reqId;
		$set->selectByParams(array(), -1, -1, $statement);
		$set->firstRow();
		$tempInfo= $set->getField("NAMA_LENGKAP");
		echo $tempInfo;exit;
	}
	
	function set_info_pegawai_data()
	{
		$this->load->model('Pegawai');
		$this->load->model('PegawaiFile');

		$set = new Pegawai();
		$reqId= $this->input->get("reqId");
		
		$statement= " AND A.PEGAWAI_ID = ".$reqId;
		$set->selectByParamsMonitoring(array(), -1, -1, $statement);
		$set->firstRow();
		$tempNama= $set->getField("NAMA_LENGKAP");
		$tempNipBaru= $set->getField("NIP_BARU");
		$tempPangkatNama= $set->getField("PANGKAT_RIWAYAT_KODE");
		$tempJabatanNama= $set->getField("JABATAN_RIWAYAT_NAMA");
		
		$set_detil= new PegawaiFile();
		$statement= " AND A.RIWAYAT_TABLE = 'PEGAWAI' AND A.RIWAYAT_ID = 1 AND A.PEGAWAI_ID = ".$reqId;
		$set_detil->selectByParamsLastRiwayatTable(array(), -1, -1, $statement);
		$set_detil->firstRow();
		//echo $set_detil->query;exit;
		$tempPath= $set_detil->getField("PATH");
		
		if($tempPath == "")
		$tempPath= "images/foto-profile.jpg";
		
		$tempInfo='<div class="profil-photo-wrap">
			<img src="'.$tempPath.'" alt="" class="circle responsive-img valign profile-image">
		</div>
		<table class="table bordered striped black-text">
			<tbody >
				<tr>
					<td><b>NAMA</b></td>
					<td>'.$tempNama.'</td>
				</tr>

				<tr>
					<td><b>NIP</b></td>
					<td>'.$tempNipBaru.'</td>
				</tr>
				<tr>
					<td><b>Pangkat</b></td>
					<td>'.$tempPangkatNama.'</td>
				</tr>
				<tr>
					<td><b>Jabatan</b></td>
					<td>
						<span class="truncate">'.$tempJabatanNama.'</span>
					</td>
				</tr>
				<tr style="cursor:pointer" onclick="showhidemenu()">
					<td><i class="mdi-action-dashboard"></i></td>
					<td>Show / Hide Menu</td>
				</tr>
			</tbody>
		</table>';
		echo $tempInfo;
	}
	
	function nama_pegawai() 
	{
		$this->load->model("Pegawai");
		$this->load->model('SatuanKerja');
		
		$reqSatuanKerjaId= $this->input->get("reqSatuanKerjaId");
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		
		$set = new Pegawai();
		
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
			$statement= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
			//$statement= " AND ( A.SATUAN_KERJA_ID = ANY( AMBIL_ID_SATUAN_KERJA_TREE_ARRAY(".$reqSatuanKerjaId.") ) OR A.SATUAN_KERJA_ID = ".$reqSatuanKerjaId." )";
		}
		

		$statement.= " AND (UPPER(A.NAMA) LIKE '%".strtoupper($search_term)."%' OR UPPER(A.NIP_BARU) LIKE '%".strtoupper($search_term)."%' ) ";
		$set->selectByParamsMonitoring(array(), 70, 0, $statement);
		//echo $set->query;exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			$arr_json[$i]['label'] = $set->getField("NAMA_LENGKAP");
			$arr_json[$i]['desc'] = $set->getField("NAMA_LENGKAP")."<br/><label style='font-size:12px'>".$set->getField("NIP_BARU")."</label>";
			$i++;
		}
		echo json_encode($arr_json);		
		
	}

	function cari_pegawai()
	{
		$this->load->model("Pegawai");
		
		$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";
		
		$reqId= $this->input->get("reqId");
        $reqMode= $this->input->get("reqMode");
		
		$set= new Pegawai();
		$statement.= " AND UPPER(A.NIP_BARU) LIKE '%".strtoupper(str_replace(" ", "", $search_term))."%' ";
		
		// if($reqSatuanKerjaId == "")
		// {
		// 	$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		// }
		
		// if($reqSatuanKerjaId == ""){}
		// else
		// {
		// 	$skerja= new SatuanKerja();
		// 	$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
		// 	unset($skerja);
		// 	//echo $reqSatuanKerjaId;exit;
		// 	$statement.= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
		// }

		$set->selectsimplepegawai(array(), 10, 0, $statement);
		//echo $set->query;exit;
		$arr_json = array();
		$i = 0;
		while($set->nextRow())
		{
			$arr_json[$i]['id'] = $set->getField("PEGAWAI_ID");
			$arr_json[$i]['label'] = $set->getField("NIP_BARU");
			$arr_json[$i]['desc'] = $set->getField("NIP_BARU")."<br/><label style='font-size:12px'>".$set->getField("NAMA_LENGKAP")."</label>";
			$arr_json[$i]['namapegawai'] = $set->getField("NAMA_LENGKAP");
			$i++;
		}
		echo json_encode($arr_json);
	}

	function getidsatuankerja()
	{
		$this->load->model('SatuanKerja');

		// PENDIDIKAN
		// $arrsatuankerja= array(803, 804, 736, 737, 738, 739, 740, 741, 742, 743, 744, 745, 746, 747, 748, 749, 750, 751, 752, 753, 754, 755, 756, 757, 758, 759, 760, 761, 762, 763, 764, 765, 767, 768, 769, 770, 771, 772, 773, 774, 775, 776, 777, 778, 779, 780, 735, 766, 782, 783, 784, 785, 786, 787, 788, 789, 790, 791, 792, 793, 794, 795, 796, 797, 798, 799, 800, 801, 802);

		$arrsatuankerja= array(83);

		// BADANG KEPAGAWAIAN
		// $arrsatuankerja= array(66);
		// print_r($arrsatuankerja);exit();
		// 66,599,600,601,602,603,2369,2370,2371,2372,2373,2374,2375,2376,2377,2378,2379
		
		// DINAS Pendidikan
		// $arrsatuankerja= array(83);
		// 83,782,783,784,785,786,787,788,789,790,791,792,793,794,795,796,797,798,799,800,801,737,738,758,759,739,740,741,780,744,745,746,747,748,749,750,761,752,753,754,755,756,757,762,763,729,730,731,732,733,781,764,765,766,767,768,769,770,771,772,773,774,775,776,777,778,779,742,743,734,728,802,803,804,735,736,760,751,2604,2815,2857,2858,2859,2871,2872,2873,2874,2875,2876,2877,2878,2879,2880,2881,2882,2883,2884,2885,3320,2907,3021,3022,3403,2666,2667,2668,2670,2671,2672,2678,2624,2679,2625,2626,2627,2628,2629,2630,2631,2632,2633,2634,2635,2636,2637,2638,2639,2640,2680,2681,2682,2683,2684,2685,2693,2694,2695,2696,2697,2698,2699,2700,2701,2690,2691,2730,2731,2605,2702,2703,2704,2764,3086,2860,2861,2870,2826,2827,2886,2887,2888,2889,2890,3441,3479,3508,3509,3510,3511,3512,3513,3514,3515,3516,3494,3517,2662,3544,3545,3546,3547,3548,3549,3550,3551,3552,3553,2962,3189,3254,3265,3240,3241,3242,3299,3300,3301,3302,3303,3304,3305,3306,3307,3308,3065,3067,3264,3151,3152,3153,3154,3194,3195,3196,3255,3256,3257,3258,2960,3351,3360,3361,2614,2615,3424,3425,3426,3432,2928,2929,3181,2902,2903,2904,2905,2906,2908,2909,2910,2911,2912,2913,2914,2915,2916,2921,3459,3476,2799,2800,2801,3384,3815,3201,3214,2891,3343,3344,3345,3346,3478,3480,3496,3497,3498,3499,3500,3501,3502,3503,3504,3352,3238,3309,3310,2673,2674,2675,2676,2677,2941,2959,3212,3213,3355,3356,3357,3358,2798,2917,2918,2919,2920,2922,2923,2924,2925,2926,2931,2932,2933,2942,2943,2944,2945,2927,3019,3020,3023,3024,3025,3026,3027,2999,3028,3029,3030,3031,3032,3033,3085,3087,3088,3089,3090,3091,3092,3093,3094,3095,3096,3097,3098,3099,3100,3101,3117,3118,3119,3120,3121,3122,3123,3124,3125,2842,2843,2844,2866,2705,2706,2707,2708,2709,2710,2711,2712,2713,2714,2715,2716,2717,2718,2719,3126,3127,3128,3182,3183,3274,3275,3276,3277,3442,2720,2721,2722,3443,3444,3445,3446,3447,3448,3449,3450,3451,3452,3453,3454,3455,3456,3457,3458,3460,3461,3462,3463,3464,3465,3474,3475,3477,3495,3244,3245,3246,3247,3248,3249,3250,3251,3252,3253,2723,2724,2725,2733,2734,2735,2736,2737,2738,3554,3555,3556,3557,3559,3560,3561,3562,3422,3423,3433,3434,3435,3436,3437,3518,3519,3520,3521,3522,3536,3184,2726,2727,2728,2729,2739,3202,3203,3204,3205,3206,3207,3208,3209,3210,3211,2740,2741,2742,2743,2744,2745,2746,2747,2748,2749,2750,2751,2752,2753,2754,2755,2756,2757,2758,2759,2760,2761,2762,2763,2765,3353,3354,2946,2948,2949,2950,2951,2952,2953,2954,2930,2968,2969,2970,2971,2972,2973,2974,2975,2976,2977,2978,2979,2980,2981,2982,2983,2984,2985,2986,2766,2767,2768,2769,2770,2987,2988,2989,2990,2991,2992,2993,2994,3010,3011,3012,3013,3014,3015,3016,3017,3018,3034,3035,3050,3051,3052,3053,3055,3056,3058,3059,3060,3061,3062,3192,3063,3064,3078,2771,2772,2773,2802,2803,2804,2805,2806,2807,2808,2809,2810,2811,2812,2813,2814,3079,3080,3081,3082,3083,3084,3129,3130,3131,3132,3133,3134,3135,3136,3137,3138,3139,3140,3141,3142,3143,2965,2966,3144,3145,3146,3147,3148,3149,3150,3164,3165,3166,3167,3168,3169,3170,3171,3172,3173,3174,3175,3176,3177,3178,3179,3180,3186,3190,3191,3193,3218,3219,3220,3221,3222,3223,3224,3225,3226,3227,3228,3229,3230,3231,3232,3233,3263,2816,2817,2818,2819,2820,3234,3235,3236,3237,3243,3266,3267,3268,3269,3270,3271,3272,3273,3278,3279,3280,3292,3293,3294,3295,3296,3297,3298,3311,3312,3313,3314,3315,3316,3317,3321,3814,3816,3322,3323,3324,3325,3328,3329,3330,3331,3332,3333,3334,3335,3402,2821,2822,2823,2824,2825,2845,3336,3337,3338,3339,3340,3341,3342,3347,3348,3350,3368,3369,3370,3371,3372,3373,3374,3375,3376,3377,3378,3379,3380,3381,3382,3383,3386,3387,3388,3389,3390,3391,3392,3393,3394,3405,3406,3407,3408,3409,3493,2846,2847,2848,2849,2850,2851,2852,2853,2854,2855,2856,3410,3413,3414,3415,3416,3417,3418,3419,3420,3421,3438,3439,3440,2613,3537,3538,3539,3540,3541,3542,3543,3534,2790,3466,3467,3468,3469,3075,3076,3102,3114,3115,3160,3162,3427,3428,3429,3470,3471,3472,3473,3215,3216,2686,2687,2688,2689,2692,2732,2774,2775,2776,2777,2778,2779,2780,2781,2782,2783,2796,2797,2828,3262,2829,2830,2831,2832,2833,2834,2835,2836,2837,2838,2839,2840,2841,2862,2863,2864,2865,2868,2869,2934,2955,2956,2957,2958,2961,2963,2964,2995,2996,2997,2998,3000,3001,3002,3003,3006,3036,3037,3038,3040,3041,3042,3043,3044,3045,3046,3068,3069,3070,3071,3072,3073,3074,3103,3104,3431,3105,3106,3107,3108,3109,3110,3111,3112,3113,3155,3156,3157,3158,3159,3163,3197,3198,3199,3200,3259,3260,3261,3281,3282,3283,3284,3285,3286,3287,3362,3363,3364,3395,3396,3397,3398,3399,3400,3404,3481,3482,3483,3484,3485,3486,3487,3488,3489,3490,3491,3523,3524,3525,3526,3527,3528,3529,3530,3531,3532,3535,3563,3564,3565,3566,3567,2967,3066,3057,2616,2867,3007,3047,3048,3319,3558,2641,2642,2643,2644,2645,2646,2647,2648,2649,2650,3505,3506,3507,2601,2602,2603,2607,2947,3185,3187,3188,3288,3291,3359,3349,3326,3327,3385,3411,3412,3077,2784,2785,2786,2787,2788,2789,2791,2792,2793,2794,2795,2935,2936,2937,2938,2939,2940,3049,2665,3430,3492,3039,3367,2892,2893,2894,2895,2896,2897,2898,2899,2900,2901,3054,3533,3568,3569,3217,3004,3005,2617,2618,2619,2620,2621,2622,2623,2606,3008,3289,3290,3318,3365,3366,3401,2608,2609,2610,2611,2612,3161,2651,2652,2653,2654,2655,2656,2657,2658,2659,2660,2661,2663,2664,2669,3239,3009,3116

		// DINAS KESEHATAN
		// $arrsatuankerja= array(74);
		//74,668,669,670,671,672,673,674,636,637,638,639,640,641,635,655,642,643,644,645,653,654,656,657,658,659,660,661,662,663,664,665,666,667,646,647,648,649,650,651,652,2461,2462,2463,2490,2491,2492,2493,2494,2468,2469,2470,2471,2472,2473,2474,2475,2476,2486,2480,2481,2482,2483,2484,2485,2448,2449,2450,2477,2451,2452,2454,2455,2456,2457,2458,2459,2460,2478,2479,2464,2465,2466,2467,2487,2488,2489,2453

		// DINAS KESEHATAN
		// $arrsatuankerja= array(641, 642, 666, 643, 644, 645, 646, 647, 648, 649, 650, 651, 652, 653, 654, 655, 656, 657, 658, 659, 660, 661, 662, 663, 664, 665, 667, 668, 669, 670, 671, 672, 673, 674);
		// echo count($arrsatuankerja);exit();
		$tempDataSatker= "";
		for($i=0; $i < count($arrsatuankerja); $i++)
		{
			$reqSatuanKerjaId= $arrsatuankerja[$i];
			$skerja= new SatuanKerja();
			$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
			// echo $reqSatuanKerjaId;exit();
			unset($skerja);

			if($i==0)
			$tempDataSatker= $reqSatuanKerjaId;
			else
			$tempDataSatker.= ",".$reqSatuanKerjaId;
		}
		echo $tempDataSatker;
	}

	function enkripdata()
	{
		// $string_to_encrypt='John Smith';
		// $password='password';
		// $encrypted_string=encrypt($string_to_encrypt, $password);
		// $decrypted_string=decrypt($encrypted_string, $password);
		// echo $encrypted_string.";;;<br/>".$decrypted_string;exit();

		$reqdata= urldecode($this->input->get("reqdata"));
		$reqkunci= urldecode($this->input->get("reqkunci"));

		echo mencrypt($reqdata, $reqkunci);
	}

	function dekripdata()
	{
		$reqdata= urldecode($this->input->get("reqdata"));
		$reqkunci= urldecode($this->input->get("reqkunci"));

		echo mdecrypt($reqdata, $reqkunci);
	}

	function reset_password()
	{
		$this->load->model('UserLoginPersonal');
		$set = new UserLoginPersonal();
		
		$reqId =  $this->input->get('reqId');
		$set->setField("PEGAWAI_ID", $reqId);
		$set->setField("STATUS", "0");
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		
		if($set->resetPassword())
			$arrJson["PESAN"] = "Password berhasil direset.";
		else
			$arrJson["PESAN"] = "Password gagal direset.";		
		
		echo json_encode($arrJson);
	}

	function cekfile()
	{
		$vurl= "uploads/8300/cek.pdf";
		$namagenerate= "uploads/8300/cek1.pdf";
		if(file_exists($vurl))
		{
			rename($vurl, $namagenerate);
			echo "a";
		}
		else
		{
			echo "b";
		}
	}
		
}
?>