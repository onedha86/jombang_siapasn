<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/encrypt.func.php");

class globalvalidasifilepegawai
{
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

	function tipekondisikategori()
	{
		$arrField= [];
		$arrField["1"]= $this->kondisikategori("1");
		$arrField["else"]= $this->kondisikategori("else");
		return $arrField;
	}

	function setriwayatfield($riwayattable, $kategorifileid="")
	{
		$CI = &get_instance();
		$CI->load->model("base-api/PegawaiNewFile");

		$vreturn= [];
		if($riwayattable == "ANAK")
		{
			// $arrvalid= ["foto", "aktakelahiran"];
			$arrvalid= ["aktakelahiran"];
			$set= new PegawaiNewFile();
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

			$set= new PegawaiNewFile();
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
				$set= new PegawaiNewFile();

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
			$set= new PegawaiNewFile();
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
			$set= new PegawaiNewFile();
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
			$set= new PegawaiNewFile();

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

	function listpilihfile_sebelum_pegawai($reqId, $riwayattable, $reqRowId, $suratmasukpegawaiid="", $paramriwayatfield="", $infodetilparam=[])
	{
		if($reqRowId == "baru")
		{
			$reqRowId= -1;	
		}

		// $addlink= "../";
		$addlookuplink= "../";
		$addusulanlink= "../";

		$reqTempValidasiId= "";
		if(!empty($infodetilparam))
		{
			$reqTempValidasiId= $infodetilparam[0]["reqTempValidasiId"];
		}
		// echo $reqTempValidasiId;exit;

		$CI = &get_instance();
		$CI->load->model("base-api/PegawaiNewFile");

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
					if(!empty($vdetil))
						$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
					$vdetil= $v["ID_IBU"];
					if(!empty($vdetil))
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
								if(!empty($vdetil))
									$vriwayatid= getconcatseparator($vriwayatid, $vdetil);
								$vdetil= $v["ID_IBU"];
								if(!empty($vdetil))
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
		$setfile= new PegawaiNewFile();
		$setfile->selectByParamsFile(array(), -1,-1, $statement, $reqId, $sorderfile);
		// echo $setfile->query;exit;

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


			// khusus orang tua
			if(!empty($infodetilparam))
			{
				$checkDokumenFileRiwayatField= explode("-", $vdatainforiwayatfield);
				$checkDokumenFileRiwayatField= $checkDokumenFileRiwayatField[0];

				if($checkDokumenFileRiwayatField == "L")
				{
					$vidayah= $infodetilparam[0]["ID_AYAH"];
					$vidibu= $infodetilparam[0]["ID_IBU"];
					if(!empty($vidayah))
						$reqRowId= $vidayah;
				}
				else if($checkDokumenFileRiwayatField == "P")
				{
					$vidayah= $infodetilparam[0]["ID_AYAH"];
					$vidibu= $infodetilparam[0]["ID_IBU"];
					if(!empty($vidibu))
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
				$arrdata["vurl"]= $addlookuplink.$reqDokumenFilePath;
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
			}
		}
		$arrcheckpilih= $arrpilihfile;
		// print_r($arrcheckpilih);exit;

		// echo $lokasi_link_file;exit;
		$ambil_data_file= lihatfiledirektori($addlookuplink.$lokasi_link_file);
		// print_r($ambil_data_file);exit;

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
		$set= new PegawaiNewFile();
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
			$infopath= $addlookuplink.$set->getField("PATH");

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

		}

		$arrreturn["riwayat"]= $arrriwayatfile;
		$arrreturn["pilihfile"]= $arrpilihfile;
		// print_r($arrreturn);exit;

		return $arrreturn;
	}

	function getsettingurlupload()
	{
		$CI = &get_instance();
		$configdata= $CI->config;
        $settingurlupload= $configdata->config["settingurlupload"];
        return $settingurlupload;
	}

	function listpilihfilepegawai($reqId, $riwayattable, $reqRowId, $suratmasukpegawaiid="", $paramriwayatfield="", $infodetilparam=[])
	{
		$reqTempValidasiId= -1;
		if($reqRowId == "baru")
		{
			$reqRowId= -1;
			$reqTempValidasiId= $infodetilparam[0]["reqTempValidasiId"];
		}

		$addlookuplink= "../";
		$addusulanlink= "../";

		$CI = &get_instance();
        $settingurlupload= $this->getsettingurlupload();

		$CI->load->model("base-api/PegawaiNewFile");

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
			if($reqRowId == -1){}
			else
			{
				$statement= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
			}
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
			{
				if($reqRowId == -1)
				{
					$statement.= " 
					AND 
					(
						(
							A.RIWAYAT_TABLE = '".$riwayattable."' AND TEMP_VALIDASI_BELUM_ID = ".$reqTempValidasiId."
						)
						OR
						(
							TEMP_VALIDASI_BELUM_ID = ".$reqTempValidasiId."
						)
					)
					";
				}
				else
					$statement.= " AND A.RIWAYAT_ID = ".$reqRowId;
			}
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
						if($reqRowId == -1){}
						else
						{
							$statement.= " AND A.RIWAYAT_TABLE = '".$riwayattable."'";
						}
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
						{
							if($reqRowId == -1)
							{
								$statement.= " 
								AND 
								(
									(
										A.RIWAYAT_TABLE = '".$riwayattable."' AND TEMP_VALIDASI_BELUM_ID = ".$reqTempValidasiId."
									)
									OR
									(
										TEMP_VALIDASI_BELUM_ID = ".$reqTempValidasiId."
									)
								)
								";
							}
							else
								$statement.= " AND RIWAYAT_ID = ".$reqRowId;
						}
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

		$setfile= new PegawaiNewFile();
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
					// $arrdata["vurl"]= $reqDokumenFilePath;
					$arrdata["vurl"]= $settingurlupload.$reqDokumenFilePath;
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
		
		// $ambil_data_file= lihatfiledirektori($lokasi_link_file);
		// echo $settingurlupload.$lokasi_link_file;exit;
		$ambil_data_file= lihatfiledirektori($settingurlupload.$lokasi_link_file);
		// print_r($ambil_data_file);exit;

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
		$set= new PegawaiNewFile();
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
			// $infopath= $set->getField("PATH");
			$infopath= $settingurlupload.$set->getField("PATH");

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

			// tambahan cek data
			if($riwayattable !== $vinforiwayattable && !empty($vinforiwayattable))
			{
				continue;
			}


			if($riwayattable == $vinforiwayattable)
			{
				/*if($reqRowId == $vinforiwayatid){}
				else
					continue;*/
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

		}

		if($reqId == "383")
		{
			// print_r($arrpilihfile);exit;
		}
		// print_r($arrpilihfile);exit;

		$arrreturn["riwayat"]= $arrriwayatfile;
		$arrreturn["pilihfile"]= $arrpilihfile;
		// print_r($arrreturn);exit;

		return $arrreturn;
	}

	function simpanfilepegawai($vpost, $reqLinkFile, $arrparam=[])
	{
		$reqTempValidasiId= $arrparam["reqTempValidasiId"];
		// echo $reqTempValidasiId;exit;
		// kalau multi
		if(is_array($vpost["reqDokumenPilih"]))
		{
		}
		else if(!empty($reqTempValidasiId))
		{
			$reqPegawaiId= $arrparam["reqPegawaiId"];
			$vpostparam= [];
			$vlinkfile= $reqLinkFile;
			$vpostparam["reqDokumenPilih"]= $vpost["reqDokumenPilih"];
			$vpostparam["reqId"]= $reqPegawaiId;
			$vpostparam["reqTempValidasiId"]= $reqTempValidasiId;
			$vpostparam["reqDokumenKategoriFileId"]= $vpost["reqDokumenKategoriFileId"];
			$vpostparam["reqDokumenPath"]= $vpost["reqDokumenPath"];
			$vpostparam["reqDokumenFileId"]= $vpost["reqDokumenFileId"];
			$vpostparam["reqDokumenFileKualitasId"]= $vpost["reqDokumenFileKualitasId"];
			$vpostparam["indexfile"]= "";
			$vpostparam["reqDokumenKategoriField"]= $vpost["reqDokumenKategoriField"];
			// print_r($vpostparam);exit;

			$reqRowId= $arrparam["reqRowId"];
			$arrparamdetil= ["reqRowId"=>$reqRowId];
			$this->simpanfilepegawaidb($vpostparam, $vlinkfile, $arrparamdetil);
		}
	}

	function simpanfilepegawaidb($vpost, $reqLinkFile, $arrparam=[])
	{
		$CI = &get_instance();
		$CI->load->model("base-api/PegawaiNewFile");

		// print_r($vpost);exit;

		$reqDokumenPilih= $vpost["reqDokumenPilih"];
		$reqId= $vpost["reqId"];
		// $reqRowId= $vpost["reqRowId"];
		$reqDokumenKategoriFileId= $vpost["reqDokumenKategoriFileId"];
		$reqDokumenPath= $vpost["reqDokumenPath"];
		$indexfile= $vpost["indexfile"];
		$reqDokumenKategoriField= $vpost["reqDokumenKategoriField"];
		$reqDokumenFileRiwayatTable= $vpost["reqDokumenFileRiwayatTable"];
		$reqTempValidasiId= $vpost["reqTempValidasiId"];

		$reqRowId= $arrparam["reqRowId"];

		if(!empty($reqDokumenPilih))
		{
			// print_r($reqLinkFile);exit;
			if (is_numeric($indexfile))
			{
				$fileuploadexe= strtolower(getExtension($reqLinkFile['name'][$indexfile]));
				// $fileuploadexe= strtolower(getExtension($reqLinkFile[$indexfile]['postname']));
			}
			else
			{
				$fileuploadexe= strtolower(getExtension($reqLinkFile['name']));
				// $fileuploadexe= "xxx";
			}
			// echo $fileuploadexe;exit;

			$lihatquery= "";

			$statement= " AND A.PEGAWAI_ID = ".$reqId." AND NO_URUT = ".$reqDokumenKategoriFileId;

			if(!empty($reqRowId))
			{
				$statement.= " AND A.RIWAYAT_ID = '".$reqRowId."'";
			}

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

			$setfile= new PegawaiNewFile();
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

			if(!empty($reqTempValidasiId) && empty($reqRowId))
			{
				$ambilriwayatfield= "2";
				$reqRiwayatId= "";
			}

			// kalau sama baru proses simpan
			if($reqRiwayatId == $reqRowId || $ambilriwayatfield == "1" || $ambilriwayatfield == "2")
			{
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

				$setfile= new PegawaiNewFile();
				$setfile->setField("PEGAWAI_ID", $reqId);
				$setfile->setField("RIWAYAT_TABLE", $reqRiwayatTable);
				$setfile->setField("RIWAYAT_FIELD", $reqRiwayatField);
				$setfile->setField("FILE_KUALITAS_ID", ValToNullDB($reqKualitasFileId));
				$setfile->setField("KATEGORI_FILE_ID", $reqKategoriFileId);
				$setfile->setField("RIWAYAT_ID", ValToNullDB($reqRiwayatId));
				$setfile->setField("LAST_LEVEL", ValToNullDB($LOGIN_LEVEL));
				$setfile->setField("LAST_USER", $LOGIN_USER);
				$setfile->setField("USER_LOGIN_ID", ValToNullDB($LOGIN_ID));
				$setfile->setField("USER_LOGIN_PEGAWAI_ID", ValToNullDB($LOGIN_PEGAWAI_ID));
				$setfile->setField("LAST_DATE", "NOW()");
				$setfile->setField("TEMP_VALIDASI_BELUM_ID", $reqTempValidasiId);

				$setfile->setField("IPCLIENT", sfgetipaddress());
				$setfile->setField("MACADDRESS", sfgetmac());
				$setfile->setField("NAMACLIENT", getHostName());
				$setfile->setField("PRIORITAS", $reqPrioritas);

				$setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);

				$settingurlupload= $this->getsettingurlupload();
				$target_dir= $settingurlupload."uploads/".$reqId."/";
				// echo $target_dir;exit;
				if(file_exists($target_dir)){}
				else
				{
					makedirs($target_dir);
				}

				// echo $reqDokumenPilih;exit;
				if($reqDokumenPilih == "1")
				{
					if (is_numeric($indexfile))
					{
						$fileName= basename($_FILES["reqLinkFile"]["name"][$indexfile]);
						// $fileName= basename($reqLinkFile[$indexfile]['postname']);
					}
					else
					{
						$fileName= basename($_FILES["reqLinkFile"]["name"]);
					}
					// echo $fileName;exit;

					// $reqLinkFile["tmp_name"]
					$fileNameInfo = substr($fileName, 0, strpos($fileName, "."));
					$file_name= preg_replace( '/[^a-zA-Z0-9_]+/', '_', $fileNameInfo);

					if (is_numeric($indexfile))
					{
						$infoext= pathinfo($_FILES['reqLinkFile']['name'][$indexfile]);
						// $infoext= pathinfo($reqLinkFile[$indexfile]['postname']);
					}
					else
					{
						$infoext= pathinfo($_FILES['reqLinkFile']['name']);
					}
					$ext= $infoext['extension'];

					$target_file_asli= $file_name;
					$namagenerate =generateRandomString().".".$ext;
					$target_file_generate= $target_dir.$namagenerate; 
					// echo $target_file_generate;exit;

					$settingurlupload= $this->getsettingurlupload();

					$setfile->setField('PATH', str_replace($settingurlupload, "", $target_file_generate));
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
					// echo $simpanfile."xxx".$target_file_generate;exit;
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
					if(empty($reqDokumenFileId))
					{
						echo "A";exit;
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
						$setfiledetil= new PegawaiNewFile();
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

	function ambilfilemode($arrinfo, $keymode, $keytable="", $inforowid="", $infodetilparam=[])
	{
		$arrreturn= [];
		$arrcheck= [];

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
			}
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
					if(!empty($vidayah))
						$inforowid= $vidayah;
				}
				else if($checkDokumenFileRiwayatField == "P")
				{
					$vidayah= $infodetilparam[0]["ID_AYAH"];
					$vidibu= $infodetilparam[0]["ID_IBU"];
					if(!empty($vidibu))
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

				$arrdata= [];
				$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
				$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
				$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
				$arrdata["id"]= $arrinfo[$vindex]["id"];
				$arrdata["index"]= "v".count($arrreturn);
				$arrdata["selected"]= $arrinfo[$vindex]["selected"];
				$arrdata["nama"]= $arrinfo[$vindex]["nama"];
				$arrdata["vurl"]= $arrinfo[$vindex]["vurl"];
				// $arrdata["vurlblob"]= base64_encode(file_get_contents($arrinfo[$vindex]["vurl"]));
				$arrdata["vurlblob"]= "";
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

						$arrdata= [];
						$arrdata["KEY"]= $arrinfo[$vindex]["KEY"];
						$arrdata["KEYINFO"]= $arrinfo[$vindex]["KEYINFO"];
						$arrdata["KEYMODE"]= $arrinfo[$vindex]["KEYMODE"];
						$arrdata["id"]= $arrinfo[$vindex]["id"];
						$arrdata["index"]= "v".count($arrreturn);
						$arrdata["selected"]= $infoselected;
						$arrdata["nama"]= $arrinfo[$vindex]["nama"];
						$arrdata["vurl"]= $vinforowurl;
						// $arrdata["vurlblob"]= base64_encode(file_get_contents($vinforowurl));
						$arrdata["vurlblob"]= "";
						$arrdata["ext"]= strtolower($arrinfo[$vindex]["ext"]);
						$arrdata["filekualitasid"]= $arrinfo[$vindex]["filekualitasid"];
						$arrdata["inforiwayatid"]= $arrinfo[$vindex]["inforiwayatid"];
						$arrdata["inforiwayatfield"]= $arrinfo[$vindex]["inforiwayatfield"];
						$arrdata["infotable"]= $arrinfo[$vindex]["infotable"];
						array_push($arrreturn, $arrdata);
						// echo $vindex;exit;
					}

				}
			}	
		}
		// $arrcheck= in_array_column($infocarikey, "KEYINFO", $arrinfo);
		// print_r($arrreturn);exit;
		return $arrreturn;
	}

