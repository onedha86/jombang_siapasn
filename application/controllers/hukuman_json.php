<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class hukuman_json extends CI_Controller {

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
	
	function add()
	{
		// validasi untuk file
		$this->load->library('globalfilepegawai');
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

		$this->load->model('Hukuman');
		$this->load->model('JabatanRiwayat');
		$this->load->model('PangkatRiwayat');
		$this->load->model('GajiRiwayat');
		$this->load->model('PegawaiStatus');
		$this->load->model('PejabatPenetap');
		
		$set = new Hukuman();
		
		$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
		$reqPangkatRiwayatTerakhirId= $this->input->post("reqPangkatRiwayatTerakhirId");
		$reqGajiRiwayatTerakhirId= $this->input->post("reqGajiRiwayatTerakhirId");
		$reqPangkatRiwayatTurunId= $this->input->post("reqPangkatRiwayatTurunId");
		$reqGajiRiwayatTurunId= $this->input->post("reqGajiRiwayatTurunId");
		$reqPangkatRiwayatKembaliId= $this->input->post("reqPangkatRiwayatKembaliId");
		$reqGajiRiwayatKembaliId= $this->input->post("reqGajiRiwayatKembaliId");
		$reqPegawaiStatusId= $this->input->post("reqPegawaiStatusId");
		
		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");
		$reqRowId= $this->input->post('reqRowId');
		$reqModeSimpan= $this->input->post('reqModeSimpan');

		// echo "xxx-".$reqModeSimpan;exit();
		
		$reqPegawaiStatusId= $this->input->post('reqPegawaiStatusId');
		$reqPejabatPenetapId= $this->input->post('reqPejabatPenetapId');
		$reqPejabatPenetap= $this->input->post('reqPejabatPenetap');
		$reqNoSk= $this->input->post('reqNoSk');
		$reqTanggalSk= $this->input->post('reqTanggalSk');
		$reqTmtSk= $this->input->post('reqTmtSk');
		$reqJenisHukumanId= $this->input->post('reqJenisHukumanId');
		$reqTingkatHukumanId= $this->input->post('reqTingkatHukumanId');
		$reqPeraturan= $this->input->post('reqPeraturan');
		$reqPermasalahan= $this->input->post('reqPermasalahan');
		$reqMasihBerlaku= $this->input->post('reqMasihBerlaku');
		$reqTanggalMulai= $this->input->post('reqTanggalMulai');
		$reqTanggalAkhir= $this->input->post('reqTanggalAkhir');
		$reqTanggalPemulihan= $this->input->post('reqTanggalPemulihan');
		
		$reqKenaikanPangkatBerikutnya= $this->input->post('reqKenaikanPangkatBerikutnya');
		$reqKenaikanGajiBerikutnya= $this->input->post('reqKenaikanGajiBerikutnya');
		
		// kalau pejabat tidak ada
		if(empty($reqPejabatPenetapId))
		{
			$set_pejabat=new PejabatPenetap();
			$set_pejabat->setField('NAMA', strtoupper($reqPejabatPenetap));
			$set_pejabat->setField("LAST_USER", $this->LOGIN_USER);
			$set_pejabat->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_pejabat->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_pejabat->setField("LAST_DATE", "NOW()");
			$set_pejabat->insert();
			// echo $set_pejabat->query;exit();
			$reqPejabatPenetapId=$set_pejabat->id;
			unset($set_pejabat);
		}

		// echo $reqModeSimpan;exit;
		// khusus jenis hukuman berat
		$statement= " AND A.PEGAWAI_ID = ".$reqId;
		$set_detil= new PegawaiStatus();
		$set_detil->selectByParamsPegawaiTerakhir(array(), -1,-1, $statement);
		$set_detil->firstRow();
		$tempStatusPegawaiId= $set_detil->getField("STATUS_PEGAWAI_ID");
		if($reqJenisHukumanId == 10 || $reqJenisHukumanId == 11)
		{
			$statement= " AND A.TIPE_ID = 1 AND A.JENIS_ID = ".$reqJenisHukumanId;
			$set_detil= new PegawaiStatus();
			$set_detil->selectByParamsStatusKedudukan(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempStatusPegawaiId= "4";
			$tempStatusPegawaiKedudukanId= $set_detil->getField("STATUS_PEGAWAI_KEDUDUKAN_ID");
		}
		else
		{
			$statement= " AND A.TIPE_ID = 1 AND A.JENIS_ID = 1 AND A.STATUS_PEGAWAI_ID = ".$tempStatusPegawaiId;
			$set_detil= new PegawaiStatus();
			$set_detil->selectByParamsStatusKedudukan(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempStatusPegawaiKedudukanId= $set_detil->getField("STATUS_PEGAWAI_KEDUDUKAN_ID");
		}

		$statement= " AND PEGAWAI_ID = ".$reqId." AND TMT = ".dateToDBCheck($reqTmtSk);
		$set_detil= new PegawaiStatus();
		$set_detil->selectByParams(array(), -1,-1, $statement);
		// echo $set_detil->query;exit();
		$set_detil->firstRow();
		$reqPegawaiStatusId= $set_detil->getField("PEGAWAI_STATUS_ID");

		$set_detil= new PegawaiStatus();
		$set_detil->setField('PEGAWAI_ID', $reqId);
		$set_detil->setField('STATUS_PEGAWAI_ID', $tempStatusPegawaiId);
		$set_detil->setField('TMT', dateToDBCheck($reqTmtSk));
		$set_detil->setField('STATUS_PEGAWAI_KEDUDUKAN_ID', $tempStatusPegawaiKedudukanId);
		$set_detil->setField('STATUS', ValToNullDB($req));
		$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set_detil->setField("LAST_USER", $this->LOGIN_USER);
		$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set_detil->setField("LAST_DATE", "NOW()");
		
		// if($reqMode == "insert")
		if($reqPegawaiStatusId == "")
		{
			if($set_detil->insert())
			{
				$reqPegawaiStatusId= $set_detil->id;
				// echo $set_detil->query; exit;
			}
		}
		else
		{
			$set_detil->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
			if($set_detil->update()){}
		}
		//echo $set_detil->query;exit;
		//========

		$infosimpan= "";
		if($reqModeSimpan == "hukuman")
		{
			$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
			$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
			$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
			$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
			$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
			$set->setField('NO_SK', $reqNoSk);	
			$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
			$set->setField('KETERANGAN', $reqPermasalahan);	
			$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
			$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
			$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
			$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
			$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
			
			$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
			$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
			$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
			$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
			$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
			$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
			$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($req));
			//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
			$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
	
			$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
			$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set->setField("LAST_USER", $this->LOGIN_USER);
			$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set->setField("LAST_DATE", "NOW()");
			
			if($reqMode == "insert")
			{
				if($set->insert())
				{
					$reqRowId= $set->id;
					$infosimpan= "1";
				} 
				else
				{
					if($reqPegawaiStatusId == ""){}
					else
					{
						$set_detil= new PegawaiStatus();
						$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
						$set_detil->deleteData();
					}
					echo "xxx-Data gagal disimpan.";
					exit;
				}
			}
			else
			{
				$set->setField('HUKUMAN_ID', $reqRowId);
				if($set->update())
				{
					$infosimpan= "1";
				}
				else
				{
					echo "xxx-Data gagal disimpan.";
					exit;
				}
			}
			// echo $set->query;exit;
		}
		elseif($reqModeSimpan == "jabatan_fungsional_umum")
		{
			$reqJenisJabatan= 2;
			$reqTipePegawaiId= 12;
			$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
			$reqJabatanFuIsManual= $this->input->post("reqJabatanFuIsManual");
			$reqJabatanFuJabatanFuId= $this->input->post("reqJabatanFuJabatanFuId");
			$reqJabatanFuJabatanFtId= $this->input->post("reqJabatanFuJabatanFtId");
			$reqJabatanFuNoSk= $this->input->post("reqJabatanFuNoSk");
			$reqJabatanFuTglSk= $this->input->post("reqJabatanFuTglSk");
			$reqJabatanFuNama= $this->input->post("reqJabatanFuNama");
			$reqJabatanFuTmtJabatan= $this->input->post("reqJabatanFuTmtJabatan");
			$reqJabatanFuTmtWaktuJabatan= $this->input->post("reqJabatanFuTmtWaktuJabatan");
			$reqJabatanFuEselonId= $this->input->post("reqJabatanFuEselonId");
			$reqJabatanFuNama= $this->input->post("reqJabatanFuNama");
			$reqJabatanFuTmtEselon= $this->input->post("reqJabatanFuTmtEselon");
			$reqJabatanFuKeteranganBUP= $this->input->post("reqJabatanFuKeteranganBUP");
			$reqJabatanFuNoPelantikan= $this->input->post("reqJabatanFuNoPelantikan");    
			$reqJabatanFuTglPelantikan= $this->input->post("reqJabatanFuTglPelantikan");
			$reqJabatanFuTunjangan= $this->input->post("reqJabatanFuTunjangan");
			$reqJabatanFuBlnDibayar= $this->input->post("reqJabatanFuBlnDibayar");
			$reqJabatanFuSatkerId= $this->input->post("reqJabatanFuSatkerId");
			$reqJabatanFuSatker= $this->input->post("reqJabatanFuSatker");
			$reqJabatanFuKredit= $this->input->post("reqJabatanFuKredit");
			$reqJabatanFuPejabatPenetap= $this->input->post("reqJabatanFuPejabatPenetap");
			$reqJabatanFuPejabatPenetapId= $this->input->post("reqJabatanFuPejabatPenetapId");
			
			$set_detil= new JabatanRiwayat();
			$set_detil->setField('TIPE_PEGAWAI_ID', $reqTipePegawaiId);
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			
			$set_detil->setField('JABATAN_FU_ID', ValToNullDB($reqJabatanFuJabatanFuId));
			$set_detil->setField('JABATAN_FT_ID', ValToNullDB($req));
			$set_detil->setField('BIDANG_JABATAN_TERKAIT_ID', ValToNullDB($reqBidangJabatanTerkaitId));
			
			$set_detil->setField('SATKER_ID', ValToNullDB($reqJabatanFuSatkerId));
			$set_detil->setField('SATKER_NAMA', $reqJabatanFuSatker);
			$set_detil->setField('IS_MANUAL', ValToNullDB($reqJabatanFuIsManual));
			$set_detil->setField('NO_SK', $reqNoSk);
			$set_detil->setField('ESELON_ID', ValToNullDB($reqJabatanFuEselonId));
			$set_detil->setField('NAMA', $reqJabatanFuNama);
			$set_detil->setField('NO_PELANTIKAN', $reqJabatanFuNoPelantikan);
			$set_detil->setField("TUNJANGAN", ValToNullDB(dotToNo($reqJabatanFuTunjangan)));
			$set_detil->setField('KREDIT', ValToNullDB(dotToNo($reqJabatanFuKredit)));
			$set_detil->setField('TMT_BATAS_USIA_PENSIUN', ValToNullDB($req));
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));
			if(strlen($reqJabatanFuTmtWaktuJabatan) == 5)
			$set_detil->setField('TMT_JABATAN', dateTimeToDBCheck($reqJabatanFuTmtJabatan." ".$reqJabatanFuTmtWaktuJabatan));
			else
			$set_detil->setField('TMT_JABATAN', dateToDBCheck($reqJabatanFuTmtJabatan));

			$set_detil->setField('TMT_ESELON', ValToNullDB($req));

			$set_detil->setField('TANGGAL_PELANTIKAN', dateToDBCheck($reqJabatanFuTglPelantikan));
			$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqJabatanFuBlnDibayar));
			$set_detil->setField('KETERANGAN_BUP', $reqJabatanFuKeteranganBUP);
			$set_detil->setField('JENIS_JABATAN_ID', $reqJenisJabatan);
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");

			// tambahan baru
			$set_detil->setField('STATUS_SK_DASAR_JABATAN', ValToNullDB($reqSkDasarJabatan));
			$set_detil->setField('TMT_SELESAI_JABATAN', dateToDBCheck($reqTanggalSelesai));
			$set_detil->setField('LAMA_JABATAN', ValToNullDB($reqLamaMenjabat));
			$set_detil->setField('NILAI_REKAM_JEJAK', ValToNullDB($reqNilaiRekam));
			$set_detil->setField('RUMPUN_ID', ValToNullDB($reqRumpunJabatan));
			$set_detil->setField('SERTIFIKASI_NO_SK', $reqNoSkSertifikasi);
			$set_detil->setField('SERTIFIKASI_TGL_SK', dateToDBCheck($reqTglSkSertifikasi));
			$set_detil->setField('SERTIFIKASI_TGL_BERLAKU', dateToDBCheck($reqTglBerlaku));
			$set_detil->setField('SERTIFIKASI_TGL_EXPIRED', dateToDBCheck($reqTglExpired));

			$set_detil->setField('EOFFICE_JABATAN_ID', ValToNullDB($reqEofficeJabatanId));
			$set_detil->setField('EOFFICE_JABATAN_NAMA', $reqEofficeJabatanNama);
			$set_detil->setField('EOFFICE_SATUAN_KERJA_ID', ValToNullDB($reqEofficeSatkerId));
			$set_detil->setField('EOFFICE_SATUAN_KERJA_NAMA', $reqEofficeSatkerNama);
			$set_detil->setField('TMT_SPMT', dateToDBCheck($reqTmtSpmt));
			
			$reqSimpan= "";
			// if($reqMode == "insert")
			if($reqJabatanRiwayatId == "")
			{
				if($set_detil->insert())
				{
					$reqJabatanRiwayatId= $set_detil->id;
					$reqSimpan= 1;
				}
			}
			else
			{
				$set_detil->setField('JABATAN_RIWAYAT_ID', $reqJabatanRiwayatId);
				if($set_detil->update())
					$reqSimpan= 1;
			}
			
			// echo $set_detil->query;exit;
			
			if($reqSimpan == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						$infosimpan= "1";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
						
						echo "xxx-Data gagal disimpan.";
						exit;
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
					{
						$infosimpan= "1";
					}
					else
					{
						echo "xxx-Data gagal disimpan.";
						exit;
					}
				}
			
			}
			else
			{
				echo "xxx-Proses simpan belum di buat.";
				exit;
			}

		}
		elseif($reqModeSimpan == "jabatan_struktural")
		{
			// tambahan peraturan id
			$reqJenisJabatan= $this->input->post("reqJenisJabatan");
			if($reqJenisJabatan == 1)
				$reqTipePegawaiId= 11;
			else if($reqJenisJabatan == 2)
				$reqTipePegawaiId= 12;

			$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
			$reqJabatanStrukturalIsManual= $this->input->post("reqJabatanStrukturalIsManual");
			$reqJabatanStrukturalJabatanFuId= $this->input->post("reqJabatanStrukturalJabatanFuId");
			$reqJabatanStrukturalJabatanFu= $this->input->post("reqJabatanStrukturalJabatanFu");
			$reqJabatanStrukturalJabatanFtId= $this->input->post("reqJabatanStrukturalJabatanFtId");
			$reqJabatanStrukturalNoSk= $this->input->post("reqJabatanStrukturalNoSk");
			$reqJabatanStrukturalTglSk= $this->input->post("reqJabatanStrukturalTglSk");
			$reqJabatanStrukturalNama= $this->input->post("reqJabatanStrukturalNama");
			$reqJabatanStrukturalTmtJabatan= $this->input->post("reqJabatanStrukturalTmtJabatan");
			$reqJabatanStrukturalTmtWaktuJabatan= $this->input->post("reqJabatanStrukturalTmtWaktuJabatan");
			$reqJabatanStrukturalEselonId= $this->input->post("reqJabatanStrukturalEselonId");
			$reqJabatanStrukturalNama= $this->input->post("reqJabatanStrukturalNama");
			$reqJabatanStrukturalTmtEselon= $this->input->post("reqJabatanStrukturalTmtEselon");
			$reqJabatanStrukturalKeteranganBUP= $this->input->post("reqJabatanStrukturalKeteranganBUP");
			$reqJabatanStrukturalNoPelantikan= $this->input->post("reqJabatanStrukturalNoPelantikan");    
			$reqJabatanStrukturalTglPelantikan= $this->input->post("reqJabatanStrukturalTglPelantikan");
			$reqJabatanStrukturalTunjangan= $this->input->post("reqJabatanStrukturalTunjangan");
			$reqJabatanStrukturalBlnDibayar= $this->input->post("reqJabatanStrukturalBlnDibayar");
			$reqJabatanStrukturalSatkerId= $this->input->post("reqJabatanStrukturalSatkerId");
			$reqJabatanStrukturalSatker= $this->input->post("reqJabatanStrukturalSatker");
			$reqJabatanStrukturalKredit= $this->input->post("reqJabatanStrukturalKredit");
			$reqJabatanStrukturalPejabatPenetap= $this->input->post("reqJabatanStrukturalPejabatPenetap");
			$reqJabatanStrukturalPejabatPenetapId= $this->input->post("reqJabatanStrukturalPejabatPenetapId");
			
			$set_detil= new JabatanRiwayat();
			$set_detil->setField('TIPE_PEGAWAI_ID', $reqTipePegawaiId);
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			
			$set_detil->setField('JABATAN_FU_ID', ValToNullDB($reqJabatanStrukturalJabatanFuId));
			$set_detil->setField('JABATAN_FT_ID', ValToNullDB($req));
			$set_detil->setField('BIDANG_JABATAN_TERKAIT_ID', ValToNullDB($reqBidangJabatanTerkaitId));
			
			$set_detil->setField('SATKER_ID', ValToNullDB($reqJabatanStrukturalSatkerId));
			$set_detil->setField('SATKER_NAMA', $reqJabatanStrukturalSatker);
			$set_detil->setField('IS_MANUAL', ValToNullDB($reqJabatanStrukturalIsManual));
			$set_detil->setField('NO_SK', $reqNoSk);
			$set_detil->setField('ESELON_ID', ValToNullDB($reqJabatanStrukturalEselonId));

			if($reqJenisJabatan == 1)
				$set_detil->setField('NAMA', $reqJabatanStrukturalNama);
			else if($reqJenisJabatan == 2)
				$set_detil->setField('NAMA', $reqJabatanStrukturalJabatanFu);

			$set_detil->setField('NO_PELANTIKAN', $reqJabatanStrukturalNoPelantikan);
			$set_detil->setField("TUNJANGAN", ValToNullDB(dotToNo($reqJabatanStrukturalTunjangan)));
			$set_detil->setField('KREDIT', ValToNullDB(dotToNo($reqJabatanStrukturalKredit)));
			$set_detil->setField('TMT_BATAS_USIA_PENSIUN', ValToNullDB($req));
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));

			if(strlen($reqJabatanStrukturalTmtWaktuJabatan) == 5)
			{
				$set_detil->setField('TMT_JABATAN', dateTimeToDBCheck($reqJabatanStrukturalTmtJabatan." ".$reqJabatanStrukturalTmtWaktuJabatan));
				$set_detil->setField('TMT_ESELON', dateTimeToDBCheck($reqJabatanStrukturalTmtJabatan." ".$reqJabatanStrukturalTmtWaktuJabatan));
			}
			else
			{
				$set_detil->setField('TMT_JABATAN', dateToDBCheck($reqJabatanStrukturalTmtJabatan));
				$set_detil->setField('TMT_ESELON', dateToDBCheck($reqJabatanStrukturalTmtJabatan));
			}

			$set_detil->setField('TANGGAL_PELANTIKAN', dateToDBCheck($reqJabatanStrukturalTglPelantikan));
			$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqJabatanStrukturalBlnDibayar));
			$set_detil->setField('KETERANGAN_BUP', $reqJabatanStrukturalKeteranganBUP);
			$set_detil->setField('JENIS_JABATAN_ID', $reqJenisJabatan);
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");

			// tambahan baru
			$set_detil->setField('STATUS_SK_DASAR_JABATAN', ValToNullDB($reqSkDasarJabatan));
			$set_detil->setField('TMT_SELESAI_JABATAN', dateToDBCheck($reqTanggalSelesai));
			$set_detil->setField('LAMA_JABATAN', ValToNullDB($reqLamaMenjabat));
			$set_detil->setField('NILAI_REKAM_JEJAK', ValToNullDB($reqNilaiRekam));
			$set_detil->setField('RUMPUN_ID', ValToNullDB($reqRumpunJabatan));
			$set_detil->setField('SERTIFIKASI_NO_SK', $reqNoSkSertifikasi);
			$set_detil->setField('SERTIFIKASI_TGL_SK', dateToDBCheck($reqTglSkSertifikasi));
			$set_detil->setField('SERTIFIKASI_TGL_BERLAKU', dateToDBCheck($reqTglBerlaku));
			$set_detil->setField('SERTIFIKASI_TGL_EXPIRED', dateToDBCheck($reqTglExpired));

			$set_detil->setField('EOFFICE_JABATAN_ID', ValToNullDB($reqEofficeJabatanId));
			$set_detil->setField('EOFFICE_JABATAN_NAMA', $reqEofficeJabatanNama);
			$set_detil->setField('EOFFICE_SATUAN_KERJA_ID', ValToNullDB($reqEofficeSatkerId));
			$set_detil->setField('EOFFICE_SATUAN_KERJA_NAMA', $reqEofficeSatkerNama);
			$set_detil->setField('TMT_SPMT', dateToDBCheck($reqTmtSpmt));
			
			$reqSimpan= "";
			// if($reqMode == "insert")
			if($reqJabatanRiwayatId == "")
			{
				if($set_detil->insert())
				{
					$reqJabatanRiwayatId= $set_detil->id;
					$reqSimpan= 1;
				}
			}
			else
			{
				$set_detil->setField('JABATAN_RIWAYAT_ID', $reqJabatanRiwayatId);
				if($set_detil->update())
					$reqSimpan= 1;
			}
			// echo $set_detil->query;exit;
			
			if($reqSimpan == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						$infosimpan= "1";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
						echo "xxx-Data gagal disimpan.";
						exit;
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
					{
						$infosimpan= "1";
					}
					else
					{
						echo "xxx-Data gagal disimpan.";
						exit;
					}
				}
			
			}
			else
			{
				echo "xxx-Proses simpan belum di buat.";
				exit;
			}
		
		}
		elseif($reqModeSimpan == "pangkat_riwayat")
		{
			// Hukuman disiplin
			$reqJenisRiwayat= 8;
			$reqKenaikanPangkatTurunKode= $this->input->post("reqKenaikanPangkatTurunKode");
			$reqKenaikanPangkatTurunTh= $this->input->post("reqKenaikanPangkatTurunTh");
			$reqKenaikanPangkatTurunBl= $this->input->post("reqKenaikanPangkatTurunBl");
			$reqKenaikanPangkatTurunGajiPokok= $this->input->post("reqKenaikanPangkatTurunGajiPokok");
			
			$set_detil= new PangkatRiwayat();
			$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatTurunKode);
			$set_detil->setField('NO_SK', $reqNoSk);	
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTmtSk));	
			$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
			$set_detil->setField('STATUS', ValToNullDB($req));
			$set_detil->setField('KETERANGAN', $req);
			$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatTurunTh));
			$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatTurunBl));
			$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatTurunGajiPokok)));
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpanTurun= "";
			// if($reqMode == "insert")
			if($reqPangkatRiwayatTurunId == "")
			{
				if($set_detil->insertHukuman())
				{
					$reqPangkatRiwayatTurunId= $set_detil->id;
					$statement= " AND PEGAWAI_ID = ".$reqId." AND JENIS_KENAIKAN IN (".$reqJenisRiwayat.") AND (COALESCE(NULLIF(STATUS, ''), NULL) IS NULL OR STATUS = '2')
					AND TANGGAL_SK = ".dateToDBCheck($reqTanggalSk)."
					AND TMT_SK = ".dateToDBCheck($reqTmtSk);
					$set_data= new PangkatRiwayat();
					$reqGajiRiwayatTurunId= $set_data->getCountByParamsGajiRiwayatId($statement);
					if($reqGajiRiwayatTurunId == ""){}
					else
					{
						//$set_data= new GajiRiwayat();
						//$set_data->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
						//$set_data->setField("LAST_USER", $this->LOGIN_USER);
						//$set_data->setField("LAST_DATE", "NOW()");
						//$set_data->setField("STATUS", "1");
						//$set_data->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
						//if($set_data->updateStatus())
						//{
							$reqSimpanTurun= 1;
						//}
						
					}
				}
			}
			else
			{
				$set_detil->setField('PANGKAT_RIWAYAT_ID', $reqPangkatRiwayatTurunId);
				if($set_detil->updateHukuman())
					$reqSimpanTurun= 1;
			}
			//echo $set_detil->query;exit;
			
			//Pemulihan hukuman disiplin
			$reqJenisRiwayat= 9;
			$reqKenaikanPangkatKembaliKode= $this->input->post("reqKenaikanPangkatKembaliKode");
			$reqKenaikanPangkatKembaliTh= $this->input->post("reqKenaikanPangkatKembaliTh");
			$reqKenaikanPangkatKembaliBl= $this->input->post("reqKenaikanPangkatKembaliBl");
			$reqKenaikanPangkatKembaliGajiPokok= $this->input->post("reqKenaikanPangkatKembaliGajiPokok");
			
			$set_detil= new PangkatRiwayat();
			$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatKembaliKode);
			$set_detil->setField('NO_SK', $reqNoSk);	
			//$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			//$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));	
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalAkhir));
			$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));
			// $set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTmtSk));
			$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
			$set_detil->setField('STATUS', ValToNullDB("1"));
			$set_detil->setField('KETERANGAN', $req);
			$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatKembaliTh));
			$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatKembaliBl));
			$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatKembaliGajiPokok)));
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpanKembali= "";
			// if($reqMode == "insert")
			if($reqPangkatRiwayatKembaliId == "")
			{
				if($set_detil->insertHukuman())
				{
					$reqPangkatRiwayatKembaliId= $set_detil->id;
					$statement= " AND PEGAWAI_ID = ".$reqId." AND JENIS_KENAIKAN IN (".$reqJenisRiwayat.") AND (COALESCE(NULLIF(STATUS, ''), NULL) IS NULL OR STATUS = '2')
					AND TANGGAL_SK = ".dateToDBCheck($reqTanggalAkhir)."
					AND TMT_SK = ".dateToDBCheck($reqTanggalAkhir);
					$set_data= new PangkatRiwayat();
					$reqGajiRiwayatKembaliId= $set_data->getCountByParamsGajiRiwayatId($statement);
					if($reqGajiRiwayatKembaliId == ""){}
					else
					{
						$set_data= new GajiRiwayat();
						$set_data->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
						$set_data->setField("LAST_USER", $this->LOGIN_USER);
						$set_data->setField("USER_LOGIN_ID", $this->LOGIN_ID);
						$set_data->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
						$set_data->setField("LAST_DATE", "NOW()");
						$set_data->setField("STATUS", "1");
						$set_data->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);

						if($set_data->updateStatus())
						{
							$reqSimpanKembali= 1;
						}
						
					}
				}
			}
			else
			{
				$set_detil->setField('PANGKAT_RIWAYAT_ID', $reqPangkatRiwayatKembaliId);
				if($set_detil->updateHukuman())
				{
					$reqSimpanKembali= 1;
					$set_detil= new GajiRiwayat();
					$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatKembaliKode);
					$set_detil->setField('NO_SK', $reqNoSk);
					$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalAkhir));
					$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));
					$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
					$set_detil->setField('STATUS', ValToNullDB("1"));
					$set_detil->setField('KETERANGAN', $req);
					$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatKembaliTh));
					$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatKembaliBl));
					$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatKembaliGajiPokok)));
					$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
					$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
					$set_detil->setField('PEGAWAI_ID', $reqId);
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField('GAJI_RIWAYAT_ID', $reqGajiRiwayatKembaliId);
					$set_detil->updateHukuman();
				}
			}
			//echo $set_detil->query;exit;
			
			if($reqSimpanTurun == 1 && $reqSimpanKembali == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($reqPangkatRiwayatTurunId));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($reqGajiRiwayatTurunId));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($reqPangkatRiwayatKembaliId));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($reqGajiRiwayatKembaliId));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						$infosimpan= "1";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
						
						// echo $set->query;exit();
						// echo "xxx-Data gagal disimpan.";
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
					{
						$infosimpan= "1";
					}
					else
					{
						echo "xxx-Data gagal disimpan.";
						exit;
					}
				}
			
			}
			else
			{
				if($reqMode == "insert")
				{
					if($reqJabatanRiwayatId == ""){}
					else
					{
						$set_detil= new JabatanRiwayat();
						$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
						$set_detil->deleteData();
						//echo $set_detil->query;exit;
					}
	
					if($reqPangkatRiwayatTurunId == ""){}
					else
					{
						$set_detil= new PangkatRiwayat();
						$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
						$set_detil->deleteData();
					}
					
					if($reqGajiRiwayatTurunId == ""){}
					else
					{
						$set_detil= new GajiRiwayat();
						$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
						$set_detil->deleteData();
					}
					
					if($reqPangkatRiwayatKembaliId == ""){}
					else
					{
						$set_detil= new PangkatRiwayat();
						$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
						$set_detil->deleteData();
					}
					
					if($reqGajiRiwayatKembaliId == ""){}
					else
					{
						$set_detil= new GajiRiwayat();
						$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
						$set_detil->deleteData();
					}
					
					if($reqPegawaiStatusId == ""){}
					else
					{
						$set_detil= new PegawaiStatus();
						$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
						$set_detil->deleteData();
					}
				}
				
				//echo "xxx-Proses simpan belum di buat.";
				echo "xxx-Proses simpan belum di buat.a".$reqSimpanTurun.";".$reqSimpanKembali.";".$reqGajiRiwayatTurunId;
				exit;
			}
		
		}
		else
		{
			echo "xxx-Proses simpan belum di buat.b".$reqSimpanTurun.";".$reqSimpanKembali.";".$reqGajiRiwayatTurunId;
			exit;
		}
		//echo "xxx-Proses simpan belum di buat.";

		if($infosimpan == "1")
		{
			// untuk simpan file
			$vpost= $this->input->post();
			$vsimpanfilepegawai= new globalfilepegawai();
			$vsimpanfilepegawai->simpanfilepegawai($vpost, $reqRowId, $reqLinkFile);

			echo $reqRowId."-Data berhasil disimpan.";
		}
	}

	function addsebelum()
	{
		$this->load->model('Hukuman');
		$this->load->model('JabatanRiwayat');
		$this->load->model('PangkatRiwayat');
		$this->load->model('GajiRiwayat');
		$this->load->model('PegawaiStatus');
		
		$set = new Hukuman();
		
		$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
		$reqPangkatRiwayatTerakhirId= $this->input->post("reqPangkatRiwayatTerakhirId");
		$reqGajiRiwayatTerakhirId= $this->input->post("reqGajiRiwayatTerakhirId");
		$reqPangkatRiwayatTurunId= $this->input->post("reqPangkatRiwayatTurunId");
		$reqGajiRiwayatTurunId= $this->input->post("reqGajiRiwayatTurunId");
		$reqPangkatRiwayatKembaliId= $this->input->post("reqPangkatRiwayatKembaliId");
		$reqGajiRiwayatKembaliId= $this->input->post("reqGajiRiwayatKembaliId");
		$reqPegawaiStatusId= $this->input->post("reqPegawaiStatusId");
		
		$reqId= $this->input->post("reqId");
		$reqMode= $this->input->post("reqMode");
		$reqRowId= $this->input->post('reqRowId');
		$reqModeSimpan= $this->input->post('reqModeSimpan');

		// echo "xxx-".$reqModeSimpan;exit();
		
		$reqPegawaiStatusId= $this->input->post('reqPegawaiStatusId');
		$reqPejabatPenetapId= $this->input->post('reqPejabatPenetapId');
		$reqPejabatPenetap= $this->input->post('reqPejabatPenetap');
		$reqNoSk= $this->input->post('reqNoSk');
		$reqTanggalSk= $this->input->post('reqTanggalSk');
		$reqTmtSk= $this->input->post('reqTmtSk');
		$reqJenisHukumanId= $this->input->post('reqJenisHukumanId');
		$reqTingkatHukumanId= $this->input->post('reqTingkatHukumanId');
		$reqPeraturan= $this->input->post('reqPeraturan');
		$reqPermasalahan= $this->input->post('reqPermasalahan');
		$reqMasihBerlaku= $this->input->post('reqMasihBerlaku');
		$reqTanggalMulai= $this->input->post('reqTanggalMulai');
		$reqTanggalAkhir= $this->input->post('reqTanggalAkhir');
		$reqTanggalPemulihan= $this->input->post('reqTanggalPemulihan');
		
		$reqKenaikanPangkatBerikutnya= $this->input->post('reqKenaikanPangkatBerikutnya');
		$reqKenaikanGajiBerikutnya= $this->input->post('reqKenaikanGajiBerikutnya');
		// echo $reqModeSimpan;exit;
		// khusus jenis hukuman berat
		$statement= " AND A.PEGAWAI_ID = ".$reqId;
		$set_detil= new PegawaiStatus();
		$set_detil->selectByParamsPegawaiTerakhir(array(), -1,-1, $statement);
		$set_detil->firstRow();
		$tempStatusPegawaiId= $set_detil->getField("STATUS_PEGAWAI_ID");
		if($reqJenisHukumanId == 10 || $reqJenisHukumanId == 11)
		{
			$statement= " AND A.TIPE_ID = 1 AND A.JENIS_ID = ".$reqJenisHukumanId;
			$set_detil= new PegawaiStatus();
			$set_detil->selectByParamsStatusKedudukan(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempStatusPegawaiId= "4";
			$tempStatusPegawaiKedudukanId= $set_detil->getField("STATUS_PEGAWAI_KEDUDUKAN_ID");
		}
		else
		{
			$statement= " AND A.TIPE_ID = 1 AND A.JENIS_ID = 1 AND A.STATUS_PEGAWAI_ID = ".$tempStatusPegawaiId;
			$set_detil= new PegawaiStatus();
			$set_detil->selectByParamsStatusKedudukan(array(), -1,-1, $statement);
			$set_detil->firstRow();
			$tempStatusPegawaiKedudukanId= $set_detil->getField("STATUS_PEGAWAI_KEDUDUKAN_ID");
		}

		$statement= " AND PEGAWAI_ID = ".$reqId." AND TMT = ".dateToDBCheck($reqTmtSk);
		$set_detil= new PegawaiStatus();
		$set_detil->selectByParams(array(), -1,-1, $statement);
		// echo $set_detil->query;exit();
		$set_detil->firstRow();
		$reqPegawaiStatusId= $set_detil->getField("PEGAWAI_STATUS_ID");

		$set_detil= new PegawaiStatus();
		$set_detil->setField('PEGAWAI_ID', $reqId);
		$set_detil->setField('STATUS_PEGAWAI_ID', $tempStatusPegawaiId);
		$set_detil->setField('TMT', dateToDBCheck($reqTmtSk));
		$set_detil->setField('STATUS_PEGAWAI_KEDUDUKAN_ID', $tempStatusPegawaiKedudukanId);
		$set_detil->setField('STATUS', ValToNullDB($req));
		$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set_detil->setField("LAST_USER", $this->LOGIN_USER);
		$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set_detil->setField("LAST_DATE", "NOW()");
		
		// if($reqMode == "insert")
		if($reqPegawaiStatusId == "")
		{
			if($set_detil->insert())
			{
				$reqPegawaiStatusId= $set_detil->id;
				// echo $set_detil->query; exit;
			}
		}
		else
		{
			$set_detil->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
			if($set_detil->update()){}
		}
		//echo $set_detil->query;exit;
		//========
		
		if($reqModeSimpan == "hukuman")
		{
			$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
			$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
			$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
			$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
			$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
			$set->setField('NO_SK', $reqNoSk);	
			$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
			$set->setField('KETERANGAN', $reqPermasalahan);	
			$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
			$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
			$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
			$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
			$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
			$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
			
			$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
			$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
			$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
			$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
			$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
			$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
			$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($req));
			//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
			$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
	
			$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
			$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set->setField("LAST_USER", $this->LOGIN_USER);
			$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set->setField("LAST_DATE", "NOW()");
			
			if($reqMode == "insert")
			{
				if($set->insert())
				{
					$reqRowId= $set->id;
					echo $reqRowId."-Data berhasil disimpan.";
				} 
				else
				{
					if($reqPegawaiStatusId == ""){}
					else
					{
						$set_detil= new PegawaiStatus();
						$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
						$set_detil->deleteData();
					}
					echo "xxx-Data gagal disimpan.";
					
				}
			}
			else
			{
				$set->setField('HUKUMAN_ID', $reqRowId);
				if($set->update())
					echo $reqRowId."-Data berhasil disimpan.";
				else 
					echo "xxx-Data gagal disimpan.";
			}
			// echo $set->query;exit;
		}
		elseif($reqModeSimpan == "jabatan_fungsional_umum")
		{
			$reqJenisJabatan= 2;
			$reqTipePegawaiId= 12;
			$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
			$reqJabatanFuIsManual= $this->input->post("reqJabatanFuIsManual");
			$reqJabatanFuJabatanFuId= $this->input->post("reqJabatanFuJabatanFuId");
			$reqJabatanFuJabatanFtId= $this->input->post("reqJabatanFuJabatanFtId");
			$reqJabatanFuNoSk= $this->input->post("reqJabatanFuNoSk");
			$reqJabatanFuTglSk= $this->input->post("reqJabatanFuTglSk");
			$reqJabatanFuNama= $this->input->post("reqJabatanFuNama");
			$reqJabatanFuTmtJabatan= $this->input->post("reqJabatanFuTmtJabatan");
			$reqJabatanFuTmtWaktuJabatan= $this->input->post("reqJabatanFuTmtWaktuJabatan");
			$reqJabatanFuEselonId= $this->input->post("reqJabatanFuEselonId");
			$reqJabatanFuNama= $this->input->post("reqJabatanFuNama");
			$reqJabatanFuTmtEselon= $this->input->post("reqJabatanFuTmtEselon");
			$reqJabatanFuKeteranganBUP= $this->input->post("reqJabatanFuKeteranganBUP");
			$reqJabatanFuNoPelantikan= $this->input->post("reqJabatanFuNoPelantikan");    
			$reqJabatanFuTglPelantikan= $this->input->post("reqJabatanFuTglPelantikan");
			$reqJabatanFuTunjangan= $this->input->post("reqJabatanFuTunjangan");
			$reqJabatanFuBlnDibayar= $this->input->post("reqJabatanFuBlnDibayar");
			$reqJabatanFuSatkerId= $this->input->post("reqJabatanFuSatkerId");
			$reqJabatanFuSatker= $this->input->post("reqJabatanFuSatker");
			$reqJabatanFuKredit= $this->input->post("reqJabatanFuKredit");
			$reqJabatanFuPejabatPenetap= $this->input->post("reqJabatanFuPejabatPenetap");
			$reqJabatanFuPejabatPenetapId= $this->input->post("reqJabatanFuPejabatPenetapId");
			
			$set_detil= new JabatanRiwayat();
			$set_detil->setField('TIPE_PEGAWAI_ID', $reqTipePegawaiId);
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			
			$set_detil->setField('JABATAN_FU_ID', ValToNullDB($reqJabatanFuJabatanFuId));
			$set_detil->setField('JABATAN_FT_ID', ValToNullDB($req));
			$set_detil->setField('BIDANG_JABATAN_TERKAIT_ID', ValToNullDB($reqBidangJabatanTerkaitId));
			
			$set_detil->setField('SATKER_ID', ValToNullDB($reqJabatanFuSatkerId));
			$set_detil->setField('SATKER_NAMA', $reqJabatanFuSatker);
			$set_detil->setField('IS_MANUAL', ValToNullDB($reqJabatanFuIsManual));
			$set_detil->setField('NO_SK', $reqNoSk);
			$set_detil->setField('ESELON_ID', ValToNullDB($reqJabatanFuEselonId));
			$set_detil->setField('NAMA', $reqJabatanFuNama);
			$set_detil->setField('NO_PELANTIKAN', $reqJabatanFuNoPelantikan);
			$set_detil->setField("TUNJANGAN", ValToNullDB(dotToNo($reqJabatanFuTunjangan)));
			$set_detil->setField('KREDIT', ValToNullDB(dotToNo($reqJabatanFuKredit)));
			$set_detil->setField('TMT_BATAS_USIA_PENSIUN', ValToNullDB($req));
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));
			if(strlen($reqJabatanFuTmtWaktuJabatan) == 5)
			$set_detil->setField('TMT_JABATAN', dateTimeToDBCheck($reqJabatanFuTmtJabatan." ".$reqJabatanFuTmtWaktuJabatan));
			else
			$set_detil->setField('TMT_JABATAN', dateToDBCheck($reqJabatanFuTmtJabatan));

			$set_detil->setField('TMT_ESELON', ValToNullDB($req));

			$set_detil->setField('TANGGAL_PELANTIKAN', dateToDBCheck($reqJabatanFuTglPelantikan));
			$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqJabatanFuBlnDibayar));
			$set_detil->setField('KETERANGAN_BUP', $reqJabatanFuKeteranganBUP);
			$set_detil->setField('JENIS_JABATAN_ID', $reqJenisJabatan);
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpan= "";
			// if($reqMode == "insert")
			if($reqJabatanRiwayatId == "")
			{
				if($set_detil->insert())
				{
					$reqJabatanRiwayatId= $set_detil->id;
					$reqSimpan= 1;
				}
			}
			else
			{
				$set_detil->setField('JABATAN_RIWAYAT_ID', $reqJabatanRiwayatId);
				if($set_detil->update())
					$reqSimpan= 1;
			}
			
			// echo $set_detil->query;exit;
			
			if($reqSimpan == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						echo $reqRowId."-Data berhasil disimpan.";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
						
						echo "xxx-Data gagal disimpan.";
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
						echo $reqRowId."-Data berhasil disimpan.";
					else 
						echo "xxx-Data gagal disimpan.";
				}
			
			}
			else
			echo "xxx-Proses simpan belum di buat.";

		}
		elseif($reqModeSimpan == "jabatan_struktural")
		{
			$reqJenisJabatan= 1;
			$reqTipePegawaiId= 11;
			$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
			$reqJabatanStrukturalIsManual= $this->input->post("reqJabatanStrukturalIsManual");
			$reqJabatanStrukturalJabatanFuId= $this->input->post("reqJabatanStrukturalJabatanFuId");
			$reqJabatanStrukturalJabatanFtId= $this->input->post("reqJabatanStrukturalJabatanFtId");
			$reqJabatanStrukturalNoSk= $this->input->post("reqJabatanStrukturalNoSk");
			$reqJabatanStrukturalTglSk= $this->input->post("reqJabatanStrukturalTglSk");
			$reqJabatanStrukturalNama= $this->input->post("reqJabatanStrukturalNama");
			$reqJabatanStrukturalTmtJabatan= $this->input->post("reqJabatanStrukturalTmtJabatan");
			$reqJabatanStrukturalTmtWaktuJabatan= $this->input->post("reqJabatanStrukturalTmtWaktuJabatan");
			$reqJabatanStrukturalEselonId= $this->input->post("reqJabatanStrukturalEselonId");
			$reqJabatanStrukturalNama= $this->input->post("reqJabatanStrukturalNama");
			$reqJabatanStrukturalTmtEselon= $this->input->post("reqJabatanStrukturalTmtEselon");
			$reqJabatanStrukturalKeteranganBUP= $this->input->post("reqJabatanStrukturalKeteranganBUP");
			$reqJabatanStrukturalNoPelantikan= $this->input->post("reqJabatanStrukturalNoPelantikan");    
			$reqJabatanStrukturalTglPelantikan= $this->input->post("reqJabatanStrukturalTglPelantikan");
			$reqJabatanStrukturalTunjangan= $this->input->post("reqJabatanStrukturalTunjangan");
			$reqJabatanStrukturalBlnDibayar= $this->input->post("reqJabatanStrukturalBlnDibayar");
			$reqJabatanStrukturalSatkerId= $this->input->post("reqJabatanStrukturalSatkerId");
			$reqJabatanStrukturalSatker= $this->input->post("reqJabatanStrukturalSatker");
			$reqJabatanStrukturalKredit= $this->input->post("reqJabatanStrukturalKredit");
			$reqJabatanStrukturalPejabatPenetap= $this->input->post("reqJabatanStrukturalPejabatPenetap");
			$reqJabatanStrukturalPejabatPenetapId= $this->input->post("reqJabatanStrukturalPejabatPenetapId");
			
			$set_detil= new JabatanRiwayat();
			$set_detil->setField('TIPE_PEGAWAI_ID', $reqTipePegawaiId);
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			
			$set_detil->setField('JABATAN_FU_ID', ValToNullDB($reqJabatanStrukturalJabatanFuId));
			$set_detil->setField('JABATAN_FT_ID', ValToNullDB($req));
			$set_detil->setField('BIDANG_JABATAN_TERKAIT_ID', ValToNullDB($reqBidangJabatanTerkaitId));
			
			$set_detil->setField('SATKER_ID', ValToNullDB($reqJabatanStrukturalSatkerId));
			$set_detil->setField('SATKER_NAMA', $reqJabatanStrukturalSatker);
			$set_detil->setField('IS_MANUAL', ValToNullDB($reqJabatanStrukturalIsManual));
			$set_detil->setField('NO_SK', $reqNoSk);
			$set_detil->setField('ESELON_ID', ValToNullDB($reqJabatanStrukturalEselonId));
			$set_detil->setField('NAMA', $reqJabatanStrukturalNama);
			$set_detil->setField('NO_PELANTIKAN', $reqJabatanStrukturalNoPelantikan);
			$set_detil->setField("TUNJANGAN", ValToNullDB(dotToNo($reqJabatanStrukturalTunjangan)));
			$set_detil->setField('KREDIT', ValToNullDB(dotToNo($reqJabatanStrukturalKredit)));
			$set_detil->setField('TMT_BATAS_USIA_PENSIUN', ValToNullDB($req));
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));
			if(strlen($reqJabatanStrukturalTmtWaktuJabatan) == 5)
			$set_detil->setField('TMT_JABATAN', dateTimeToDBCheck($reqJabatanStrukturalTmtJabatan." ".$reqJabatanStrukturalTmtWaktuJabatan));
			else
			$set_detil->setField('TMT_JABATAN', dateToDBCheck($reqJabatanStrukturalTmtJabatan));
			$set_detil->setField('TANGGAL_PELANTIKAN', dateToDBCheck($reqJabatanStrukturalTglPelantikan));
			$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqJabatanStrukturalBlnDibayar));
			$set_detil->setField('KETERANGAN_BUP', $reqJabatanStrukturalKeteranganBUP);
			$set_detil->setField('JENIS_JABATAN_ID', $reqJenisJabatan);
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpan= "";
			// if($reqMode == "insert")
			if($reqJabatanRiwayatId == "")
			{
				if($set_detil->insert())
				{
					$reqJabatanRiwayatId= $set_detil->id;
					$reqSimpan= 1;
				}
			}
			else
			{
				$set_detil->setField('JABATAN_RIWAYAT_ID', $reqJabatanRiwayatId);
				if($set_detil->update())
					$reqSimpan= 1;
			}
			
			//echo $set_detil->query;exit;
			
			if($reqSimpan == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($req));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($req));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						echo $reqRowId."-Data berhasil disimpan.";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
				
						echo "xxx-Data gagal disimpan.";
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
						echo $reqRowId."-Data berhasil disimpan.";
					else 
						echo "xxx-Data gagal disimpan.";
				}
			
			}
			else
			echo "xxx-Proses simpan belum di buat.";
		
		}
		elseif($reqModeSimpan == "pangkat_riwayat")
		{
			//Hukuman disiplin
			$reqJenisRiwayat= 8;
			$reqKenaikanPangkatTurunKode= $this->input->post("reqKenaikanPangkatTurunKode");
			$reqKenaikanPangkatTurunTh= $this->input->post("reqKenaikanPangkatTurunTh");
			$reqKenaikanPangkatTurunBl= $this->input->post("reqKenaikanPangkatTurunBl");
			$reqKenaikanPangkatTurunGajiPokok= $this->input->post("reqKenaikanPangkatTurunGajiPokok");
			
			$set_detil= new PangkatRiwayat();
			$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatTurunKode);
			$set_detil->setField('NO_SK', $reqNoSk);	
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTmtSk));	
			$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
			$set_detil->setField('STATUS', ValToNullDB($req));
			$set_detil->setField('KETERANGAN', $req);
			$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatTurunTh));
			$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatTurunBl));
			$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatTurunGajiPokok)));
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpanTurun= "";
			// if($reqMode == "insert")
			if($reqPangkatRiwayatTurunId == "")
			{
				if($set_detil->insertHukuman())
				{
					$reqPangkatRiwayatTurunId= $set_detil->id;
					$statement= " AND PEGAWAI_ID = ".$reqId." AND JENIS_KENAIKAN IN (".$reqJenisRiwayat.") AND (COALESCE(NULLIF(STATUS, ''), NULL) IS NULL OR STATUS = '2')
					AND TANGGAL_SK = ".dateToDBCheck($reqTanggalSk)."
					AND TMT_SK = ".dateToDBCheck($reqTmtSk);
					$set_data= new PangkatRiwayat();
					$reqGajiRiwayatTurunId= $set_data->getCountByParamsGajiRiwayatId($statement);
					if($reqGajiRiwayatTurunId == ""){}
					else
					{
						//$set_data= new GajiRiwayat();
						//$set_data->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
						//$set_data->setField("LAST_USER", $this->LOGIN_USER);
						//$set_data->setField("LAST_DATE", "NOW()");
						//$set_data->setField("STATUS", "1");
						//$set_data->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
						//if($set_data->updateStatus())
						//{
							$reqSimpanTurun= 1;
						//}
						
					}
				}
			}
			else
			{
				$set_detil->setField('PANGKAT_RIWAYAT_ID', $reqPangkatRiwayatTurunId);
				if($set_detil->updateHukuman())
					$reqSimpanTurun= 1;
			}
			//echo $set_detil->query;exit;
			
			//Pemulihan hukuman disiplin
			$reqJenisRiwayat= 9;
			$reqKenaikanPangkatKembaliKode= $this->input->post("reqKenaikanPangkatKembaliKode");
			$reqKenaikanPangkatKembaliTh= $this->input->post("reqKenaikanPangkatKembaliTh");
			$reqKenaikanPangkatKembaliBl= $this->input->post("reqKenaikanPangkatKembaliBl");
			$reqKenaikanPangkatKembaliGajiPokok= $this->input->post("reqKenaikanPangkatKembaliGajiPokok");
			
			$set_detil= new PangkatRiwayat();
			$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatKembaliKode);
			$set_detil->setField('NO_SK', $reqNoSk);	
			//$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
			//$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));	
			$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalAkhir));
			$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));
			// $set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTmtSk));
			$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
			$set_detil->setField('STATUS', ValToNullDB("1"));
			$set_detil->setField('KETERANGAN', $req);
			$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatKembaliTh));
			$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatKembaliBl));
			$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatKembaliGajiPokok)));
			$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
			$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
			$set_detil->setField('PEGAWAI_ID', $reqId);
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			$set_detil->setField("LAST_DATE", "NOW()");
			
			$reqSimpanKembali= "";
			// if($reqMode == "insert")
			if($reqPangkatRiwayatKembaliId == "")
			{
				if($set_detil->insertHukuman())
				{
					$reqPangkatRiwayatKembaliId= $set_detil->id;
					$statement= " AND PEGAWAI_ID = ".$reqId." AND JENIS_KENAIKAN IN (".$reqJenisRiwayat.") AND (COALESCE(NULLIF(STATUS, ''), NULL) IS NULL OR STATUS = '2')
					AND TANGGAL_SK = ".dateToDBCheck($reqTanggalAkhir)."
					AND TMT_SK = ".dateToDBCheck($reqTanggalAkhir);
					$set_data= new PangkatRiwayat();
					$reqGajiRiwayatKembaliId= $set_data->getCountByParamsGajiRiwayatId($statement);
					if($reqGajiRiwayatKembaliId == ""){}
					else
					{
						$set_data= new GajiRiwayat();
						$set_data->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
						$set_data->setField("LAST_USER", $this->LOGIN_USER);
						$set_data->setField("USER_LOGIN_ID", $this->LOGIN_ID);
						$set_data->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
						$set_data->setField("LAST_DATE", "NOW()");
						$set_data->setField("STATUS", "1");
						$set_data->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);

						if($set_data->updateStatus())
						{
							$reqSimpanKembali= 1;
						}
						
					}
				}
			}
			else
			{
				$set_detil->setField('PANGKAT_RIWAYAT_ID', $reqPangkatRiwayatKembaliId);
				if($set_detil->updateHukuman())
				{
					$reqSimpanKembali= 1;
					$set_detil= new GajiRiwayat();
					$set_detil->setField('PANGKAT_ID', $reqKenaikanPangkatKembaliKode);
					$set_detil->setField('NO_SK', $reqNoSk);
					$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqTanggalAkhir));
					$set_detil->setField('TMT_PANGKAT', dateToDBCheck($reqTanggalAkhir));
					$set_detil->setField('JENIS_RIWAYAT', $reqJenisRiwayat);
					$set_detil->setField('STATUS', ValToNullDB("1"));
					$set_detil->setField('KETERANGAN', $req);
					$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqKenaikanPangkatKembaliTh));
					$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqKenaikanPangkatKembaliBl));
					$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqKenaikanPangkatKembaliGajiPokok)));
					$set_detil->setField('PEJABAT_PENETAP_ID', $reqPejabatPenetapId);
					$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
					$set_detil->setField('PEGAWAI_ID', $reqId);
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField('GAJI_RIWAYAT_ID', $reqGajiRiwayatKembaliId);
					$set_detil->updateHukuman();
				}
			}
			//echo $set_detil->query;exit;
			
			if($reqSimpanTurun == 1 && $reqSimpanKembali == 1)
			{
				$set->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set->setField('PEJABAT_PENETAP', $reqPejabatPenetap);
				$set->setField('PERATURAN_ID', ValToNullDB($reqPeraturan));	
				$set->setField('TINGKAT_HUKUMAN_ID', ValToNullDB($reqTingkatHukumanId));	
				$set->setField('JENIS_HUKUMAN_ID', ValToNullDB($reqJenisHukumanId));	
				$set->setField('NO_SK', $reqNoSk);	
				$set->setField('TANGGAL_SK', dateToDBCheck($reqTanggalSk));	
				$set->setField('TMT_SK', dateToDBCheck($reqTmtSk));	
				$set->setField('KETERANGAN', $reqPermasalahan);	
				$set->setField('BERLAKU', ValToNullDB($reqMasihBerlaku));	
				$set->setField('TANGGAL_MULAI', dateToDBCheck($reqTanggalMulai));	
				$set->setField('TANGGAL_AKHIR', dateToDBCheck($reqTanggalAkhir));
				$set->setField('TANGGAL_PEMULIHAN', dateToDBCheck($reqTanggalPemulihan));
				$set->setField('TMT_BERIKUT_PANGKAT', dateToDBCheck($reqKenaikanPangkatBerikutnya));
				$set->setField('TMT_BERIKUT_GAJI', dateToDBCheck($reqKenaikanGajiBerikutnya));
				
				$set->setField('GAJI_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqGajiRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TERAKHIR_ID', ValToNullDB($reqPangkatRiwayatTerakhirId));
				$set->setField('PANGKAT_RIWAYAT_TURUN_ID', ValToNullDB($reqPangkatRiwayatTurunId));
				$set->setField('GAJI_RIWAYAT_TURUN_ID', ValToNullDB($reqGajiRiwayatTurunId));
				$set->setField('PANGKAT_RIWAYAT_KEMBALI_ID', ValToNullDB($reqPangkatRiwayatKembaliId));
				$set->setField('GAJI_RIWAYAT_KEMBALI_ID', ValToNullDB($reqGajiRiwayatKembaliId));
				$set->setField('JABATAN_RIWAYAT_ID', ValToNullDB($reqJabatanRiwayatId));
				//$set->setField('PEGAWAI_STATUS_ID', ValToNullDB($reqPegawaiStatusId));
				$set->setField('PEGAWAI_STATUS_ID', $reqPegawaiStatusId);
		
				$set->setField('PEGAWAI_ID', ValToNullDB($reqId));
				$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				$set->setField("LAST_USER", $this->LOGIN_USER);
				$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$set->setField("LAST_DATE", "NOW()");
				
				if($reqMode == "insert")
				{
					if($set->insert())
					{
						$reqRowId= $set->id;
						echo $reqRowId."-Data berhasil disimpan.";
					}
					else
					{
						if($reqJabatanRiwayatId == ""){}
						else
						{
							$set_detil= new JabatanRiwayat();
							$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
							$set_detil->deleteData();
							//echo $set_detil->query;exit;
						}
		
						if($reqPangkatRiwayatTurunId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatTurunId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
							$set_detil->deleteData();
						}
						
						if($reqPangkatRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new PangkatRiwayat();
							$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqGajiRiwayatKembaliId == ""){}
						else
						{
							$set_detil= new GajiRiwayat();
							$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
							$set_detil->deleteData();
						}
						
						if($reqPegawaiStatusId == ""){}
						else
						{
							$set_detil= new PegawaiStatus();
							$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
							$set_detil->deleteData();
						}
						
						// echo $set->query;exit();
						// echo "xxx-Data gagal disimpan.";
					}
				}
				else
				{
					$set->setField('HUKUMAN_ID', $reqRowId);
					if($set->update())
						echo $reqRowId."-Data berhasil disimpan.";
					else 
						echo "xxx-Data gagal disimpan.";
				}
			
			}
			else
			{
				if($reqMode == "insert")
				{
					if($reqJabatanRiwayatId == ""){}
					else
					{
						$set_detil= new JabatanRiwayat();
						$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
						$set_detil->deleteData();
						//echo $set_detil->query;exit;
					}
	
					if($reqPangkatRiwayatTurunId == ""){}
					else
					{
						$set_detil= new PangkatRiwayat();
						$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
						$set_detil->deleteData();
					}
					
					if($reqGajiRiwayatTurunId == ""){}
					else
					{
						$set_detil= new GajiRiwayat();
						$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
						$set_detil->deleteData();
					}
					
					if($reqPangkatRiwayatKembaliId == ""){}
					else
					{
						$set_detil= new PangkatRiwayat();
						$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
						$set_detil->deleteData();
					}
					
					if($reqGajiRiwayatKembaliId == ""){}
					else
					{
						$set_detil= new GajiRiwayat();
						$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
						$set_detil->deleteData();
					}
					
					if($reqPegawaiStatusId == ""){}
					else
					{
						$set_detil= new PegawaiStatus();
						$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
						$set_detil->deleteData();
					}
				}
				
				//echo "xxx-Proses simpan belum di buat.";
				echo "xxx-Proses simpan belum di buat.a".$reqSimpanTurun.";".$reqSimpanKembali.";".$reqGajiRiwayatTurunId;
			}
		
		}
		else
		echo "xxx-Proses simpan belum di buat.b".$reqSimpanTurun.";".$reqSimpanKembali.";".$reqGajiRiwayatTurunId;
		//echo "xxx-Proses simpan belum di buat.";
	}
	
	function delete()
	{
		$this->load->model('Hukuman');
		$this->load->model('JabatanRiwayat');
		$this->load->model('PangkatRiwayat');
		$this->load->model('GajiRiwayat');
		$this->load->model('PegawaiStatus');
		
		$set= new Hukuman();
		
		$reqId =  $this->input->get('reqId');
		$reqMode =  $this->input->get('reqMode');
		
		$set_detil= new Hukuman();
		$set_detil->selectByParams(array(), -1,-1, " AND A.HUKUMAN_ID = ".$reqId);
		$set_detil->firstRow();
		//echo $set_detil->query;exit;
		$reqHukumanTmtSk= $set_detil->getField('TMT_SK');
		$reqHukumanPegawaiId= $set_detil->getField('PEGAWAI_ID');

		$reqJabatanRiwayatId= $set_detil->getField('JABATAN_RIWAYAT_ID');
		$reqPangkatRiwayatTurunId= $set_detil->getField('PANGKAT_RIWAYAT_TURUN_ID');
		$reqGajiRiwayatTurunId= $set_detil->getField('GAJI_RIWAYAT_TURUN_ID');
		$reqPangkatRiwayatKembaliId= $set_detil->getField('PANGKAT_RIWAYAT_KEMBALI_ID');
		$reqGajiRiwayatKembaliId= $set_detil->getField('GAJI_RIWAYAT_KEMBALI_ID');
		$reqPegawaiStatusId= $set_detil->getField('PEGAWAI_STATUS_ID');
		unset($set_detil);

		$set_detil= new PegawaiStatus();
		$set_detil->selectByParams(array(), -1,-1, " AND A.PEGAWAI_ID = ".$reqHukumanPegawaiId." AND TO_DATE('".$reqHukumanTmtSk."', 'YYYY-MM-DD') = A.TMT");
		$set_detil->firstRow();
		// echo $set_detil->query;exit;
		$reqPegawaiStatusId= $set_detil->getField('PEGAWAI_STATUS_ID');
		// echo $reqPegawaiStatusId;exit;

		//echo $reqGajiRiwayatTurunId;exit;
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set->setField("HUKUMAN_ID", $reqId);
		
		if($reqMode == "hukuman_0")
		{
			$set->setField("STATUS", "1");
			if($reqJabatanRiwayatId == "" && $reqPangkatRiwayatTurunId == "" && $reqPangkatRiwayatKembaliId == "" && $reqPegawaiStatusId == "")
			{
				if($set->updateStatus())
				{
					echo "Data berhasil di nonaktifkan.";
				}
				else
					echo "Data gagal di nonaktifkan.";	
			}
			else
			{
				$reqsimpan="";
				if($reqJabatanRiwayatId == ""){}
				else
				{
					$set_detil= new JabatanRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
					//echo $set_detil->query;exit;
				}

				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPangkatRiwayatTurunId == ""){}
				else
				{
					$set_detil= new PangkatRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqGajiRiwayatTurunId == ""){}
				else
				{
					$set_detil= new GajiRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPangkatRiwayatKembaliId == ""){}
				else
				{
					$set_detil= new PangkatRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPangkatRiwayatKembaliId == ""){}
				else
				{
					$set_detil= new GajiRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatKembaliId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPegawaiStatusId == ""){}
				else
				{
					$set_detil= new PegawaiStatus();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "1");
					$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				if($reqsimpan == "1")
				{
					if($set->updateStatus())
					{
						echo "Data berhasil di nonaktifkan.";
					}
					else
						echo "Data gagal di nonaktifkan.";	
				}
				else
					echo "Data gagal di nonaktifkan.";
			}	
			
		}
		elseif($reqMode == "hukuman_1")
		{
			$set->setField("STATUS", "2");
			if($reqJabatanRiwayatId == "" && $reqPangkatRiwayatTurunId == "" && $reqPangkatRiwayatKembaliId == "" && $reqPegawaiStatusId == "")
			{
				if($set->updateStatus())
					echo "Data berhasil di aktifkan.";
				else
					echo "Data gagal di aktifkan.";	
			}
			else
			{
				$reqsimpan="";
				if($reqJabatanRiwayatId == ""){}
				else
				{
					$set_detil= new JabatanRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "2");
					$set_detil->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
					
				}

				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPangkatRiwayatTurunId == ""){}
				else
				{
					$set_detil= new PangkatRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "2");
					$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatTurunId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqGajiRiwayatTurunId == ""){}
				else
				{
					$set_detil= new GajiRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "2");
					$set_detil->setField("GAJI_RIWAYAT_ID", $reqGajiRiwayatTurunId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				/*if($reqPangkatRiwayatKembaliId == ""){}
				else
				{
					$set_detil= new PangkatRiwayat();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("STATUS", "2");
					$set_detil->setField("PANGKAT_RIWAYAT_ID", $reqPangkatRiwayatKembaliId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}*/
				//}
				
				//if($reqsimpan == 1){}
				//else
				//{
				if($reqPegawaiStatusId == ""){}
				else
				{
					$set_detil= new PegawaiStatus();
					$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
					$set_detil->setField("LAST_USER", $this->LOGIN_USER);
					$set_detil->setField("LAST_DATE", "NOW()");
					$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					$set_detil->setField("STATUS", "2");
					$set_detil->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
					if($set_detil->updateStatus())
					{
						$reqsimpan= 1;
					}
				}
				//}
				
				if($reqsimpan == "1")
				{
					if($set->updateStatus())
					{
						echo "Data berhasil di aktifkan.";
					}
					else
						echo "Data gagal di aktifkan.";	
				}
				else
					echo "Data gagal di aktifkan.";
			}
			
		}
	}

	function getpangkatriwayat() 
	{
		$this->load->model("Hukuman");
		$set= new Hukuman();
		
		$reqTmtSk= $this->input->get("reqTmtSk");
		$reqId= $this->input->get("reqId");
		
		$statement= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqId;
		$set->selectByParamsPangkatRiwayat(array(), -1,-1, dateToPageCheck($reqTmtSk), $statement);
		$set->firstRow();
		//echo $set->query;exit;
		$tempPangkatRiwayatId= $set->getField("PANGKAT_RIWAYAT_ID");
		$tempPangkatId= $set->getField("PANGKAT_ID");
		$tempKode= $set->getField("PANGKAT_KODE");
		$tempTmt= dateToPageCheck($set->getField("PANGKAT_TMT"));
		$tempMasaKerjaTahun= $set->getField("MASA_KERJA_TAHUN");
		$tempMasaKerjaBulan= $set->getField("MASA_KERJA_BULAN");
		$tempGajiPokok= numberToIna($set->getField("GAJI_POKOK"));
		
		$tempInfo= $tempKode.", TMT : ".$tempTmt;
		$arrData= array("pangkat"=>$tempInfo, "pangkatriwayatid"=>$tempPangkatRiwayatId, "pangkatid"=>$tempPangkatId, "tmt"=>$tempTmt, "masatahun"=>$tempMasaKerjaTahun, "masabulan"=>$tempMasaKerjaBulan, "gajipokok"=>$tempGajiPokok);
		
		echo json_encode($arrData);
	}
	
	function getpangkatriwayatturun() 
	{
		$this->load->model("Hukuman");
		$this->load->model("GajiPokok");
		
		$reqPangkatId= $this->input->get("reqPangkatId");
		$reqMasaKerjaTahun= $this->input->get("reqMasaKerjaTahun");
		$reqMasaKerjaBulan= $this->input->get("reqMasaKerjaBulan");
		$reqAwal= $this->input->get("reqAwal");
		$reqAkhir= $this->input->get("reqAkhir");
		$reqTmt= $this->input->get("reqTmt");
		$reqId= $this->input->get("reqId");
		
		$set= new Hukuman();
		$set->selectByParamsPangkatTurunInfo($reqPangkatId, dateToDbCheck($reqAwal), dateToDbCheck($reqAkhir));
		$set->firstRow();
		// echo $set->query;exit;
		$tempPangkatId= $set->getField("PANGKAT_ID");
		$tempSelisih= $set->getField("SELISIH");
		// echo $tempSelisih;exit();
		$arrSelisih= explode(" - ", $tempSelisih);
		$tempMasaKerjaTahun= $arrSelisih[0];
		$tempMasaKerjaBulan= $arrSelisih[1];
		
		$addBulan= 0;
		$tempMasaKerjaBulanPerubahan= $reqMasaKerjaBulan + $tempMasaKerjaBulan;
		if($tempMasaKerjaBulanPerubahan % 12 == 0)
		{
			$tempMasaKerjaBulanPerubahan= 0;
		}
		elseif($tempMasaKerjaBulanPerubahan % 24 == 0)
		{
			$tempMasaKerjaBulanPerubahan= 0;
		}
		elseif($tempMasaKerjaBulanPerubahan > 12)
		{
			$infotahun= round(($tempMasaKerjaBulanPerubahan / 12));
			$tempMasaKerjaBulanPerubahan= $tempMasaKerjaBulanPerubahan % 12;
			// echo $infotahun;exit;
			$addBulan= $infotahun;
		}
		// echo $reqMasaKerjaBulan."-".$tempMasaKerjaBulan;exit();

		// $tempMasaKerjaTahunPerubahan= $reqMasaKerjaTahun + $tempMasaKerjaTahun + floor(($reqMasaKerjaBulan + $tempMasaKerjaBulan) / 12);
		$tempMasaKerjaTahunPerubahan= $reqMasaKerjaTahun + $tempMasaKerjaTahun + $addBulan;
		
		$set= new GajiPokok();
		$tempPeriode= str_replace("-","",$reqTmt);
		$tempGajiPokok= numberToIna($set->getCountByParamsGajiBerlaku($tempPeriode, $tempMasaKerjaTahunPerubahan, $tempPangkatId));
		//echo $tempMasaKerjaTahunPerubahan." ".$tempMasaKerjaBulanPerubahan;
		if($tempGajiPokok == "")
		$tempGajiPokok= 0;
		
		$arrData= array("pangkatid"=>$tempPangkatId, "masatahun"=>$tempMasaKerjaTahunPerubahan, "masabulan"=>$tempMasaKerjaBulanPerubahan, "gajipokok"=>$tempGajiPokok);
		echo json_encode($arrData);
	}
	
	function getpangkatriwayatkembali() 
	{
		$this->load->model("Hukuman");
		$this->load->model("GajiPokok");
		
		$reqPangkatId= $this->input->get("reqPangkatId");
		$reqMasaKerjaTahun= $this->input->get("reqMasaKerjaTahun");
		$reqMasaKerjaBulan= $this->input->get("reqMasaKerjaBulan");
		$reqAwal= $this->input->get("reqAwal");
		$reqAkhir= $this->input->get("reqAkhir");
		$reqTmt= $this->input->get("reqTmt");
		$reqId= $this->input->get("reqId");
		
		$set= new Hukuman();
		$set->selectByParamsPangkatTurunInfo($reqPangkatId, dateToDbCheck($reqAwal), dateToDbCheck($reqAkhir));
		$set->firstRow();
		$tempPangkatId= $reqPangkatId;
		$tempSelisih= $set->getField("SELISIH");
		$arrSelisih= explode(" - ", $tempSelisih);
		$tempMasaKerjaTahun= $arrSelisih[0];
		$tempMasaKerjaBulan= $arrSelisih[1];
		
		$addBulan= 0;
		$tempMasaKerjaBulanPerubahan= $reqMasaKerjaBulan + $tempMasaKerjaBulan;
		if($tempMasaKerjaBulanPerubahan % 12 == 0)
		{
			$tempMasaKerjaBulanPerubahan= 0;
		}
		elseif($tempMasaKerjaBulanPerubahan % 24 == 0)
		{
			$tempMasaKerjaBulanPerubahan= 0;
		}
		elseif($tempMasaKerjaBulanPerubahan > 12)
		{
			$infotahun= round(($tempMasaKerjaBulanPerubahan / 12));
			$tempMasaKerjaBulanPerubahan= $tempMasaKerjaBulanPerubahan % 12;
			// echo $infotahun;exit;
			$addBulan= $infotahun;
		}
		// echo $reqMasaKerjaBulan."-".$tempMasaKerjaBulan;exit();

		// $tempMasaKerjaTahunPerubahan= $reqMasaKerjaTahun + $tempMasaKerjaTahun + floor(($reqMasaKerjaBulan + $tempMasaKerjaBulan) / 12);
		$tempMasaKerjaTahunPerubahan= $reqMasaKerjaTahun + $tempMasaKerjaTahun + $addBulan;

		$set= new GajiPokok();
		$tempPeriode= str_replace("-","",$reqTmt);
		$tempGajiPokok= numberToIna($set->getCountByParamsGajiBerlaku($tempPeriode, $tempMasaKerjaTahunPerubahan, $tempPangkatId));
		if($tempGajiPokok == "")
		$tempGajiPokok= 0;
		//echo $tempMasaKerjaTahunPerubahan." ".$tempMasaKerjaBulanPerubahan;
		
		$arrData= array("pangkatid"=>$tempPangkatId, "masatahun"=>$tempMasaKerjaTahunPerubahan, "masabulan"=>$tempMasaKerjaBulanPerubahan, "gajipokok"=>$tempGajiPokok);
		echo json_encode($arrData);
	}
	
	function getgajiriwayat() 
	{
		$this->load->model("Hukuman");
		$set= new Hukuman();
		
		$reqTmtSk= $this->input->get("reqTmtSk");
		$reqId= $this->input->get("reqId");
		
		$statement= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqId;
		$set->selectByParamsGajiRiwayat(array(), -1,-1, dateToPageCheck($reqTmtSk), $statement);
		$set->firstRow();
		//echo $set->query;exit;
		$tempGajiRiwayatId= $set->getField("GAJI_RIWAYAT_ID");
		$tempKode= $set->getField("PANGKAT_KODE");
		$tempTmt= dateToPageCheck($set->getField("TMT_SK"));
		$tempMasaKerjaTahun= $set->getField("MASA_KERJA_TAHUN");
		$tempMasaKerjaBulan= $set->getField("MASA_KERJA_BULAN");
		$tempGajiPokok= numberToIna($set->getField("GAJI_POKOK"));
		
		$tempInfo= $tempKode.", TMT : ".$tempTmt;
		$arrData= array("pangkat"=>$tempInfo, "gajiriwayatid"=>$tempGajiRiwayatId, "masatahun"=>$tempMasaKerjaTahun, "masabulan"=>$tempMasaKerjaBulan, "gajipokok"=>$tempGajiPokok);
		
		echo json_encode($arrData);
	}
	
	function log($riwayatId) 
	{	
		$this->load->model('HukumanLog');

		$set = new HukumanLog();
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		
		
		$aColumns = array("INFO_LOG", "LAST_USER", "LAST_DATE", "STATUS_NAMA", "HUKUMAN_ID");
		$aColumnsAlias = array("INFO_LOG", "LAST_USER", "LAST_DATE", "STATUS_NAMA", "HUKUMAN_ID");
		

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
				$sOrder = " ORDER BY LAST_DATE ASC ";
				 
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
		
		$sOrder= " ORDER BY A.LAST_DATE DESC ";
		// $searchJson = "  AND (UPPER(NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%')";
		$allRecord = $set->getCountByParams(array());
		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getCountByParams(array(), $searchJson);
		
		$arrayWhere = array("HUKUMAN_ID" => $riwayatId);
		$set->selectByParams($arrayWhere, $dsplyRange, $dsplyStart, $searchJson, $sOrder);     		
		
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
				if($aColumns[$i] == "LAST_DATE")
					$row[] = getFormattedDateTime($set->getField($aColumns[$i]));
				else if($aColumns[$i] == "KETERANGAN")
					$row[] = truncate($set->getField($aColumns[$i]), 5)."...";
				else
					$row[] = $set->getField($aColumns[$i]);
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

}
?>