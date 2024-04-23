<?php
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
include_once("lib/phpqrcode/qrlib.php");
include_once("functions/string.func.php");
include_once("functions/date.func.php");
require_once('vendor/autoload.php');

use mikehaertl\wkhtmlto\Pdf;

class ReportPDF
{
	var $reqId;
	var $reqTemplate;
	var $reqJenisReport;
	// function generate($reqId, $reqLink, $="",$reqBulan="",$reqTahun="",$reqJenisKgb="",$reqPegawaiId="")
	function generate($arrparam)
	{
		// print_r($reqTemplate);exit;
		$reqId= $arrparam["reqId"];
		$reqLink= $arrparam["reqLink"];
		$reqJenis= $arrparam["reqJenis"];
		$reqBulan= $arrparam["reqBulan"];
		$reqTahun= $arrparam["reqTahun"];
		$reqJenisKgb= $arrparam["reqJenisKgb"];
		$reqPegawaiId= $arrparam["reqPegawaiId"];
		$reqSatuanKerjaId= $arrparam["reqSatuanKerjaId"];
		
		$CI = &get_instance();

		$basereport= $CI->config->item('base_url');
		$urllink=  $basereport."app/loadUrl/app/".$reqLink."/?reqJenis=".$reqJenis."&reqBulan=".$reqBulan."&reqTahun=".$reqTahun."&reqJenisKgb=".$reqJenisKgb."&reqPegawaiId=".$reqPegawaiId."&reqSatuanKerjaId=".$reqSatuanKerjaId."";

		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);

		$html.= file_get_contents($urllink, false, stream_context_create($arrContextOptions));
		// var_dump($urllink) ;exit;


		$wkhtmltopdf = new PDF($html);
		$wkhtmltopdf->setOptions(
		    array(
		        "javascript-delay" => 1000
		        // , "margin-left"=> 25
		        // , "margin-right"=> 25
		        // , "margin-top"=> 10
		        , "margin-bottom"=> 20
				, "page-width" => '215'
				, "page-height" => '330'
		    )
		);