	function getinfofile($reqId, $statementriwayattable="")
	{
		$CI = &get_instance();
		$CI->load->model("base-api/PegawaiNewFile");

		$arrreturn= [];
		$statement= "";
		$set= new PegawaiNewFile();
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

	function settingpegawaifile()
	{
		$CI = &get_instance();
		$CI->load->model("base-api/PegawaiNewFile");
		// $USER_LOGIN_ID= $CI->kauth->getInstance()->getIdentity()->USER_LOGIN_ID;
		// echo $USER_LOGIN_ID;exit;

		$vreturn= [];
		$set= new PegawaiNewFile();
		$set->selectfileuser(array(), -1,-1, "", " ");
		// AND B1.STATUS = '1'
		// echo $set->query;exit;
		// echo $set->errorMsg;exit;
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
		// print_r($vreturn);exit;
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
			// $infofilenama= $reqLinkFile['name'][$key];

			$infofilenama= "";
			if(!empty($reqLinkFile))
			{
				$infofilenama= $reqLinkFile[$key]['postname'];
			}
			// echo $reqDokumenPilih."--".$infofilenama."--".$reqDokumenRequiredTable."--".$reqDokumenRequiredNama;exit;

			// [name] => C:\wamp\tmp\phpB581.tmp
			// [mime] => application/octet-stream
			// [postname] => .htaccess

			$kondisilewati= "";

			// kalau user option file
			/*if(!empty($reqDokumenRequiredTable))
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
			}*/

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

}