<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/browser.func.php");
include_once("functions/encrypt.func.php");

class globalfilesycnbkn
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
		$arrreturn["ttd_enkrip"]= $CI->config->item('ttd_enkrip');
		$arrreturn["base_url"]= $CI->config->item('base_report');

		return $arrreturn;
	}

	function cptofile($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model('base-api/DataCombo');

		// print_r($arrparam);exit;
		$vpath= $arrparam["vpath"];
		$refid= $arrparam["refid"];
		$pegawaiid= $arrparam["pegawaiid"];
		$rowid= $arrparam["rowid"];

		if(!empty($vpath) && !empty($pegawaiid))
		{
			if(empty($refid)) $refid= -1;

			$infologdata= $infosimpan= "";
			$arrgetsessionuser= $this->getsessionuser();
			// print_r($arrgetsessionuser);exit;

			$sessionloginlevel= $arrgetsessionuser["sessionloginlevel"];
			$sessionloginuser= $arrgetsessionuser["sessionloginuser"];
			$sessionloginid= $arrgetsessionuser["sessionloginid"];
			$sessionloginpegawaiid= $arrgetsessionuser["sessionloginpegawaiid"];
			$reqkunci= $arrgetsessionuser["ttd_enkrip"];
			$vbaseurl= $arrgetsessionuser["base_url"];

			if(is_array($refid))
			{
				/*foreach ($arrpath as $k => $v)
				{
					echo $k."<br/>".$v."<br/><br/>";
				}*/
			}
			else
			{
				$query= $CI->db->query("select * from ref_bkn_file where idcari in (".$refid.")");
				$arrjenisbkn= $query->result_array();
				$CI->db->close();
				// print_r($arrjenisbkn);exit;
				$keyrefindex= $arrjenisbkn[0]["id"];

				$vdoc= $vpath[$keyrefindex];
				// echo $vdoc["dok_nama"]."\n".$vdoc["dok_uri"];exit;
				$arrparam= [
					"id"=>$pegawaiid
					, "rowid"=>$rowid
					, "vid"=>$refid
					, "vlink"=>$vdoc["dok_uri"]
					, "vurl"=>"Update_file_bkn"
				]
				;
				// print_r($arrparam);exit;
				$set= new DataCombo();
				$set->selectdata($arrparam, "");
			}
		}
	}

	function uptofile($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model('base-api/DataCombo');

		// print_r($arrparam);exit;
		$vpath= $arrparam["vpath"];
		$refid= $arrparam["refid"];
		$pegawaiid= $arrparam["pegawaiid"];
		$rowid= $arrparam["rowid"];

		if(!empty($rowid) && !empty($pegawaiid))
		{
			$arrparam= [
				"id"=>$pegawaiid
				, "rowid"=>$rowid
				, "vid"=>$refid
				, "m"=>"upload"
				, "vurl"=>"Update_file_bkn"
			]
			;
			// print_r($arrparam);exit;
			$set= new DataCombo();
			$vreturn= $set->selectdata($arrparam, "", "result");
			// print_r($vreturn);exit;
			return $vreturn;
		}
	}
}