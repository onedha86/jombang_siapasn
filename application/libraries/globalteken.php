<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/browser.func.php");
include_once("functions/encrypt.func.php");
include_once("lib/phpqrcode/qrlib.php");

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
		$arrreturn["ttd_enkrip"]= $CI->config->item('ttd_enkrip');
		$arrreturn["base_url"]= $CI->config->item('base_report');

		return $arrreturn;
	}

	function settoken($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model("base-cuti/CutiUsulan");
		$CI->load->model("base-cuti/CutiUrutan");
		$CI->load->model("PegawaiFile");
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
		$vpegawaiid= $set->getField("PEGAWAI_ID");
		$vcutiid= $set->getField("CUTI_ID");
		$vtte= $set->getField("VALID_TTE");
		$vnomor= $set->getField("VALID_NOMOR");
		$vperiode= $set->getField("VALID_PERIODE");
		$vsubnomor= $set->getField("VALID_SUB_NOMOR");
		$vmenupenandatanganid= $set->getField("MENU_PENANDA_TANGAN_ID");

		$infoid= $reqId;
		$filelokasi= "uploads/cuti/".$infoid."/";
		// kalau masih vnomor kosong maka proses tte
		if(empty($vnomor))
		{
			$report= new ReportPDF();
			$arrparam= ["reqId"=>$infoid];
			$docPDF= $report->generatecuti($arrparam);
			$infourl= $filelokasi.$docPDF;
		}

		$sessionloginlevel= $arrgetsessionuser["sessionloginlevel"];
		$sessionloginuser= $arrgetsessionuser["sessionloginuser"];
		$sessionloginid= $arrgetsessionuser["sessionloginid"];
		$sessionloginpegawaiid= $arrgetsessionuser["sessionloginpegawaiid"];
		$reqkunci= $arrgetsessionuser["ttd_enkrip"];
		$vbaseurl= $arrgetsessionuser["base_url"];

		// harus nomor kosong untuk generate
		if(empty($vnomor))
		{
			// harus ada file template, simpan data ke pegawai file yg nnti nya di ubah kl sudah valid
			if(file_exists($infourl))
			{
				$reqRiwayatTable= "CUTI_USULAN_TTE";
				$reqRiwayatField= $reqKategoriFileId= "";
				$reqRiwayatId= $infoid;
				$reqKualitasFileId= "1";
				$infoext= getExtension($infourl);

				$statementdetil= " AND A.RIWAYAT_TABLE = 'CUTI_USULAN_TTE' AND A.RIWAYAT_ID = ".$reqRiwayatId;
				$setdetil= new PegawaiFile();
				$setdetil->selectByParamsFile(array(), -1, -1, $statementdetil, $vpegawaiid);
				$setdetil->firstRow();
				$reqDokumenFileId= $setdetil->getField("PEGAWAI_FILE_ID");
				// echo $reqDokumenFileId;exit;

				$setfile= new PegawaiFile();
				$setfile->setField("PEGAWAI_ID", $vpegawaiid);
				$setfile->setField("RIWAYAT_TABLE", $reqRiwayatTable);
				$setfile->setField("RIWAYAT_FIELD", $reqRiwayatField);
				$setfile->setField("FILE_KUALITAS_ID", ValToNullDB($reqKualitasFileId));
				$setfile->setField("KATEGORI_FILE_ID", ValToNullDB($reqKategoriFileId));
				$setfile->setField("RIWAYAT_ID", ValToNullDB($reqRiwayatId));
				
				$setfile->setField("LAST_LEVEL", $sessionloginlevel);
				$setfile->setField("LAST_USER", $sessionloginuser);
				$setfile->setField("USER_LOGIN_ID", $sessionloginid);
				$setfile->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($sessionloginpegawaiid));
				$setfile->setField("LAST_DATE", "NOW()");

				$setfile->setField("IPCLIENT", sfgetipaddress());
				$setfile->setField("MACADDRESS", sfgetmac());
				$setfile->setField("NAMACLIENT", getHostName());
				$setfile->setField("PRIORITAS", $reqPrioritas);
				$setfile->setField("EXT", $infoext);
				$setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);

				if(empty($reqDokumenFileId))
				{
					if($setfile->insert())
					{
					}
				}

				$enkrip_1= $reqDokumenFileId."_".$vpegawaiid;
				$enkrip_1= mencrypt($enkrip_1, $reqkunci);
				$enkrip_2= "viewfile-".$enkrip_1;
				$enkrip_2= mencrypt($enkrip_2, $reqkunci);
				$enkrip= $enkrip_2;

				// buat qrcode sesuai link enkrip
				$fileqrname= $filelokasi.'qr.png';
				if(!file_exists($fileqrname))
				{
					$filepath=  $fileqrname;
					$infolokasiqr= $vbaseurl.'qrcode'.'?data='.$enkrip;
					// echo $infolokasiqr;exit;

					$errorCorrectionLevel = 'H';
					$matrixPointSize = 2;

					QRcode::png($infolokasiqr, $fileqrname, $errorCorrectionLevel, $matrixPointSize, 2);   

					// Apabila mengunakan logo Kecil di tengah
					$logothumps= "images/qr_logo.png";
					$pngqr= imagecreatefrompng($filepath);
					$logo= imagecreatefromstring(file_get_contents($logothumps));
					imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
					imagealphablending($logo , false);
					imagesavealpha($logo , true);

					$infoqrwidth= imagesx($pngqr);
					$infoqrheight= imagesy($pngqr);

					$logo_width= imagesx($logo);
					$logo_height= imagesy($logo);
					// Scale logo to fit in the QR Code

					$pembagian= 3;
					$logo_qr_width= $infoqrwidth / $pembagian;
					$scale= ($logo_width / $logo_qr_width)*1.1;
					$logo_qr_height= $logo_height / $scale;
					imagecopyresampled($pngqr, $logo, $infoqrwidth / $pembagian, $infoqrheight / $pembagian, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
					
					// Save QR code again, but with logo on it
					imagepng($pngqr,$filepath);
				}

				// menempelkan url qr baru
				if(file_exists($fileqrname))
				{
					$stnm= new CutiUsulan();
					$stnm->setField("VID", $infoid);
					$stnm->validcutinomor();
					unset($stnm);

					$report= new ReportPDF();
					$arrparam= ["reqId"=>$infoid];
					$docPDF= $report->generatecuti($arrparam);
				}
			}
		}
		else
		{
			$fileuntukditt= $filelokasi.'draft.pdf';
			$filehasiltt= $filelokasi.'draft_tt.pdf';

			if(!file_exists($filehasiltt))
			{
				$vttdurl= $arrgetsessionuser["ttd_url"];
				$vttdusername= $arrgetsessionuser["ttd_username"];
				$vttdpassword= $arrgetsessionuser["ttd_password"];

				/*if (function_exists('curl_file_create')) 
				{
					$cfile= curl_file_create($fileuntukditt);
				}
				else 
				{ 
					$cfile= '@'.realpath($fileuntukditt);
				}*/
				$cfile = new CURLFile(realpath($fileuntukditt), "application/pdf");
				// print_r($cfile);exit;

				// misal user kepala bkpsdm kan tahu siapa pns nya, itu di cari di tabel pegawai, nik nya brapa
				// di menu setting urutan cuti
				$statementcari= " AND A1.MENU_ID = '".$vmenupenandatanganid."'";
				$setp= new CutiUrutan();
				$setp->selectByParams(array(), -1,-1, $statementcari);
				$setp->firstRow();
				$vttenik= $setp->getField("NIP_BARU");
				$vttepassphrase= $reqPassphrase;

				// untuk cek hardcode dl untuk dummy
				$vttenik= "0803202100007062";
				// $vttepassphrase= "Hantek1234.!";

				$vparamdata= array(
					"file"=> $cfile
					, "nik"=> $vttenik
					, "passphrase"=> $vttepassphrase
					, "tampilan"=> "invisible"
				);
				// print_r($vparamdata);exit;

				// "method"=> "get"
				// , "urldetil"=> "/api/user/status/0803202100007062"
				$arrparam= [];
				$arrparam= array(
					"method"=> "post"
					, "lihat"=> ""
					, "url"=> $vttdurl
					, "urldetil"=> "/api/sign/pdf"
					, "username"=> $vttdusername
					, "password"=> $vttdpassword
					, "vdata"=> $vparamdata
					, "filehasiltt"=> $filehasiltt
				);

				$verror= "";
				$rsapi= $this->esign($arrparam);
				if(isset($rsapi) && property_exists($rsapi,"error"))
				{
					$verror= $rsapi["error"];
				}

				if(!empty($verror))
				{
					$infologdata= "1";
					$reqLogKeterangan= $verror;
				}
			}
		}
		// exit;

		if($infologdata == "1")
		{
			$reqIp= getClientIpEnv();
			$ua= getBrowser();
			$reqUserAgent= $ua['name'] . " " . $ua['version'] . " pada OS ( " .$ua['platform'] . ")";

			$CI = &get_instance();
			$CI->load->model("TekenLog");
			// $reqLogKeterangan= "coba log gagal";

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

		$vreturn= [];
		$vreturn= array(
			"info"=> $reqLogKeterangan
			, "status"=> $infosimpan
		);

		return $vreturn;
	}

	function esign($arrparam)
	{
		// signpdf
		$vmethod= $arrparam["method"];
		$vlihat= $arrparam["lihat"];
		$vurl= $arrparam["url"];
		$vurldetil= $arrparam["urldetil"];
		$vusername= $arrparam["username"];
		$vpassword= $arrparam["password"];
		$vdata= $arrparam["vdata"];
		$vfilehasiltt= $arrparam["filehasiltt"];
		// print_r($arrparam);exit;

		if(!empty($vurldetil))
		{
			$vurl.= $vurldetil;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $vurl);
		if($vmethod == "post")
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $vdata);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $vusername.':'.$vpassword);

		// execute post
		$result= curl_exec($ch);
		// close connection
		curl_close($ch);

		if($vlihat == "1")
		{
			print_r($result);exit();
		}

		$rs= json_decode($result);
		if($vlihat == "2")
		{
			print_r($rs);exit;
		}

		$verror= "";
		if(isset($rs) && property_exists($rs,"error"))
		{
			$verror= $rs["error"];
		}

		if(empty($verror) && !empty($vfilehasiltt))
		{
			file_put_contents($vfilehasiltt, $result);
		}

		if(!empty($verror))
			return $this->object_to_array($rs);
		else
			return "";
	}

	function object_to_array($data)
	{
	    $result = [];
	    foreach ($data as $key => $value)
	    {
	        $result[$key] = (is_array($value) || is_object($value)) ? object_to_array($value) : $value;
	    }
	    return $result;
	}
}