<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/encrypt.func.php");

class globalfilepegawai
{
	function setriwayatfield($riwayattable, $kategorifileid="")
	{
		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$vreturn= [];
		if($riwayattable == "ANAK")
		{
			// $arrvalid= ["foto", "aktakelahiran"];
			$arrvalid= ["aktakelahiran"];
			$set= new PegawaiFile();
			$set->selectbyriwayatfieldanakfile();
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$infofield= $set->getField("RIWAYAT_FIELD");
				$infostyle= "background-color: color !important;";

				// if($infofield == "foto")
				// {
				// 	$infostyle= "display:none !important;";
				// }
				// else
				if($infofield == "aktakelahiran")
				{
					$infostyle= "background-color: yellow !important; color: black;";
				}
				else if($infofield == "ktp")
				{
					$infostyle= "background-color: red !important;";
				}
				else if($infofield == "sim")
				{
					$infostyle= "background-color: purple !important;";
				}
				else if($infofield == "suratkematian")
				{
					$infostyle= "background-color: black !important;";
				}

				$arrdata= [];
				$arrdata["riwayatfield"]= $infofield;
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
				$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
				$arrdata["riwayatfieldstyle"]= $infostyle;
				$riwayatfieldrequired= $this->setfilerequired($arrvalid, $infofield);
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);

				array_push($vreturn, $arrdata);
			}
		}
		else if($riwayattable == "SUAMI_ISTRI")
		{
			$arrvalid= ["foto", "aktanikah"];

			$set= new PegawaiFile();
			$set->selectbyriwayatfieldsuamiistrifile();
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$infofield= $set->getField("RIWAYAT_FIELD");
				$infostyle= "background-color: color !important;";

				// if($infofield == "foto")
				// {
				// 	$infostyle= "display:none !important;";
				// }
				// else
				if($infofield == "aktakelahiran")
				{
					$infostyle= "background-color: yellow !important; color: black;";
				}
				else if($infofield == "ktp")
				{
					$infostyle= "background-color: red !important;";
				}
				else if($infofield == "sim")
				{
					$infostyle= "background-color: purple !important;";
				}
				else if($infofield == "suratkematian")
				{
					$infostyle= "background-color: black !important;";
				}

				$arrdata= [];
				$arrdata["riwayatfield"]= $infofield;
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
				$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
				$arrdata["riwayatfieldstyle"]= $infostyle;
				$riwayatfieldrequired= $this->setfilerequired($arrvalid, $infofield);
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
				array_push($vreturn, $arrdata);
			}
		}
		else if($riwayattable == "PANGKAT_RIWAYAT")
		{
			$arrlihatjenisfile= array("1", "2");
			if(!in_array($kategorifileid, $arrlihatjenisfile))
			{
				$arrdata= [];
				$arrdata["riwayatfield"]= "";
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= "Cek EFile";
				$arrdata["riwayatfieldtipe"]= "";
				$arrdata["riwayatfieldstyle"]= "";
				$riwayatfieldrequired= "1";
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
				array_push($vreturn, $arrdata);
			}
			else
			{
				$arrvalid= ["skcpns", "skpns"];
				$set= new PegawaiFile();

				// cpns
				if($kategorifileid == "1")
					$set->selectbyriwayatfieldcpnsfile();
				// pns
				else if($kategorifileid == "2")
					$set->selectbyriwayatfieldpnsfile();

				// echo $set->query;exit;
				while($set->nextRow())
				{
					$infofield= $set->getField("RIWAYAT_FIELD");
					$infostyle= "background-color: color !important;";

					if($infofield == "skcpns" || $infofield == "skpns")
					{
						$infostyle= "background-color: yellow !important; color: black;";
					}
					else if($infofield == "notausulcpns" || $infofield == "notausulpns")
					{
						$infostyle= "background-color: purple !important;";
					}
					else if($infofield == "suratujikesehatan" || $infofield == "skpns")
					{
						$infostyle= "background-color: red !important;";
					}
					else if($infofield == "sttplprajabatan" || $infofield == "skpns")
					{
						$infostyle= "background-color: black !important;";
					}
					else if($infofield == "bapsumpah" || $infofield == "skpns")
					{
						$infostyle= "background-color: green !important;";
					}

					$arrdata= [];
					$arrdata["riwayatfield"]= $infofield;
					$arrdata["vriwayattable"]= $riwayattable;
					$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
					$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
					$arrdata["riwayatfieldstyle"]= $infostyle;
					$riwayatfieldrequired= $this->setfilerequired($arrvalid, $infofield);
					// $riwayatfieldrequired= "";
					$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
					$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
					array_push($vreturn, $arrdata);
				}

			}
		}
		else if($riwayattable == "ORANG_TUA")
		{
			$set= new PegawaiFile();
			$set->selectbyriwayatfieldorangtuafile();
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$infofield= $set->getField("RIWAYAT_FIELD");
				$infostyle= "background-color: color !important;";

				$arrdata= [];
				$arrdata["riwayatfield"]= $infofield;
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
				$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
				$arrdata["riwayatfieldstyle"]= $infostyle;
				$riwayatfieldrequired= "";
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
				array_push($vreturn, $arrdata);
			}
		}
		else if($riwayattable == "PENILAIAN_SKP")
		{
			$arrvalid= ["ppk"];
			$set= new PegawaiFile();
			$set->selectbyriwayatfieldskpppkfile();
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$infofield= $set->getField("RIWAYAT_FIELD");
				$infostyle= "background-color: color !important;";

				if($infofield == "ppk")
				{
					$infostyle= "background-color: yellow !important; color: black;";
				}
				else if($infofield == "skp")
				{
					$infostyle= "background-color: purple !important;";
				}

				$arrdata= [];
				$arrdata["riwayatfield"]= $infofield;
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
				$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
				$arrdata["riwayatfieldstyle"]= $infostyle;
				$riwayatfieldrequired= $this->setfilerequired($arrvalid, $infofield);
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);

				array_push($vreturn, $arrdata);
			}
		}
		else if($riwayattable == "PENDIDIKAN_RIWAYAT")
		{
			$arrvalid= [];
			$set= new PegawaiFile();

			$arrvalid= ["ijazah"];
			if($kategorifileid == "14")
				$set->selectbyriwayatfieldpendidikantupelfile();
			else
				$set->selectbyriwayatfieldpendidikanfile();
			// echo $set->query;exit;
			while($set->nextRow())
			{
				$infofield= $set->getField("RIWAYAT_FIELD");
				$infostyle= "background-color: color !important;";

				if($infofield == "ijazah")
				{
					$infostyle= "background-color: yellow !important; color: black;";
				}
				else if($infofield == "transkrip")
				{
					$infostyle= "background-color: red !important;";
				}
				else if($infofield == "tugasbelajar")
				{
					$infostyle= "background-color: purple !important;";
				}
				else if($infofield == "ijinbelajar")
				{
					$infostyle= "background-color: black !important;";
				}

				$arrdata= [];
				$arrdata["riwayatfield"]= $infofield;
				$arrdata["vriwayattable"]= $riwayattable;
				$arrdata["riwayatfieldinfo"]= $set->getField("INFO_DATA");
				$arrdata["riwayatfieldtipe"]= $set->getField("TIPE_FILE");
				$arrdata["riwayatfieldstyle"]= $infostyle;
				$riwayatfieldrequired= $this->setfilerequired($arrvalid, $infofield);
				$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
				array_push($vreturn, $arrdata);
			}
		}
		else
		{
			$arrdata= [];
			$arrdata["riwayatfield"]= "";
			$arrdata["vriwayattable"]= $riwayattable;
			$arrdata["riwayatfieldinfo"]= "Cek EFile";
			$arrdata["riwayatfieldtipe"]= "";
			$arrdata["riwayatfieldstyle"]= "";
			$riwayatfieldrequired= "1";
			$arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
			$arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);
			array_push($vreturn, $arrdata);
		}
		// print_r($vreturn);exit;

		return $vreturn;
	}

	function setfilerequired($arrvalid, $infofield)
	{
		$vreturn= "";
		if(in_array($infofield, $arrvalid))
			$vreturn= "1";

		return $vreturn;
	}

	function setfilerequiredinfo($val, $label="")
	{
		$vdefault= $label;
		if(empty($vdefault))
			$vdefault= ' *';

		$vreturn= "";
		if($val == "1")
			$vreturn= $vdefault;

		return $vreturn;
	}

	function settingpegawaifile()
	{
		$CI = &get_instance();
		$CI->load->model("UserLogin");
		$USER_LOGIN_ID= $CI->kauth->getInstance()->getIdentity()->USER_LOGIN_ID;
		// echo $USER_LOGIN_ID;exit;

		$vreturn= [];
		$set= new UserLogin();
		$set->selectfileuser(array(), -1,-1, $USER_LOGIN_ID, " AND B1.STATUS = '1'");
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["ID_ROW"]= $set->getField("ID_ROW");
			$arrdata["STATUS"]= $set->getField("STATUS");
			$arrdata["KATEGORI_FILE_ID"]= $set->getField("KATEGORI_FILE_ID");
			$arrdata["KATEGORI_FILE_NAMA"]= $set->getField("KATEGORI_FILE_NAMA");
			$arrdata["RIWAYAT_TABLE"]= $set->getField("RIWAYAT_TABLE");
			$arrdata["RIWAYAT_ID"]= $set->getField("RIWAYAT_ID");
			$arrdata["RIWAYAT_FIELD"]= $set->getField("RIWAYAT_FIELD");
			$arrdata["INFO_DATA"]= $set->getField("INFO_DATA");
			$arrdata["NAMA"]= $set->getField("NAMA");
			$arrdata["URUT"]= $set->getField("URUT");
			array_push($vreturn, $arrdata);
		}
		return $vreturn;
	}

	function validasifilerequired($vpost, $reqLinkFile)
	{
		$settingpegawaifile= $this->settingpegawaifile();
		// print_r($settingpegawaifile);exit;

		$vreturn= "";
		// print_r($vpost);exit;
		// print_r($reqLinkFile);exit;
		// print_r($vpost["reqDokumenRequired"]);exit;
		// print_r($vpost["reqDokumenRequiredTable"]);exit;

		foreach ($vpost["reqDokumenRequired"] as $key => $value) {
			$reqDokumenPilih= $vpost["reqDokumenPilih"][$key];
			$reqDokumenTipe= $vpost["reqDokumenTipe"][$key];
			$reqDokumenRequiredNama= $vpost["reqDokumenRequiredNama"][$key];
			$reqDokumenIndexId= $vpost["reqDokumenIndexId"][$key];
			$reqDokumenKategoriField= $vpost["reqDokumenKategoriField"][$key];
			$reqDokumenRequiredTable= $vpost["reqDokumenRequiredTable"][$key];
			$infofilenama= $reqLinkFile['name'][$key];

			$kondisilewati= "";

			// kalau user option file
			if(!empty($reqDokumenRequiredTable))
			{
				$reqDokumenRequiredTableRow= $vpost["reqDokumenRequiredTableRow"][$key];
				$infocarikey= $reqDokumenRequiredTableRow;
				// echo $infocarikey;exit;
				$arrcheck= in_array_column($infocarikey, "ID_ROW", $settingpegawaifile);
				// print_r($arrcheck);exit;
				if(!empty($arrcheck))
				{
					return "";
				}
			}

			if(empty($kondisilewati))
			{
				// kalau ada upload data baru, validasi file exe
				if($reqDokumenPilih == "1" && !empty($infofilenama))
				{
					if($reqDokumenTipe == "1")
					{
						$infokecualifile= "jpg";
						$arrkecualifile= array("jpg", "jpg");
					}
					else
					{
						$infokecualifile= "pdf";
						$arrkecualifile= array("pdf");
					}

					// Allow certain file formats
					$bolehupload = "";
					$fileuploadexe= strtolower(getExtension($infofilenama));

					if(in_array(strtolower($fileuploadexe), $arrkecualifile))
						$bolehupload = 1;

					$infopesan= "";
					if($bolehupload == "")
					{
						$infopesan= "check file ".$reqDokumenRequiredNama." upload harus format ".$infokecualifile.".";
					}

					if(!empty($infopesan))
					{
						$vreturn= getconcatseparator($vreturn, $infopesan, "<br/>");
					}
					// echo $vreturn;exit;
				}

				// validasi harus ada file
				if($value == "1")
				{
					$infopesan= "";

					if(
						empty($reqDokumenPilih) || // kalau dokumen pilih kosong
						($reqDokumenPilih == "1" && empty($infofilenama)) || // kalau dokumen pilih baru tapi upload file kosong
						($reqDokumenPilih == "2" && empty($reqDokumenIndexId)) // kalau dokumen pilih dari e file tapi belum pilih data
					)
					{
						$infopesan= "file ".$reqDokumenRequiredNama." upload harus diisi.";
					}

					if(!empty($infopesan))
					{
						$vreturn= getconcatseparator($vreturn, $infopesan, "<br/>");
					}
					// echo $vreturn;exit;
				}
			}

		}

		// echo $vreturn;exit;
		return $vreturn;
	}

	function pilihfiledokumen()
	{
		$arrField= array(
		  array("id"=>"", "nama"=>"")
		  , array("id"=>"1", "nama"=>"Upload File Scan Baru")
		  , array("id"=>"2", "nama"=>"Dari e-File")
		);
		return $arrField;
	}

	function kondisikategori($tipe)
	{
		if($tipe == "1")
		{
			$arrField= array(4,5,6);
		}
		else
		{
			$arrField= array(1,2,3);
		}
		return $arrField;
	}

	function ambilfilemode($arrinfo, $keymode, $keytable="", $inforowid="", $infodetilparam=[])
	{
		// $arrkeymode= explode(";", $keymode);
		// $infotable= $arrkeymode[0];
		// $inforowid= $arrkeymode[1];
		// $infofield= $arrkeymode[2];

		$arrreturn= [];
		// $infocarikey= $infotable.";".$inforowid.";".$infofield;
		$arrcheck= [];
		// $arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);

		// khusus table persuratan.suratmasukpegawai
		$ambilriwayatfield= "";
		if(!empty($keytable))
		{
			if($keytable == "PEGAWAI")
			{
				$infocarikey= $keytable.$keymode;
				$arrcheck= in_array_column($infocarikey, "inforiwayattableid", $arrinfo);
			}
			elseif($keytable == "SERTIFIKAT_FILE")
			{
				$infocarikey= $keymode;
				$arrcheck= in_array_column($infocarikey, "inforiwayattableid", $arrinfo);
				// print_r($arrinfo);exit;
				// print_r($arrcheck);exit;
			}
			elseif($keytable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
			{
				$ambilriwayatfield= "1";
				// print_r($arrinfo);
				$infocarikey= $keytable.$keymode;
				$infocarikeydetil= $infocarikey.";".$inforowid;
				// echo $infocarikeydetil;
				// echo $infocarikey;
				// exit;
				
				$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
				// print_r($arrcheck);exit;

				// $arrcheck= in_array_column($infocarikeydetil, "KEYMODE", $arrinfo);
				// if(empty($arrcheck))
				// {
				// 	$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
				// }
			}
			// else if($keytable == "inforiwayattableid")
			// {
			// 	$infocarikey= $keymode;
			// 	$arrcheck= in_array_column($infocarikey, "inforiwayattableid", $arrinfo);
			// }

			else if(
				(
				$keytable == "SUAMI_ISTRI" && $keymode == "aktanikah"
				)
				||
				(
				$keytable == "SUAMI_ISTRI" && $keymode == "aktacerai"
				)
				||
				(
				$keytable == "SUAMI_ISTRI" && $keymode == "suratkematian"
				)
			)
			{
				$infocarikey= $keytable.";".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
				// print_r($arrcheck);exit;
			}
			else if(
				(
				$keytable == "ANAK" && $keymode == "aktakelahiran"
				)
				||
				(
				$keytable == "ANAK" && $keymode == "suratketerangankuliah"
				)
				||
				(
				$keytable == "ANAK" && $keymode == "suratketeranganbelumbekerja"
				)
			)
			{
				$infocarikey= $keytable.";".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
				// print_r($arrcheck);exit;
			}
			elseif($keytable == "PENILAIAN_SKP")
			{
				$infocarikey= $keytable.";".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
				// print_r($arrcheck);exit;
			}
			elseif($keytable == "ORANG_TUA")
			{
				$checkDokumenFileRiwayatField= explode("-", $keymode);
				$checkDokumenFileRiwayatField= $checkDokumenFileRiwayatField[0];

				if($checkDokumenFileRiwayatField == "L")
				{
					$vidayah= $infodetilparam[0]["ID_AYAH"];
					$vidibu= $infodetilparam[0]["ID_IBU"];
					$inforowid= $vidayah;
				}
				else if($checkDokumenFileRiwayatField == "P")
				{
					$vidayah= $infodetilparam[0]["ID_AYAH"];
					$vidibu= $infodetilparam[0]["ID_IBU"];
					$inforowid= $vidibu;
				}

				$infocarikey= $keytable.";".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
			}
			elseif($keytable == "PANGKAT_RIWAYAT_PNS")
			{
				$infocarikey= "PANGKAT_RIWAYAT;".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
			}
			elseif($keytable == "PANGKAT_RIWAYAT_AKHIR")
			{
				$infocarikey= "PANGKAT_RIWAYAT;".$inforowid;
				$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
			}
			elseif($keytable == "JABATAN_RIWAYAT_AKHIR")
			{
				$infocarikey= "JABATAN_RIWAYAT;".$inforowid;
				$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
			}
			elseif($keytable == "PAK_AKHIR")
			{
				$infocarikey= "PAK;".$inforowid;
				$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
			}
			elseif($keytable == "GAJI_RIWAYAT_AKHIR")
			{
				$infocarikey= "GAJI_RIWAYAT;".$inforowid;
				$arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
			}
			elseif($keytable == "PENDIDIKAN_RIWAYAT_AKHIR")
			{
				$infocarikey= "PENDIDIKAN_RIWAYAT;".$inforowid.";".$keymode;
				$arrcheck= in_array_column($infocarikey, "KEYMODE", $arrinfo);
			}
			else
			{
				$infocarikey= $keytable.$keymode;
				// print_r($arrinfo);
				// echo "\n".$infocarikey."xxx\n";
				$arrcheck= in_array_column($infocarikey, "inforiwayattable", $arrinfo);
			}
		}
		else
		{
			$infocarikey= $keymode;
			$arrcheck= in_array_column($infocarikey, "inforiwayatfield", $arrinfo);
		}

		$arrinforiwayatfield= [];
		if($keytable == "PANGKAT_RIWAYAT_AKHIR")
		{
			$arrinforiwayatfield= ["sttplprajabatan", "notausulcpns", "suratujikesehatan", "sttplprajabatan", "bapsumpah"];
		}

		// print_r($arrcheck);exit;
		if(!empty($arrcheck))
		{
			foreach ($arrcheck as $vindex)
			{
				$vext= strtolower($arrinfo[$vindex]["ext"]);

				if(empty($keymode))
				{
					if(strtolower($vext) !== "pdf")
						continue;
				}

				if($keytable == "PANGKAT_RIWAYAT_AKHIR")
				{
					$cekinforiwayatfield= $arrinfo[$vindex]["inforiwayatfield"];
					// kalau ada dalam kondisi maka lewati
					if(in_array($cekinforiwayatfield, $arrinforiwayatfield))
					{
						continue;
					}
				}

				$arrdata= [];
				$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
				$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
				$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
				$arrdata["id"]= $arrinfo[$vindex]["id"];
				$arrdata["index"]= "v".count($arrreturn);
				$arrdata["selected"]= $arrinfo[$vindex]["selected"];
				$arrdata["nama"]= $arrinfo[$vindex]["nama"];
				$arrdata["vurl"]= $arrinfo[$vindex]["vurl"];
				$arrdata["ext"]= strtolower($vext);
				$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
				$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
				$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
				$arrdata["infotable"]= $arrinfo[$vindex]["infotable"];
				array_push($arrreturn, $arrdata);
				// echo $vindex;exit;
			}
		}

		if($keytable == "SERTIFIKAT_FILE")
		{
			// print_r($arrreturn);exit;
		}

		if($keymode == "foto")
		{
			$infocarikey= "jpg";
			$arrcheck= [];
			$arrcheck= in_array_column($infocarikey, "ext", $arrinfo);
			if(!empty($arrcheck))
			{
				foreach ($arrcheck as $vindex)
				{
					$infocarikey= $arrinfo[$vindex]["KEY"];
					$inforiwayatfield= $arrinfo[$vindex]["inforiwayatfield"];
					$inforiwayatid= $arrinfo[$vindex]["inforiwayatid"];
					$infoselected= $arrinfo[$vindex]["selected"];
					$infoselected= "";

					if(empty($inforiwayatfield) && empty($inforiwayatid))
					{
						$vinforowurl= $arrinfo[$vindex]["vurl"];
						// kalau url sudah ada maka lewati
						$arrcheckdetil= in_array_column($vinforowurl, "vurl", $arrreturn);
						if(!empty($arrcheckdetil))
							continue;
						
						$arrdata= [];
						$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
						$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
						$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
						$arrdata["id"]= $arrinfo[$vindex]["id"];
						$arrdata["index"]= "v".count($arrreturn);
						$arrdata["selected"]= $infoselected;
						$arrdata["nama"]= $arrinfo[$vindex]["nama"];
						$arrdata["vurl"]= $vinforowurl;
						$arrdata["ext"]= strtolower($arrinfo[$vindex]["ext"]);
						$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
						$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
						$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
						$arrdata["infotable"]= $arrinfo[$vindex]["infotable"];
						array_push($arrreturn, $arrdata);
						// echo $vindex;exit;
					}

					/*$arrcheck= [];
					$arrcheck= in_array_column($infocarikey, "KEY", $arrreturn);
					if(empty($arrcheck))
					{
						$arrdata= [];
						$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
						$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
						$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
						$arrdata["id"]= $arrinfo[$vindex]["id"];
						$arrdata["index"]= "v".count($arrreturn);
						$arrdata["selected"]= $arrinfo[$vindex]["selected"];
						$arrdata["nama"]= $arrinfo[$vindex]["nama"];
						$arrdata["vurl"]= $arrinfo[$vindex]["vurl"];
						$arrdata["ext"]= $arrinfo[$vindex]["ext"];
						$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
						$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
						$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
						array_push($arrreturn, $arrdata);
						// echo $vindex;exit;
					}*/
				}
			}
		}
		else
		{
			$infocarikey= "pdf";
			$arrcheck= [];
			$arrcheck= in_array_column($infocarikey, "ext", $arrinfo);
			// print_r($arrinfo);exit;

			if(!empty($arrcheck))
			{
				if($keymode == "aktakelahiran")
				{
					// print_r($arrcheck);
					// print_r($arrinfo);exit;
				}

				foreach ($arrcheck as $vindex)
				{
					$infocarikey= $arrinfo[$vindex]["KEY"];
					$inforiwayatfield= $arrinfo[$vindex]["inforiwayatfield"];
					$inforiwayatid= $arrinfo[$vindex]["inforiwayatid"];
					$infoselected= $arrinfo[$vindex]["selected"];
					$infoselected= "";

					// if($infoselected == "selected")
					// 	continue;

					if(empty($inforiwayatfield) && empty($inforiwayatid))
					{
						$vinforowurl= $arrinfo[$vindex]["vurl"];
						// kalau url sudah ada maka lewati
						$arrcheckdetil= in_array_column($vinforowurl, "vurl", $arrreturn);
						if(!empty($arrcheckdetil))
							continue;

						if($keytable == "PANGKAT_RIWAYAT_AKHIR")
						{
							$cekinforiwayatfield= $arrinfo[$vindex]["inforiwayatfield"];
							// kalau ada dalam kondisi maka lewati
							if(in_array($cekinforiwayatfield, $arrinforiwayatfield))
							{
								continue;
							}
						}

						$arrdata= [];
						$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
						$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
						$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
						$arrdata["id"]= $arrinfo[$vindex]["id"];
						$arrdata["index"]= "v".count($arrreturn);
						$arrdata["selected"]= $infoselected;
						$arrdata["nama"]= $arrinfo[$vindex]["nama"];
						$arrdata["vurl"]= $vinforowurl;
						$arrdata["ext"]= strtolower($arrinfo[$vindex]["ext"]);
						$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
						$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
						$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
						$arrdata["infotable"]= $arrinfo[$vindex]["infotable"];
						array_push($arrreturn, $arrdata);
						// echo $vindex;exit;
					}

					/*$arrcheck= [];
					$arrcheck= in_array_column($infocarikey, "KEY", $arrreturn);
					if(empty($arrcheck))
					{
						$inforiwayatfield= $arrinfo[$vindex]["inforiwayatfield"];
						if(empty($inforiwayatfield))
						{
							$arrdata= [];
							$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
							$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
							$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
							$arrdata["id"]= $arrinfo[$vindex]["id"];
							$arrdata["index"]= "v".count($arrreturn);
							$arrdata["selected"]= $arrinfo[$vindex]["selected"];
							$arrdata["nama"]= $arrinfo[$vindex]["nama"];
							$arrdata["vurl"]= $arrinfo[$vindex]["vurl"];
							$arrdata["ext"]= $arrinfo[$vindex]["ext"];
							$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
							$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
							$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
							array_push($arrreturn, $arrdata);
							// echo $vindex;exit;
						}

					}*/

				}
			}	
		}
		// $arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function listpilihfilepegawaibug($reqId, $riwayattable, $reqRowId, $suratmasukpegawaiid="", $paramriwayatfield="", $infodetilparam=[])
	{
		if($reqRowId == "baru")
		{
			$reqRowId= -1;	
		}

		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$arrfieldcpns= ["skcpns", "notausulcpns"];
		$arrfieldpns= ["skpns", "notausulpns"];
		$arrfieldppk= ["sk"];
		$arrfieldskp= ["ppk", "skp"];
		$arrfieldanak= ["foto", "aktakelahiran", "ktp", "pasport", "sim", "suratkematian", "suratnikah", "suratcerai"];
		$arrfieldsaudara= ["ktp", "suratkematian"];
		$arrfieldsuamiistri= ["foto", "aktanikah", "aktacerai", "kariskarsu", "aktakelahiran", "ktp", "pasport", "sim", "suratkematian", "skkonversinipbaru", "suratnikah", "suratcerai", "skjandaduda", "laporanpernikahanpertama"];
		$arrfieldorangtua= ["L-ktp", "L-suratkematian", "P-ktp", "P-suratkematian"];
		$arrfieldpendidikan= ["ijazah", "transkrip"];
		$arrfieldpendidikantupel= ["tugasbelajar", "ijinbelajar"];

		$arrcarifileddetil= array_unique(array_merge($arrfieldcpns,$arrfieldpns,$arrfieldppk,$arrfieldskp,$arrfieldanak,$arrfieldsaudara,$arrfieldsuamiistri,$arrfieldorangtua,$arrfieldpendidikan,$arrfieldpendidikantupel));
		// print_r($arrcarifileddetil);exit;

		$sorderfile= "ORDER BY A.RIWAYAT_FIELD, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC";

		$arrgetinfofile= $this->getinfofile($reqId);
		// print_r($arrgetinfofile);exit;

		if(is_array($riwayattable))
		{
			// $riwayattable= [];
			// array_push($riwayattable, "tes");
			// array_push($riwayattable, "xxx");
			// array_push($riwayattable, "yyy");

			$vtable= "";
			foreach ($riwayattable as $k => $v) {
				$vtable= getconcatseparator($vtable, $v, "','");
			}

			if(!empty($vtable))
			{
				$vtable= "'".$vtable."'";
				$statement= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
			}
			// echo $vtable;exit;
		}
		else
		{
			$statement= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
		}

		if(!empty($reqRowId) && empty($paramriwayatfield))
		{
			$vriwayatid= "";
			if(!empty($infodetilparam))
			{
				foreach ($infodetilparam as $k => $v) {
					$vdetil= $v["ID_AYAH"];
					$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
					$vdetil= $v["ID_IBU"];
					$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
				}
			}
			// echo $vriwayatid;exit;
			if(!empty($vriwayatid))
				$statement.= " AND RIWAYAT_ID IN (".$vriwayatid.")";
			else
				$statement.= " AND A.RIWAYAT_ID = ".$reqRowId;
		}

		$arrparamriwayatfield= [];
		if(!empty($paramriwayatfield))
		{
			$statementparam= "";
			$arrparamriwayatfield= explode("," , $paramriwayatfield);
			foreach ($arrparamriwayatfield as $key => $value) 
			{
				if(empty($statementparam))
					$statementparam= "'".$value."'";
				else
					$statementparam.= ",'".$value."'";
			}
			$statement.= " AND A.RIWAYAT_FIELD IN (".$statementparam.")";
		}
		// echo $statement;exit;

		$statement.= "
		AND EXISTS
		(
			SELECT 1
			FROM
			(
				SELECT *
				FROM
				(
					SELECT
					A.PEGAWAI_FILE_ID
					, CASE WHEN A.RIWAYAT_TABLE = 'PERSURATAN.SURAT_MASUK_PEGAWAI'
					THEN
						ROW_NUMBER () OVER 
						(
							PARTITION BY A.RIWAYAT_TABLE, A.RIWAYAT_ID
							ORDER BY CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
						)
					ELSE
						ROW_NUMBER () OVER 
						(
							PARTITION BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID
							ORDER BY CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
						)
					END INFOPOSISI
					FROM PEGAWAI_FILE A
					WHERE 1=1 AND A.PEGAWAI_ID = ".$reqId."
		";
					if(is_array($riwayattable))
					{
						$statement.= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
					}
					else
					{
						$statement.= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
					}

					if(!empty($reqRowId) && empty($paramriwayatfield))
					{
						$vriwayatid= "";
						if(!empty($infodetilparam))
						{
							foreach ($infodetilparam as $k => $v) {
								$vdetil= $v["ID_AYAH"];
								$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
								$vdetil= $v["ID_IBU"];
								$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
							}
						}
						// echo $vriwayatid;exit;
						if(!empty($vriwayatid))
							$statement.= " AND RIWAYAT_ID IN (".$vriwayatid.")";
						else
							$statement.= " AND RIWAYAT_ID = ".$reqRowId;
					}

					if(!empty($paramriwayatfield))
					{
						// $statement.= " AND A.RIWAYAT_FIELD = '".$paramriwayatfield."'";
					}

		$statement.= "
					ORDER BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
				) X WHERE INFOPOSISI = 1
			) X WHERE A.PEGAWAI_FILE_ID = X.PEGAWAI_FILE_ID
		)";

		// echo $statement;exit;

		$setfile= new PegawaiFile();
		$setfile->selectByParamsFile(array(), -1,-1, $statement, $reqId, $sorderfile);
		// $lihatquery= "1";
		if($reqId == "12673")
		{
			$lihatquery= "1";
		}

		if(!empty($lihatquery))
		{
	  		// echo $setfile->query;exit;
		}

		$lokasi_link_file= "uploads/".$reqId."/";

		$arrriwayatfile= [];
		$arrpilihfile=[];

	  	$checkriwayatfield= "";
		// $setfile->firstRow();
	  	while($setfile->nextRow())
	  	{
			$reqDokumenFilePath= $setfile->getField("PATH");

			$vinforiwayatid= $setfile->getField("RIWAYAT_ID");
			$vinforiwayattable= $setfile->getField("RIWAYAT_TABLE");
			$vdatainforiwayatfield= $setfile->getField("RIWAYAT_FIELD");

			if($vinforiwayattable == "NULL")
				$vinforiwayattable= "";

			$reqDokumenFileId= $setfile->getField("PEGAWAI_FILE_ID");
			$reqDokumenFileKualitasId= $setfile->getField("FILE_KUALITAS_ID");
			$reqDokumenFilePathAsli= $setfile->getField("PATH_ASLI");
			$reqDokumenFileKeterangan= $setfile->getField("KETERANGAN");

			// khusus table persuratan.suratmasukpegawai
			$ambilriwayatfield= "";
			if($vinforiwayattable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
				$ambilriwayatfield= "1";

			if($ambilriwayatfield == "1")
			{
				$reqDokumenFileRiwayatField= "";
				if($vdatainforiwayatfield == $suratmasukpegawaiid)
					$reqDokumenFileRiwayatField= $suratmasukpegawaiid;

				// echo $reqDokumenFileRiwayatField."-".$vdatainforiwayatfield;exit;
			}
			else
				$reqDokumenFileRiwayatField= $setfile->getField("RIWAYAT_FIELD");

			if($reqDokumenFileKeterangan == "NULL")
				$reqDokumenFileRiwayatField= "";

			$vriwayatfield= $reqDokumenFileRiwayatField;
			if($vriwayatfield == "")
				$vriwayatfield= "xxx";

			// if($checkriwayatfield == $vriwayatfield){}
			// else
			// {

				// khusus orang tua
				if(!empty($infodetilparam))
				{
					$checkDokumenFileRiwayatField= explode("-", $vdatainforiwayatfield);
					$checkDokumenFileRiwayatField= $checkDokumenFileRiwayatField[0];

					if($checkDokumenFileRiwayatField == "L")
					{
						$vidayah= $infodetilparam[0]["ID_AYAH"];
						$vidibu= $infodetilparam[0]["ID_IBU"];
						$reqRowId= $vidayah;
					}
					else if($checkDokumenFileRiwayatField == "P")
					{
						$vidayah= $infodetilparam[0]["ID_AYAH"];
						$vidibu= $infodetilparam[0]["ID_IBU"];
						$reqRowId= $vidibu;
					}
				}

				// kalau ada data terkait
				if(!empty($reqDokumenFileId))
				{
					if(empty($reqRowId))
						$infocarikeynew= $vinforiwayattable.";".$vinforiwayatid;
					else
						$infocarikeynew= $riwayattable.";".$reqRowId;

					$infocarikeymode= $infocarikeynew.";".$reqDokumenFileRiwayatField;
					$infocarikey= $infocarikeymode.";".$reqDokumenFileId;

					if(empty($reqDokumenFilePathAsli))
					{
						$reqDokumenFilePathAsli= $reqDokumenFilePath;
						$reqDokumenFilePathAsli= str_replace($lokasi_link_file, "", $reqDokumenFilePathAsli);
					}

					// kalau ada data terkait
					$arrcaripilih= [];
					if(!empty($vinforiwayatfield) && in_array($vinforiwayatfield, $arrcarifileddetil))
					{
						$keycaripilih= $infocarikey;
						$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);
					}
					else
					{
						$keycaripilih= $infocarikeymode;
						$arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrpilihfile);
					}

					/*if(in_array($vinforiwayatfield, $arrcarifileddetil))
					{
						$keycaripilih= $infocarikey;
						$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);
					}
					else
					{
						$keycaripilih= $infocarikeymode;
						$arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrcheckpilih);
					}*/

					if(!empty($arrcaripilih))
						continue;

					if($ambilriwayatfield == "1")
					{
						if(empty($reqDokumenFileRiwayatField))
							continue;
					}

					$infonama= $reqDokumenFilePathAsli;
					$arrdata= [];
					$arrdata["KEY"]= $infocarikey;
					$arrdata["KEYINFO"]= $infocarikeynew;
					$arrdata["KEYMODE"]= $infocarikeymode;
					$arrdata["id"]= $reqDokumenFileId;
					$arrdata["index"]= "v".count($arrpilihfile);
					$arrdata["selected"]= "selected";
					$arrdata["nama"]= $infonama;
					$arrdata["vurl"]= $reqDokumenFilePath;
					$arrdata["ext"]= strtolower(end(explode(".", $reqDokumenFilePath)));
					$arrdata["filekualitasid"]= $reqDokumenFileKualitasId;
					if(empty($reqRowId))
						$arrdata["inforiwayatid"]= $vinforiwayatid;
					else
						$arrdata["inforiwayatid"]= $reqRowId;

					$arrdata["inforiwayatfield"]= $reqDokumenFileRiwayatField;
					$arrdata["inforiwayattable"]= $vinforiwayattable.$reqDokumenFileRiwayatField;
					$arrdata["inforiwayattableid"]= $vinforiwayattable.$vinforiwayatid;
					$arrdata["infotable"]= $vinforiwayattable;
					array_push($arrpilihfile, $arrdata);

					if($ambilriwayatfield == "1")
					{
						// print_r($arrpilihfile);exit;
						// echo $keycaripilih;exit;
						// print_r($arrcaripilih);exit;
					}
				}

				// $checkriwayatfield= $vriwayatfield;
			// }
		}
		$arrcheckpilih= $arrpilihfile;

		if($ambilriwayatfield == "1")
		{
			// print_r($arrcheckpilih);
			// exit;
		}
		// print_r($arrcheckpilih);exit;
		
		$ambil_data_file= lihatfiledirektori($lokasi_link_file);

		// $statement= " AND A.RIWAYAT_ID IS NULL AND COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL";
		$statement= " AND COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL";

		if(is_array($riwayattable))
		{
			$statementriwayattable= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
			// $statement.= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
		}
		else
		{
			$statementriwayattable= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
			// $statement.= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
		}
		
		$sorderfile= "ORDER BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC";
		$set= new PegawaiFile();
		$set->selectByParamsFile(array(), -1,-1, $statement, $reqId, $sorderfile, $statementriwayattable);
		// echo $set->query;exit;

		$arrPegawaiDokumen=[];
		while($set->nextRow())
		{
			$inforiwayattable= $set->getField("RIWAYAT_TABLE");
			if($inforiwayattable == "NULL")
				$inforiwayattable= "";

			$inforiwayatfield= $set->getField("RIWAYAT_FIELD");
			$inforiwayatid= $set->getField("RIWAYAT_ID");
			$infopath= $set->getField("PATH");

			$arrdata= [];
			$arrdata["PEGAWAI_FILE_ID"]= $set->getField("PEGAWAI_FILE_ID");
			$arrdata["ROWID"]= $infopath;
			$arrdata["JENIS_DOKUMEN"]= $inforiwayattable.";".$inforiwayatid.";".$inforiwayatfield;
			$arrdata["FILE_KUALITAS_ID"]= $set->getField("FILE_KUALITAS_ID");
			$arrdata["FILE_KUALITAS_NAMA"]= $set->getField("FILE_KUALITAS_NAMA");
			$arrdata["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
			$arrdata["RIWAYAT_TABLE"]= $inforiwayattable;
			$arrdata["RIWAYAT_FIELD"]= $inforiwayatfield;
			$arrdata["RIWAYAT_ID"]= $inforiwayatid;
			$arrdata["INFO_DATA"]= $set->getField("INFO_DATA");
			$arrdata["KATEGORI_FILE_ID"]= $set->getField("KATEGORI_FILE_ID");

			$vinfogroupdata= "";
			$vpidrow= $set->getField("P_ID_ROW");
			$arrcheckgetinfofile= in_array_column($vpidrow, "ID_ROW", $arrgetinfofile);
			// print_r($arrcheckgetinfofile);exit;
			if(!empty($arrcheckgetinfofile))
			{
				$indexcheckgetinfofile= $arrcheckgetinfofile[0];
				$vinfogroupdata= $arrgetinfofile[$indexcheckgetinfofile]["NAMA_ROW"];
				// $vinfogroupdata
			}
			$arrdata["INFO_GROUP_DATA"]= $vinfogroupdata;
			// $arrdata["INFO_GROUP_DATA"]= $set->getField("INFO_GROUP_DATA");

			$infopathasli= $set->getField("PATH_ASLI");
			if(empty($infopathasli))
			{
				$infopathasli= str_replace($lokasi_link_file, "", $infopath);
			}
			$arrdata["PATH_ASLI"]= $infopathasli;
			$arrdata["EXT"]= $set->getField("EXT");
			array_push($arrPegawaiDokumen, $arrdata);
		}
		// $jumlah_pegawai_dokumen= count($arrPegawaiDokumen);
		// print_r($arrPegawaiDokumen);exit;

		for($index_file=0; $index_file < count($ambil_data_file); $index_file++)
        {
			$reqPegawaiFileId= $tempKategoriFileId= $tempRiwayatTable= $tempFileKualitasId= $tempFileKualitasNama= "";
            $tempUrlFile= $ambil_data_file[$index_file];
            $tempNamaUrlFile= pathinfo($tempUrlFile, PATHINFO_BASENAME);
			$vinforiwayattable= $tempRiwayatTable= $tempInfoGroupData= $tempFileKualitasNama= $tempFileKualitasId= "";
			
			// echo $tempUrlFile;exit;
			$vinforiwayatid= $vinforiwayatfield= "";
			$arrcaridata= [];
			$arrcaridata= in_array_column($tempUrlFile, "ROWID", $arrPegawaiDokumen);
			// print_r($arrcaridata);exit;

			// var_dump($tempUrlFile);
			// kalau belum ada date terkait, tanpa file terhapus
			if(empty($arrcaridata))
			{
				$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);

				if($tempFileDelete == 1)
					continue;

				$infoext= end(explode(".", $tempUrlFile));

				$infofilekualitasid= "1";
				if(strtolower($infoext) !== "pdf")
					$infofilekualitasid= "4";

				$infonama= $tempNamaUrlFile;
				$arrdata= [];
				$arrdata["KEY"]= "";
				$arrdata["KEYINFO"]= "";
				$arrdata["KEYMODE"]= "";
				$arrdata["id"]= $reqPegawaiFileId;
				$arrdata["index"]= "v".count($arrpilihfile);
				$arrdata["selected"]= "";
				$arrdata["nama"]= $infonama;
				$arrdata["vurl"]= $tempUrlFile;
				$arrdata["ext"]= strtolower($infoext);
				$arrdata["filekualitasid"]= $infofilekualitasid;
				$arrdata["inforiwayatid"]= "";
				$arrdata["inforiwayatfield"]= "";
				$arrdata["inforiwayattable"]= "";
				$arrdata["inforiwayattableid"]= "";
				$arrdata["infotable"]= "";
				array_push($arrpilihfile, $arrdata);
				continue;
			}
			else
			{
				$index_row= $arrcaridata[0];
				$vinforowurl= $arrPegawaiDokumen[$index_row]["ROWID"];
				$reqPegawaiFileId= $arrPegawaiDokumen[$index_row]["PEGAWAI_FILE_ID"];
				$vinforiwayattable= $arrPegawaiDokumen[$index_row]["RIWAYAT_TABLE"];
				$vinforiwayatid= $arrPegawaiDokumen[$index_row]["RIWAYAT_ID"];
				$vinforiwayatfield= $arrPegawaiDokumen[$index_row]["RIWAYAT_FIELD"];
				if($vinforiwayatfield == "NULL")
					$vinforiwayatfield= "";
				$tempInfoGroupData= $arrPegawaiDokumen[$index_row]["INFO_GROUP_DATA"];
				$tempKategoriFileId= $arrPegawaiDokumen[$index_row]["KATEGORI_FILE_ID"];
				$tempRiwayatTable= $arrPegawaiDokumen[$index_row]["JENIS_DOKUMEN"];
				$tempFileKualitasId= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_ID"];
				$tempFileKualitasNama= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_NAMA"];
				$tempNamaUrlFileDB= $arrPegawaiDokumen[$index_row]["PATH_ASLI"];
				$ext= $arrPegawaiDokumen[$index_row]["EXT"];
				$tempNamaUrlFileAsli=$tempNamaUrlFileDB.".".$ext;
				// var_dump($tempNamaUrlFile);
			}

			// khusus table persuratan.suratmasukpegawai
			$ambilriwayatfield= "";
			if($vinforiwayattable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
			{
				$ambilriwayatfield= "1";
			}

			if($index_row == 14)
			{
				// print_r($arrPegawaiDokumen[$index_row]);
				// echo $vinforiwayatfield."-".$vinforiwayatid."-".$reqRowId."-".$vinforowurl."\n";
			}

			if($reqKategoriFileId == ""){}
			else
			{
				if($tempKategoriFileId == $reqKategoriFileId){}
				else
				continue;
			}

			if($reqKualitasFileId == ""){}
			else
			{
				if($tempFileKualitasId == $reqKualitasFileId){}
				else
				continue;
			}
			
			if($reqRiwayatTable == ""){}
			else
			{
				$tempCheck= $reqRiwayatTable.";".$reqRiwayatId.";".$reqRiwayatField;

				if($ambilriwayatfield == "1")
				{
					// echo $tempCheck."\n";
					// echo $tempRiwayatTable."\n";
					// exit;
				}

				if($tempRiwayatTable == $tempCheck){}
				else
				continue;
			}

			if($reqJenisDokumen == "-1")
			{
				if($reqKategoriFileId == "")
				{
					if($tempInfoGroupData == ""){}
					else
					continue;
				}
				else
				{
					if($tempInfoGroupData == "")
					continue;
				}
			}

			// $tempFileDelete= "";
			// if($tempUserLoginLevel == "99"){}
			// else
			// {
				// sebelum
				// $tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);
			// }

			// sebelum
			// if($tempFileDelete == 1)
			// 	continue;

			// set nama
			$infonama= $tempNamaUrlFileAsli;
			if(empty($arrcaridata))
            {
            	$infonama= $tempNamaUrlFile;
            }

            $tempFileDelete= likeMatch("%_delete_%", $infonama);
            if($tempFileDelete == 1)
				continue;

			if($ambilriwayatfield == "1")
			{
				// print_r($arrpilihfile);
				// exit;
			}

			// kalau tidak sama dengan table, dan row id lewati
			if(!empty($vinforiwayatid))
			{
				// if($vinforiwayatid == $reqRowId && $vinforiwayattable == $riwayattable){}
				// if($vinforiwayatid == $reqRowId && $vinforiwayattable == $inforiwayattable){}
				// else
				// 	continue;

				// $infocarikeynew= $riwayattable.";".$reqRowId;
				$infocarikeynew= $vinforiwayattable.";".$vinforiwayatid;
				$infocarikeymode= $infocarikeynew.";".$vinforiwayatfield;
				$infocarikey= $infocarikeymode.";".$reqPegawaiFileId;

				// echo $infocarikeynew;exit;

				if($ambilriwayatfield == "1")
				{
					// print_r($vinforiwayattable);
					// print_r($riwayattable);
					// echo $riwayattable."-".$vinforiwayatid."-".$reqRowId."-".$vinforowurl."\n";
					// exit;
				}

				// sesuai table atau kosong
				if(is_array($riwayattable))
				{
					if(!in_array($vinforiwayattable, $riwayattable))
					{
						if($ambilriwayatfield == "1")
						{
							// echo "aaa\n";
							// exit;
						}
						continue;
					}
				}
				else
				{
					if($vinforiwayattable !== $riwayattable)
					{
						if($ambilriwayatfield == "1")
						{
							// echo "bb\n";
							// exit;
						}
						continue;
					}
				}

				// if($ambilriwayatfield == "1")
				// {
				// 	print_r($arrpilihfile);
				// 	echo $infocarikeymode."\n";
				// 	echo $reqPegawaiFileId."\n";
				// 	echo $tempRiwayatTable."\n";
				// 	exit;
				// }

				$arrcaripilih= [];
				if(in_array($vinforiwayatfield, $arrcarifileddetil))
				// if($vinforiwayatfield == "skpns")
				{
					$keycaripilih= $infocarikey;
					$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);

					if($ambilriwayatfield == "1")
					{
						// echo "a";exit;
					}

					// print_r($arrcaripilih);exit;
					// echo $infocarikeymode."\n";
					// echo $infocarikey."\n";

					// echo $tempRiwayatTable." == ".$tempCheck."\n";
					// echo $vinforiwayatfield."-".$vinforiwayatid."-".$reqRowId."-".$vinforowurl."\n";
					// echo $vinforiwayatid."-".$reqRowId."-".$vinforiwayattable."-".$inforiwayattable."\n";

					// $infotes= $vinforiwayattable.$vinforiwayatid;
					// echo $infotes."\n";
					// if($infotes == "SUAMI_ISTRI8020")
					// {
					// 	echo $vinforiwayattable." !== ".$riwayattable." && ".$vinforiwayatid;exit;
					// }
				}
				else if($ambilriwayatfield == "1")
				{
					$keycaripilih= $infocarikey;
					// print_r($arrpilihfile);
					// echo $keycaripilih."\n";
					// echo $reqPegawaiFileId."\n";
					// exit;
					$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);
				}
				else
				{
					if
					(
						($vinforiwayattable == "PANGKAT_RIWAYAT" || $vinforiwayattable == "GAJI_RIWAYAT")
						&& empty($vinforiwayatfield)
					)
					{
						$arrcaripilih= [];
					}
					else
					{
						$keycaripilih= $infocarikeymode;
						$arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrcheckpilih);
					}

					if($ambilriwayatfield == "1")
					{
						// echo "b";exit;
					}
				}

				// if($ambilriwayatfield == "1")
				// {
				// 	print_r($arrcheckpilih);
				// 	echo $keycaripilih."-"."\n";
				// 	exit;
				// }

				if(!empty($arrcaripilih))
					continue;

				// set untuk riwayat
				$arrdata= [];
				$arrdata["KEY"]= $infocarikey;
				$arrdata["KEYINFO"]= $infocarikeynew;
				$arrdata["KEYMODE"]= $infocarikeymode;
				$arrdata["id"]= $reqPegawaiFileId;
				$arrdata["index"]= "v".count($arrriwayatfile);
				$arrdata["selected"]= "";
				$arrdata["nama"]= $infonama;
				$arrdata["vurl"]= $tempUrlFile;
				$arrdata["ext"]= strtolower(end(explode(".", $tempUrlFile)));
				$arrdata["filekualitasid"]= $tempFileKualitasId;
				$arrdata["inforiwayatid"]= $vinforiwayatid;
				$arrdata["inforiwayatfield"]= $vinforiwayatfield;
				array_push($arrriwayatfile, $arrdata);

				// kalau data selected sudah terkait
				if($reqPegawaiFileId == $reqDokumenFileId)
					continue;
			}

			// set untuk file pilih data
			// $infocarikeynew= $riwayattable.";".$reqRowId;
			
			// $infocarikeynew= $inforiwayattable.";".$reqRowId;
			$infocarikeynew= $vinforiwayattable.";".$vinforiwayatid;
			$infocarikeymode= $infocarikeynew.";".$vinforiwayatfield;
			$infocarikey= $infocarikeymode.";".$reqPegawaiFileId;

			$arrcheck= [];
			$arrcheck= in_array_column($infocarikey, "KEY", $arrpilihfile);

			if
			(
				($vinforiwayattable == "PANGKAT_RIWAYAT" || $vinforiwayattable == "GAJI_RIWAYAT")
				&& empty($vinforiwayatfield)
			)
			{
				/*$arrcheck= [];
				$arrcheck= in_array_column($tempUrlFile, "vurl", $arrpilihfile);
				print_r($arrcheck);
				// vurl
				// $arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrcheckpilih);
				// echo $infocarikey;
				print_r($arrpilihfile);exit;*/
			}

			if($ambilriwayatfield == "1")
			{
				// print_r($arrpilihfile);
				// print_r($arrPegawaiDokumen[$index_row]);
				// echo "xx".$infocarikey."\n";
				// // echo "xx".$reqPegawaiFileId."\n";
				// print_r($arrcheck);
				// exit;
			}

			if(empty($arrcheck))
			{
				$infoext= end(explode(".", $tempUrlFile));

				if(empty($tempFileKualitasId))
				{
					$infofilekualitasid= "1";
					if(strtolower($infoext) !== "pdf")
						$infofilekualitasid= "4";
				}
				else
				{
					$infofilekualitasid= $tempFileKualitasId;
				}

				// kalau paramriwayatfield khusus pangkat
				if(!empty($paramriwayatfield))
				{
					if(
						($riwayattable == $vinforiwayattable.$vinforiwayatfield) || 
						(!empty($vinforiwayatfield) && 
							// $vinforiwayatfield !== $paramriwayatfield
							!in_array($vinforiwayatfield, $arrparamriwayatfield)
						)
					)
					{
						continue;
					}
				}

				$arrdata= [];
				$arrdata["KEY"]= $infocarikey;
				$arrdata["KEYINFO"]= $infocarikeynew;
				$arrdata["KEYMODE"]= $infocarikeymode;
				$arrdata["id"]= $reqPegawaiFileId;
				$arrdata["index"]= "v".count($arrpilihfile);
				$arrdata["selected"]= "";
				$arrdata["nama"]= $infonama;
				$arrdata["vurl"]= $tempUrlFile;
				$arrdata["ext"]= strtolower($infoext);
				$arrdata["filekualitasid"]= $infofilekualitasid;
				$arrdata["inforiwayatid"]= $vinforiwayatid;
				$arrdata["inforiwayatfield"]= $vinforiwayatfield;
				$arrdata["inforiwayattable"]= $vinforiwayattable.$vinforiwayatfield;
				$arrdata["inforiwayattableid"]= $vinforiwayattable.$vinforiwayatid;
				$arrdata["infotable"]= $vinforiwayattable;
				array_push($arrpilihfile, $arrdata);

				if($ambilriwayatfield == "1")
				{
					// print_r($arrpilihfile);
					// exit;
				}

			}

		}

		if($reqId == "12673")
		{
			// print_r($arrpilihfile);exit;
		}

		$arrreturn["riwayat"]= $arrriwayatfile;
		$arrreturn["pilihfile"]= $arrpilihfile;
		// print_r($arrreturn);exit;

		return $arrreturn;
	}

	function listpilihfilepegawai($reqId, $riwayattable, $reqRowId, $suratmasukpegawaiid="", $paramriwayatfield="", $infodetilparam=[])
	{
		if($reqRowId == "baru")
		{
			$reqRowId= -1;	
		}

		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$arrfieldcpns= ["skcpns", "notausulcpns"];
		$arrfieldpns= ["skpns", "notausulpns"];
		$arrfieldppk= ["sk"];
		$arrfieldskp= ["ppk", "skp"];
		$arrfieldanak= ["foto", "aktakelahiran", "ktp", "pasport", "sim", "suratkematian", "suratnikah", "suratcerai"];
		$arrfieldsaudara= ["ktp", "suratkematian"];
		$arrfieldsuamiistri= ["foto", "aktanikah", "aktacerai", "kariskarsu", "aktakelahiran", "ktp", "pasport", "sim", "suratkematian", "skkonversinipbaru", "suratnikah", "suratcerai", "skjandaduda", "laporanpernikahanpertama"];
		$arrfieldorangtua= ["L-ktp", "L-suratkematian", "P-ktp", "P-suratkematian"];
		$arrfieldpendidikan= ["ijazah", "transkrip"];
		$arrfieldpendidikantupel= ["tugasbelajar", "ijinbelajar"];

		$arrcarifileddetil= array_unique(array_merge($arrfieldcpns,$arrfieldpns,$arrfieldppk,$arrfieldskp,$arrfieldanak,$arrfieldsaudara,$arrfieldsuamiistri,$arrfieldorangtua,$arrfieldpendidikan,$arrfieldpendidikantupel));
		// print_r($arrcarifileddetil);exit;

		$sorderfile= "ORDER BY A.RIWAYAT_FIELD, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC";

		if(is_array($riwayattable))
		{
			// $riwayattable= [];
			// array_push($riwayattable, "tes");
			// array_push($riwayattable, "xxx");
			// array_push($riwayattable, "yyy");

			$vtable= "";
			foreach ($riwayattable as $k => $v) {
				if($v == "SERTIFIKAT_FILE")
				{
					$vtable= getconcatseparator($vtable, "", "','");
					$vtable= getconcatseparator($vtable, "NULL", "','");
				}
				else
				{
					$vtable= getconcatseparator($vtable, $v, "','");
				}
			}

			if(!empty($vtable))
			{
				$vtable= "'".$vtable."'";
				$statement= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
			}
			// echo $vtable;exit;
		}
		else
		{
			$statement= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
		}

		if(!empty($reqRowId) && empty($paramriwayatfield))
		{
			$vriwayatid= "";
			if(!empty($infodetilparam))
			{
				foreach ($infodetilparam as $k => $v) {
					$vdetil= $v["ID_AYAH"];
					$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
					$vdetil= $v["ID_IBU"];
					$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
				}
			}
			// echo $vriwayatid;exit;
			if(!empty($vriwayatid))
				$statement.= " AND RIWAYAT_ID IN (".$vriwayatid.")";
			else
				$statement.= " AND A.RIWAYAT_ID = ".$reqRowId;
		}

		$arrparamriwayatfield= [];
		if(!empty($paramriwayatfield))
		{
			$statementparam= "";
			$arrparamriwayatfield= explode("," , $paramriwayatfield);
			foreach ($arrparamriwayatfield as $key => $value) 
			{
				if(empty($statementparam))
					$statementparam= "'".$value."'";
				else
					$statementparam.= ",'".$value."'";
			}
			$statement.= " AND A.RIWAYAT_FIELD IN (".$statementparam.")";
		}
		// echo $statement;exit;

		$statement.= "
		AND EXISTS
		(
			SELECT 1
			FROM
			(
				SELECT *
				FROM
				(
					SELECT
					A.PEGAWAI_FILE_ID
					, CASE WHEN A.RIWAYAT_TABLE = 'PERSURATAN.SURAT_MASUK_PEGAWAI'
					THEN
						ROW_NUMBER () OVER 
						(
							PARTITION BY A.RIWAYAT_TABLE, A.RIWAYAT_ID
							ORDER BY CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
						)
					ELSE
						ROW_NUMBER () OVER 
						(
							PARTITION BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID
							ORDER BY CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
						)
					END INFOPOSISI
					FROM PEGAWAI_FILE A
					WHERE 1=1 AND A.PEGAWAI_ID = ".$reqId."
					AND A.TEMP_VALIDASI_BELUM_ID IS NULL
		";
					if(is_array($riwayattable))
					{
						$statement.= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
					}
					else
					{
						$statement.= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
					}

					if(!empty($reqRowId) && empty($paramriwayatfield))
					{
						$vriwayatid= "";
						if(!empty($infodetilparam))
						{
							foreach ($infodetilparam as $k => $v) {
								$vdetil= $v["ID_AYAH"];
								$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
								$vdetil= $v["ID_IBU"];
								$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
							}
						}
						// echo $vriwayatid;exit;
						if(!empty($vriwayatid))
							$statement.= " AND RIWAYAT_ID IN (".$vriwayatid.")";
						else
							$statement.= " AND RIWAYAT_ID = ".$reqRowId;
					}

					if(!empty($paramriwayatfield))
					{
						// $statement.= " AND A.RIWAYAT_FIELD = '".$paramriwayatfield."'";
					}

		$statement.= "
					ORDER BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, A.RIWAYAT_ID, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC
				) X WHERE INFOPOSISI = 1
			) X WHERE A.PEGAWAI_FILE_ID = X.PEGAWAI_FILE_ID
		)";

		// echo $statement;exit;

		$setfile= new PegawaiFile();
		$setfile->selectByParamsFile(array(), -1,-1, $statement, $reqId, $sorderfile);
		// $lihatquery= "1";
		if($reqId == "12673")
		{
			$lihatquery= "1";
		}

		if(!empty($lihatquery))
		{
	  		// echo $setfile->query;exit;
		}

		$lokasi_link_file= "uploads/".$reqId."/";

		$arrriwayatfile= [];
		$arrpilihfile=[];

	  	$checkriwayatfield= "";
		// $setfile->firstRow();
	  	while($setfile->nextRow())
	  	{
			$reqDokumenFilePath= $setfile->getField("PATH");

			$vinforiwayatid= $setfile->getField("RIWAYAT_ID");
			$vinforiwayattable= $setfile->getField("RIWAYAT_TABLE");
			$vdatainforiwayatfield= $setfile->getField("RIWAYAT_FIELD");

			if($vinforiwayattable == "NULL")
				$vinforiwayattable= "";

			$reqDokumenFileId= $setfile->getField("PEGAWAI_FILE_ID");
			$reqDokumenFileKualitasId= $setfile->getField("FILE_KUALITAS_ID");
			$reqDokumenFilePathAsli= $setfile->getField("PATH_ASLI");
			$reqDokumenFileKeterangan= $setfile->getField("KETERANGAN");

			// khusus table persuratan.suratmasukpegawai
			$ambilriwayatfield= "";
			if($vinforiwayattable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
				$ambilriwayatfield= "1";

			if($ambilriwayatfield == "1")
			{
				$reqDokumenFileRiwayatField= "";
				if($vdatainforiwayatfield == $suratmasukpegawaiid)
					$reqDokumenFileRiwayatField= $suratmasukpegawaiid;

				// echo $reqDokumenFileRiwayatField."-".$vdatainforiwayatfield;exit;
			}
			else
				$reqDokumenFileRiwayatField= $setfile->getField("RIWAYAT_FIELD");

			if($reqDokumenFileKeterangan == "NULL")
				$reqDokumenFileRiwayatField= "";

			$vriwayatfield= $reqDokumenFileRiwayatField;
			if($vriwayatfield == "")
				$vriwayatfield= "xxx";

			// if($checkriwayatfield == $vriwayatfield){}
			// else
			// {

				// khusus orang tua
				if(!empty($infodetilparam))
				{
					$checkDokumenFileRiwayatField= explode("-", $vdatainforiwayatfield);
					$checkDokumenFileRiwayatField= $checkDokumenFileRiwayatField[0];

					if($checkDokumenFileRiwayatField == "L")
					{
						$vidayah= $infodetilparam[0]["ID_AYAH"];
						$vidibu= $infodetilparam[0]["ID_IBU"];
						$reqRowId= $vidayah;
					}
					else if($checkDokumenFileRiwayatField == "P")
					{
						$vidayah= $infodetilparam[0]["ID_AYAH"];
						$vidibu= $infodetilparam[0]["ID_IBU"];
						$reqRowId= $vidibu;
					}
				}

				// kalau ada data terkait
				if(!empty($reqDokumenFileId))
				{
					if(empty($reqRowId))
						$infocarikeynew= $vinforiwayattable.";".$vinforiwayatid;
					else
						$infocarikeynew= $riwayattable.";".$reqRowId;

					$infocarikeymode= $infocarikeynew.";".$reqDokumenFileRiwayatField;
					$infocarikey= $infocarikeymode.";".$reqDokumenFileId;

					if(empty($reqDokumenFilePathAsli))
					{
						$reqDokumenFilePathAsli= $reqDokumenFilePath;
						$reqDokumenFilePathAsli= str_replace($lokasi_link_file, "", $reqDokumenFilePathAsli);
					}

					// kalau ada data terkait
					$arrcaripilih= [];
					if(!empty($vinforiwayatfield) && in_array($vinforiwayatfield, $arrcarifileddetil))
					{
						$keycaripilih= $infocarikey;
						$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);
					}
					else
					{
						$keycaripilih= $infocarikeymode;
						$arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrpilihfile);
					}

					/*if(in_array($vinforiwayatfield, $arrcarifileddetil))
					{
						$keycaripilih= $infocarikey;
						$arrcaripilih= in_array_column($keycaripilih, "KEY", $arrcheckpilih);
					}
					else
					{
						$keycaripilih= $infocarikeymode;
						$arrcaripilih= in_array_column($keycaripilih, "KEYMODE", $arrcheckpilih);
					}*/

					if(!empty($arrcaripilih))
						continue;

					if($ambilriwayatfield == "1")
					{
						if(empty($reqDokumenFileRiwayatField))
							continue;
					}

					$infonama= $reqDokumenFilePathAsli;
					$arrdata= [];
					$arrdata["KEY"]= $infocarikey;
					$arrdata["KEYINFO"]= $infocarikeynew;
					$arrdata["KEYMODE"]= $infocarikeymode;
					$arrdata["id"]= $reqDokumenFileId;
					$arrdata["index"]= "v".count($arrpilihfile);
					$arrdata["selected"]= "selected";
					$arrdata["nama"]= addslashes($infonama);
					$arrdata["vurl"]= $reqDokumenFilePath;
					$arrdata["ext"]= strtolower(end(explode(".", $reqDokumenFilePath)));
					$arrdata["filekualitasid"]= $reqDokumenFileKualitasId;
					if(empty($reqRowId))
						$arrdata["inforiwayatid"]= $vinforiwayatid;
					else
						$arrdata["inforiwayatid"]= $reqRowId;

					$arrdata["inforiwayatfield"]= $reqDokumenFileRiwayatField;
					$arrdata["inforiwayattable"]= $vinforiwayattable.$reqDokumenFileRiwayatField;
					$arrdata["inforiwayattableid"]= $vinforiwayattable.$vinforiwayatid;
					$arrdata["infotable"]= $vinforiwayattable;
					array_push($arrpilihfile, $arrdata);

					if($ambilriwayatfield == "1")
					{
						// print_r($arrpilihfile);exit;
						// echo $keycaripilih;exit;
						// print_r($arrcaripilih);exit;
					}
				}

				// $checkriwayatfield= $vriwayatfield;
			// }
		}
		$arrcheckpilih= $arrpilihfile;

		if($ambilriwayatfield == "1")
		{
			// print_r($arrcheckpilih);
			// exit;
		}
		// print_r($arrcheckpilih);exit;
		
		$ambil_data_file= lihatfiledirektori($lokasi_link_file);

		// $statement= " AND A.RIWAYAT_ID IS NULL AND COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL";
		$statement= " AND COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL
		AND A.TEMP_VALIDASI_BELUM_ID IS NULL
		";

		if(is_array($riwayattable))
		{
			$statementriwayattable= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
			// $statement.= " AND A.RIWAYAT_TABLE IN (".$vtable.")";
		}
		else
		{
			$statementriwayattable= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
			// $statement.= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
		}
		
		$sorderfile= "ORDER BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC";
		$set= new PegawaiFile();
		$set->selectByParamsFile(array(), -1,-1, $statement, $reqId, $sorderfile, $statementriwayattable);
		// echo $set->query;exit;

		$arrPegawaiDokumen=[];
		while($set->nextRow())
		{
			$inforiwayattable= $set->getField("RIWAYAT_TABLE");
			if($inforiwayattable == "NULL")
				$inforiwayattable= "";

			$inforiwayatfield= $set->getField("RIWAYAT_FIELD");
			$inforiwayatid= $set->getField("RIWAYAT_ID");
			$infopath= $set->getField("PATH");

			$arrdata= [];
			$arrdata["PEGAWAI_FILE_ID"]= $set->getField("PEGAWAI_FILE_ID");
			$arrdata["ROWID"]= $infopath;
			$arrdata["JENIS_DOKUMEN"]= $inforiwayattable.";".$inforiwayatid.";".$inforiwayatfield;
			$arrdata["FILE_KUALITAS_ID"]= $set->getField("FILE_KUALITAS_ID");
			$arrdata["FILE_KUALITAS_NAMA"]= $set->getField("FILE_KUALITAS_NAMA");
			$arrdata["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
			$arrdata["RIWAYAT_TABLE"]= $inforiwayattable;
			$arrdata["RIWAYAT_FIELD"]= $inforiwayatfield;
			$arrdata["RIWAYAT_ID"]= $inforiwayatid;
			$arrdata["INFO_DATA"]= $set->getField("INFO_DATA");
			$arrdata["KATEGORI_FILE_ID"]= $set->getField("KATEGORI_FILE_ID");
			$arrdata["INFO_GROUP_DATA"]= $set->getField("INFO_GROUP_DATA");

			$infopathasli= $set->getField("PATH_ASLI");
			if(empty($infopathasli))
			{
				$infopathasli= str_replace($lokasi_link_file, "", $infopath);
			}
			$arrdata["PATH_ASLI"]= $infopathasli;
			$arrdata["EXT"]= $set->getField("EXT");
			array_push($arrPegawaiDokumen, $arrdata);
		}
		// $jumlah_pegawai_dokumen= count($arrPegawaiDokumen);
		// print_r($arrPegawaiDokumen);exit;

		for($index_file=0; $index_file < count($ambil_data_file); $index_file++)
        {
			$reqPegawaiFileId= $tempKategoriFileId= $tempRiwayatTable= $tempFileKualitasId= $tempFileKualitasNama= "";
            $tempUrlFile= $ambil_data_file[$index_file];
            $tempNamaUrlFile= pathinfo($tempUrlFile, PATHINFO_BASENAME);
			$vinforiwayattable= $tempRiwayatTable= $tempInfoGroupData= $tempFileKualitasNama= $tempFileKualitasId= "";
			
			// echo $tempUrlFile;exit;
			$vinforiwayatid= $vinforiwayatfield= "";
			$arrcaridata= [];
			$arrcaridata= in_array_column($tempUrlFile, "ROWID", $arrPegawaiDokumen);
			// print_r($arrcaridata);exit;

			// var_dump($tempUrlFile);
			// kalau belum ada date terkait, tanpa file terhapus
			if(empty($arrcaridata))
			{
				$tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);

				if($tempFileDelete == 1)
					continue;

				$infoext= end(explode(".", $tempUrlFile));

				$infofilekualitasid= "1";
				if(strtolower($infoext) !== "pdf")
					$infofilekualitasid= "4";

				$infonama= $tempNamaUrlFile;
				$arrdata= [];
				$arrdata["KEY"]= "";
				$arrdata["KEYINFO"]= "";
				$arrdata["KEYMODE"]= "";
				$arrdata["id"]= $reqPegawaiFileId;
				$arrdata["index"]= "v".count($arrpilihfile);
				$arrdata["selected"]= "";
				$arrdata["nama"]= addslashes($infonama);
				$arrdata["vurl"]= $tempUrlFile;
				$arrdata["ext"]= strtolower($infoext);
				$arrdata["filekualitasid"]= $infofilekualitasid;
				$arrdata["inforiwayatid"]= "";
				$arrdata["inforiwayatfield"]= "";
				$arrdata["inforiwayattable"]= "";
				$arrdata["inforiwayattableid"]= "";
				$arrdata["infotable"]= "";
				array_push($arrpilihfile, $arrdata);
				continue;
			}
			else
			{
				$index_row= $arrcaridata[0];
				$vinforowurl= $arrPegawaiDokumen[$index_row]["ROWID"];
				$reqPegawaiFileId= $arrPegawaiDokumen[$index_row]["PEGAWAI_FILE_ID"];
				$vinforiwayattable= $arrPegawaiDokumen[$index_row]["RIWAYAT_TABLE"];
				$vinforiwayatid= $arrPegawaiDokumen[$index_row]["RIWAYAT_ID"];
				$vinforiwayatfield= $arrPegawaiDokumen[$index_row]["RIWAYAT_FIELD"];
				if($vinforiwayatfield == "NULL")
					$vinforiwayatfield= "";
				$tempInfoGroupData= $arrPegawaiDokumen[$index_row]["INFO_GROUP_DATA"];
				$tempKategoriFileId= $arrPegawaiDokumen[$index_row]["KATEGORI_FILE_ID"];
				$tempRiwayatTable= $arrPegawaiDokumen[$index_row]["JENIS_DOKUMEN"];
				$tempFileKualitasId= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_ID"];
				$tempFileKualitasNama= $arrPegawaiDokumen[$index_row]["FILE_KUALITAS_NAMA"];
				$tempNamaUrlFileDB= $arrPegawaiDokumen[$index_row]["PATH_ASLI"];
				$ext= $arrPegawaiDokumen[$index_row]["EXT"];
				$tempNamaUrlFileAsli=$tempNamaUrlFileDB.".".$ext;
				// var_dump($tempNamaUrlFile);
			}

			// khusus table persuratan.suratmasukpegawai
			$ambilriwayatfield= "";
			if($vinforiwayattable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
			{
				$ambilriwayatfield= "1";
			}

			if($index_row == 14)
			{
				// print_r($arrPegawaiDokumen[$index_row]);
				// echo $vinforiwayatfield."-".$vinforiwayatid."-".$reqRowId."-".$vinforowurl."\n";
			}

			if($reqKategoriFileId == ""){}
			else
			{
				if($tempKategoriFileId == $reqKategoriFileId){}
				else
				continue;
			}

			if($reqKualitasFileId == ""){}
			else
			{
				if($tempFileKualitasId == $reqKualitasFileId){}
				else
				continue;
			}
			
			if($reqRiwayatTable == ""){}
			else
			{
				$tempCheck= $reqRiwayatTable.";".$reqRiwayatId.";".$reqRiwayatField;

				if($ambilriwayatfield == "1")
				{
					// echo $tempCheck."\n";
					// echo $tempRiwayatTable."\n";
					// exit;
				}

				if($tempRiwayatTable == $tempCheck){}
				else
				continue;
			}

			if($reqJenisDokumen == "-1")
			{
				if($reqKategoriFileId == "")
				{
					if($tempInfoGroupData == ""){}
					else
					continue;
				}
				else
				{
					if($tempInfoGroupData == "")
					continue;
				}
			}

			// $tempFileDelete= "";
			// if($tempUserLoginLevel == "99"){}
			// else
			// {
				// sebelum
				// $tempFileDelete= likeMatch("%_delete_%", $tempNamaUrlFile);
			// }

			// sebelum
			// if($tempFileDelete == 1)
			// 	continue;

			// set nama
			$infonama= $tempNamaUrlFileAsli;
			if(empty($arrcaridata))
            {
            	$infonama= $tempNamaUrlFile;
            }

            $tempFileDelete= likeMatch("%_delete_%", $infonama);
            if($tempFileDelete == 1)
				continue;

			$vinforowurl= $tempUrlFile;
			// kalau url sudah ada maka lewati
			$arrcheckdetil= in_array_column($vinforowurl, "vurl", $arrpilihfile);
			if(!empty($arrcheckdetil))
				continue;

			// $infocarikeynew= $inforiwayattable.";".$reqRowId;
			$infocarikeynew= $vinforiwayattable.";".$vinforiwayatid;
			$infocarikeymode= $infocarikeynew.";".$vinforiwayatfield;
			$infocarikey= $infocarikeymode.";".$reqPegawaiFileId;

			$infoext= end(explode(".", $tempUrlFile));

			if(empty($tempFileKualitasId))
			{
				$infofilekualitasid= "1";
				if(strtolower($infoext) !== "pdf")
					$infofilekualitasid= "4";
			}
			else
			{
				$infofilekualitasid= $tempFileKualitasId;
			}

			// kalau paramriwayatfield khusus pangkat
			if(!empty($paramriwayatfield))
			{
				if(
					($riwayattable == $vinforiwayattable.$vinforiwayatfield) || 
					(!empty($vinforiwayatfield) && 
						// $vinforiwayatfield !== $paramriwayatfield
						!in_array($vinforiwayatfield, $arrparamriwayatfield)
					)
				)
				{
					continue;
				}
			}

			$arrdata= [];
			$arrdata["KEY"]= $infocarikey;
			$arrdata["KEYINFO"]= $infocarikeynew;
			$arrdata["KEYMODE"]= $infocarikeymode;
			$arrdata["id"]= $reqPegawaiFileId;
			$arrdata["index"]= "v".count($arrpilihfile);
			$arrdata["selected"]= "";
			$arrdata["nama"]= addslashes($infonama);
			$arrdata["vurl"]= $tempUrlFile;
			$arrdata["ext"]= strtolower($infoext);
			$arrdata["filekualitasid"]= $infofilekualitasid;
			$arrdata["inforiwayatid"]= $vinforiwayatid;
			$arrdata["inforiwayatfield"]= $vinforiwayatfield;
			$arrdata["inforiwayattable"]= $vinforiwayattable.$vinforiwayatfield;
			$arrdata["inforiwayattableid"]= $vinforiwayattable.$vinforiwayatid;
			$arrdata["infotable"]= $vinforiwayattable;
			array_push($arrpilihfile, $arrdata);

		}

		if($reqId == "383")
		{
			// print_r($arrpilihfile);exit;
		}

		$arrreturn["riwayat"]= $arrriwayatfile;
		$arrreturn["pilihfile"]= $arrpilihfile;
		// print_r($arrreturn);exit;

		return $arrreturn;
	}

	function simpanfilepegawaidb($vpost, $reqRowId, $reqLinkFile)
	{
		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$LOGIN_USER= $CI->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$LOGIN_LEVEL= $CI->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$LOGIN_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$LOGIN_PEGAWAI_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;

		$reqDokumenPilih= $vpost["reqDokumenPilih"];
		$reqId= $vpost["reqId"];
		// $reqRowId= $vpost["reqRowId"];
		$reqDokumenKategoriFileId= $vpost["reqDokumenKategoriFileId"];
		$reqDokumenPath= $vpost["reqDokumenPath"];
		$indexfile= $vpost["indexfile"];
		$reqDokumenKategoriField= $vpost["reqDokumenKategoriField"];
		$reqDokumenFileRiwayatTable= $vpost["reqDokumenFileRiwayatTable"];

		if(empty($reqRowId))
		{
			$reqRowId= $vpost["reqDokumenFileRiwayatId"];
		}

		if(!empty($reqDokumenPilih))
		{
			if (is_numeric($indexfile))
			{
				$fileuploadexe= strtolower(getExtension($reqLinkFile['name'][$indexfile]));
			}
			else
			{
				$fileuploadexe= strtolower(getExtension($reqLinkFile['name']));
			}
			// echo $fileuploadexe;exit;

			$lihatquery= "";

			$statement= " AND A.PEGAWAI_ID = ".$reqId." AND NO_URUT = ".$reqDokumenKategoriFileId." AND A.RIWAYAT_ID = '".$reqRowId."'";
			// if (!empty($reqDokumenKategoriField))
			if (!empty($reqDokumenKategoriField) && !is_numeric($reqDokumenKategoriField))
			{
				$statement.= " AND A.RIWAYAT_FIELD = '".$reqDokumenKategoriField."'";
			}

			// khusus table persuratan.suratmasukpegawai
			$ambilriwayatfield= "";
			if($reqDokumenFileRiwayatTable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
			{
				$ambilriwayatfield= "1";
				$lihatquery= "1";
			}

			if($reqDokumenPilih == "1")
			{
				// $lihatquery= "1";
			}

			if($ambilriwayatfield == "1")
			{
				$statement.= " AND A.RIWAYAT_FIELD = '".$reqDokumenKategoriField."'";	
			}

			$setfile= new PegawaiFile();
			$setfile->selectByParamsJenisDokumen(array(), -1,-1, $statement);
			$setfile->firstRow();
			$reqRiwayatId= $setfile->getField("RIWAYAT_ID");
			// $lihatquery= "1";
			if(!empty($lihatquery))
			{
				// echo $reqRiwayatId." == ".$reqRowId;exit;
				// echo $reqDokumenKategoriField;exit;
				// echo $setfile->query;exit;
			}

			// kalau sama baru proses simpan
			if($reqRiwayatId == $reqRowId || $ambilriwayatfield == "1")
			{
				// echo $reqDokumenPilih;exit;
				$reqRiwayatTable= $setfile->getField("RIWAYAT_TABLE");
				$reqRiwayatField= $setfile->getField("RIWAYAT_FIELD");
				$reqDokumenFileId= $vpost["reqDokumenFileId"];
				$reqKualitasFileId= $vpost["reqDokumenFileKualitasId"];
				$reqKategoriFileId= $reqDokumenKategoriFileId;
				$reqPrioritas= "1";
				// print_r($reqDokumenFileId);exit;

				if($ambilriwayatfield == "1")
				{
					$reqRiwayatTable= $reqDokumenFileRiwayatTable;
					$reqRiwayatField= $reqDokumenKategoriField;
					$reqRiwayatId= $reqRowId;
					// echo $reqRiwayatTable."xxx".$reqRiwayatField."xxx".$reqRiwayatId;exit;
				}

				$setfile= new PegawaiFile();
				$setfile->setField("PEGAWAI_ID", $reqId);
				$setfile->setField("RIWAYAT_TABLE", $reqRiwayatTable);
				$setfile->setField("RIWAYAT_FIELD", $reqRiwayatField);
				$setfile->setField("FILE_KUALITAS_ID", ValToNullDB($reqKualitasFileId));
				$setfile->setField("KATEGORI_FILE_ID", $reqKategoriFileId);
				$setfile->setField("RIWAYAT_ID", ValToNullDB($reqRiwayatId));
				
				$setfile->setField("LAST_LEVEL", $LOGIN_LEVEL);
				$setfile->setField("LAST_USER", $LOGIN_USER);
				$setfile->setField("USER_LOGIN_ID", $LOGIN_ID);
				$setfile->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($LOGIN_PEGAWAI_ID));
				$setfile->setField("LAST_DATE", "NOW()");

				$setfile->setField("IPCLIENT", sfgetipaddress());
				$setfile->setField("MACADDRESS", sfgetmac());
				$setfile->setField("NAMACLIENT", getHostName());
				$setfile->setField("PRIORITAS", $reqPrioritas);

				$setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);

				$target_dir= "uploads/".$reqId."/";
				if(file_exists($target_dir)){}
				else
				{
					makedirs($target_dir);
				}

				// kalau nilai satu maka, upload data baru ke e file
				if($reqDokumenPilih == "1")
				{
					if (is_numeric($indexfile))
					{
						$fileName= basename($_FILES["reqLinkFile"]["name"][$indexfile]);
					}
					else
					{
						$fileName= basename($_FILES["reqLinkFile"]["name"]);
					}
					// $reqLinkFile["tmp_name"]
					$fileNameInfo = substr($fileName, 0, strpos($fileName, "."));
					$file_name = preg_replace( '/[^a-zA-Z0-9_]+/', '_', $fileNameInfo);

					if (is_numeric($indexfile))
					{
						$infoext= pathinfo($_FILES['reqLinkFile']['name'][$indexfile]);
					}
					else
					{
						$infoext= pathinfo($_FILES['reqLinkFile']['name']);
					}
					$ext= $infoext['extension'];

					$target_file_asli= $file_name;
					$namagenerate =generateRandomString().".".$ext;
					$target_file_generate= $target_dir.$namagenerate; 
					// print_r($ext);exit;

					$setfile->setField('PATH', $target_file_generate);
					$setfile->setField('PATH_ASLI', $target_file_asli);
					$setfile->setField('EXT', $ext);

					$simpanfile= "";
					if (is_numeric($indexfile))
					{
						if (move_uploaded_file($_FILES["reqLinkFile"]["tmp_name"][$indexfile], $target_file_generate))
						{
							$simpanfile= "1";
						}
					}
					else
					{
						if (move_uploaded_file($_FILES["reqLinkFile"]["tmp_name"], $target_file_generate))
						{
							$simpanfile= "1";
						}
					}
					// $simpanfile= "1";

					// kalau kosong lewati
					if(empty($ext))
					{
						$simpanfile= "";
					}

					if ($simpanfile == "1")
					{
						if($setfile->noketinsert())
						{
							// echo $setfile->query();
							$reqDokumenFileId= $setfile->id;
							$setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);
							if($setfile->updateprioritas())
							{
								// echo $setfile->query();
							}
							// exit;
						}
					}
				}
				else if($reqDokumenPilih == "2")
				{
					// if($ambilriwayatfield == "1")
					// {
					// 	echo $reqDokumenFileId."xxx".$reqDokumenPilih;exit;
					// }

					if(empty($reqDokumenFileId))
					{
						$ext= strtolower(getExtension($reqDokumenPath));
						// kalau kosong lewati
						if(!empty($reqDokumenPath))
						{
							$reqDokumenPathAsli= str_replace(".$ext", "", str_replace("uploads/$reqId/", "", $reqDokumenPath));
							$reqDokumenPathAsli= str_replace(" ", "_", $reqDokumenPathAsli);
							$setfile->setField('PATH', $reqDokumenPath);
							$setfile->setField('PATH_ASLI', $reqDokumenPathAsli);
							$setfile->setField('EXT', $ext);

							if($setfile->noketinsert())
							{
								$reqDokumenFileId= $setfile->id;
								$setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);
								if($setfile->updateprioritas())
								{
								}
							}
						}
					}
					else
					{
						$statement= " AND A.PEGAWAI_FILE_ID = ".$reqDokumenFileId;
						$setfiledetil= new PegawaiFile();
						$setfiledetil->selectByParamsFile(array(), -1,-1, $statement, $reqId);
						// echo $setfiledetil->query;exit;
						$setfiledetil->firstRow();
						$reqUrlFile= $setfiledetil->getField("PATH");
						$reqPathAsli= $setfiledetil->getField("PATH_ASLI");
						// echo $reqUrlFile;exit;

						$setfile->setField("PATH", $reqUrlFile);
						$setfile->setField("PATH_ASLI", $reqPathAsli);

						if(!empty($reqPrioritas))
						{
							if($setfile->noketupdate())
							{
								// if($reqDokumenFileId == 259595)
								// {
								// 	echo $setfile->query;exit;
								// }
								

								if($setfile->updateprioritas())
								{
									// if($reqDokumenFileId == 259595)
									// {
									// 	echo $setfile->query;exit;
									// }
								}
							}
						}
					}
				}
			}

		}
	}

	function simpanfilepegawai($vpost, $reqRowId, $reqLinkFile)
	{
		// print_r($vpost);exit;
		// print_r($reqLinkFile);exit;

		// kalau multi
		if(is_array($vpost["reqDokumenPilih"]))
		{
			// if(is_array($vpost["reqDokumenFileRiwayatTable"]))
			if(empty($reqRowId))
			{
				// print_r($vpost["reqDokumenPilih"]);exit;
				// print_r($reqLinkFile["name"][0]);exit;

				$reqStatusEfileField= $vpost["reqStatusEfileField"];
				$suratmasukpegawaiid= $vpost["reqRowId"];
				// echo $reqStatusEfileField;exit;
				$total_butuh_upload= $total_sudah_ada_file= 0;

				foreach ($vpost["reqDokumenPilih"] as $key => $value) {
					$vpostparam= [];
					$infobutuhupload= $vpost["infobutuhupload"][$key];
					$infodokumenpilih= $vpost["reqDokumenPilih"][$key];
					$infodokumenpath= $vpost["reqDokumenPath"][$key];
					$infodokumenfileharusupload= $vpost["reqDokumenFileHarusUpload"][$key];
					// untuk required

					if(!empty($infobutuhupload))
					{
						if(empty($infodokumenfileharusupload))
						{
							if($infodokumenpilih == "1" && !empty($reqLinkFile["name"][$key]))
							{
								$total_sudah_ada_file++;
							}
							else if($infodokumenpilih == "2" && !empty($infodokumenpath))
							{
								$total_sudah_ada_file++;
							}

							$total_butuh_upload++;
						}
					}

					$vlinkfile= $reqLinkFile;
					$vpostparam["reqDokumenPilih"]= $infodokumenpilih;
					$vpostparam["reqId"]= $vpost["reqPegawaiId"];
					$vpostparam["reqDokumenKategoriFileId"]= $vpost["reqDokumenKategoriFileId"][$key];
					$vpostparam["reqDokumenPath"]= $infodokumenpath;
					$vpostparam["reqDokumenFileId"]= $vpost["reqDokumenFileId"][$key];
					$vpostparam["reqDokumenFileKualitasId"]= $vpost["reqDokumenFileKualitasId"][$key];
					$vpostparam["indexfile"]= $key;
					$vpostparam["reqDokumenKategoriField"]= $vpost["reqDokumenKategoriField"][$key];
					$vpostparam["reqDokumenFileRiwayatTable"]= $vpost["reqDokumenFileRiwayatTable"][$key];
					$vpostparam["reqDokumenFileRiwayatId"]= $vpost["reqDokumenFileRiwayatId"][$key];
					// print_r($vpostparam);exit;

					$this->simpanfilepegawaidb($vpostparam, $reqRowId, $vlinkfile);
				}

				// kalau ada status field, maka update status
				if(!empty($reqStatusEfileField))
				{
					// echo $total_butuh_upload." == ".$total_sudah_ada_file;exit;
					if($total_butuh_upload == $total_sudah_ada_file)
					{
						$CI = &get_instance();
						$CI->load->model("persuratan/SuratMasukPegawai");

						$set= new SuratMasukPegawai();

						$simpan= "";
						if($reqStatusEfileField == "bkd")
						{
							$simpan= "1";
							$set->setField("PEGAWAI_ID", $vpost["reqPegawaiId"]);
							$set->setField("FIELD", "STATUS_E_FILE_BKD");
							$set->setField("FIELD_NILAI", "1");
							$set->setField("FIELD_WHERE", "SURAT_MASUK_BKD_ID");
							$set->setField("FIELD_WHERE_NILAI", $vpost["reqId"]);
						}
						else if($reqStatusEfileField == "upt")
						{
							$simpan= "1";
							$set->setField("PEGAWAI_ID", $vpost["reqPegawaiId"]);
							$set->setField("FIELD", "STATUS_E_FILE_UPT");
							$set->setField("FIELD_NILAI", "1");
							$set->setField("FIELD_WHERE", "SURAT_MASUK_UPT_ID");
							$set->setField("FIELD_WHERE_NILAI", $vpost["reqId"]);
						}
						else if($reqStatusEfileField == "uptbkd")
						{
							$simpan= "1";
							$set->setField("PEGAWAI_ID", $vpost["reqPegawaiId"]);
							$set->setField("FIELD_NILAI", "1");
							$set->setField("FIELD_WHERE", "SURAT_MASUK_PEGAWAI_ID");
							$set->setField("FIELD_WHERE_NILAI", $suratmasukpegawaiid);
						}

						if(!empty($simpan))
						{
							if($reqStatusEfileField == "uptbkd")
							{
								$set->updatestatusuptbkdefile();
							}
							else
							{
								$set->updatestatusefile();
							}
						}
						// echo $vpost["reqId"]."-".$vpost["reqPegawaiId"]."-".$reqStatusEfileField."-".$total_butuh_upload." = ".$total_sudah_ada_file;exit;
					}
				}
			}
			else
			{
				foreach ($vpost["reqDokumenPilih"] as $key => $value) {
					$vpostparam= [];
					$vlinkfile= $reqLinkFile;
					$vpostparam["reqDokumenPilih"]= $vpost["reqDokumenPilih"][$key];
					$vpostparam["reqId"]= $vpost["reqId"];
					$vpostparam["reqDokumenKategoriFileId"]= $vpost["reqDokumenKategoriFileId"][$key];
					$vpostparam["reqDokumenPath"]= $vpost["reqDokumenPath"][$key];
					$vpostparam["reqDokumenFileId"]= $vpost["reqDokumenFileId"][$key];
					$vpostparam["reqDokumenFileKualitasId"]= $vpost["reqDokumenFileKualitasId"][$key];
					$vpostparam["indexfile"]= $key;
					$vpostparam["reqDokumenKategoriField"]= $vpost["reqDokumenKategoriField"][$key];

					$this->simpanfilepegawaidb($vpostparam, $reqRowId, $vlinkfile);
				}
			}
		}
		else
		{
			$vpostparam= [];
			$vlinkfile= $reqLinkFile;
			$vpostparam["reqDokumenPilih"]= $vpost["reqDokumenPilih"];
			$vpostparam["reqId"]= $vpost["reqId"];
			$vpostparam["reqDokumenKategoriFileId"]= $vpost["reqDokumenKategoriFileId"];
			$vpostparam["reqDokumenPath"]= $vpost["reqDokumenPath"];
			$vpostparam["reqDokumenFileId"]= $vpost["reqDokumenFileId"];
			$vpostparam["reqDokumenFileKualitasId"]= $vpost["reqDokumenFileKualitasId"];
			$vpostparam["indexfile"]= "";

			$this->simpanfilepegawaidb($vpostparam, $reqRowId, $vlinkfile);
		}
		// print_r($vpostparam);
		// exit;
	}

	function infopensiunsuamiistri()
	{
		$pensiunsuamiistrikematian= array("02", "03", "05", "06", "08", "09", "11", "12", "14", "15", "17", "18", "20", "21");
		$pensiunsuamiistrinikah= array("02", "05", "08", "11", "14", "17", "20");
		$pensiunsuamiistricerai= array("03", "06", "09", "12", "15", "18", "21");
		$pensiunsuamiistri= array(
		  array("id"=> "01", "index"=>0)
		  , array("id"=> "02", "index"=>0)
		  , array("id"=> "03", "index"=>0)
		  , array("id"=> "04", "index"=>1)
		  , array("id"=> "05", "index"=>1)
		  , array("id"=> "06", "index"=>1)
		  , array("id"=> "07", "index"=>2)
		  , array("id"=> "08", "index"=>2)
		  , array("id"=> "09", "index"=>2)
		  , array("id"=> "10", "index"=>3)
		  , array("id"=> "11", "index"=>3)
		  , array("id"=> "12", "index"=>3)
		  , array("id"=> "13", "index"=>4)
		  , array("id"=> "14", "index"=>4)
		  , array("id"=> "15", "index"=>4)
		  , array("id"=> "16", "index"=>5)
		  , array("id"=> "17", "index"=>5)
		  , array("id"=> "18", "index"=>5)
		  , array("id"=> "19", "index"=>6)
		  , array("id"=> "20", "index"=>6)
		  , array("id"=> "21", "index"=>6)
		);

		$arrreturn= [];
		$arrreturn["pensiunsuamiistrikematian"]= $pensiunsuamiistrikematian;
		$arrreturn["pensiunsuamiistrinikah"]= $pensiunsuamiistrinikah;
		$arrreturn["pensiunsuamiistricerai"]= $pensiunsuamiistricerai;
		$arrreturn["pensiunsuamiistri"]= $pensiunsuamiistri;
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function infopensiunanak()
	{
		$pensiunanaktanpaupload= array("01", "04", "07", "10", "13", "16", "19");
		$pensiunanakbelumlulus= array("01", "02", "04", "05", "07", "08", "10", "11", "13", "14", "16", "17", "19", "20");
		$pensiunanaklulus= array("01", "03", "04", "06", "07", "09", "10", "12", "13", "15", "16", "18", "19", "21");
		$pensiunanak= array(
		  array("id"=> "01", "index"=>0)
		  , array("id"=> "02", "index"=>0)
		  , array("id"=> "03", "index"=>0)
		  , array("id"=> "04", "index"=>1)
		  , array("id"=> "05", "index"=>1)
		  , array("id"=> "06", "index"=>1)
		  , array("id"=> "07", "index"=>2)
		  , array("id"=> "08", "index"=>2)
		  , array("id"=> "09", "index"=>2)
		  , array("id"=> "10", "index"=>3)
		  , array("id"=> "11", "index"=>3)
		  , array("id"=> "12", "index"=>3)
		  , array("id"=> "13", "index"=>4)
		  , array("id"=> "14", "index"=>4)
		  , array("id"=> "15", "index"=>4)
		  , array("id"=> "16", "index"=>5)
		  , array("id"=> "17", "index"=>5)
		  , array("id"=> "18", "index"=>5)
		  , array("id"=> "19", "index"=>6)
		  , array("id"=> "20", "index"=>6)
		  , array("id"=> "21", "index"=>6)
		);

		$arrreturn= [];
		$arrreturn["pensiunanaktanpaupload"]= $pensiunanaktanpaupload;
		$arrreturn["pensiunanakbelumlulus"]= $pensiunanakbelumlulus;
		$arrreturn["pensiunanaklulus"]= $pensiunanaklulus;
		$arrreturn["pensiunanak"]= $pensiunanak;
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function ambilcpnspns($arrparam)
	{
		$CI = &get_instance();
		$CI->load->model("SkPns");
		$CI->load->model("PangkatRiwayat");

		$reqPegawaiId= $arrparam["reqPegawaiId"];

		$arrreturn= [];

		$setdetil= new SkPns();
		$setdetil->selectByParams(array(), -1,-1, " AND A.PEGAWAI_ID = ".$reqPegawaiId);
		$setdetil->firstRow();
		$vjalurpengangkatan= $setdetil->getField("JALUR_PENGANGKATAN");

		if($vjalurpengangkatan == "2" || $vjalurpengangkatan == "3")
		{
			$vjalurpengangkatan= "1";
		}
		else
		{
			$vjalurpengangkatan= "";
		}
		$arrreturn["pnsjalurpengangkatan"]= $vjalurpengangkatan;
		
		$setdetil= new PangkatRiwayat();
		$setdetil->selectByParams(array(), -1,-1, " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS_RIWAYAT = 1");
		$setdetil->firstRow();
		$vpangkatriwayatid= $setdetil->getField("PANGKAT_RIWAYAT_ID");
		$arrreturn["cpnspangkatriwayatid"]= $vpangkatriwayatid;

		$setdetil= new PangkatRiwayat();
		$setdetil->selectByParams(array(), -1,-1, " AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.JENIS_RIWAYAT = 2");
		$setdetil->firstRow();
		$vpangkatriwayatid= $setdetil->getField("PANGKAT_RIWAYAT_ID");
		$arrreturn["pnspangkatriwayatid"]= $vpangkatriwayatid;
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function persyaratanusulan($arrparam)
	{
		$reqId= $arrparam["reqId"];
		$reqMode= $arrparam["reqMode"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiCheck");

		$set= new SuratMasukPegawaiCheck();

		if($reqMode == "personal")
		{
			$statement= " AND A.SURAT_MASUK_PEGAWAI_ID = ".$reqId;
			$set->selectByParamsUsulanNew(array(), -1, -1, $statement);
		}
		else
		{
			$statement= " AND A.USULAN_SURAT_ID = ".$reqId;
			if($reqId == 366)
			{
				// $statement.= " AND A.PEGAWAI_ID IN (258,418,429,486,620)";
				// $statement.= " AND A.PEGAWAI_ID IN (941,1111,1278,1635,1673)";
				// $statement.= " AND A.PEGAWAI_ID IN (1717,1853,5695,6092,6609)";
				// $statement.= " AND A.PEGAWAI_ID IN (6640,6662,6767,6987,7170)";
				// $statement.= " AND A.PEGAWAI_ID IN (7412,7462,7679,8008,8183)";
				// $statement.= " AND A.PEGAWAI_ID IN (8476,8619,8637,9365,10463)";
				// $statement.= " AND A.PEGAWAI_ID IN (10712,10814,11388,11712,12323)";
				// $statement.= " AND A.PEGAWAI_ID IN (12954,13104,13408,13451)";
			}
			$set->selectByParamsUsulanGroupNew(array(), -1, -1, $statement, "ORDER BY A.SURAT_MASUK_PEGAWAI_ID");
		}

		// echo $set->query;exit;
		$set->firstRow();

		$arrreturn= [];
		$arrreturn["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
		$arrreturn["NIP_BARU"]= $set->getField("NIP_BARU");
		$arrreturn["PEGAWAI_JENIS_KELAMIN"]= $set->getField("PEGAWAI_JENIS_KELAMIN");
		$arrreturn["NAMA_PEGAWAI"]= str_replace("`", "", str_replace("'", "", $set->getField("NAMA_PEGAWAI")));
		$arrreturn["NAMA_LENGKAP"]= str_replace("`", "", str_replace("'", "", $set->getField("NAMA_LENGKAP")));
		$arrreturn["SURAT_KELUAR_NOMOR"]= $set->getField("SURAT_KELUAR_NOMOR");
		$arrreturn["SURAT_KELUAR_TANGGAL"]= $set->getField("SURAT_KELUAR_TANGGAL");
		$arrreturn["SEMENTARA_NOMOR"]= $set->getField("SEMENTARA_NOMOR");
		$arrreturn["SEMENTARA_TANGGAL"]= dateToPageCheck(datetimeToPage($set->getField("SEMENTARA_TANGGAL"), "date"));
		$arrreturn["KATEGORI"]= $set->getField("KATEGORI");
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function persyaratanpegawaiusulan($arrparam)
	{
		$reqId= $arrparam["reqId"];
		$reqMode= $arrparam["reqMode"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiCheck");

		$set= new SuratMasukPegawaiCheck();
		if($reqMode == "usulan")
		{
			$statement= " AND A.USULAN_SURAT_ID = ".$reqId;
		}
		else
		{
			$statement= " AND 1=2";
		}
		$set->selectByParamsUsulanGroupNew(array(), -1, -1, $statement, "ORDER BY A.SURAT_MASUK_PEGAWAI_ID");
		// echo $set->query;exit;

		$arrreturn= [];
		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
			$arrdata["SURAT_MASUK_PEGAWAI_ID"]= $set->getField("SURAT_MASUK_PEGAWAI_ID");
			array_push($arrreturn, $arrdata);
		}
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function persyaratanvalid($arrparam)
	{
		$reqId= $arrparam["reqId"];
		$reqMode= $arrparam["reqMode"];
		// $reqPegawaiId= $arrparam["reqPegawaiId"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiCheck");

		$arrsyarat= $arrtable= $arrpegawai= [];

		$infopensiunsuamiistri= $this->infopensiunsuamiistri();
		$pensiunsuamiistrikematian= $infopensiunsuamiistri["pensiunsuamiistrikematian"];
		$pensiunsuamiistrinikah= $infopensiunsuamiistri["pensiunsuamiistrinikah"];
		$pensiunsuamiistricerai= $infopensiunsuamiistri["pensiunsuamiistricerai"];
		$pensiunsuamiistri= $infopensiunsuamiistri["pensiunsuamiistri"];

		$infopensiunanak= $this->infopensiunanak();
		$pensiunanaktanpaupload= $infopensiunanak["pensiunanaktanpaupload"];
		$pensiunanakbelumlulus= $infopensiunanak["pensiunanakbelumlulus"];
		$pensiunanaklulus= $infopensiunanak["pensiunanaklulus"];
		$pensiunanak= $infopensiunanak["pensiunanak"];

		$set= new SuratMasukPegawaiCheck();

		if($reqMode == "personal")
		{
			$statement= " AND A.SURAT_MASUK_PEGAWAI_ID = ".$reqId;
			// $set->selectByParamsUsulanNew(array(), -1, -1, $statement);
		}
		else
		{
			$statement= " AND A.USULAN_SURAT_ID = ".$reqId;
			if($reqId == 366)
			{
				// $statement.= " AND A.PEGAWAI_ID IN (258,418,429,486,620)";
				// $statement.= " AND A.PEGAWAI_ID IN (941,1111,1278,1635,1673)";
				// $statement.= " AND A.PEGAWAI_ID IN (1717,1853,5695,6092,6609)";
				// $statement.= " AND A.PEGAWAI_ID IN (6640,6662,6767,6987,7170)";
				// $statement.= " AND A.PEGAWAI_ID IN (7412,7462,7679,8008,8183)";
				// $statement.= " AND A.PEGAWAI_ID IN (8476,8619,8637,9365,10463)";
				// $statement.= " AND A.PEGAWAI_ID IN (10712,10814,11388,11712,12323)";
				// $statement.= " AND A.PEGAWAI_ID IN (12954,13104,13408,13451)";
			}
			// $set->selectByParamsUsulanGroupNew(array(), -1, -1, $statement, "ORDER BY A.SURAT_MASUK_PEGAWAI_ID");
		}
		$set->selectByParamsUsulanNew(array(), -1, -1, $statement);

		if($reqId == 382)
		{
			// echo $set->query;exit;
		}

		while($set->nextRow())
		{
			$reqPegawaiId= $set->getField("PEGAWAI_ID");
			$reqKategori= $set->getField("KATEGORI");
			$reqRowId= $set->getField("SURAT_MASUK_PEGAWAI_ID");
			$infotahunsurat= $set->getField("TAHUN_SURAT");

			if(!empty($reqPegawaiId))
			{
				$infocarikey= $reqPegawaiId;
				$arrkondisicheck= in_array_column($infocarikey, "PEGAWAI_ID", $arrpegawai);
				if(empty($arrkondisicheck))
				{
					$arrdata= [];
					$arrdata["PEGAWAI_ID"]= $reqPegawaiId;
					$arrdata["PEGAWAI_NIP_BARU"]= $set->getField("NIP_BARU");
					$arrdata["PEGAWAI_NAMA"]= str_replace("`", "", str_replace("'", "", $set->getField("NAMA_PEGAWAI")));
					$arrdata["PEGAWAI_NAMA_LENGKAP"]= str_replace("`", "", str_replace("'", "", $set->getField("NAMA_LENGKAP")));

					$arrdata["ROW_ID"]= $reqRowId;
					$arrdata["TAHUN_SURAT"]= $infotahunsurat;
					$arrdata["KP_PAK_LAMA_ID"]= $set->getField("KP_PAK_LAMA_ID");
					$arrdata["KP_PAK_BARU_ID"]= $set->getField("KP_PAK_BARU_ID");
					$arrdata["KATEGORI"]= $set->getField("KATEGORI");
					array_push($arrpegawai, $arrdata);

					$arrparam= ["reqPegawaiId"=>$reqPegawaiId];
					$infopensiuninfosuamiistri= $this->pensiuninfosuamiistri($arrparam);
					// print_r($infopensiuninfosuamiistri);exit;

					$infopensiuninfosuamiistrijumlah= 0;
					if(!empty($infopensiuninfosuamiistri))
					{
						$infopensiuninfosuamiistrijumlah= count($infopensiuninfosuamiistri);
						if($infopensiuninfosuamiistrijumlah > 1)
							$infopensiuninfosuamiistrijumlah= $infopensiuninfosuamiistrijumlah - 1;
					}

					$arrparam= ["reqPegawaiId"=>$reqPegawaiId, "reqKategori"=>$reqKategori];
					$infopensiuninfoanak= $this->pensiuninfoanak($arrparam);
					// print_r($infopensiuninfoanak);exit;

					$infopensiuninfoanakjumlah= 0;
					if(!empty($infopensiuninfoanak))
					{
						$infopensiuninfoanakjumlah= count($infopensiuninfoanak) - 1;
						if($infopensiuninfoanakjumlah > 1)
							$infopensiuninfoanakjumlah= $infopensiuninfoanakjumlah - 1;
					}
				}
			}

			$infosuratmasukpegawaicheckid= $set->getField("SURAT_MASUK_PEGAWAI_CHECK_ID");
			$infonomor= $set->getField("NOMOR");
			$infonomordetil= end(explode(".", $infonomor));
			$infotable= $set->getField("INFORMASI_TABLE");
			$infotipe= $set->getField("TIPE");
			$infojenispelayananid= $set->getField("JENIS_PELAYANAN_ID");
			$infojenisid= $set->getField("JENIS_ID");

			$arrdata= [];
			$arrdata["KATEGORI_FILE_ID"]= $set->getField("KATEGORI_FILE_ID");
			$arrdata["JENIS_ID"]= $infojenisid;
			$arrdata["SURAT_MASUK_BKD_ID"]= $set->getField("SURAT_MASUK_BKD_ID");
			$arrdata["SURAT_MASUK_UPT_ID"]= $set->getField("SURAT_MASUK_UPT_ID");
			$arrdata["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
			$arrdata["NOMOR"]= $infonomor;
			$arrdata["JENIS_PELAYANAN_ID"]= $infojenispelayananid;
			$infodatatipe= $set->getField("TIPE");
			$arrdata["TIPE"]= $infodatatipe;
			$arrdata["INFORMASI_TABLE"]= $infotable;
			$arrdata["INFORMASI_FIELD"]= $set->getField("INFORMASI_FIELD");
			$arrdata["JENIS_PELAYANAN_NAMA"]= $set->getField("JENIS_PELAYANAN_NAMA");
			$arrdata["PANGKAT_RIWAYAT_ID"]= $set->getField("PANGKAT_RIWAYAT_ID");
			$arrdata["GAJI_RIWAYAT_ID"]= $set->getField("GAJI_RIWAYAT_ID");
			$arrdata["JABATAN_RIWAYAT_ID"]= $set->getField("JABATAN_RIWAYAT_ID");
			$arrdata["PENDIDIKAN_RIWAYAT_ID"]= $set->getField("PENDIDIKAN_RIWAYAT_ID");
			$arrdata["SURAT_MASUK_PEGAWAI_CHECK_ID"]= $set->getField("SURAT_MASUK_PEGAWAI_CHECK_ID");

			$infopensiuninfosuamiistridetilid= "";
			if($infopensiuninfosuamiistrijumlah > 0 && isStrContain($infonomor, "10."))
			{
				$infocarikey= $infonomordetil;
				$arrkondisicheck= in_array_column($infocarikey, "id", $pensiunsuamiistri);
				$indexpensiunsuamiistri= $pensiunsuamiistri[$arrkondisicheck[0]]["index"];

				// kalau melebihi data
				if($indexpensiunsuamiistri > $infopensiuninfosuamiistrijumlah)
					continue;

				$infopensiuninfosuamiistridetil= $infopensiuninfosuamiistri[$indexpensiunsuamiistri];
				$infopensiuninfosuamiistridetilid= $infopensiuninfosuamiistridetil["ID"];
			}

			$infopensiuninfoanakdetilid= "";
			if($infopensiuninfoanakjumlah > 0 && isStrContain($infonomor, "11."))
			{
				$infocarikey= $infonomordetil;
				$arrkondisicheck= in_array_column($infocarikey, "id", $pensiunanak);
				$indexpensiunanak= $pensiunanak[$arrkondisicheck[0]]["index"];

				// kalau melebihi data
				if($indexpensiunanak > $infopensiuninfoanakjumlah)
					continue;

				$infopensiuninfoanakdetil= $infopensiuninfoanak[$indexpensiunanak];
				$infopensiuninfoanakdetilid= $infopensiuninfoanakdetil["ID"];
			}

			$arrdata["SUAMI_ISTRI_ID"]= $infopensiuninfosuamiistridetilid;
			$arrdata["ANAK_ID"]= $infopensiuninfoanakdetilid;
			$arrdata["KATEGORI"]= $reqKategori;
			$arrdata["INFO_TANPA_UPLOAD"]= "";
			array_push($arrsyarat, $arrdata);

			if(!empty($infotable))
			{
				if(!in_array($infotable, $arrtable))
				{
					array_push($arrtable, $infotable);
				}
			}
		}
		// print_r($arrsyarat);exit;
		$arrreturn["syarat"]= $arrsyarat;
		$arrreturn["table"]= $arrtable;
		$arrreturn["arrpegawai"]= $arrpegawai;
		// print_r($arrpegawai);exit;
		// print_r($arrreturn);exit;

		$arrInfo= $arrreturn["syarat"];
		$riwayattable= $arrreturn["table"];
		// print_r($riwayattable);exit;

		// print_r($arrpegawai);exit;
		// $arrpegawaidownload= [];
		foreach ($arrpegawai as $keypegawai => $valuepegawai)
		{
			$reqPegawaiId= $valuepegawai["PEGAWAI_ID"];
			$reqPegawaiNipBaru= $valuepegawai["PEGAWAI_NIP_BARU"];
			$reqPegawaiNama= $valuepegawai["PEGAWAI_NAMA"];
			$reqPegawaiNamaLengkap= $valuepegawai["PEGAWAI_NAMA_LENGKAP"];
			$reqRowId= $valuepegawai["ROW_ID"];
			$reqKpPakLamaId= $valuepegawai["KP_PAK_LAMA_ID"];
			$reqKpPakBaruId= $valuepegawai["KP_PAK_BARU_ID"];
			$infotahunsurat= $valuepegawai["TAHUN_SURAT"];

			$arrparam= ["reqPegawaiId"=>$reqPegawaiId];
			$ambilcpnspns= $this->ambilcpnspns($arrparam);
			// print_r($ambilcpnspns);exit;
			$cpnspangkatriwayatid= $ambilcpnspns["cpnspangkatriwayatid"];
			$pnspangkatriwayatid= $ambilcpnspns["pnspangkatriwayatid"];
			$pnsjalurpengangkatan= $ambilcpnspns["pnsjalurpengangkatan"];

			// echo $reqPegawaiId.', '.$riwayattable.', "",'. $reqRowId;exit;
			$arrlistriwayatfilepegawai= $this->listpilihfilepegawai($reqPegawaiId, $riwayattable, "", $reqRowId);
			if($reqPegawaiId == "13135")
			{
				// print_r($arrlistriwayatfilepegawai);exit;
			}
			$arrlistpilihfile= $arrlistriwayatfilepegawai["pilihfile"];
			// print_r($arrlistpilihfile);exit;
			
			$infotahunppk= $infotahunsurat;

			// untuk ambil data pegawai
		    /*$arrlistpilihfilefield[$keycarimode][0]["PEGAWAI_ID"]= $reqPegawaiId;
		    $arrlistpilihfilefield[$keycarimode][0]["PEGAWAI_NIP_BARU"]= $reqPegawaiNipBaru;
		    $arrlistpilihfilefield[$keycarimode][0]["PEGAWAI_NAMA"]= $reqPegawaiNama;
		    $arrlistpilihfilefield[$keycarimode][0]["PEGAWAI_NAMA_LENGKAP"]= $reqPegawaiNamaLengkap;*/

		    $arrlistpilihfilefield= [];
		    $reqDokumenPilih= [];
		    $arrlistpilihfilepegawai= [];

			// pensiun
			if($infojenisid == "7")
			{
				foreach ($arrInfo as $key => $value)
				{
					$keynomor= $value["NOMOR"];
					$keycheckfile= "adafile";
					$keymode= $value["TIPE"];
					$keytable= $value["INFORMASI_TABLE"];
					$keyidsuamiistri= $value["SUAMI_ISTRI_ID"];
					$keyidanak= $value["ANAK_ID"];
					$keyinfotanpaupload= $value["INFO_TANPA_UPLOAD"];

					if($keymode == "0")
					    $keymode= "";

					if($keytable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
					{
						$keymode= ";80";
					}

					$keycarimode= $keynomor;
					$keycarimode= str_replace(".", "_", $keycarimode);
					// $keycarimode= $keytable."-".$keymode;
					$arrlistpilihfilefield[$keycarimode]= [];
					if($keycheckfile !== "1" && !empty($keycheckfile) && empty($keyinfotanpaupload))
					{
						// echo $keycarimode."-".$keymode."-".$keytable."\n";
						if(isStrContain($keynomor, "5."))
						{
							$infotahunppk--;
							$statement= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.TAHUN = ".$infotahunppk;
							$set_detil= new SuratMasukPegawaiCheck();
							$set_detil->selectByParamsPenilaianSkp(array(),-1,-1, $statement);
							$set_detil->firstRow();
							// echo $set_detil->query;exit;
							$infopenilaianskpid= $set_detil->getField("PENILAIAN_SKP_ID");
							unset($set_detil);

							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $infopenilaianskpid);
					    }
					    else if(!empty($keyidsuamiistri) && isStrContain($keynomor, "10."))
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $keyidsuamiistri);
					    }
					    else if(!empty($keyidanak) && isStrContain($keynomor, "11."))
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $keyidanak);
					    }
					    // sk cpns
					    else if($keynomor == "1")
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PANGKAT_RIWAYAT_PNS", $cpnspangkatriwayatid);
					    }
					    // sk pns
					    else if($keynomor == "2")
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PANGKAT_RIWAYAT_PNS", $pnspangkatriwayatid);
					    }
					    // pangkat akhir
					    else if($keynomor == "3")
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PANGKAT_RIWAYAT_AKHIR", $value["PANGKAT_RIWAYAT_ID"]);
					    }
					    // kgb akhir
					    else if($keynomor == "4")
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "GAJI_RIWAYAT_AKHIR", $value["GAJI_RIWAYAT_ID"]);
					    }
					    else
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $reqRowId);
					    }

					    // ambil data yg terpilih
					    $infocari= "selected";
					    $arraycari= in_array_column($infocari, "selected", $arrlistpilihfilefield[$keycarimode]);
					    // print_r($arraycari);exit;
					    if(!empty($arraycari))
					    {
					    	$infodetilpegawaifiledata= [];
					    	$infodetilpegawaifiledata= $arrlistpilihfilefield[$keycarimode][$arraycari[0]];

					    	$infodetilpegawaifiledatainforiwayatid= $infodetilpegawaifiledata["inforiwayatid"];
					    	$infodetilpegawaifiledatainforiwayatfield= $infodetilpegawaifiledata["inforiwayatfield"];
					    	$infodetilpegawaifiledatainfotable= $infodetilpegawaifiledata["infotable"];
					    	// print_r($infodetilpegawaifiledata);exit;

					    	$statementdetil= " AND A.PEGAWAI_ID = ".$reqPegawaiId;
					    	if(!empty($infodetilpegawaifiledatainfotable))
					    		$statementdetil.= " AND A.RIWAYAT_TABLE = '".$infodetilpegawaifiledatainfotable."'";

					    	if(!empty($infodetilpegawaifiledatainforiwayatfield))
					    		$statementdetil.= " AND A.RIWAYAT_FIELD = '".$infodetilpegawaifiledatainforiwayatfield."'";

					    	if(!empty($infodetilpegawaifiledatainforiwayatid))
					    		$statementdetil.= " AND A.RIWAYAT_ID = ".$infodetilpegawaifiledatainforiwayatid;

					    	if($infodetilpegawaifiledatainforiwayatfield == "suratketerangankuliah")
					    	{
								// echo $statementdetil;exit;
					    	}

							$setdetil= new SuratMasukPegawaiCheck();
							$setdetil->selectByParamsDownload(array(),-1,-1, $statementdetil);
							$setdetil->firstRow();
							if($keynomor == "7")
					    	{
								// echo $setdetil->query;exit;
					    	}
							$infoformatbkn= $setdetil->getField("FORMAT_BKN");

							$infodetilpegawaifiledata["FORMAT_BKN"]= $infoformatbkn;
							// print_r($infodetilpegawaifiledata);exit;
					    	$arrlistpilihfilepegawai[$keycarimode]= $infodetilpegawaifiledata;
					    }
					}
				}
			}
			// khusus karis karsu
			else if($infojenisid == "3")
			{

			}
			// khusus karis karpeg
			else if($infojenisid == "3")
			{

			}
			// khusus kenaikan pangkat
			else if($infojenisid == "10")
			{
				foreach ($arrInfo as $key => $value)
				{
					$infoubahformat= "";
					$keynomor= $value["NOMOR"];
					$keycheckfile= "adafile";
					$keymode= $value["TIPE"];
					$keytable= $value["INFORMASI_TABLE"];
					$keyidsuamiistri= $value["SUAMI_ISTRI_ID"];
					$keyidanak= $value["ANAK_ID"];
					$keyinfotanpaupload= $value["INFO_TANPA_UPLOAD"];

					if($keymode == "0")
					    $keymode= "";

					if($keytable == "PERSURATAN.SURAT_MASUK_PEGAWAI")
					{
						$keymode= ";80";
					}

					$keycarimode= $keynomor;
					$keycarimode= str_replace(".", "_", $keycarimode);
					// $keycarimode= $keytable."-".$keymode;
					$arrlistpilihfilefield[$keycarimode]= [];
					if($keycheckfile !== "1" && !empty($keycheckfile) && empty($keyinfotanpaupload))
					{
						// echo $keycarimode."-".$keymode."-".$keytable."-".$keynomor."\n";
						if
					    (
					      (
					        (
					          $reqKategori == "kpreguler" 
					          || $reqKategori == "kppi"
					          || $reqKategori == "kpstugas"
					          || $reqKategori == "kpbtugas"
					          || $reqKategori == "kpjft"
					          || $reqKategori == "kpstruktural"
					        )
					        && isStrContain($keynomor, "3.")
					      )
					      || ($reqKategori == "kpreguler" && isStrContain($keynomor, "3."))
					    )
					    {
					    	$infotahunppk--;
					    	$statement= " AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.TAHUN = ".$infotahunppk;
					    	$set_detil= new SuratMasukPegawaiCheck();
					    	$set_detil->selectByParamsPenilaianSkp(array(),-1,-1, $statement);
					    	$set_detil->firstRow();
					      	// echo $set_detil->query;exit;
					    	$infopenilaianskpid= $set_detil->getField("PENILAIAN_SKP_ID");
					    	unset($set_detil);

					    	$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $infopenilaianskpid);
					    }
					    // pangkat akhir
					    else if($keynomor == "1")
					    {
					      	$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PANGKAT_RIWAYAT_AKHIR", $value["PANGKAT_RIWAYAT_ID"]);
					    }
					    // jabatan akhir
					    else if($keynomor == "2")
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "JABATAN_RIWAYAT_AKHIR", $value["JABATAN_RIWAYAT_ID"]);
					    }
					    // pendidikan akhir
					    else if
					    (
					      (
					        (
					          $reqKategori == "kpreguler" 
					          || $reqKategori == "kppi"
					          || $reqKategori == "kpstugas"
					          || $reqKategori == "kpstruktural"
					        )
					        && 
					        (
					          (
					            $keynomor >= 4 && $keynomor < 8
					          )
					          || $keynomor == 10
					        )
					      )
					      || ($reqKategori == "kpjft" && $keynomor >= 6 && $keynomor <= 10)
					    )
					    {
					    	$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PENDIDIKAN_RIWAYAT_AKHIR", $value["PENDIDIKAN_RIWAYAT_ID"]);
					    }
					    // pak 1
					    else if($reqKategori == "kpjft" && $keynomor == "5.1")
					    {
					    	$infoubahformat= "pak";
					    	$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PAK_AKHIR", $reqKpPakLamaId);
					    }
					    // pak 2
					    else if($reqKategori == "kpjft" && $keynomor == "5.2")
					    {
					    	$infoubahformat= "pak";
					    	$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, "PAK_AKHIR", $reqKpPakBaruId);
					    }
					    else
					    {
							$arrlistpilihfilefield[$keycarimode]= $this->ambilfilemode($arrlistpilihfile, $keymode, $keytable, $reqRowId);
					    }

					    // ambil data yg terpilih
					    $infocari= "selected";
					    $arraycari= in_array_column($infocari, "selected", $arrlistpilihfilefield[$keycarimode]);
					    // print_r($arraycari);exit;
					    if(!empty($arraycari))
					    {
					    	$infodetilpegawaifiledata= [];
					    	$infodetilpegawaifiledata= $arrlistpilihfilefield[$keycarimode][$arraycari[0]];

					    	$infodetilpegawaifiledatainforiwayatid= $infodetilpegawaifiledata["inforiwayatid"];
					    	$infodetilpegawaifiledatainforiwayatfield= $infodetilpegawaifiledata["inforiwayatfield"];
					    	$infodetilpegawaifiledatainfotable= $infodetilpegawaifiledata["infotable"];
					    	// print_r($infodetilpegawaifiledata);exit;

					    	$statementdetil= " AND A.PEGAWAI_ID = ".$reqPegawaiId;
					    	if(!empty($infodetilpegawaifiledatainfotable))
					    		$statementdetil.= " AND A.RIWAYAT_TABLE = '".$infodetilpegawaifiledatainfotable."'";

					    	if(!empty($infodetilpegawaifiledatainforiwayatfield))
					    		$statementdetil.= " AND A.RIWAYAT_FIELD = '".$infodetilpegawaifiledatainforiwayatfield."'";

					    	if(!empty($infodetilpegawaifiledatainforiwayatid))
					    		$statementdetil.= " AND A.RIWAYAT_ID = ".$infodetilpegawaifiledatainforiwayatid;

					    	if($infodetilpegawaifiledatainforiwayatfield == "suratketerangankuliah")
					    	{
								// echo $statementdetil;exit;
					    	}

							$setdetil= new SuratMasukPegawaiCheck();
							$setdetil->selectByParamsDownload(array(),-1,-1, $statementdetil);
							$setdetil->firstRow();
							if($keynomor == "7")
					    	{
								// echo $setdetil->query;exit;
					    	}
							$infoformatbkn= $setdetil->getField("FORMAT_BKN");

							if(!empty($infoubahformat))
							{
								if($infoubahformat == "pak")
								{
									$infoformatbkn= explode("_", $infoformatbkn);
									// print_r($infoformatbkn);exit;
									$infoformatbkn= $infoformatbkn[0]."_".$infoformatbkn[2];
									// echo $infoformatbkn;exit;
								}
							}

							$infodetilpegawaifiledata["FORMAT_BKN"]= $infoformatbkn;
							// print_r($infodetilpegawaifiledata);exit;
					    	$arrlistpilihfilepegawai[$keycarimode]= $infodetilpegawaifiledata;
					    }
					}
				}
			}

			$arrpegawai[$keypegawai]["arrlistpilihfilepegawai"]= $arrlistpilihfilepegawai;

			if($reqPegawaiId == "13135")
			{
				// print_r($arrpegawai);exit;
			}

		}

		// print_r($arrlistpilihfilepegawai);exit;
		// print_r($arrpegawai);exit;
		return $arrpegawai;
	}

	function persyaratandata($arrparam, $infodetilparam=[])
	{
		// print_r($arrparam);exit;
		$reqJenis= $arrparam["reqJenis"];
		$reqRowId= $arrparam["reqRowId"];
		$reqJenisKarpeg= $arrparam["reqJenisKarpeg"];
		$reqPegawaiNipLama= $arrparam["reqPegawaiNipLama"];
		$reqKategori= $arrparam["reqKategori"];
		$reqTahun= $arrparam["reqTahun"];
		$reqMode= $arrparam["reqMode"];
		$pnsjalurpengangkatan= $arrparam["pnsjalurpengangkatan"];

		// untuk kenaikan pangkat
		$reqKpStatusPendidikanRiwayatBelumDiakui= $arrparam["reqKpStatusPendidikanRiwayatBelumDiakui"];
		$reqKpPendidikanRiwayatBelumDiakuiId= $arrparam["reqKpPendidikanRiwayatBelumDiakuiId"];
		$reqKpStatusSuratTandaLulus= $arrparam["reqKpStatusSuratTandaLulus"];
		$reqKpStatusPendidikanRiwayatIjinTugas= $arrparam["reqKpStatusPendidikanRiwayatIjinTugas"];
		$reqKpStatusPendidikanRiwayatCantumGelar= $arrparam["reqKpStatusPendidikanRiwayatCantumGelar"];
		$reqKpPakPertamaStatusId= $arrparam["reqKpPakPertamaStatusId"];
		$reqKpPakLamaId= $arrparam["reqKpPakLamaId"];
		$reqKpPakBaruId= $arrparam["reqKpPakBaruId"];
		$reqKpStatusSertifikatKeaslian= $arrparam["reqKpStatusSertifikatKeaslian"];
		$reqKpStatusSertifikatPendidik= $arrparam["reqKpStatusSertifikatPendidik"];
		$reqKpStatusStrukturalId= $arrparam["reqKpStatusStrukturalId"];

		// PNS Pernikahan Pertama:infopernikahanpertamapns
		// ya value 0, tidak 1
		$infopernikahanpertamapns= $arrparam["infopernikahanpertamapns"];
		// Pasangan Pernikahan Pertama:infopernikahanpertamapasanganstatus
		// ya value 1, tidak 0
		$infopernikahanpertamapasanganstatus= $arrparam["infopernikahanpertamapasanganstatus"];
		$infopasangansaatinipns= $arrparam["infopasangansaatinipns"];

		$infopernikahanpertamastatus= $arrparam["infopernikahanpertamastatus"];
		$infopernikahanpasanganstatus= $arrparam["infopernikahanpasanganstatus"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiCheck");
		$CI->load->model("JabatanRiwayat");

		$infotahunppk= $reqTahun;
		$arrreturn= [];
		if($reqMode == "karpeg" || $reqMode == "karsu" || $reqMode == "pensiun" || $reqMode == "kenaikanpangkat")
		{
			$statementdetil= "";
			$statement= " AND A.JENIS_PELAYANAN_ID = ".$reqJenis;
			if(!empty($reqKategori))
			{
				$statement.= " AND A.KATEGORI = '".$reqKategori."'";
			}

			$set= new SuratMasukPegawaiCheck();
			$set->selectByParamsMonitoringCheck(array(), -1,-1, $statement, $reqRowId, $statementdetil);
			// echo $set->query;exit;
		}

		$arrsyarat= [];
		$arrtable=[];

		$infopensiunsuamiistri= $this->infopensiunsuamiistri();
		$pensiunsuamiistrikematian= $infopensiunsuamiistri["pensiunsuamiistrikematian"];
		$pensiunsuamiistrinikah= $infopensiunsuamiistri["pensiunsuamiistrinikah"];
		$pensiunsuamiistricerai= $infopensiunsuamiistri["pensiunsuamiistricerai"];
		$pensiunsuamiistri= $infopensiunsuamiistri["pensiunsuamiistri"];

		$infopensiunanak= $this->infopensiunanak();
		$pensiunanaktanpaupload= $infopensiunanak["pensiunanaktanpaupload"];
		$pensiunanakbelumlulus= $infopensiunanak["pensiunanakbelumlulus"];
		$pensiunanaklulus= $infopensiunanak["pensiunanaklulus"];
		$pensiunanak= $infopensiunanak["pensiunanak"];

		$infopensiuninfosuamiistrijumlah= -1;
		$infopensiuninfosuamiistri= $infodetilparam["infopensiuninfosuamiistri"];
		// print_r($infopensiuninfosuamiistri);exit;
		if(!empty($infopensiuninfosuamiistri))
		{
			$infopensiuninfosuamiistrijumlah= count($infopensiuninfosuamiistri);
			// if($infopensiuninfosuamiistrijumlah > 1)
				$infopensiuninfosuamiistrijumlah= $infopensiuninfosuamiistrijumlah - 1;

		}
		// echo $infopensiuninfosuamiistrijumlah;exit;

		$infopensiuninfoanakjumlah= 1;
		$infopensiuninfoanak= $infodetilparam["infopensiuninfoanak"];
		// print_r($infopensiuninfoanak);exit;
		if(!empty($infopensiuninfoanak))
		{
			$infopensiuninfoanakjumlah= count($infopensiuninfoanak);
			// if($infopensiuninfoanakjumlah > 1)
				$infopensiuninfoanakjumlah= $infopensiuninfoanakjumlah - 1;
		}

		if(!empty($reqMode))
		{
			while($set->nextRow())
			{
				$infosuratmasukpegawaicheckid= $set->getField("SURAT_MASUK_PEGAWAI_CHECK_ID");
				$infonomor= $set->getField("NOMOR");
				$infotable= $set->getField("INFORMASI_TABLE");
				$infotipe= $set->getField("TIPE");
				$infolinkfile= $set->getField("LINK_FILE");
				$infodatanama= $set->getField("NAMA");
				$infopendidikanterakhirid= $set->getField("PENDIDIKAN_RIWAYAT_ID");
				$infojabatanterakhirid= $set->getField("JABATAN_RIWAYAT_ID");
				$infotambahan= $infonamadetil= $infotanpaupload= $reqDokumenFileHarusUpload= "";

				if($reqMode == "karpeg")
				{
					if($reqJenisKarpeg == 1 && ($infonomor == 5 || $infonomor == 6))
						continue;
					elseif($reqJenisKarpeg == 2 && $infonomor == 5)
						continue;
					elseif($reqJenisKarpeg == 3 && $infonomor == 6)
						continue;

					if($infonomor == 5)
					{
						$reqNoSuratKehilangan= $arrparam["reqNoSuratKehilangan"];
						$reqTanggalSuratKehilangan= $arrparam["reqTanggalSuratKehilangan"];
						$infotambahan= ": Nomor ".$reqNoSuratKehilangan." Tanggal ".$reqTanggalSuratKehilangan;
					}

					// kalau revisi maka ambil data karpeg
					if($infonomor == 7)
					{
						if($reqJenisKarpeg == 2){}
						else
							continue;
					}
				}
				else if($reqMode == "karsu")
				{
					if($infotipe == "skkonversinipbaru" || $infonomor == 3 || $infonomor == 13)
					// if($infotipe == "skkonversinipbaru")
					{
						// if($reqPegawaiNipLama == "")
						// {
							continue;
						// }
					}

					// PNS Pernikahan Pertama:infopernikahanpertamapns
					// ya value 0, tidak 1

					// Pasangan Pernikahan Pertama:infopernikahanpertamapasanganstatus
					// ya value 1, tidak 0

					// status pns: infopasangansaatinipns, kalau ya value 1

					// kalau
					// 2;"Cerai Hidup"
					// 3;"Cerai Mati"
					if($infonomor == 9 || $infonomor == 11)
					{
						if(
							(
								$infonomor == 9 && $infopernikahanpertamastatus == "2"
							)
							||
							(
								$infonomor == 11 && $infopernikahanpertamastatus == "3"
							)
						){}
						else
							continue;
					}
					else if($infonomor == 1 && $pnsjalurpengangkatan == "1")
					{
						continue;
						// $reqDokumenFileHarusUpload= "1";
					}

					if($infonomor == 10 || $infonomor == 12)
					{
						if(
							(
								$infonomor == 10 && $infopernikahanpasanganstatus == "2"
							)
							||
							(
								$infonomor == 12 && $infopernikahanpasanganstatus == "3"
							)
						){}
						else
							continue;
					}

					if($infotipe == "aktacerai")
					{
						/*
						// echo $infopernikahanpertamapns."-".$infopernikahanpertamapasanganstatus."-".$infopasangansaatinipns."\n";
						// echo $tambahstatement;exit;
						if($infopernikahanpertamapns == "0" && $infopernikahanpertamapasanganstatus == "1")
							continue;
						else if($infopernikahanpertamapns == "0" && $infopernikahanpertamapasanganstatus == "0")
						{
							if($infopasangansaatinipns == "1" && $infonomor == 9)
							{
								continue;
							}
							elseif($infopasangansaatinipns !== "1" && ($infonomor == 9 || $infonomor == 10))
							{
								continue;
							}
						}
						else
						{
							// echo $infopernikahanpertamapns."-".$infopernikahanpertamapasanganstatus."-".$infopasangansaatinipns."\n";
							// echo $tambahstatement;exit;
							if($infonomor == 9)
							{
								$tambahstatement= "";
								if($infopernikahanpertamapns !== "1")
								{
									$tambahstatement= "1";
								}

								if(!empty($tambahstatement))
								{
									continue;
								}

							}
							else if($infonomor == 10)
							{
								$tambahstatement= "";
								if($infopernikahanpertamapns !== "1" && $infopernikahanpertamapasanganstatus !== "1" && $infopasangansaatinipns == "1")
								{
									$tambahstatement= "1";
								}
								else if($infopernikahanpertamapasanganstatus !== "1" && $infopasangansaatinipns !== "1")
								{
									$tambahstatement= "1";
								}
								// PNS Pernikahan Pertama	Tidak
								// Pasangan Pernikahan Pertama	Ya
								// PNS ataupun bukan PNS
								else if($infopernikahanpertamapns == "1" && $infopernikahanpertamapasanganstatus == "1")
								{
									$tambahstatement= "1";
								}
								// echo $infopernikahanpertamapns."-".$infopernikahanpertamapasanganstatus."-".$infopasangansaatinipns."\n";
								// echo $tambahstatement;exit;

								if(!empty($tambahstatement))
								{
									continue;
								}

							}
						}*/
					}

					// kalau surat kehilangan
					if($infonomor == 15)
					{
						if($reqJenisKarpeg == 3){}
						else
						{
							continue;
						}
					}

					// kalau surat revisi
					if($infonomor == 16)
					{
						if($reqJenisKarpeg == 2){}
						else
						{
							continue;
						}
					}

				}
				else if($reqMode == "pensiun")
				{
					$infonomordetil= end(explode(".", $infonomor));
					// echo $kondisiinfonomordetil."-".$infonomordetil."\n";

					// if($reqKategori == "bup")
					// {
						// if($infonomor == 5.1 || $infonomor == 5.2)
						if(isStrContain($infonomor, "5."))
						{
							$infotahunppk--;

							$infotambahan= "";
							if(empty($infosuratmasukpegawaicheckid))
								$infotambahan= " ".$infotahunppk;
						}
						else if($infonomor == 1 && $pnsjalurpengangkatan == "1")
						{
							continue;
							// $reqDokumenFileHarusUpload= "1";
						}
						else if(isStrContain($infonomor, "10."))
						{
							$infocarikey= $infonomordetil;
							$arrkondisicheck= in_array_column($infocarikey, "id", $pensiunsuamiistri);
							$indexpensiunsuamiistri= $pensiunsuamiistri[$arrkondisicheck[0]]["index"];

							// kalau melebihi data
							if($indexpensiunsuamiistri > $infopensiuninfosuamiistrijumlah)
								continue;

							// echo $infocarikey.";".$indexpensiunsuamiistri.">".$infopensiuninfosuamiistrijumlah."\n";

							// print_r($indexpensiunsuamiistri);
							$infopensiuninfosuamiistridetil= $infopensiuninfosuamiistri[$indexpensiunsuamiistri];
							// print_r($infopensiuninfosuamiistridetil);exit;

							$infopensiuninfosuamiistridetilid= $infopensiuninfosuamiistridetil["ID"];
							$infopensiuninfosuamiistridetilnama= $infopensiuninfosuamiistridetil["NAMA"];
							$infopensiuninfosuamiistridetilstatushidup= $infopensiuninfosuamiistridetil["STATUS_HIDUP"];
							$infopensiuninfosuamiistridetilstatuskawin= $infopensiuninfosuamiistridetil["STATUS_KAWIN"];
							$infopensiuninfosuamiistridetilkematianno= $infopensiuninfosuamiistridetil["KEMATIAN_NO"];
							$infopensiuninfosuamiistridetilkematiantanggal= $infopensiuninfosuamiistridetil["KEMATIAN_TANGGAL"];
							$infopensiuninfosuamiistridetiltanggalmeninggal= $infopensiuninfosuamiistridetil["TANGGAL_MENINGGAL"];
							// $infopensiuninfosuamiistridetilaktanikahnomor= $infopensiuninfosuamiistridetil["AKTA_NIKAH_NO"];
							$infopensiuninfosuamiistridetilaktanikahnomor= $infopensiuninfosuamiistridetil["SURAT_NIKAH"];
							$infopensiuninfosuamiistridetilaktanikahtanggal= $infopensiuninfosuamiistridetil["AKTA_NIKAH_TANGGAL"];
							$infopensiuninfosuamiistridetilnikahtanggal= $infopensiuninfosuamiistridetil["NIKAH_TANGGAL"];
							$infopensiuninfosuamiistridetilaktacerainomor= $infopensiuninfosuamiistridetil["AKTA_CERAI_NO"];
							$infopensiuninfosuamiistridetilaktaceraitanggal= $infopensiuninfosuamiistridetil["AKTA_CERAI_TANGGAL"];
							$infopensiuninfosuamiistridetilceraitanggal= $infopensiuninfosuamiistridetil["CERAI_TANGGAL"];

							if($infopensiuninfosuamiistridetilstatushidup == "2")
							{
								if(in_array($infonomordetil, $pensiunsuamiistrikematian))
								{
									continue;
								}
								else
								{
									 // <span style='color: red'>,".$infotambahan."</span>
									if(empty($infosuratmasukpegawaicheckid))
										$infotambahan= ", An ".$infopensiuninfosuamiistridetilnama;

									$infonamadetil= "
									<table class='bordered md-text'>
									<tr>
										<th class='material-font' style='width:20%'>Surat Ket Kematian</th>
										<th class='material-font' style='width:1%'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilkematianno."</td>
									</tr>
									<tr>
										<th class='material-font'>Tgl Surat</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilkematiantanggal."</td>
									</tr>
									<tr>
										<th class='material-font'>Tgl Wafat</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetiltanggalmeninggal."</td>
									</tr>
									</table>
									";
								}
							}
							else
							{
								// kalau wafat lewati
								if(!in_array($infonomordetil, $pensiunsuamiistrikematian))
								{
									continue;
								}

								// kalau menikah
								if($infopensiuninfosuamiistridetilstatuskawin == "1")
								{
									if(in_array($infonomordetil, $pensiunsuamiistricerai))
									{
										continue;
									}
								}

								// $infodatanama.= "<span style='color: red'>, An ".$infopensiuninfosuamiistridetilnama."</span>";
								// $infotambahan= "";

								// kalau tidak ada data suami istri lewati saja
								if(empty($infopensiuninfosuamiistri))
									continue;

								// untuk tambahan info menikah
								if(in_array($infonomordetil, $pensiunsuamiistrinikah))
								{
									if(empty($infosuratmasukpegawaicheckid))
										$infotambahan= ", An ".$infopensiuninfosuamiistridetilnama;

									$infonamadetil= "
									<table class='bordered md-text'>
									<tr>
										<th class='material-font' style='width:20%'>Akta Nikah</th>
										<th class='material-font' style='width:1%'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilaktanikahnomor."</td>
									</tr>
									<tr>
										<th class='material-font'>Tgl Akta Nikah</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilaktanikahtanggal."</td>
									</tr>
									<tr>
										<th class='material-font'>Tanggal Nikah</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilnikahtanggal."</td>
									</tr>
									</table>
									";
								}

								// untuk tambahan info cerai
								if(in_array($infonomordetil, $pensiunsuamiistricerai))
								{
									if(empty($infosuratmasukpegawaicheckid))
										$infotambahan= ", An ".$infopensiuninfosuamiistridetilnama;

									$infonamadetil= "
									<table class='bordered md-text'>
									<tr>
										<th class='material-font' style='width:20%'>Akta Cerai</th>
										<th class='material-font' style='width:1%'>:</th>
										<td>".$infopensiuninfosuamiistridetilaktacerainomor."</td>
									</tr>
									<tr>
										<th class='material-font'>Tgl Akta Cerai</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilaktaceraitanggal."</td>
									</tr>
									<tr>
										<th class='material-font'>Tanggal Cerai</th>
										<th class='material-font'>:</th>
										<td class='material-font'>".$infopensiuninfosuamiistridetilceraitanggal."</td>
									</tr>
									</table>
									";
								}
								// $infotambahan= " ".$infonomordetil.";".$indexpensiunsuamiistri." > ".$infopensiuninfosuamiistrijumlah;
							}
						}
						else if(isStrContain($infonomor, "11."))
						{
							$infocarikey= $infonomordetil;
							$arrkondisicheck= in_array_column($infocarikey, "id", $pensiunanak);
							$indexpensiunanak= $pensiunanak[$arrkondisicheck[0]]["index"];

							// kalau melebihi data
							if($indexpensiunanak > $infopensiuninfoanakjumlah)
								continue;

							$infopensiuninfoanakdetil= $infopensiuninfoanak[$indexpensiunanak];
							// print_r($infopensiuninfoanakdetil);exit;

							$infopensiuninfoanakdetilid= $infopensiuninfoanakdetil["ID"];
							$infopensiuninfoanakdetilnama= $infopensiuninfoanakdetil["NAMA"];
							$infopensiuninfoanakdetilstatusaktif= $infopensiuninfoanakdetil["STATUS_AKTIF"];
							$infopensiuninfoanakdetilstatusaktifnama= $infopensiuninfoanakdetil["STATUS_AKTIF_NAMA"];
							$infopensiuninfoanakdetilstatuskeluarga= $infopensiuninfoanakdetil["STATUS_KELUARGA"];
							$infopensiuninfoanakdetilstatuskeluarganama= $infopensiuninfoanakdetil["STATUS_KELUARGA_NAMA"];
							$infopensiuninfoanakdetilstatusbekerja= $infopensiuninfoanakdetil["STATUS_BEKERJA"];
							$infopensiuninfoanakdetilstatusbekerjanama= $infopensiuninfoanakdetil["STATUS_BEKERJA_NAMA"];
							$infopensiuninfoanakdetilstatuslulus= $infopensiuninfoanakdetil["STATUS_LULUS"];
							$infopensiuninfoanakdetilstatuslulusnama= $infopensiuninfoanakdetil["STATUS_LULUS_NAMA"];
							$infopensiuninfoanakdetiljeniskawinid= $infopensiuninfoanakdetil["JENIS_KAWIN_ID"];
							$infopensiuninfoanakdetiljeniskawinnama= $infopensiuninfoanakdetil["JENIS_KAWIN_NAMA"];
							$infopensiuninfoanakdetilpendidikanid= $infopensiuninfoanakdetil["PENDIDIKAN_ID"];
							$infopensiuninfoanakdetilpendidikannama= $infopensiuninfoanakdetil["PENDIDIKAN_NAMA"];

							$infotanpaupload= "continue";
							if
							(
								$infopensiuninfoanakdetilstatusaktif == "1"
								&& $infopensiuninfoanakdetilstatuskeluarga == "1"
								&& empty($infopensiuninfoanakdetilstatusbekerja)
								&&
								(
									empty($infopensiuninfoanakdetiljeniskawinid) || $infopensiuninfoanakdetiljeniskawinid == "4"
								)
							)
							{
								// echo $infopensiuninfoanakdetilstatusaktif."\n";
								// echo $infopensiuninfoanakdetilstatuskeluarga."\n";
								// exit;
								$infotanpaupload= "";
							}

							// kalau tanpa upload
							if(!empty($infotanpaupload) && !in_array($infonomordetil, $pensiunanaktanpaupload))
							{
								continue;
							}

							// // kalau status lulus, belum
							if(empty($infopensiuninfoanakdetilstatuslulus) && !in_array($infonomordetil, $pensiunanakbelumlulus))
							{
								continue;
							}

							// // kalau status lulus, sudah
							if(!empty($infopensiuninfoanakdetilstatuslulus) && !in_array($infonomordetil, $pensiunanaklulus))
							{
								continue;
							}

							if(!empty($infotanpaupload))
							{
								$infodatanama= "<span style='color: rxed'>An ".$infopensiuninfoanakdetilnama."</span>";
								$infotambahan= "";
							}
							else
							{
								// $infodatanama.= "<span style='color: red'>, An ".$infopensiuninfoanakdetilnama."</span>";
								// $infotambahan= "";
								
								if(empty($infosuratmasukpegawaicheckid))
									$infotambahan= ", An ".$infopensiuninfoanakdetilnama;
							}

							// kalau belum punya
							if(empty($infopensiuninfoanakdetilnama))
							{
								continue;
							}

							if(!in_array($infonomordetil, $pensiunanaktanpaupload))
							{
								$reqDokumenFileHarusUpload= "1";
							}

							if(in_array($infonomordetil, $pensiunanaktanpaupload))
							{
								$infonamadetil= "
								<table class='bordered md-text'>
								<tr>
									<th class='material-font' style='width:20%'>Status Hidup</th>
									<th class='material-font' style='width:1%'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetilstatusaktifnama."</td>
									<th class='material-font'>Status Bekerja</th>
									<th class='material-font'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetilstatusbekerjanama."</td>
									<th class='material-font'>Pendidikan Terakhir</th>
									<th class='material-font'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetilpendidikannama."</td>
								</tr>
								<tr>
									<th class='material-font'>Status Kandung</th>
									<th class='material-font'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetilstatuskeluarganama."</td>
									<th class='material-font'>Status Perkawinan</th>
									<th class='material-font'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetiljeniskawinnama."</td>
									<th class='material-font'>Status Lulus</th>
									<th class='material-font'>:</th>
									<td class='material-font'>".$infopensiuninfoanakdetilstatuslulusnama."</td>
								</tr>
								</table>
								";
							}

						}
					// }
				}
				else if($reqMode == "kenaikanpangkat")
				{
					// reqKpStatusPendidikanRiwayatBelumDiakui, 1 maka Ya null maka tidak
					// reqKpPendidikanRiwayatBelumDiakuiId, pendidikan terakhir
					// reqKpStatusSuratTandaLulus, 1 maka Ya null maka tidak
					// reqKpStatusPendidikanRiwayatIjinTugas, 1 maka Ijin belajar / tugas belajar mandiri, 2 maka Tugas Belajar
					// reqKpStatusPendidikanRiwayatCantumGelar, 1 maka Ya, 2 maka Tidak

					$infopendidikanterakhirid= $reqKpPendidikanRiwayatBelumDiakuiId;
					if($reqKategori == "kpreguler" || $reqKategori == "kppi" || $reqKategori == "kpstugas" || $reqKategori == "kpbtugas" || $reqKategori == "kpstruktural")
					{
						if(isStrContain($infonomor, "3."))
						{
							$infotahunppk--;
							$infotambahan= "";
							if(empty($infosuratmasukpegawaicheckid))
								$infotambahan= " ".$infotahunppk;
						}

						if($reqKpStatusPendidikanRiwayatBelumDiakui == "")
						{
							if($infonomor >= 4 && $infonomor < 8)
							{
								continue;
							}
						}

						if($reqKategori == "kpstruktural")
						{
							// kalau 1 diklat stlud
							if($infonomor == "8.1")
							{
								if($reqKpStatusStrukturalId == "1"){}
								else
									continue;
							}

							// kalau 2 diklat pim
							if($infonomor == "8.2")
							{
								if($reqKpStatusStrukturalId == "2"){}
								else
									continue;
							}
						}
						


						if($reqKpStatusSuratTandaLulus == "")
						{
							if($infonomor == 8)
							{
								continue;
							}
						}

						$infotugasoptional= "";
						if($infonomor == 9)
						{
							if($reqKategori == "kpstruktural")
							{
								/*if
								(
									(
										$reqKpStatusPendidikanRiwayatBelumDiakui == "" || $reqKpStatusSuratTandaLulus == ""
									)
									&& !empty($reqKpStatusStrukturalId)
								){}
								else
									continue;*/

								if($reqKpStatusPendidikanRiwayatBelumDiakui == "")
								{
									continue;
								}
								else
								{
									$infotugasoptional= "1";
								}
							}
							else
							{
								if($reqKpStatusPendidikanRiwayatBelumDiakui == "" && $reqKpStatusSuratTandaLulus == "")
								{
									continue;
								}
								else
								{
									$infotugasoptional= "1";
								}
							}
						}

						if($infonomor == 10 && ($reqKpStatusPendidikanRiwayatCantumGelar == "" || $reqKpStatusPendidikanRiwayatCantumGelar == "2"))
						{
							continue;
						}

						if(isStrContain($infonomor, "7."))
						{
							// kalau Tanpa Ijin Belajar
							if($reqKpStatusPendidikanRiwayatIjinTugas == "3")
								continue;

							if($reqKpStatusPendidikanRiwayatIjinTugas == "1")
							{
								if($infotipe == "ijinbelajar"){}
								else
									continue;
							}

							if($reqKpStatusPendidikanRiwayatIjinTugas == "2")
							{
								if($infotipe == "tugasbelajar"){}
								else
									continue;
							}
						}

						// khusus kpstruktural eselon 21 atau 22
						if($reqKategori == "kpstruktural" && isStrContain($infonomor, "15."))
						{
							if($infonomor == "15.3"){}
							else
							{
								$statementkhusus= " AND A.JABATAN_RIWAYAT_ID = ".$infojabatanterakhirid;
								$setdetil= new JabatanRiwayat();
								$setdetil->selectByParams(array(), -1, -1, $statementkhusus);
								$setdetil->firstRow();
								$infocheckeselonid= $setdetil->getField('ESELON_ID');
								if($infocheckeselonid == "21" || $infocheckeselonid == "22"){}
								else
									continue;
							}
						}

						$reqDokumenFileHarusUpload= $infotanpaupload= "";
						if($infonomor == 10 || $infonomor == "15.1" || $infonomor == "15.3" || $infotugasoptional == "1")
						{
							$reqDokumenFileHarusUpload= "1";
							$infotanpaupload= "continue";
						}
					}
					else if($reqKategori == "kpjft")
					{
						if($infonomor == "4.1")
						{
							// Tidak
							if($reqKpStatusSertifikatKeaslian == "")
							{
								continue;
							}
						}

						if($infonomor == "4.2")
						{
							// Tidak
							if($reqKpStatusSertifikatPendidik == "")
							{
								continue;
							}
						}

						if($infonomor == "5.2")
						{
							// Ya
							if($reqKpPakPertamaStatusId == "1")
							{
								continue;
							}
						}

						if(isStrContain($infonomor, "3."))
						{
							$infotahunppk--;
							$infotambahan= "";
							if(empty($infosuratmasukpegawaicheckid))
								$infotambahan= " ".$infotahunppk;
						}

						if($reqKpStatusPendidikanRiwayatBelumDiakui == "")
						{
							if($infonomor >= 6 && $infonomor < 10)
							{
								continue;
							}
						}

						if($infonomor == 10 && ($reqKpStatusPendidikanRiwayatCantumGelar == "" || $reqKpStatusPendidikanRiwayatCantumGelar == "2"))
						{
							continue;
						}

						if(isStrContain($infonomor, "9."))
						{
							// kalau Tanpa Ijin Belajar
							if($reqKpStatusPendidikanRiwayatIjinTugas == "3")
								continue;
							
							if($reqKpStatusPendidikanRiwayatIjinTugas == "1")
							{
								if($infotipe == "ijinbelajar"){}
								else
									continue;
							}

							if($reqKpStatusPendidikanRiwayatIjinTugas == "2")
							{
								if($infotipe == "tugasbelajar"){}
								else
									continue;
							}
						}

						$reqDokumenFileHarusUpload= $infotanpaupload= "";
						if($infonomor == 10 || $infonomor == "15.1" || $infonomor == "15.2" || $infonomor == "15.3")
						{
							$reqDokumenFileHarusUpload= "1";
							$infotanpaupload= "continue";
						}
					}
					else
					{
						continue;
					}

				}

				$arrdata= [];
				$arrdata["KATEGORI_FILE_ID"]= $set->getField("KATEGORI_FILE_ID");
				$arrdata["JENIS_ID"]= $set->getField("JENIS_ID");
				$arrdata["SURAT_MASUK_BKD_ID"]= $set->getField("SURAT_MASUK_BKD_ID");
				$arrdata["SURAT_MASUK_UPT_ID"]= $set->getField("SURAT_MASUK_UPT_ID");
				$arrdata["PEGAWAI_ID"]= $set->getField("PEGAWAI_ID");
				$arrdata["NOMOR"]= $infonomor;
				$arrdata["JENIS_PELAYANAN_ID"]= $set->getField("JENIS_PELAYANAN_ID");
				$infodatatipe= $set->getField("TIPE");
				$arrdata["TIPE"]= $infodatatipe;

				$jenisdokumen= "2";
				if($infodatatipe == "foto")
					$jenisdokumen= "1";

				$arrdata["jenisdokumen"]= $jenisdokumen;
				
				$arrdata["NAMA"]= $infodatanama.$infotambahan;
				$arrdata["NAMA_DETIL"]= $infonamadetil;
				$arrdata["INFO_CHECKED"]= $set->getField("INFO_CHECKED");
				$arrdata["LINK_FILE"]= $set->getField("LINK_FILE");
				$arrdata["STATUS_INFORMASI"]= $set->getField("STATUS_INFORMASI");
				$arrdata["INFORMASI_TABLE"]= $infotable;
				$arrdata["INFORMASI_FIELD"]= $set->getField("INFORMASI_FIELD");
				$arrdata["JENIS_PELAYANAN_NAMA"]= $set->getField("JENIS_PELAYANAN_NAMA");
				$arrdata["PANGKAT_RIWAYAT_ID"]= $set->getField("PANGKAT_RIWAYAT_ID");
				$arrdata["GAJI_RIWAYAT_ID"]= $set->getField("GAJI_RIWAYAT_ID");
				$arrdata["JABATAN_RIWAYAT_ID"]= $infojabatanterakhirid;
				$arrdata["PENDIDIKAN_RIWAYAT_ID"]= $infopendidikanterakhirid;
				$arrdata["SURAT_MASUK_PEGAWAI_CHECK_ID"]= $set->getField("SURAT_MASUK_PEGAWAI_CHECK_ID");

				$reqDokumenFileHarusUploadInfo= "";
				if(empty($reqDokumenFileHarusUpload) && empty($infotanpaupload))
					$reqDokumenFileHarusUploadInfo= '<span style="color: red;"> *</span>';

				$arrdata["REQUIRED_UPLOAD_INFO"]= $reqDokumenFileHarusUploadInfo;
				$arrdata["REQUIRED_UPLOAD"]= $reqDokumenFileHarusUpload;

				// $arrdata["riwayatfieldrequired"]= $riwayatfieldrequired;
				// $arrdata["riwayatfieldrequiredinfo"]= $this->setfilerequiredinfo($riwayatfieldrequired);

				// khusus pensiun
				if($reqMode == "pensiun")
				{
					$arrdata["SUAMI_ISTRI_ID"]= $infopensiuninfosuamiistridetilid;
					$arrdata["ANAK_ID"]= $infopensiuninfoanakdetilid;
					$arrdata["INFO_TANPA_UPLOAD"]= $infotanpaupload;
				}
				array_push($arrsyarat, $arrdata);

				if(!empty($infotable))
				{
					if(!in_array($infotable, $arrtable))
					{
						array_push($arrtable, $infotable);
					}
				}
			}
		}

		$arrreturn["syarat"]= $arrsyarat;
		$arrreturn["table"]= $arrtable;

		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function turunstatusdata($arrparam)
	{
		// print_r($arrparam);exit;
		$reqRowId= $arrparam["reqRowId"];
		$reqJenis= $arrparam["reqJenis"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiTurunStatus");

		$arrreturn= [];
		$statement= " AND A.SURAT_MASUK_PEGAWAI_ID = ".$reqRowId;
		if(empty($reqJenis))
			$statement.= " AND COALESCE(NULLIF(A.JENIS, ''), NULL) IS NULL";
		else
			$statement.= " AND A.JENIS IN ('".$reqJenis."')";

		$set= new SuratMasukPegawaiTurunStatus();
		$set->selectByParams(array(), -1,-1, $statement);
		// echo $set->query;exit;

		while($set->nextRow())
		{
			$infojenis= $set->getField("JENIS");
			$arrdata= [];
			$arrdata["KETERANGAN"]= $set->getField("KETERANGAN");
			$arrdata["JENIS"]= $infojenis;
			$infojenisnama= "";
			if($infojenis == "kirim_wa_asn")
			{
				$infojenisnama= "Telah Terkirim Whatsapp ke Nomor ASN";
			}
			if($infojenis == "kirim_wa_opd")
			{
				$infojenisnama= "Telah Terkirim Whatsapp ke Nomor Admin OPD/Unit Kerja";
			}
			$arrdata["JENIS_INFO"]= $infojenisnama;

			$arrdata["LAST_USER"]= $set->getField("LAST_USER");
			$arrdata["LAST_DATE"]= $set->getField("LAST_DATE");
			array_push($arrreturn, $arrdata);
		}

		return $arrreturn;
	}

	function revisistatusdata($arrparam)
	{
		// print_r($arrparam);exit;
		$reqRowId= $arrparam["reqRowId"];
		$reqJenis= $arrparam["reqJenis"];

		$CI = &get_instance();
		$CI->load->model("persuratan/CetakIjinBelajar");

		$arrreturn= [];
		$statement= " AND A.SURAT_MASUK_PEGAWAI_ID = ".$reqRowId;

		$set= new CetakIjinBelajar();
		$set->selectByParams(array(), -1,-1, $statement);
		// echo $set->query;exit;

		while($set->nextRow())
		{
			$arrdata= [];
			$arrdata["CETAK_IJIN_BELAJAR_ID"]= $set->getField("CETAK_IJIN_BELAJAR_ID");
			$arrdata["LAST_USER"]= $set->getField("LAST_USER");
			$arrdata["LAST_DATE"]= $set->getField("LAST_DATE");
			array_push($arrreturn, $arrdata);
		}

		return $arrreturn;
	}

	function ambilinforiwayat($arrparam)
	{
		// print_r($arrparam);exit;
		$reqKategori= $arrparam["reqKategori"];
		$reqJenis= $arrparam["reqJenis"];
		$infopegawaiid= $arrparam["infopegawaiid"];
		$infokategorifileid= $arrparam["infokategorifileid"];
		$infotipe= $arrparam["infotipe"];
		$infonomor= $arrparam["infonomor"];

		$infotahunppk= $arrparam["infotahunppk"];
		$infosuamiistriid= $arrparam["infosuamiistriid"];
		$infoanakid= $arrparam["infoanakid"];

		$infopernikahanpertamapns= $arrparam["infopernikahanpertamapns"];
		$infopernikahanpertamapasanganstatus= $arrparam["infopernikahanpertamapasanganstatus"];
		$infopasangansaatinipns= $arrparam["infopasangansaatinipns"];

		$infosuamiistrisebelum= $arrparam["infosuamiistrisebelum"];
		$infosuamiistrisekarang= $arrparam["infosuamiistrisekarang"];

		$infopangkatriwayatakhirid= $arrparam["infopangkatriwayatakhirid"];
		$infojabatanriwayatakhirid= $arrparam["infojabatanriwayatakhirid"];
		$reqKpPakLamaId= $arrparam["reqKpPakLamaId"];
		$reqKpPakBaruId= $arrparam["reqKpPakBaruId"];
		$pnspangkatriwayatid= $arrparam["pnspangkatriwayatid"];
		$infogajiriwayatakhirid= $arrparam["infogajiriwayatakhirid"];
		$infopendidikanriwayatakhirid= $arrparam["infopendidikanriwayatakhirid"];

		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$lihatquery= "";
		$statement= " AND A.PEGAWAI_ID = ".$infopegawaiid." AND NO_URUT = ".$infokategorifileid;

		$ambilkalaukosong= "";
		if (is_numeric($infotipe))
		{
			$statement.= " AND A.RIWAYAT_ID = '".$infotipe."'";	
		}
		// khusus karis karsu
		else if($reqJenis == "3")
		{
			// pasangan sebelumnya
			if($infonomor == 9 || $infonomor == 11)
			{
				$statement.= " AND A.RIWAYAT_ID = '".$infosuamiistrisebelum."'";
			}

			// pasangan saat ini
			if($infonomor == 10 || $infonomor == 12)
			{
				$statement.= " AND A.RIWAYAT_ID = '".$infosuamiistrisekarang."'";
			}

			if($infotipe == "aktacerai")
			{
				/*if($infopernikahanpertamapns == "0" && $infopernikahanpertamapasanganstatus == "1")
				{
					// continue;
				}
				else if($infopernikahanpertamapns == "0" && $infopernikahanpertamapasanganstatus == "0")
				{
					if($infopasangansaatinipns == "1" && $infonomor == 9)
					{
						// continue;
					}
				}
				else
				{
					// untuk ambil data tukar status statement, dari lihat
					if($infonomor == 9)
					{
						$tambahstatement= "1";
						if($infopernikahanpertamapns !== "1")
						{
							$tambahstatement= "";
						}

						if(!empty($tambahstatement))
						{
							$statement.= " AND A.RIWAYAT_ID = '".$arrparam["infosuamiistrisebelum"]."'";
							$lihatquery= "1";
							// 	continue;
						}

					}
					else if($infonomor == 10)
					{
						$tambahstatement= "1";
						if($infopernikahanpertamapns !== "1" && $infopernikahanpertamapasanganstatus !== "1" && $infopasangansaatinipns == "1")
						{
							$tambahstatement= "";
						}
						else if($infopernikahanpertamapasanganstatus !== "1" && $infopasangansaatinipns !== "1")
						{
							$tambahstatement= "";
						}
						else if($infopernikahanpertamapns == "1" && $infopernikahanpertamapasanganstatus == "1")
						{
							$tambahstatement= "";
						}

						if(!empty($tambahstatement))
						{
							$statement.= " AND A.RIWAYAT_ID = '".$arrparam["infosuamiistrisekarang"]."'";
							$lihatquery= "1";
							// continue;
						}

					}
				}*/
			}

			// print_r($arrparam);exit;
		}
		// khusus karpeg
		else if($reqJenis == "4")
		{
			if($infonomor == 5)
			{
				$statement.= " AND A.RIWAYAT_ID = '81'";
			}
			else if($infonomor == 3 || $infonomor == 3)
			{
				$statement.= " AND A.RIWAYAT_ID = '".$infopangkatriwayatakhirid."'";
				// $lihatquery= "1";
			}
			else if($infonomor == 2 || $infonomor == 4)
			{
				$statement.= " AND A.RIWAYAT_ID = '".$pnspangkatriwayatid."'";
			}
		}
		// khusus pensiun
		else if($reqJenis == "7")
		{
			// if($reqKategori == "bup")
			// {
				// Penilaian SKP
				// if($infonomor == 5.1 || $infonomor == 5.2)
				if(isStrContain($infonomor, "5."))
				{
					$statement.= " AND RIWAYAT_FIELD = '".$infotipe."' AND INFO_DATA = 'PPKTahun".$infotahunppk."'";
					// $lihatquery= "1";
				}
				else if(!empty($infosuamiistriid) && isStrContain($infonomor, "10."))
				{
					$statement.= " AND RIWAYAT_FIELD = '".$infotipe."' AND RIWAYAT_ID = '".$infosuamiistriid."'";
					// $lihatquery= "1";
				}
				else if(!empty($infoanakid) && isStrContain($infonomor, "11."))
				{
					$statement.= " AND RIWAYAT_FIELD = '".$infotipe."' AND RIWAYAT_ID = '".$infoanakid."'";
					// $lihatquery= "1";
				}
				else if($infonomor == 3 || $infonomor == 3)
				{
					$statement.= " AND A.RIWAYAT_ID = '".$infopangkatriwayatakhirid."'";
				}
				else if($infonomor == 4 || $infonomor == 4)
				{
					$statement.= " AND A.RIWAYAT_ID = '".$infogajiriwayatakhirid."'";
					// $lihatquery= "1";
				}
			// }
		}
		// khusus kenaikan pangkat
		else if($reqJenis == "10")
		{
			if
			(
				
				(
					(
						$reqKategori == "kpreguler"
						|| $reqKategori == "kppi"
						|| $reqKategori == "kpstugas"
						|| $reqKategori == "kpstruktural"
					)
					&&
					(
						($infonomor >= 4 && $infonomor < 8)
						|| $infonomor == 10
					)
				)
				|| ($reqKategori == "kpjft" && $infonomor >= 6 && $infonomor <= 10)
			)
			{
				$ambilkalaukosong= $statement;
				$statement.= " AND RIWAYAT_FIELD = '".$infotipe."' AND A.RIWAYAT_ID = '".$infopendidikanriwayatakhirid."'";

				// if($reqKategori == "kpjft")
					// $lihatquery= "1";
			}
			else if
			(
				(
					(
						$reqKategori == "kpreguler"
						|| $reqKategori == "kppi"
						|| $reqKategori == "kpstugas"
						|| $reqKategori == "kpbtugas"
						|| $reqKategori == "kpjft"
						|| $reqKategori == "kpstruktural"
					)
					&& isStrContain($infonomor, "3.")
				)
				|| ($reqKategori == "kpreguler" && isStrContain($infonomor, "3."))
			)
			{
				$statement.= " AND RIWAYAT_FIELD = '".$infotipe."' AND INFO_DATA = 'PPKTahun".$infotahunppk."'";
				// $lihatquery= "1";
			}
			// pangkat akhir
			else if($infonomor == "1")
		    {
		    	$statement.= " AND A.RIWAYAT_ID = '".$infopangkatriwayatakhirid."'";
		    }
		    // jabatan akhir
		    else if($infonomor == "2")
		    {
		    	$statement.= " AND A.RIWAYAT_ID = '".$infojabatanriwayatakhirid."'";
		    }
		    // pak 1
		    else if($reqKategori == "kpjft" && $infonomor == "5.1")
		    {
		    	$statement.= " AND A.RIWAYAT_ID = '".$reqKpPakLamaId."'";
		    }
		    // pak 2
		    else if($reqKategori == "kpjft" && $infonomor == "5.2")
		    {
		    	$statement.= " AND A.RIWAYAT_ID = '".$reqKpPakBaruId."'";
		    }
		}

		if($infonomor == 9)
		{
			// print_r($arrparam);exit;
			// $lihatquery= "1";
		}

		if($infonomor == 5)
		{
			// print_r($arrparam);exit;
			// $lihatquery= "1";
		}

		// $lihatquery= "1";
		$set_detil= new PegawaiFile();
		$set_detil->selectByParamsJenisDokumen(array(), -1,-1, $statement);
		if(!empty($lihatquery))
		{
			// echo $set_detil->query;
			// echo "<br/>";
			// exit;
		}
		$set_detil->firstRow();

		/*if(empty($set_detil->firstRow()) && !empty($ambilkalaukosong))
		{
			$set_detil= new PegawaiFile();
			$set_detil->selectByParamsJenisDokumen(array(), -1,-1, $ambilkalaukosong);
			$set_detil->firstRow();
			// echo $set_detil->query;exit;
		}*/

		$vreturn= [];
		$vreturn["RIWAYAT_TABLE"]= $set_detil->getField("RIWAYAT_TABLE");
		$vreturn["RIWAYAT_ID"]= $set_detil->getField("RIWAYAT_ID");
		$vreturn["RIWAYAT_FIELD"]= $set_detil->getField("RIWAYAT_FIELD");

		return $vreturn;

	}

	function ambilinfodetil($arrparam)
	{
		// print_r($arrparam);exit;
		$value= $arrparam["value"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawaiCheck");
		$CI->load->model("SuamiIstri");

		$infoinformasitable= $value["INFORMASI_TABLE"];
		$infoinformasifield= $value["INFORMASI_FIELD"];
		$infojenispelayananid= $value["JENIS_PELAYANAN_ID"];
		$infonomor= $value["NOMOR"];

		if($infoinformasitable == "PANGKAT_RIWAYAT")
		{
			$statement= " AND A.PANGKAT_RIWAYAT_ID = ".$value["PANGKAT_RIWAYAT_ID"];
			$set_detil= new SuratMasukPegawaiCheck();
			$set_detil->selectByParamsPangkat(array(),-1,-1, $statement);
			$set_detil->firstRow();
			//$set_detil->query;exit;

			$tempPangkatKode= $set_detil->getField("PANGKAT_KODE");
			$tempPangkatTahun= $set_detil->getField("MASA_KERJA_TAHUN");
			$tempPangkatBulan= $set_detil->getField("MASA_KERJA_BULAN");
			unset($set_detil);

			if($infoinformasifield == "PANGKAT_INFO")
			{
				$inforeturn= $tempPangkatKode;
			}
		}
		else if($infojenispelayananid == "3")
		{
			if($infonomor == "7")
			{
				$inforeturn= $arrparam["infopernikahanpertamapnsnama"].", Status pernikahan sebelumnya : ".$arrparam["infopernikahanpertamastatusnama"];
			}
			else if($infonomor == "8")
			{
				$inforeturn= $arrparam["infopernikahanpertamapasanganstatusnama"].", Status pasangan saat ini : ".$arrparam["infopernikahanpasanganstatusnama"].", ".$arrparam["infopasangansaatinipnsnama"];
			}
			else if($infonomor == "9" || $infonomor == "11")
			{
				$statement= " AND A.SUAMI_ISTRI_ID = ".$arrparam["infosuamiistrisebelum"];
				$set_detil= new SuamiIstri();
				$set_detil->selectByParams(array(),-1,-1, $statement);
				$set_detil->firstRow();
				
				$inforeturn= " ".$set_detil->getField("NAMA");
			}
			else if($infonomor == "10" || $infonomor == "12")
			{
				$statement= " AND A.SUAMI_ISTRI_ID = ".$arrparam["infosuamiistrisekarang"];
				$set_detil= new SuamiIstri();
				$set_detil->selectByParams(array(),-1,-1, $statement);
				$set_detil->firstRow();
				
				$inforeturn= " ".$set_detil->getField("NAMA");
			}
		}


		return $inforeturn;

	}

	function simpansuamiistri($vpost, $reqPegawaiId)
	{
		// print_r($vpost);exit;
		// print_r($reqLinkFile);exit;

		$CI = &get_instance();
		$CI->load->model("SuamiIstri");

		$LOGIN_USER= $CI->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$LOGIN_LEVEL= $CI->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$LOGIN_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$LOGIN_PEGAWAI_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;

		if(!empty($vpost["reqSuamiIstriId"]))
		{
			foreach ($vpost["reqSuamiIstriId"] as $key => $value) {
				$reqSuamiIstriId= $vpost["reqSuamiIstriId"][$key];
				if(!empty($reqSuamiIstriId))
				{
					$reqSuamiIstriSuratNikah= $vpost["reqSuamiIstriSuratNikah"][$key];
					$reqSuamiIstriTanggalKawin= $vpost["reqSuamiIstriTanggalKawin"][$key];
					$reqSuamiIstriAktaNikahTanggal= $vpost["reqSuamiIstriAktaNikahTanggal"][$key];
					$reqSuamiIstriStatusHidup= $vpost["reqSuamiIstriStatusHidup"][$key];
					$reqSuamiIstriKematianNo= $vpost["reqSuamiIstriKematianNo"][$key];
					$reqSuamiIstriKematianTanggal= $vpost["reqSuamiIstriKematianTanggal"][$key];
					$reqSuamiIstriTanggalMeninggal= $vpost["reqSuamiIstriTanggalMeninggal"][$key];
					$reqSuamiIstriStatusSi= $vpost["reqSuamiIstriStatusSi"][$key];
					$reqSuamiIstriAktaNikahNo= $vpost["reqSuamiIstriAktaNikahNo"][$key];
					$reqSuamiIstriNikahTanggal= $vpost["reqSuamiIstriNikahTanggal"][$key];
					$reqSuamiIstriAktaCeraiNo= $vpost["reqSuamiIstriAktaCeraiNo"][$key];
					$reqSuamiIstriAktaCeraiTanggal= $vpost["reqSuamiIstriAktaCeraiTanggal"][$key];
					$reqSuamiIstriCeraiTanggal= $vpost["reqSuamiIstriCeraiTanggal"][$key];

					$set = new SuamiIstri();
					$set->setField("SURAT_NIKAH", $reqSuamiIstriSuratNikah);
					$set->setField("TANGGAL_KAWIN", dateToDBCheck($reqSuamiIstriTanggalKawin));
					$set->setField("AKTA_NIKAH_TANGGAL", dateToDBCheck($reqSuamiIstriAktaNikahTanggal));
					$set->setField("STATUS_AKTIF", $reqSuamiIstriStatusHidup);
					$set->setField("KEMATIAN_NO", $reqSuamiIstriKematianNo);
					$set->setField("KEMATIAN_TANGGAL", dateToDBCheck($reqSuamiIstriKematianTanggal));
					$set->setField("TANGGAL_MENINGGAL", dateToDBCheck($reqSuamiIstriTanggalMeninggal));
					$set->setField("STATUS_S_I", $reqSuamiIstriStatusSi);
					$set->setField("AKTA_NIKAH_NO", $reqSuamiIstriAktaNikahNo);
					$set->setField("NIKAH_TANGGAL", dateToDBCheck($reqSuamiIstriNikahTanggal));
					$set->setField("AKTA_CERAI_NO", $reqSuamiIstriAktaCeraiNo);
					$set->setField("AKTA_CERAI_TANGGAL", dateToDBCheck($reqSuamiIstriAktaCeraiTanggal));
					$set->setField("CERAI_TANGGAL", dateToDBCheck($reqSuamiIstriCeraiTanggal));
					$set->setField("LAST_LEVEL", $LOGIN_LEVEL);
					$set->setField("LAST_USER", $LOGIN_USER);
					$set->setField("USER_LOGIN_ID", $LOGIN_ID);
					$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($LOGIN_PEGAWAI_ID));
					$set->setField("LAST_DATE", "NOW()");

					$set->setField("SUAMI_ISTRI_ID",$reqSuamiIstriId);
					$set->updatepensiun();
					// echo $set->query;
				}
			}
		}
		
	}

	function simpananak($vpost, $reqPegawaiId)
	{
		// print_r($vpost);exit;
		// print_r($reqLinkFile);exit;

		$CI = &get_instance();
		$CI->load->model("Anak");

		$LOGIN_USER= $CI->kauth->getInstance()->getIdentity()->LOGIN_USER;
		$LOGIN_LEVEL= $CI->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$LOGIN_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_ID;
		$LOGIN_PEGAWAI_ID= $CI->kauth->getInstance()->getIdentity()->LOGIN_PEGAWAI_ID;

		if(!empty($vpost["reqAnakId"]))
		{
			foreach ($vpost["reqAnakId"] as $key => $value) {
				$reqAnakId= $vpost["reqAnakId"][$key];
				if(!empty($reqAnakId))
				{
					$reqAnakStatusKeluarga= $vpost["reqAnakStatusKeluarga"][$key];
					$reqAnakSuamiIstriId= $vpost["reqAnakSuamiIstriId"][$key];
					$reqAnakPendidikanId= $vpost["reqAnakPendidikanId"][$key];
					$reqAnakStatusLulus= $vpost["reqAnakStatusLulus"][$key];
					$reqAnakStatusBekerja= $vpost["reqAnakStatusBekerja"][$key];
					$reqAnakStatusAktif= $vpost["reqAnakStatusAktif"][$key];
					$reqAnakJenisKawinId= $vpost["reqAnakJenisKawinId"][$key];
					$reqAnakKematianNo= $vpost["reqAnakKematianNo"][$key];
					$reqAnakKematianTanggal= $vpost["reqAnakKematianTanggal"][$key];
					$reqAnakTanggalMeninggal= $vpost["reqAnakTanggalMeninggal"][$key];
					$reqAnakAktaNikahNo= $vpost["reqAnakAktaNikahNo"][$key];
					$reqAnakAktaNikahTanggal= $vpost["reqAnakAktaNikahTanggal"][$key];
					$reqAnakNikahTanggal= $vpost["reqAnakNikahTanggal"][$key];
					$reqAnakAktaCeraiNo= $vpost["reqAnakAktaCeraiNo"][$key];
					$reqAnakAktaCeraiTanggal= $vpost["reqAnakAktaCeraiTanggal"][$key];
					$reqAnakCeraiTanggal= $vpost["reqAnakCeraiTanggal"][$key];

					$set = new Anak();
					$set->setField("SUAMI_ISTRI_ID", ValToNullDB($reqAnakSuamiIstriId));
					$set->setField("PENDIDIKAN_ID", ValToNullDB($reqAnakPendidikanId));
					$set->setField("STATUS_LULUS", ValToNullDB($reqAnakStatusLulus));
					$set->setField("STATUS_BEKERJA", ValToNullDB($reqAnakStatusBekerja));
					$set->setField("STATUS_AKTIF", $reqAnakStatusAktif);
					$set->setField("JENIS_KAWIN_ID", ValToNullDB($reqAnakJenisKawinId));
					$set->setField("KEMATIAN_NO", $reqAnakKematianNo);
					$set->setField("KEMATIAN_TANGGAL", dateToDBCheck($reqAnakKematianTanggal));
					$set->setField("TANGGAL_MENINGGAL", dateToDBCheck($reqAnakTanggalMeninggal));
					$set->setField("AKTA_NIKAH_NO", $reqAnakAktaNikahNo);
					$set->setField("AKTA_NIKAH_TANGGAL", dateToDBCheck($reqAnakAktaNikahTanggal));
					$set->setField("NIKAH_TANGGAL", dateToDBCheck($reqAnakNikahTanggal));
					$set->setField("AKTA_CERAI_NO", $reqAnakAktaCeraiNo);
					$set->setField("AKTA_CERAI_TANGGAL", dateToDBCheck($reqAnakAktaCeraiTanggal));
					$set->setField("CERAI_TANGGAL", dateToDBCheck($reqAnakCeraiTanggal));
					$set->setField("LAST_LEVEL", $LOGIN_LEVEL);
					$set->setField("LAST_USER", $LOGIN_USER);
					$set->setField("USER_LOGIN_ID", $LOGIN_ID);
					$set->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($LOGIN_PEGAWAI_ID));
					$set->setField("LAST_DATE", "NOW()");

					$set->setField("ANAK_ID",$reqAnakId);
					$set->updatepensiun();
					// echo $set->query;
					
				}
			}
		}
	}

	function pensiuninfosuamiistri($arrparam)
	{
		$reqPegawaiId= $arrparam["reqPegawaiId"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawai");

		$arrreturn= [];
		$sOrder= " ORDER BY A.TANGGAL_KAWIN ";
		$statement= " AND (COALESCE(NULLIF(A.STATUS::TEXT, ''), NULL) IS NULL OR A.STATUS = '2') AND A.PEGAWAI_ID = ".$reqPegawaiId;
		$set= new SuratMasukPegawai();
		$set->selectByParamsSuamiIstri(array(), -1, -1, $statement, $sOrder);
		// echo $set->query;exit;
		while($set->nextRow())
		{
		  $arrdata= [];
		  $arrdata["ID"]= $set->getField("SUAMI_ISTRI_ID");
		  $arrdata["NAMA"]= $set->getField("NAMA");
		  $arrdata["STATUS_HIDUP"]= $set->getField("STATUS_AKTIF");
		  $arrdata["STATUS_KAWIN"]= $set->getField("STATUS_S_I");
		  $arrdata["KEMATIAN_NO"]= $set->getField("KEMATIAN_NO");
		  $arrdata["KEMATIAN_TANGGAL"]= dateToPageCheck($set->getField("KEMATIAN_TANGGAL"));
		  $arrdata["TANGGAL_MENINGGAL"]= dateToPageCheck($set->getField("TANGGAL_MENINGGAL"));
		  $arrdata["SURAT_NIKAH"]= $set->getField("SURAT_NIKAH");
		  $arrdata["AKTA_NIKAH_NO"]= $set->getField("AKTA_NIKAH_NO");
		  $arrdata["AKTA_NIKAH_TANGGAL"]= dateToPageCheck($set->getField("AKTA_NIKAH_TANGGAL"));
		  $arrdata["NIKAH_TANGGAL"]= dateToPageCheck($set->getField("NIKAH_TANGGAL"));
		  $arrdata["AKTA_CERAI_NO"]= $set->getField("AKTA_CERAI_NO");
		  $arrdata["AKTA_CERAI_TANGGAL"]= dateToPageCheck($set->getField("AKTA_CERAI_TANGGAL"));
		  $arrdata["CERAI_TANGGAL"]= dateToPageCheck($set->getField("CERAI_TANGGAL"));
		  array_push($arrreturn, $arrdata);
		}
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function pensiuninfoanak($arrparam)
	{
		$reqPegawaiId= $arrparam["reqPegawaiId"];
		$reqKategori= $arrparam["reqKategori"];

		$CI = &get_instance();
		$CI->load->model("persuratan/SuratMasukPegawai");

		$arrreturn= [];
		$sOrder= " ORDER BY A.TANGGAL_KAWIN ";
		$statement= " AND A.NOMOR <= 5";
		$set= new SuratMasukPegawai();
		$set->selectByParamsAnak($reqPegawaiId, $reqKategori, $statement);
		// echo $set->query;exit;

		while($set->nextRow())
		{
		  $arrdata= [];
		  $arrdata["ID"]= $set->getField("ANAK_ID");
		  $arrdata["NAMA"]= $set->getField("NAMA");
		  $arrdata["STATUS_AKTIF"]= $set->getField("STATUS_AKTIF");
		  $arrdata["STATUS_AKTIF_NAMA"]= $set->getField("ANAK_STATUS_HIDUP");
		  $arrdata["STATUS_KELUARGA"]= $set->getField("STATUS_KELUARGA");
		  $arrdata["STATUS_KELUARGA_NAMA"]= $set->getField("ANAK_STATUS_NAMA");
		  $arrdata["STATUS_BEKERJA"]= $set->getField("STATUS_BEKERJA");
		  $arrdata["STATUS_BEKERJA_NAMA"]= $set->getField("ANAK_STATUS_BEKERJA");
		  $arrdata["STATUS_LULUS"]= $set->getField("STATUS_LULUS");
		  $arrdata["STATUS_LULUS_NAMA"]= $set->getField("ANAK_STATUS_LULUS");
		  $arrdata["JENIS_KAWIN_ID"]= $set->getField("JENIS_KAWIN_ID");
		  $arrdata["JENIS_KAWIN_NAMA"]= $set->getField("JENIS_KAWIN_NAMA");
		  $arrdata["PENDIDIKAN_ID"]= $set->getField("PENDIDIKAN_ID");
		  $arrdata["PENDIDIKAN_NAMA"]= $set->getField("PENDIDIKAN_NAMA");
		  array_push($arrreturn, $arrdata);
		}
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function gettahunmundur($tahun, $tanpatahunsekarang=1, $batas=2)
	{
		$vreturn= "";
		for($i=$tahun-$tanpatahunsekarang; $i >= $tahun-$batas; $i--)
		{
			$vreturn= getconcatseparator($vreturn, $i);
		}
		return $vreturn;
	}

	function pilihpensiun()
	{
		$arrField= array(
		  array("id"=>"bup", "nama"=>"Pensiun BUP")
		  , array("id"=>"meninggal", "nama"=>"Pensiun Janda/Duda")
		  , array("id"=>"dini", "nama"=>"Pensiun APS(Dini)")
		  , array("id"=>"udzur", "nama"=>"Pensiun Udzur")
		);
		return $arrField;
	}

	function getinfofile($reqId, $statementriwayattable="")
	{
		$CI = &get_instance();
		$CI->load->model("PegawaiFile");

		$arrreturn= [];
		$statement= "";
		$set= new PegawaiFile();
		$set->selectByParamsFileInfo(array(), -1,-1, $statement, $reqId, "", $statementriwayattable);
		// echo $set->query;exit;

		while($set->nextRow())
		{
		  $arrdata= [];
		  $arrdata["ID_ROW"]= $set->getField("ID_ROW");
		  $arrdata["NAMA_ROW"]= $set->getField("NAMA_ROW");
		  array_push($arrreturn, $arrdata);
		}
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function getsessionuser()
	{
		$CI = &get_instance();

		$sessionloginlevel= $CI->kauth->getInstance()->getIdentity()->LOGIN_LEVEL;
		$sessionsatuankerja= $CI->kauth->getInstance()->getIdentity()->SATUAN_KERJA_ID;
		$sessionusergroup= $CI->kauth->getInstance()->getIdentity()->USER_GROUP;
		$sessionstatussatuankerjabkd= $CI->kauth->getInstance()->getIdentity()->STATUS_SATUAN_KERJA_BKD;
		$sessionaksesappsimpegid= $CI->kauth->getInstance()->getIdentity()->AKSES_APP_SIMPEG_ID;

		$arrreturn= [];
		$arrreturn["sessionloginlevel"]= $sessionloginlevel;
		$arrreturn["sessionsatuankerja"]= $sessionsatuankerja;
		$arrreturn["sessionusergroup"]= $sessionusergroup;
		$arrreturn["sessionstatussatuankerjabkd"]= $sessionstatussatuankerjabkd;
		$arrreturn["sessionaksesappsimpegid"]= $sessionaksesappsimpegid;
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function paramlinkdetil($arrparam)
	{
		$reqJenis= $arrparam["reqJenis"];

		$arrreturn= [];
		if($reqJenis == "3" || $reqJenis == "4" || $reqJenis == "7" || $reqJenis == "10")
		{
			$CI = &get_instance();
			$CI->load->model("Menu");

			$arrgetsessionuser= $this->getsessionuser();
			$sessionusergroup= $arrgetsessionuser["sessionusergroup"];
			$sessionstatussatuankerjabkd= $arrgetsessionuser["sessionstatussatuankerjabkd"];
			$sessionaksesappsimpegid= $arrgetsessionuser["sessionaksesappsimpegid"];

			// ambil data teknis
			if(isStrContain(strtoupper($sessionusergroup), "TEKNIS") == "1" || $sessionstatussatuankerjabkd == 1)
			{
				$arrreturn["linkdetil"]= "surat_masuk_teknis_add";
			}
			else
			{
				// teknis
				// --"160303"KARSU
				// --"160403"KARPEG
				// --"160504"PENSIUN

				// dinas
				// --"160301"KARSU
				// --"160401"KARPEG
				// --"160502"PENSIUN

				if($reqJenis == "3")
					$statement= " AND A.MENU_ID = '160301'";
				else if($reqJenis == "4")
					$statement= " AND A.MENU_ID = '160401'";
				else if($reqJenis == "7")
					$statement= " AND A.MENU_ID = '160502'";
				else if($reqJenis == "10")
					$statement= " AND A.MENU_ID = '150106'";

				$set= new Menu();
				$set->selectByParamsMenu(1, $sessionaksesappsimpegid, "AKSES_APP_SIMPEG", $statement." AND B.AKSES != 'D' AND A.STATUS IS NULL", "ORDER BY COALESCE(A.URUT, 999), A.MENU_ID");
				// echo $set->query;exit;
				$set->firstRow();
				$infomenuid= $set->getField("MENU_ID");
				// echo $infomenuid;exit;

				$linkdetil= "surat_masuk_upt_add";
				if(!empty($infomenuid))
					$linkdetil= "surat_masuk_bkd_add";

				$arrreturn["linkdetil"]= $linkdetil;

			}

			return $arrreturn;
		}
	}

	function paramlinksubdetil($arrparam)
	{
		$reqJenis= $arrparam["reqJenis"];
		$vlinkdetil= $arrparam["vlinkdetil"];
		$infostatuskembali= $arrparam["infostatuskembali"];

		if(!empty($vlinkdetil))
		{
			$arrgetsessionuser= $this->getsessionuser();
			$sessionusergroup= $arrgetsessionuser["sessionusergroup"];
			$sessionstatussatuankerjabkd= $arrgetsessionuser["sessionstatussatuankerjabkd"];
			$sessionaksesappsimpegid= $arrgetsessionuser["sessionaksesappsimpegid"];

			// ambil data teknis
			if(isStrContain(strtoupper($sessionusergroup), "TEKNIS") == "1" || $sessionstatussatuankerjabkd == 1)
			{
				if($reqJenis == 3)
					$vreturn= "surat_masuk_teknis_add_verifikasi_karsu";
				else if($reqJenis == 4)
					$vreturn= "surat_masuk_teknis_add_verifikasi_karpeg";
				else if($reqJenis == 7)
					$vreturn= "surat_masuk_teknis_add_verifikasi_pensiun";
				else if($reqJenis == 10)
					$vreturn= "surat_masuk_teknis_add_verifikasi_kenaikan_pangkat";
			}
			else
			{
				if($vlinkdetil == "surat_masuk_upt_add")
				{
					if(empty($infostatuskembali))
					{
						if($reqJenis == 3)
							$vreturn= "surat_masuk_upt_add_pegawai_lookup_verfikasi_karsu";
						else if($reqJenis == 4)
							$vreturn= "surat_masuk_upt_add_pegawai_lookup_verfikasi_karpeg";
						else if($reqJenis == 7)
							$vreturn= "surat_masuk_upt_add_pegawai_lookup_verfikasi_pensiun";
						else if($reqJenis == 10)
							$vreturn= "surat_masuk_upt_add_pegawai_lookup_verfikasi_kenaikan_pangkat";
					}
					else
					{
						if($reqJenis == 3)
							$vreturn= "surat_masuk_upt_add_pegawai_verfikasi_karsu";
						else if($reqJenis == 4)
							$vreturn= "surat_masuk_upt_add_pegawai_verfikasi_karpeg";
						else if($reqJenis == 7)
							$vreturn= "surat_masuk_upt_add_pegawai_verfikasi_pensiun";
						else if($reqJenis == 10)
							$vreturn= "surat_masuk_upt_add_pegawai_verfikasi_kenaikan_pangkat";
					}
				}
				else
				{
					if(empty($infostatuskembali))
					{
						if($reqJenis == 3)
							$vreturn= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_karsu";
						else if($reqJenis == 4)
							$vreturn= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_karpeg";
						else if($reqJenis == 7)
							$vreturn= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_pensiun";
						else if($reqJenis == 10)
							$vreturn= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_kenaikan_pangkat";
					}
					else
					{
						if($reqJenis == 3)
							$vreturn= "surat_masuk_bkd_add_pegawai_verfikasi_karsu";
						else if($reqJenis == 4)
							$vreturn= "surat_masuk_bkd_add_pegawai_verfikasi_karpeg";
						else if($reqJenis == 7)
							$vreturn= "surat_masuk_bkd_add_pegawai_verfikasi_pensiun";
						else if($reqJenis == 10)
							$vreturn= "surat_masuk_bkd_add_pegawai_verfikasi_kenaikan_pangkat";
					}
				}
			}
		}

		return $vreturn;
	}

	function paramsatuankerja($arrparam)
	{
		$reqSatuanKerjaId= $arrparam["reqSatuanKerjaId"];
		$reqAlias= $arrparam["reqAlias"];

		if(empty($reqAlias))
			$reqAlias= "A.";

		$CI = &get_instance();
		$CI->load->model("SatuanKerja");

		$arrgetsessionuser= $this->getsessionuser();
		$sessionsatuankerja= $arrgetsessionuser["sessionsatuankerja"];
		$sessionusergroup= $arrgetsessionuser["sessionusergroup"];
		$sessionstatussatuankerjabkd= $arrgetsessionuser["sessionstatussatuankerjabkd"];

		if($reqSatuanKerjaId == "")
		{
			$tempSatuanKerjaId= $reqSatuanKerjaId= $sessionsatuankerja;
		}

		$statementAktif= "";
		if($reqSatuanKerjaId == "")
		{
			if(isStrContain(strtoupper($sessionusergroup), "TEKNIS") == "1" || $sessionstatussatuankerjabkd == 1)
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
			
			if(isStrContain(strtoupper($sessionusergroup), "TEKNIS") == "1" || $sessionstatussatuankerjabkd == 1)
			{
				if(isStrContain(strtoupper($sessionusergroup), "TEKNIS") == "1" && $reqSatuanKerjaTeknisId == ""){}
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
				$skerja= new SatuanKerja();
				$reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
				unset($skerja);
				$statement= " AND A.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
			}
		}
		// echo $statement;exit;

		return $statement;
	}

	function pilihstatussuratmasukpegawai()
	{
		$arrField= array(
		  array("id"=>"", "nama"=>"SEMUA")
		  , array("id"=>"1", "nama"=>"TURUN STATUS")
		  , array("id"=>"2", "nama"=>"KIRIM")
		  , array("id"=>"3", "nama"=>"DI TERIMA BKPSDM")
		  , array("id"=>"4", "nama"=>"TERVERIFIKASI")
		  , array("id"=>"9", "nama"=>"PEMBATALAN")
		  , array("id"=>"-1", "nama"=>"LAIN-LAIN")
		);
		return $arrField;
	}

	function enkripdekripkunci()
	{
		return "KuNc1";
	}

	function enkripdata($arrparam)
	{
		$reqdata= urldecode($arrparam["reqdata"]);
		$reqkunci= urldecode($arrparam["reqkunci"]);

		return mencrypt($reqdata, $reqkunci);
	}

	function dekripdata($arrparam)
	{
		$reqdata= urldecode($arrparam["reqdata"]);
		$reqkunci= urldecode($arrparam["reqkunci"]);

		return mdecrypt($reqdata, $reqkunci);
	}

	function checkfilepdfversi($filecheck)
	{
		$filepdf = fopen($filecheck,"r");
		if($filepdf) {
		  $line_first = fgets($filepdf);
		  fclose($filepdf);
		}
		else{
		  echo "error opening the file.";
		}

		preg_match_all('!\d+!', $line_first, $matches);
		       
		// save that number in a variable
		$pdfversion= implode('.', $matches[0]);

		return $pdfversion;
	}

	function gsfilepdf($direktori, $vfile)
	{
		$vexe= explode(".", $vfile);
		$namafile= $vexe[0];
		$exefile= $vexe[1];

		$srcfile= $direktori.$namafile.".".$exefile;
		if(file_exists($srcfile))
		{
			$srcfilenew= $direktori.$namafile."-versi.".$exefile;
			// echo $srcfile;exit;
			$pdfversion= $this->checkfilepdfversi($srcfile);
			// echo $pdfversion;exit;

			if($pdfversion >= 1.3)
			{
			    // kalau ada file versi maka tidak perlu buat kembali
			    if(file_exists($srcfilenew))
			    {
			    	return $srcfilenew;
			    }

			    shell_exec('gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile="'.$srcfilenew.'" "'.$srcfile.'"');

			    $endfile= "";
			    $nfile= "x";
			    if(file_exists($srcfilenew))
			    {
				    $validasifile= file($srcfilenew);
				    $endfile= trim($validasifile[count($validasifile) - 1]);
				    $nfile="%%EOF";
				}

			    // kalau tidak cocok, maka kembalikan file asli
			    if ($endfile === $nfile) 
			    {
			    	return $srcfilenew;
			      	// echo "good";
			    }
			    else
			    {
			    	return $srcfile;
			      	// echo "corrupted";
			    }
			}
			else
			{
				return $srcfile;
			}
		}
		else
		{
			return $srcfile;
		}
	}

	// bug
	/*if(!empty($reqLinkFile))
	{
		foreach ($reqDokumenTipe as $key => $value) {

			if($reqDokumenPilih[$key] == "2" || empty($reqDokumenPilih[$key]))
				continue;

			if($value == "1")
			{
				$infokecualifile= "jpg";
				$arrkecualifile= array("jpg", "jpg");
			}
			else
			{
				$infokecualifile= "pdf";
				$arrkecualifile= array("pdf");
			}

			// Allow certain file formats
			$bolehupload = "";
			$fileuploadexe= strtolower(getExtension($reqLinkFile['name'][$key]));

			if(!empty($fileuploadexe))
			{
				$filesize= $reqLinkFile['size'][$key];
				if (($filesize > 2097152))
				{
					echo "xxx-Data gagal disimpan, check file upload harus di bawah 2 MB.";
					exit();
				}

				if($fileuploadexe == "")
				{
					$bolehupload = 1;
				}
				else
				{
					
					if(in_array($fileuploadexe, $arrkecualifile))
						$bolehupload = 1;
				}

				if($bolehupload == "")
				{
					echo "xxx-Data gagal disimpan, check file upload harus format ".$infokecualifile.".";
					exit();
				}
			}
			else
			{
				echo "xxx-Data gagal disimpan, upload file scan baru harus diisi";
				exit();
			}
		}
	}*/

}