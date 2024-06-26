<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/browser.func.php");

class bio_json extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->conbio= $this->load->database("bio", TRUE);
	}

	function updatedata()
	{
		$this->load->model("TekenLog");

		$c= $this->input->get("c");
		$m= $this->input->get("m");
		$p= $this->input->get("p");

		if(empty($m))
		{
			$m= "hari_ini";
		}

		// $today= date('11-03-2024');
		//$tglnow= $today= date('d-m-Y');
		$tglnow= $today= date('d-m-Y');
		$today= strtotime("-3 months", strtotime($today));
		$today= date("d-m-Y", $today);

		/*$db_handle = pg_connect("host=103.142.14.15 port=7496 dbname=biotime user=postgres password=absensi201910");
		if ($db_handle) {
		echo 'Connection attempt succeeded.';
		} else {
		echo 'Connection attempt failed.';
		}
		pg_close($db_handle);
		exit;*/

		// $conbio= $this->load->database("bio", TRUE);
		$infoquery="
		SELECT
		ID AS ABSENSI_ID,
		PEGAWAI_ID, JAM, TIPE_ABSEN, STATUS_TARIK, verify_type, terminal_sn, terminal_alias, area_alias, terminal_id, upload_times
		FROM 
		(
			SELECT
				ID, EMP_CODE PEGAWAI_ID
				, to_char(punch_time AT TIME ZONE 'Etc/GMT+8' AT TIME ZONE 'Etc/GMT+7', 'yyyy-mm-dd hh24:mi:ss') JAM
				, PUNCH_STATE TIPE_ABSEN, STATUS_TARIK, verify_type, terminal_sn, terminal_alias, area_alias, terminal_id
				, to_char(upload_time AT TIME ZONE 'Etc/GMT+8' AT TIME ZONE 'Etc/GMT+7', 'yyyy-mm-dd hh24:mi:ss') upload_times
			FROM iclock_transaction
			WHERE 1=1
			AND STATUS_TARIK = '0'
		) A
		WHERE 1=1
		";

		if($m == "hari_ini")
		{
			//$infoquery.= " AND TO_CHAR(TO_DATE(A.JAM, 'YYYY-MM-DD'), 'DD-MM-YYYY') = '".$today."'";
			// $infoquery.= " AND TO_CHAR(TO_DATE(A.JAM, 'YYYY-MM-DD'), 'DD-MM-YYYY') >= '".$today."'";
			$infoquery.= "
			AND TO_DATE(A.JAM, 'YYYY-MM-DD') >= TO_DATE('".dateToPageCheck($today)."','YYYY/MM/DD')
			AND TO_DATE(A.JAM, 'YYYY-MM-DD') <= TO_DATE('".dateToPageCheck($tglnow)."','YYYY/MM/DD')
			";
		}


		// SET LIMIT
		$infoquery.= " LIMIT 100";

		if($c == "q")
		{
			echo $infoquery;exit;
		}

		// $query= $this->db->query($infoquery);
		// $query= $this->conbio->query($infoquery);
		$query= $this->conbio->query($infoquery);
		$arrdataabsensi= $query->result_array();
		if($c == "data")
		{
			print_r($arrdataabsensi);exit;
		}

		foreach ($arrdataabsensi as $k => $v)
		{
			$vabsensi_id= $v["absensi_id"];
            $vpegawai_id= $v["pegawai_id"];
            $vjam= datetimeToPage($v["jam"], "datetime");
            $vtipe_absen= $v["tipe_absen"];
            $vstatus_tarik= $v["status_tarik"];
            $vverify_type= $v["verify_type"];
            $vterminal_sn= $v["terminal_sn"];
            $vterminal_alias= $v["terminal_alias"];
            $varea_alias= $v["area_alias"];
            $vterminal_id= $v["terminal_id"];
            $vupload_times= datetimeToPage($v["upload_times"], "datetime");

            // ambil data terbaru
            $infocheckquery= "
            SELECT
				STATUS_TARIK
			FROM iclock_transaction
			WHERE 1=1 AND ID ='".$vabsensi_id."'
			";

			$qc= $this->conbio->query($infocheckquery);
			$arrqc= $qc->result_array();
			$vstatus_tarik= $arrqc[0]["status_tarik"];

            // kalau ada data tarik 1 maka stop semua proses, untk di lanjutkan ke proses selanjutnya
            if($vstatus_tarik == 1)
            {
            	$totalbreak= $k+1;
            	$reqIp= getClientIpEnv();
				$ua=getBrowser();
				$reqUserAgent= $ua['name'] . " " . $ua['version'] . " pada OS ( " .$ua['platform'] . ")";
				$reqJenis= "logabsensibreakdata";
				$reqLogKeterangan= " Total Data ".$totalbreak;

				$set_detil= new TekenLog();
				$set_detil->setField("JENIS", $reqJenis);
				$set_detil->setField("IP_ADDRESS", $reqIp);
				$set_detil->setField("USER_AGENT", $reqUserAgent);
				$set_detil->setField("KETERANGAN", $reqLogKeterangan);
				$set_detil->setField("LAST_USER", "");
				$set_detil->setField("USER_LOGIN_ID", ValToNullDB($req));
				$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($req));
				$set_detil->setField("LAST_DATE", "NOW()");

				if($set_detil->insert())
				{
				}
            	break;
            }

            $instquery="
            INSERT INTO presensi.ABSENSI(ABSENSI_ID, PEGAWAI_ID, JAM, TIPE_ABSEN, VALIDASI, LAST_CREATE_DATE, verify_type, terminal_sn, terminal_alias, area_alias, terminal_id, upload_time)
			VALUES
			(
				'".$vabsensi_id."'
				, '".$vpegawai_id."'
				, ".dateTimeToDBCheck($vjam)."
				, '".$vtipe_absen."'
				, 1
				, now()
				, '".$vverify_type."'
				, '".$vterminal_sn."'
				, '".$vterminal_alias."'
				, '".$varea_alias."'
				, ".ValToNullDB($vterminal_id)."
				, ".dateTimeToDBCheck($vupload_times)."
			)
			";
			// echo $instquery;exit;

			$res= $this->db->query($instquery);
			if(!$res)
		    {
		    	// check data absensi presensi apa sudah ada, kalau ada update status tarik
	            $infocheckquery= "
	            SELECT
					*
				FROM presensi.absensi
				WHERE 1=1 AND absensi_id IN (".$vabsensi_id.")
				AND status_manual = 0
				";

				$presensiqc= $this->db->query($infocheckquery);
				$arrpresensiqc= $presensiqc->result_array();
				// print_r($arrpresensiqc);exit;
				$vcheckupdate= $arrpresensiqc[0]["absensi_id"];
				// echo $vcheckupdate;exit;
				if(!empty($vcheckupdate))
				{
					// UPDATE STATUS TARIK
			    	$instquery="
					update iclock_transaction set STATUS_TARIK = '1' where ID = '".$vabsensi_id."'
					";
					$res= $this->conbio->query($instquery);
				}
		        // $error= $this->db->error();
		    }
		    else
		    {
		    	$infocheckquery= "
	            SELECT
					*
				FROM presensi.absensi
				WHERE 1=1 AND absensi_id IN (".$vabsensi_id.")
				AND status_manual = 0
				";

				$presensiqc= $this->db->query($infocheckquery);
				$arrpresensiqc= $presensiqc->result_array();
				// print_r($arrpresensiqc);exit;
				$vcheckupdate= $arrpresensiqc[0]["absensi_id"];
				// echo $vcheckupdate;exit;
				if(!empty($vcheckupdate))
				{
			    	// UPDATE STATUS TARIK
			    	$instquery="
					update iclock_transaction set STATUS_TARIK = '1' where ID = '".$vabsensi_id."'
					";
					$res= $this->conbio->query($instquery);
				}
		    }
		}

		$reqIp= getClientIpEnv();
		$ua=getBrowser();
		$reqUserAgent= $ua['name'] . " " . $ua['version'] . " pada OS ( " .$ua['platform'] . ")";
		$reqJenis= "logabsensidata";
		$reqLogKeterangan= " Total Data ".count($arrdataabsensi);

		$set_detil= new TekenLog();
		$set_detil->setField("JENIS", $reqJenis);
		$set_detil->setField("IP_ADDRESS", $reqIp);
		$set_detil->setField("USER_AGENT", $reqUserAgent);
		$set_detil->setField("KETERANGAN", $reqLogKeterangan);
		$set_detil->setField("LAST_USER", "");
		$set_detil->setField("USER_LOGIN_ID", ValToNullDB($req));
		$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($req));
		$set_detil->setField("LAST_DATE", "NOW()");

		if($set_detil->insert())
		{
		}

		// tutup koneksi
		$this->conbio->close();
		$this->db->close();
	}

}