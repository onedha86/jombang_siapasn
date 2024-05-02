<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");

class kenaikan_gaji_pppk_berkala_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		//kauth
		if (!$this->kauth->getInstance()->hasIdentity())
		{
			// trow to unauthenticated page!
			//redirect('Login');
		}       
		
		/* GLOBAL VARIABLE */
		$this->USER_GROUP= $this->kauth->getInstance()->getIdentity()->USER_GROUP;
		$this->LOGIN_USER= $this->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$this->LOGIN_LEVEL= $this->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$this->SATUAN_KERJA_TIPE= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_TIPE;
		$this->SATUAN_KERJA_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_ID;
		$this->SATUAN_KERJA_BKD_ID= $this->kauth->getInstance()->getIdentity()->SATUAN_KERJA_BKD_ID;
		$this->LOGIN_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$this->LOGIN_PEGAWAI_ID= $this->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;
		$this->STATUS_SATUAN_KERJA_BKD= $this->kauth->getInstance()->getIdentity()->STATUS_SATUAN_KERJA_BKD;
	}	

	function addshortcut()
	{
		$this->load->model('KenaikanGajiPppkBerkala');
		$this->load->model('TandaTanganBkd');
		$this->load->model('PejabatPenetap');
		
		$reqMode= $this->input->get("reqMode");
		$reqStatusKgb= $this->input->get("reqStatusKgb");
		$reqPegawaiId= $this->input->get("reqPegawaiId");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqPeriodeLama= $reqPeriode= $reqBulan.$reqTahun;
		
		$statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PERIODE = '".$reqPeriode."'";
		$set= new KenaikanGajiPppkBerkala();
		$set->selectByParamsData(array(), -1, -1, $statement);
		$set->firstRow();
		//echo $set->query;exit;
		$reqRiwayatGajiBaruTmt= dateToPageCheck($set->getField('TMT_BARU'));
		$reqRiwayatGajiBaruMasaKerjaTahun= $set->getField('MASA_KERJA_TAHUN_BARU');
		$reqRiwayatGajiBaruMasaKerjaBulan= $set->getField('MASA_KERJA_BULAN_BARU');
		$reqRiwayatGajiBaruGaji= numberToIna($set->getField('GAJI_BARU'));
		$reqRiwayatGajiBaruTanggalBaru= dateToPageCheck($set->getField('TANGGAL_BARU'));
		$reqGajiRiwayatLamaId= $set->getField('GAJI_RIWAYAT_LAMA_ID');
		$reqRiwayatGajiLamaGolId= $set->getField('PANGKAT_ID');
		$reqSatuanKerjaId= $set->getField('SATUAN_KERJA_ID');
		$reqSuratKeluarBkdId= $set->getField('SURAT_KELUAR_BKD_ID');
		$reqNomorUrut= $set->getField('NOMOR_URUT');
		$reqKeteranganTeknis= $set->getField('KETERANGAN_TEKNIS');
		
		if($reqMode == "updateselesai" || $reqMode == "update")
		{
			$statement= " AND A.TANDA_TANGAN_BKD_ID = (SELECT AMBIL_TANDA_TANGAN_BKD_TGL(TO_DATE('".$reqRiwayatGajiBaruTmt."', 'DD-MM-YYYY')))";
			$tandatangan= new TandaTanganBkd();
			$tandatangan->selectByParams(array(),-1,-1, $statement);
			$tandatangan->firstRow();
			//echo $tandatangan->query;exit;
			$reqPejabatPenetap= strtoupper($tandatangan->getField("PEJABAT_PENETAP"));
			
			if($reqPejabatPenetap == "")
			{
				$statementpejabat= " AND (COALESCE(NULLIF(A.NAMA, ''), NULL) IS NULL)";
			}
			else
			{
				$statementpejabat= " AND UPPER(A.NAMA) = '".$reqPejabatPenetap."'";
			}
			
			$pejabatpenetap= new PejabatPenetap();
			$pejabatpenetap->selectByParams(array(),-1,-1, $statementpejabat);
			//echo $pejabatpenetap->query;exit;
			$pejabatpenetap->firstRow();
			$reqPejabatPenetapId= $pejabatpenetap->getField("PEJABAT_PENETAP_ID");
			
			if($reqPejabatPenetapId == "")
			{
				$pejabatpenetap= new PejabatPenetap();
				$pejabatpenetap->setField("NAMA", strtoupper($reqPejabatPenetap));
				$pejabatpenetap->setField("LAST_USER", $this->LOGIN_USER);
				$pejabatpenetap->setField("LAST_DATE", "NOW()");
				$pejabatpenetap->insert();
				$reqPejabatPenetapId= $pejabatpenetap->id;
			}
		}
		//echo $reqPejabatPenetapId;exit;
		//TandaTanganBkd
		//PejabatPenetap
				
		//echo $reqRiwayatGajiLamaGolId;exit;
		$set = new KenaikanGajiPppkBerkala();
		$set->setField("GAJI_RIWAYAT_LAMA_ID", $reqGajiRiwayatLamaId);
		$set->setField("SATUAN_KERJA_ID", $reqSatuanKerjaId);
		$set->setField("TMT_BARU", dateToDBCheck($reqRiwayatGajiBaruTmt));
		$set->setField("MASA_KERJA_TAHUN_BARU", $reqRiwayatGajiBaruMasaKerjaTahun);
		$set->setField("MASA_KERJA_BULAN_BARU", $reqRiwayatGajiBaruMasaKerjaBulan);
		$set->setField("GAJI_BARU", ValToNullDB(dotToNo($reqRiwayatGajiBaruGaji)));
		$set->setField("TANGGAL_BARU", dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
		$set->setField("NOMOR_URUT", ValToNullDB($reqNomorUrut));
		$set->setField("PEGAWAI_ID", $reqPegawaiId);
		$set->setField("PERIODE", $reqPeriode);
		$set->setField("SURAT_KELUAR_BKD_ID", $reqSuratKeluarBkdId);
		$set->setField("STATUS_KGB", $reqStatusKgb);
		$set->setField("KETERANGAN_TEKNIS", $reqKeteranganTeknis);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
			
		if($reqMode == "update" || $reqMode == "updateselesai")
		{
			$reqSimpan= "";
			if($reqMode == "updateselesai")
			{
				if($set->updateSelesai())
				{
					$reqSimpan= "1";
				}
			}
			else
			{
				//kalau kosong maka buat nomor urut baru
				if($reqNomorUrut == "")
				{
					if($set->updateSetNomor())
					{
						$reqSimpan= "1";
					}
				}
				else
				{
					if($set->update())
					{
						$reqSimpan= "1";
					}
				}
			}
			
			if($reqStatusKgb == "3")
			{
				$set_detil= new KenaikanGajiPppkBerkala();
				$set_detil->setField("PERIODE", $reqPeriode);
				$set_detil->setField('JENIS_KENAIKAN', 3);
				$set_detil->setField('NO_SK', $reqNoSk);
				$set_detil->setField('PANGKAT_ID', $reqRiwayatGajiLamaGolId);
				$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
				$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqRiwayatGajiBaruGaji)));
				$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqRiwayatGajiBaruMasaKerjaTahun));
				$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqRiwayatGajiBaruMasaKerjaBulan));
				$set_detil->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
				$set_detil->setField('TMT_SK', dateToDBCheck($reqRiwayatGajiBaruTmt));
				$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
				$set_detil->setField('PEGAWAI_ID', $reqPegawaiId);
				$set_detil->setField('GAJI_RIWAYAT_ID', $reqGajiRiwayatBaruId);
				$set_detil->setField("LAST_LEVEL", "50");
				$set_detil->setField("LAST_USER", "SIAP ASN");
				//$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				//$set_detil->setField("LAST_USER", $this->LOGIN_USER);
				$set_detil->setField("LAST_DATE", "NOW()");
				
				$reqSimpan= "";
				if($reqGajiRiwayatBaruId == "")
				{
					if($set_detil->insertGajiRiwayat())
					{
						$reqSimpan= "1";
					}
				}
				else
				{
					if($set_detil->updateGajiRiwayat())
					{
						$reqSimpan= "1";
					}
				}
				//echo $set_detil->query;exit;
				
				//kalau gagal
				if($reqSimpan == "")
				{
					$set_status = new KenaikanGajiPppkBerkala();
					$set_status->setField("PEGAWAI_ID", $reqPegawaiId);
					$set_status->setField("PERIODE", $reqPeriodeLama);
					$set_status->setField("STATUS", "NULL");
					$set_status->setField("STATUS_KGB", 2);
					$set_status->setField("LAST_USER", $this->LOGIN_USER);
					$set_status->setField("LAST_DATE", "NOW()");
					if($set_status->updateStatus()){}
				}
				
			}
			
			if($reqSimpan == "1")
			{
				$set_status = new KenaikanGajiPppkBerkala();
				$set_status->setField("PEGAWAI_ID", $reqPegawaiId);
				$set_status->setField("PERIODE", $reqPeriodeLama);
				$set_status->setField("LAST_USER", $this->LOGIN_USER);
				$set_status->setField("LAST_DATE", "NOW()");
				if($set_status->updateResetStatusHitung()){}
				
				echo "Data berhasil disimpan.";
			}
			else
			echo "Data gagal disimpan.";
		}
		else
			echo "Data gagal disimpan.";
		
	}
	
	function add()
	{
		$this->load->model('KenaikanGajiPppkBerkala');
		$this->load->model('TandaTanganBkd');
		$this->load->model('PejabatPenetap');
		
		$reqMode= $this->input->post("reqMode");
		$reqStatusKgb= $this->input->post("reqStatusKgb");
		$reqSuratKeluarBkdId= $this->input->post("reqSuratKeluarBkdId");
		$reqPeriode= $this->input->post("reqPeriode");
		$reqPegawaiId= $this->input->post("reqPegawaiId");
		$reqNomorUrut= $this->input->post("reqNomorUrut");
		$reqRiwayatGajiBaruTanggalBaru= $this->input->post("reqRiwayatGajiBaruTanggalBaru");
		$reqRiwayatGajiBaruGaji= $this->input->post("reqRiwayatGajiBaruGaji");
		$reqRiwayatGajiBaruMasaKerjaBulan= $this->input->post("reqRiwayatGajiBaruMasaKerjaBulan");
		$reqRiwayatGajiBaruMasaKerjaTahun= $this->input->post("reqRiwayatGajiBaruMasaKerjaTahun");
		$reqRiwayatGajiBaruTmt= $this->input->post("reqRiwayatGajiBaruTmt");
		$reqSatuanKerjaId= $this->input->post("reqSatuanKerjaId");
		$reqGajiRiwayatLamaId= $this->input->post("reqGajiRiwayatLamaId");
		$reqKeteranganTeknis= $this->input->post("reqKeteranganTeknis");
		$reqPegawaiStatusId= $this->input->post("reqPegawaiStatusId");
		$reqJabatanRiwayatId= $this->input->post("reqJabatanRiwayatId");
		$reqHukumanRiwayatId= $this->input->post("reqHukumanRiwayatId");
		$reqPeriodeLama= $this->input->post("reqPeriodeLama");
		$reqRiwayatGajiLamaGolId= $this->input->post("reqRiwayatGajiLamaGolId");
		$reqGajiRiwayatBaruId= $this->input->post("reqGajiRiwayatBaruId");
		$reqStatusHitungUlang= $this->input->post("reqStatusHitungUlang");

		$reqDataGajiRiwayatId1= $this->input->post("reqDataGajiRiwayatId1");
		$reqDataGajiRiwayatId2= $this->input->post("reqDataGajiRiwayatId2");

		// echo $reqDataGajiRiwayatId1."--".$reqDataGajiRiwayatId2;exit();
		
		//echo $reqGajiRiwayatLamaId;exit;
		//set pejabat penetap
		if($reqMode == "updateselesai" || $reqMode == "update")
		{
			$statement= " AND A.TANDA_TANGAN_BKD_ID = (SELECT AMBIL_TANDA_TANGAN_BKD_TGL(TO_DATE('".$reqRiwayatGajiBaruTmt."', 'DD-MM-YYYY')))";
			$tandatangan= new TandaTanganBkd();
			$tandatangan->selectByParams(array(),-1,-1, $statement);
			$tandatangan->firstRow();
			//echo $tandatangan->query;exit;
			$reqPejabatPenetap= strtoupper($tandatangan->getField("PEJABAT_PENETAP"));
			
			if($reqPejabatPenetap == "")
			{
				$statementpejabat= " AND (COALESCE(NULLIF(A.NAMA, ''), NULL) IS NULL)";
			}
			else
			{
				$statementpejabat= " AND UPPER(A.NAMA) = '".$reqPejabatPenetap."'";
			}
			
			$pejabatpenetap= new PejabatPenetap();
			$pejabatpenetap->selectByParams(array(),-1,-1, $statementpejabat);
			//echo $pejabatpenetap->query;exit;
			$pejabatpenetap->firstRow();
			$reqPejabatPenetapId= $pejabatpenetap->getField("PEJABAT_PENETAP_ID");
			
			if($reqPejabatPenetapId == "")
			{
				$pejabatpenetap= new PejabatPenetap();
				$pejabatpenetap->setField("NAMA", strtoupper($reqPejabatPenetap));
				$pejabatpenetap->setField("LAST_USER", $this->LOGIN_USER);
				$pejabatpenetap->setField("LAST_DATE", "NOW()");
				$pejabatpenetap->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$pejabatpenetap->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				$pejabatpenetap->insert();
				$reqPejabatPenetapId= $pejabatpenetap->id;
			}
		}
		//echo $reqPejabatPenetapId;exit;
		//TandaTanganBkd
		//PejabatPenetap
				
		//echo $reqRiwayatGajiLamaGolId;exit;
		$set = new KenaikanGajiPppkBerkala();
		$set->setField("GAJI_RIWAYAT_LAMA_ID", $reqGajiRiwayatLamaId);
		$set->setField("SATUAN_KERJA_ID", $reqSatuanKerjaId);
		$set->setField("TMT_BARU", dateToDBCheck($reqRiwayatGajiBaruTmt));
		$set->setField("MASA_KERJA_TAHUN_BARU", $reqRiwayatGajiBaruMasaKerjaTahun);
		$set->setField("MASA_KERJA_BULAN_BARU", $reqRiwayatGajiBaruMasaKerjaBulan);
		$set->setField("GAJI_BARU", ValToNullDB(dotToNo($reqRiwayatGajiBaruGaji)));
		$set->setField("TANGGAL_BARU", dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
		$set->setField("NOMOR_URUT", ValToNullDB($reqNomorUrut));
		$set->setField("PEGAWAI_ID", $reqPegawaiId);
		$set->setField("PERIODE", $reqPeriode);
		$set->setField("SURAT_KELUAR_BKD_ID", $reqSuratKeluarBkdId);
		$set->setField("STATUS_KGB", $reqStatusKgb);
		$set->setField("KETERANGAN_TEKNIS", $reqKeteranganTeknis);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("LAST_DATE", "NOW()");
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			
		if($reqMode == "update" || $reqMode == "updateselesai")
		{
			$reqSimpan= "";
			if($reqMode == "updateselesai")
			{
				if($set->updateSelesai())
				{
					$reqSimpan= "1";
				}
			}
			else
			{
				//kalau kosong maka buat nomor urut baru
				if($reqNomorUrut == "")
				{
					if($set->updateSetNomor())
					{
						$reqSimpan= "1";
					}
				}
				else
				{
					if($set->update())
					{
						$reqSimpan= "1";
					}
				}
			}
			
			if($reqStatusKgb == "3")
			{
				$set_detil= new KenaikanGajiPppkBerkala();
				$set_detil->setField("PERIODE", $reqPeriode);
				$set_detil->setField('JENIS_KENAIKAN', 3);
				$set_detil->setField('NO_SK', $reqNoSk);
				$set_detil->setField('PANGKAT_ID', $reqRiwayatGajiLamaGolId);
				$set_detil->setField('TANGGAL_SK', dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
				$set_detil->setField("GAJI_POKOK", ValToNullDB(dotToNo($reqRiwayatGajiBaruGaji)));
				$set_detil->setField('MASA_KERJA_TAHUN', ValToNullDB($reqRiwayatGajiBaruMasaKerjaTahun));
				$set_detil->setField('MASA_KERJA_BULAN', ValToNullDB($reqRiwayatGajiBaruMasaKerjaBulan));
				$set_detil->setField('PEJABAT_PENETAP_ID', ValToNullDB($reqPejabatPenetapId));	
				$set_detil->setField('PEJABAT_PENETAP', strtoupper($reqPejabatPenetap));
				$set_detil->setField('TMT_SK', dateToDBCheck($reqRiwayatGajiBaruTmt));
				$set_detil->setField('BULAN_DIBAYAR', dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
				$set_detil->setField('PEGAWAI_ID', $reqPegawaiId);
				$set_detil->setField('GAJI_RIWAYAT_ID', $reqGajiRiwayatBaruId);
				$set_detil->setField("LAST_LEVEL", "50");
				$set_detil->setField("LAST_USER", "SIAP ASN");
				//$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
				//$set_detil->setField("LAST_USER", $this->LOGIN_USER);
				$set_detil->setField("LAST_DATE", "NOW()");
				$set_detil->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				
				$reqSimpan= "";
				if($reqGajiRiwayatBaruId == "")
				{
					if($set_detil->insertGajiRiwayat())
					{
						$reqSimpan= "1";
					}
				}
				else
				{
					if($set_detil->updateGajiRiwayat())
					{
						$reqSimpan= "1";
					}
				}
				// echo $set_detil->query;exit();

				// reset ulang
				if($reqDataGajiRiwayatId1 == $reqDataGajiRiwayatId2){}
				else
				{
					if($reqPeriode == $reqPeriodeLama){}
					else
					{
						$set_reset= new KenaikanGajiPppkBerkala();
						$set_reset->setField("PEGAWAI_ID", $reqPegawaiId);
						$set_reset->setField("PERIODE", $reqPeriodeLama);
						$set_reset->setField("STATUS", "1");
						$set_reset->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
						$set_reset->setField("LAST_USER", $this->LOGIN_USER);
						$set_reset->setField("USER_LOGIN_ID", $this->LOGIN_ID);
						$set_reset->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
						$set_reset->setField("LAST_DATE", "NOW()");
						$set_reset->updateBatal();
					}
				}
				
				//kalau gagal
				if($reqSimpan == "")
				{
					$set_status = new KenaikanGajiPppkBerkala();
					$set_status->setField("PEGAWAI_ID", $reqPegawaiId);
					$set_status->setField("PERIODE", $reqPeriodeLama);
					$set_status->setField("STATUS", "NULL");
					$set_status->setField("STATUS_KGB", 2);
					$set_status->setField("LAST_USER", $this->LOGIN_USER);
					$set_status->setField("LAST_DATE", "NOW()");
					$set_status->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_status->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
					if($set_status->updateStatus()){}
				}

				
			}
			
			if($reqSimpan == "1")
			{
				$set_status = new KenaikanGajiPppkBerkala();
				$set_status->setField("PEGAWAI_ID", $reqPegawaiId);
				$set_status->setField("PERIODE", $reqPeriodeLama);
				$set_status->setField("LAST_USER", $this->LOGIN_USER);
				$set_status->setField("LAST_DATE", "NOW()");
				$set_status->setField("USER_LOGIN_ID", $this->LOGIN_ID);
				$set_status->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
				if($set_status->updateResetStatusHitung()){}
				
				echo "-Data berhasil disimpan.";
			}
			else
			echo "xxx-Data gagal disimpan.";
			
					
		}
		else
		{
			$statement= " AND A.PERIODE = '".$reqPeriode."' AND A.PEGAWAI_ID = ".$reqPegawaiId;
			$set_data= new KenaikanGajiPppkBerkala();
			$set_data->selectByParams(array(), -1,-1, $statement);
			$set_data->firstRow();
			//echo $set_data->query;exit;
			$tempPegawaiId= $set_data->getField("PEGAWAI_ID");
			
			$set_data = new KenaikanGajiPppkBerkala();
			$set_data->setField("PEGAWAI_ID", $reqPegawaiId);
			$set_data->setField("PERIODE", $reqPeriode);			
			$set_data->setField("PEGAWAI_STATUS_ID", $reqPegawaiStatusId);
			$set_data->setField("JABATAN_RIWAYAT_ID", $reqJabatanRiwayatId);
			$set_data->setField("SURAT_KELUAR_BKD_ID", $reqSuratKeluarBkdId);
			$set_data->setField("HUKUMAN_RIWAYAT_ID", ValToNullDB($reqHukumanRiwayatId));
			$set_data->setField("GAJI_RIWAYAT_LAMA_ID", $reqGajiRiwayatLamaId);
			$set_data->setField("SATUAN_KERJA_ID", $reqSatuanKerjaId);
			$set_data->setField("GAJI_BARU", ValToNullDB(dotToNo($reqRiwayatGajiBaruGaji)));
			$set_data->setField("TANGGAL_BARU", dateToDBCheck($reqRiwayatGajiBaruTanggalBaru));
			$set_data->setField("NOMOR_URUT", ValToNullDB($reqNomorUrut));
			$set_data->setField("TMT_BARU", dateToDBCheck($reqRiwayatGajiBaruTmt));
			$set_data->setField("MASA_KERJA_TAHUN_BARU", $reqRiwayatGajiBaruMasaKerjaTahun);
			$set_data->setField("MASA_KERJA_BULAN_BARU", $reqRiwayatGajiBaruMasaKerjaBulan);
			$set_data->setField("STATUS_KGB", 2);
			$set_data->setField("LAST_USER", $this->LOGIN_USER);
			$set_data->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_data->setField("LAST_DATE", "NOW()");
			$set_data->setField("USER_LOGIN_ID", $this->LOGIN_ID);
			$set_data->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
			
			$reqSimpan= "";
			if($tempPegawaiId == "")
			{
				if($set_data->insert())
				{
					$reqSimpan= "1";
				}
			}
			else
			{
				if($set_data->update())
				{
					$reqSimpan= "1";
				}
				//echo $set_data->query;exit;
			}
			
			if($reqSimpan == "1")
			{
				//kalau reqStatusKgb masih proses
				//if($reqStatusKgb == "2")
				//{
					$set_status = new KenaikanGajiPppkBerkala();
					$set_status->setField("PEGAWAI_ID", $reqPegawaiId);
					$set_status->setField("PERIODE", $reqPeriodeLama);
					$set_status->setField("STATUS", 1);
					$set_status->setField("STATUS_KGB", 4);
					$set_status->setField("LAST_USER", $this->LOGIN_USER);
					$set_status->setField("LAST_DATE", "NOW()");
					$set_status->setField("USER_LOGIN_ID", $this->LOGIN_ID);
					$set_status->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));

					if($set_status->updateStatus())
					{
						echo "-Data berhasil disimpan.";
					}
					else
					{
						echo "xxx-Data gagal disimpan.";
					}
				//}
				//else
				//{
					//echo "xxx-Data gagal disimpan.";
				//}
			}
			else
			{
				echo "xxx-Data gagal disimpan.";
			}
				
			//echo $set_data->query;exit;
			//echo "xxx-Data gagal disimpan.";
		}
		//echo "-".$reqMode;exit;
	}
	
	function json() 
	{
		$this->load->model('KenaikanGajiPppkBerkala');
		$this->load->model('SatuanKerja');

		$set = new KenaikanGajiPppkBerkala();

		$reqAkses= $this->input->get("reqAkses");
		$reqMode= $this->input->get("reqMode");
		$reqSatuanKerjaId= $this->input->get("reqSatuanKerjaId");
		$tempSatuanKerjaId= $reqSatuanKerjaId;
		$reqStatusKgb= $this->input->get("reqStatusKgb");
		$reqJenisKgb= $this->input->get("reqJenisKgb");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqPangkatId= $this->input->get("reqPangkatId");
		
		ini_set("memory_limit","500M");
		ini_set('max_execution_time', 520);
		
		$aColumns = array("NIP_BARU", "NAMA_LENGKAP", "PANGKAT_KODE", "DATA_LAMA", "DATA_BARU", "JENIS_KGB", "STATUS_KGB_NAMA", "AKSI", "STATUS_KGB", "PERIODE", "PEGAWAI_ID");
		$aColumnsAlias = array("NIP_BARU", "NAMA_LENGKAP", "PANGKAT_KODE", "DATA_LAMA", "DATA_BARU", "JENIS_KGB", "STATUS_KGB_NAMA", "AKSI", "STATUS_KGB", "PERIODE", "PEGAWAI_ID");

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
				$sOrder = " ORDER BY A.NAMA ASC ";
				 
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
		
		
		if($reqMode == "proses")
		{
			$set_detil= new KenaikanGajiPppkBerkala();
			$set_detil->setField("PERIODE", $reqBulan.$reqTahun);
			$set_detil->setField("SATKERID", ValToNullDB($reqSatuanKerjaId));
			$set_detil->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
			$set_detil->setField("LAST_USER", $this->LOGIN_USER);
			$set_detil->prosesKgb();
			//echo $set_detil->query;exit;
		}

		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}

		$statementAktif= " AND EXISTS(
			SELECT 1 FROM SATUAN_KERJA S WHERE 1=1 AND COALESCE(MASA_BERLAKU_AWAL,CURRENT_DATE) <= CURRENT_DATE AND COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE) >= COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE)
			AND A.SATUAN_KERJA_ID = S.SATUAN_KERJA_ID
		)";

		if($reqSatuanKerjaId == ""){}
		else
		{
			if(isStrContain(strtoupper($this->USER_GROUP), "TEKNIS") == "1" || $this->STATUS_SATUAN_KERJA_BKD == 1)
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
			else
			{
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
			}
		}
		
		if($reqStatusKgb ==""){}
		else
		{
			if($reqStatusKgb == 99)
			$statement .= " AND A.STATUS_KGB IS NULL";
			else
			$statement .= " AND A.STATUS_KGB = '".$reqStatusKgb."'";
		}
		
		if($reqPangkatId ==''){}
		else
		{
			$statement .= " AND A.PANGKAT_ID = '".$reqPangkatId."'";
		}

		if($reqJenisKgb ==''){}
		else
		{
			$statement .= " AND CASE WHEN PR1.JENIS_KENAIKAN = 1 AND A.HUKUMAN_RIWAYAT_ID IS NULL THEN 2 WHEN A.HUKUMAN_RIWAYAT_ID IS NOT NULL THEN 3 WHEN HK.JENIS_HUKUMAN_ID = 4 THEN 4 ELSE 1 END = ".$reqJenisKgb;
		}

		$statement .= " AND A.PERIODE = '".$reqBulan.$reqTahun."'";
		$searchJson= " AND (UPPER(P.NAMA) LIKE '%".strtoupper($_GET['sSearch'])."%' OR UPPER(P.NIP_BARU) LIKE '%".strtoupper($_GET['sSearch'])."%' ) ";
		$allRecord = $set->getCountByParamsMonitoring(array(), $statementAktif.$statement);
		// echo $allRecord;

		if($_GET['sSearch'] == "")
			$allRecordFilter = $allRecord;
		else	
			$allRecordFilter = $set->getCountByParamsMonitoring(array(), $statementAktif.$statement.$searchJson);
		// echo $set->query;exit;
		$sOrder= " ORDER BY AMBIL_SATKER_NAMA_DYNAMIC(A.SATUAN_KERJA_ID), PR1.PANGKAT_ID DESC";
		$set->selectByParamsMonitoring(array(), $dsplyRange, $dsplyStart, $statementAktif.$statement.$searchJson, $sOrder);
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
			$reqSuratKeluarBkdId= $set->getField("SURAT_KELUAR_BKD_ID");
			$reqStatusKgb= $set->getField("STATUS_KGB");
			
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if($aColumns[$i] == "DATA_LAMA")
					$row[] = getFormattedDate($set->getField("TMT_LAMA"))."<br/>".$set->getField("MASA_KERJA_TAHUN_LAMA")." thn ".$set->getField("MASA_KERJA_BULAN_LAMA")." bln<br/>".currencyToPage($set->getField("GAJI_LAMA"));
				elseif($aColumns[$i] == "DATA_BARU")
					$row[] = getFormattedDate($set->getField("TMT_BARU"))."<br/>".$set->getField("MASA_KERJA_TAHUN_BARU")." thn ".$set->getField("MASA_KERJA_BULAN_BARU")." bln<br/>".currencyToPage($set->getField("GAJI_BARU"));
				elseif($aColumns[$i] == "AKSI")
				{
					if($reqStatusKgb == "" || $reqAkses == "R")
					{
						$tempRow= "";
					}
					else
					{
						$tempRow= '<div class="btn-group">
						<button type="button" class="btn btn-info btn-small dropdown-toggle" data-toggle="dropdown">
						<span class="carett"></span>
						<span class="sr-only">Toggle Dropdown</span>
						</button>
						<ul class="dropdown-menu" role="menu">';
						$tempRow.= '<li><a>Cetak</a></li><li class="divider"></li>';
						if($reqStatusKgb == "2")
						{
							//<li><a onclick="aksi(\''.$set->getField("PEGAWAI_ID").'\')">Revisi</a></li>
							//<li><a onclick="batal(\''.$set->getField("PEGAWAI_ID").'\')">Batal</a></li>
							$tempRow.= '<li><a onclick="selesai(\''.$set->getField("PEGAWAI_ID").'\')">Selesai</a></li>';
						}
						elseif($reqStatusKgb == "3")
						{
							$tempRow.= '<li><a onclick="aksi(\''.$set->getField("PEGAWAI_ID").'\')">Revisi</a></li>';
						}
						$tempRow.= '</ul></div>';
					}
					
					$row[] = $tempRow;
				}
				else
					$row[] = $set->getField(trim($aColumns[$i]));
			}
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	function batal() 
	{
		$this->load->model('KenaikanGajiPppkBerkala');

		$reqPegawaiId= $this->input->get("reqPegawaiId");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqDataGajiRiwayatId1= $this->input->get("reqDataGajiRiwayatId1");
		$reqDataGajiRiwayatId2= $this->input->get("reqDataGajiRiwayatId2");

		// echo $reqDataGajiRiwayatId1."--".$reqDataGajiRiwayatId2;exit();
		$reqPeriode= $reqBulan.$reqTahun;
		//echo "asd";exit;
		$set= new KenaikanGajiPppkBerkala();
		$set->setField("PEGAWAI_ID", $reqPegawaiId);
		$set->setField("PERIODE", $reqPeriode);
		$set->setField("STATUS", "1");
		$set->setField("LAST_LEVEL", $this->LOGIN_LEVEL);
		$set->setField("LAST_USER", $this->LOGIN_USER);
		$set->setField("USER_LOGIN_ID", $this->LOGIN_ID);
		$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($this->LOGIN_PEGAWAI_ID));
		$set->setField("LAST_DATE", "NOW()");
		$set->updateBatal();
	}
	
	function getinfototal() 
	{
		$this->load->model('KenaikanGajiPppkBerkala');
		$this->load->model('SatuanKerja');
		
		$reqSatuanKerjaId= $this->input->get("reqSatuanKerjaId");
		$tempSatuanKerjaId= $reqSatuanKerjaId;
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqPeriode= $reqBulan.$reqTahun;
		
		if($reqSatuanKerjaId == "")
		{
			$reqSatuanKerjaId= $this->SATUAN_KERJA_ID;
		}

		$statementAktif= " AND EXISTS(
			SELECT 1 FROM SATUAN_KERJA S WHERE 1=1 AND COALESCE(MASA_BERLAKU_AWAL,CURRENT_DATE) <= CURRENT_DATE AND COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE) >= COALESCE(MASA_BERLAKU_AKHIR,CURRENT_DATE)
			AND A.SATUAN_KERJA_ID = S.SATUAN_KERJA_ID
		)";

		if($reqSatuanKerjaId == ""){}
		else
		{
			if(isStrContain(strtoupper($this->USER_GROUP), "TEKNIS") == "1" || $this->STATUS_SATUAN_KERJA_BKD == 1)
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
			else
			{
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
			}
		}

		$set= new KenaikanGajiPppkBerkala();
		$set->selectByParamsInfoTotal($reqPeriode, $statementAktif.$statement);
		$set->firstRow();
		// echo $set->query;exit();
		$jumlah_data_kgb= $set->getField("JUMLAH_DATA_KGB");
		$jumlah_data_kgb_proses= $set->getField("JUMLAH_DATA_KGB_PROSES");
		$jumlah_data_kgb_selesai= $set->getField("JUMLAH_DATA_KGB_SELESAI");
		$jumlah_data_kgb_hukuman= $set->getField("JUMLAH_DATA_KGB_HUKUMAN");
		
		$arrData= array("jumlah_data_kgb"=>$jumlah_data_kgb, "jumlah_data_kgb_proses"=>$jumlah_data_kgb_proses, "jumlah_data_kgb_selesai"=>$jumlah_data_kgb_selesai, "jumlah_data_kgb_hukuman"=>$jumlah_data_kgb_hukuman);
		echo json_encode($arrData);
	}
	
	function getstatushitungulang() 
	{
		$this->load->model('KenaikanGajiPppkBerkala');
		
		$reqPegawaiId= $this->input->get("reqPegawaiId");
		$reqBulan= $this->input->get("reqBulan");
		$reqTahun= $this->input->get("reqTahun");
		$reqPeriode= $reqBulan.$reqTahun;
		
		$statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.PERIODE = '".$reqPeriode."'";
		$set= new KenaikanGajiPppkBerkala();
		$set->selectByParamsData(array(), -1, -1, $statement);
		$set->firstRow();
		//echo $set->query;exit;
		$reqStatusHitungUlang= $set->getField('STATUS_HITUNG_ULANG');
		$arrData= array("reqStatusHitungUlang"=>$reqStatusHitungUlang);
		echo json_encode($arrData);
	}
		
}
?>