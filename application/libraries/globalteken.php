<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/browser.func.php");

class globalteken
{
	function getsessionuser()
	{
		$CI = &get_instance();

		$sessionloginlevel= $CI->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$sessionloginuser= $CI->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$sessionloginid= $CI->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$sessionloginpegawaiid= $CI->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;

		$sessionsatuankerja= $CI->kauth->getInstance()->getIdentity()->SATUAN_KERJA_ID;
		$sessionusergroup= $CI->kauth->getInstance()->getIdentity()->USER_GROUP;
		$sessionstatussatuankerjabkd= $CI->kauth->getInstance()->getIdentity()->STATUS_SATUAN_KERJA_BKD;
		$sessionaksesappsimpegid= $CI->kauth->getInstance()->getIdentity()->AKSES_APP_SIMPEG_ID;

		$arrreturn= [];
		$arrreturn["sessionloginlevel"]= $sessionloginlevel;
		$arrreturn["sessionloginuser"]= $sessionloginuser;
		$arrreturn["sessionloginid"]= $sessionloginid;
		$arrreturn["sessionloginpegawaiid"]= $sessionloginpegawaiid;
		$arrreturn["sessionsatuankerja"]= $sessionsatuankerja;
		$arrreturn["sessionusergroup"]= $sessionusergroup;
		$arrreturn["sessionstatussatuankerjabkd"]= $sessionstatussatuankerjabkd;
		$arrreturn["sessionaksesappsimpegid"]= $sessionaksesappsimpegid;
		$arrreturn["sessioninfosepeta"]= $sessioninfosepeta;
		// print_r($arrreturn);exit;

		$arrreturn["ttd_url"]= $CI->config->item('ttd_url');
		$arrreturn["ttd_username"]= $CI->config->item('ttd_username');
		$arrreturn["ttd_password"]= $CI->config->item('ttd_password');

		return $arrreturn;
	}

	function settoken($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model("base-cuti/CutiUsulan");
		$CI->load->library('ReportPDF');

		// print_r($arrparam);exit;
		$reqId= $arrparam["reqId"];
		$reqJenis= $arrparam["reqJenis"];
		$reqPassphrase= $arrparam["reqPassphrase"];

		$infologdata= $infosimpan= "";
		$arrgetsessionuser= $this->getsessionuser();
		// print_r($arrgetsessionuser);exit;

		$infoparam= "";
		if(empty($reqId)) $reqId= -1;

		$infoparam= " AND A.CUTI_USULAN_ID = ".$reqId;
		$set=  new CutiUsulan();
		$set->selectdata(array(), -1, -1, $infoparam);
		// echo $set->query;exit;
		$set->firstRow();
		$vcutiid= $set->getField("CUTI_ID");
		$vtte= $set->getField("VALID_TTE");
		$vnomor= $set->getField("VALID_NOMOR");
		$vperiode= $set->getField("VALID_PERIODE");
		$vsubnomor= $set->getField("VALID_SUB_NOMOR");

		// kalau masih vtte kosong maka proses tte
		if(empty($vtte))
		{
			$infoid= $reqId;
			$report= new ReportPDF();
			$arrparam= ["reqId"=>$infoid];
			$docPDF= $report->generatecuti($arrparam);
			$infourl= 'uploads/cuti/'.$infoid.'/'.$docPDF;
			
			echo "Asd";exit;
		}
		exit;
		/*if($reqPassphrase == "gagal")
		{
			$infologdata= "1";
		}*/

		echo $infologdata;exit;

		if($infologdata == "1")
		{
			$sessionloginlevel= $arrgetsessionuser["sessionloginlevel"];
			$sessionloginuser= $arrgetsessionuser["sessionloginuser"];
			$sessionloginid= $arrgetsessionuser["sessionloginid"];
			$sessionloginpegawaiid= $arrgetsessionuser["sessionloginpegawaiid"];

			$reqIp= getClientIpEnv();
			$ua=getBrowser();
			$reqUserAgent= $ua['name'] . " " . $ua['version'] . " pada OS ( " .$ua['platform'] . ")";

			$CI = &get_instance();
			$CI->load->model("TekenLog");
			$reqLogKeterangan= "coba log gagal";

			$set_detil= new TekenLog();
			$set_detil->setField("JENIS", $reqJenis);
			$set_detil->setField("IP_ADDRESS", $reqIp);
			$set_detil->setField("USER_AGENT", $reqUserAgent);
			$set_detil->setField("KETERANGAN", $reqLogKeterangan);
			$set_detil->setField("LAST_LEVEL", $sessionloginlevel);
			$set_detil->setField("LAST_USER", $sessionloginuser);
			$set_detil->setField("USER_LOGIN_ID", $sessionloginid);
			$set_detil->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($sessionloginpegawaiid));
			$set_detil->setField("LAST_DATE", "NOW()");

			if($set_detil->insert())
			{
				// $infosimpan= "1";
			}
		}
		else
		{
			$infosimpan= "1";
		}

		return $infosimpan;
	}
}