		if (!$wkhtmltopdf->send()) {
		    $error = $wkhtmltopdf->getError();
		    // ... handle error here
		    echo $error;
		}
		exit;
	}

	function generatenew($reqId, $reqTemplate, $reqJenisReport = "")
	{
		$this->reqId = $reqId;
		$this->reqTemplate = $reqTemplate;
		$this->reqJenisReport = $reqJenisReport;

		$FILE_DIR_TEMPLATE = "uploads/";
		$FILE_DIR 		   = "uploads/" . $this->reqId . "/";

		if (!file_exists($FILE_DIR)) {
			// mkdir($FILE_DIR, 0777, true);
			makedirs($FILE_DIR, 0777, true);
		}

		$CI = &get_instance();
		// $CI->load->library("suratmasukinfo");
		// $suratmasukinfo = new suratmasukinfo();
		// $suratmasukinfo->getInfo($this->reqId);

		flush();
  		ob_flush();

		if ($this->reqJenisReport == "")
			$template = $this->reqTemplate;
		else
			$template = $this->reqJenisReport;

		// echo $template; exit;

		$basereport= $CI->config->item('base_report');
		$urllink=  $basereport."report/loadUrl/report/".$template."/?reqJenisSurat=INTERNAL&reqId=" .$this->reqId;
		// echo $basereport."report/loadUrl/report/".$template."/?reqJenisSurat=INTERNAL&reqId=" .$this->reqId; exit;

		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);

		$html.= file_get_contents($urllink, false, stream_context_create($arrContextOptions));
		// echo $html;exit;
		// echo base_url()."bg_cetak.jpg";

		$wkhtmltopdf = new PDF($html);
		$wkhtmltopdf->setOptions(
		   array(
		   	'page-width'     => '210mm',
    		'page-height'     => '297mm',      
	      	// 'background-image' => base_url().'bg_cetak.jpg',
	      	'header-html' => base_url().'report/loadUrl/report/header',
	      	'footer-html' => base_url().'report/loadUrl/report/footer',
		    )
		);

		// $saveAs= (generateZero($suratmasukinfo->SURAT_MASUK_ID, 6) . generateZero($suratmasukinfo->SATUAN_KERJA_ID_ASAL, 6)).".pdf";
		$saveAs= $reqTemplate.".pdf";
		// echo base_url().$FILE_DIR.$saveAs;exit;
		// unlink($FILE_DIR.$saveAs);
		// exit;
		$wkhtmltopdf->saveAs($FILE_DIR.$saveAs);
		// exit;

		if (!$wkhtmltopdf->saveAs($FILE_DIR.$saveAs)) {
		    $error = $wkhtmltopdf->getError();
		    // ... handle error here
		    echo $error;
		}

		// if ($suratmasukinfo->NOMOR == "" || $suratmasukinfo->TTD_KODE == "" || $suratmasukinfo->JENIS_TTD == "BASAH") {
		// } else {
		// 	$CI = &get_instance();
		// 	$CI->load->model("SuratMasuk");
		// 	$surat_masuk = new SuratMasuk();

		// 	$surat_masuk->setField("FIELD", "SURAT_PDF");
		// 	$surat_masuk->setField("FIELD_VALUE", $saveAs);
		// 	$surat_masuk->setField("LAST_UPDATE_USER", "SYSTEM");
		// 	$surat_masuk->setField("SURAT_MASUK_ID", $this->reqId);
		// 	$surat_masuk->updateByField();
		// }

		return $saveAs;
		exit;
	}

	function generatecuti($arrparam)
	{
		$CI = &get_instance();

		$reqPassphrase= $arrparam["reqPassphrase"];
		if($reqPassphrase == "oneresetdata"){}
		else
		{
			$ses_userloginid= $CI->kauth->getInstance()->getIdentity()->USER_LOGIN_ID;
			if(empty($ses_userloginid))
			{
				exit;
			}
		}

		$CI->load->model("base-cuti/CutiUsulan");

		$reqId= $arrparam["reqId"];
		$cekquery= $arrparam["c"];
		// $this->reqTemplate = $reqTemplate;
		// $this->reqJenisReport = $reqJenisReport;

		$FILE_DIR= "uploads/cuti/".$reqId."/";

		if (!file_exists($FILE_DIR)) {
			makedirs($FILE_DIR, 0777, true);
		}

		flush();
  		ob_flush();

  		$statement= " AND A.CUTI_USULAN_ID = ".$reqId;
  		$set= new CutiUsulan();
  		$set->selectByParams(array(), -1,-1, $statement);
  		$set->firstRow();
  		// echo $set->query;exit;
  		$reqJenisCutiId= $set->getField("JENIS_CUTI_ID");
  		$reqJenisCutiDetailId= $set->getField("JENIS_CUTI_DETAIL_ID");
  		$vtte= $set->getField("VALID_TTE");
  		$reqPegawaiPenandaTanganId= $set->getField("MENU_PENANDA_TANGAN_ID");
  		// echo $reqJenisCutiId;exit;

  		if(empty($vtte))
  		{
	  		$template= "";
	  		if($reqJenisCutiId == 1)
	  		{
				$template="surat_izin_cuti_tahunan";
	  		}
	  		else if($reqJenisCutiId == 3)
	  		{
	  			$template="surat_izin_cuti_sakit";
	  		}
	  		else if($reqJenisCutiId == 4)
	  		{
	  			$template="surat_izin_cuti_melahirkan";
	  		}
	  		else if($reqJenisCutiId == 5)
	  		{
	  			$template="surat_izin_cuti_alasan_penting";
	  		}

	  		if(empty($template))
	  		{
		  		echo "Template surat belum dibuat.";
		  		exit;
	  		}
			// echo $template; exit;

			$basereport= $CI->config->item('base_report');
			$urllink=  $basereport."report/loadUrl/report/".$template."/?reqId=".$reqId;

			if($cekquery == "url")
			{
				echo $urllink;exit;
			}

			$arrContextOptions=array(
				"ssl"=>array(
					"verify_peer"=>false,
					"verify_peer_name"=>false,
				),
			);

			$html.= file_get_contents($urllink, false, stream_context_create($arrContextOptions));
			// echo $html;exit;

			$wkhtmltopdf = new PDF($html);
			$wkhtmltopdf->setOptions(
			   array(
			   	'page-width'     => '210mm',
	    		'page-height'     => '297mm',      
		      	// 'background-image' => base_url().'bg_cetak.jpg',
		      	'header-html' => base_url().'report/loadUrl/report/header?reqPegawaiPenandaTanganId='.$reqPegawaiPenandaTanganId,
		      	'footer-html' => base_url().'report/loadUrl/report/footer?reqPegawaiPenandaTanganId='.$reqPegawaiPenandaTanganId,
			    )
			);

			$saveAs= "draft.pdf";
			if(file_exists($FILE_DIR.$saveAs))
			{
				unlink($FILE_DIR.$saveAs);
			}

			$wkhtmltopdf->saveAs($FILE_DIR.$saveAs);
			// exit;

			if (!$wkhtmltopdf->saveAs($FILE_DIR.$saveAs)) {
			    $error = $wkhtmltopdf->getError();
			    // ... handle error here
			    echo $error;
			}

			return $saveAs;
		}
		else
		{
			
		}
		exit;
	}
}
