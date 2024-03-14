<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/encrypt.func.php");

class qrcode extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	function index()
	{
		$CI = &get_instance();
		$reqkunci= $CI->config->item('ttd_enkrip');

		$vdata= $this->input->get("data");
		if(!empty($vdata))
		{
			$dekrip= mdecrypt($vdata, $reqkunci);
			$arrenkrip= explode("-", $dekrip);
			$vmode= $arrenkrip[0];
			$vdekripdata= $arrenkrip[1];

			if($vmode == "viewfile")
			{
				redirect('viewefile?data='.$vdekripdata);
			}
		}

		// kalau lolos maka masuk no page
		$this->load->view('nopage/index', $data);
	}
}