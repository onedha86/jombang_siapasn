<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once("functions/string.func.php");
include_once("functions/date.func.php");
include_once("functions/encrypt.func.php");

class viewefile extends CI_Controller {

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

			/*$data = array(
				'dekrip' => $dekrip
			);
			// print_r($data);exit;

			$this->load->view('fileview/templateviewfile');*/

			$view = array(
				'dekrip' => $dekrip
			);

			$data = array(
				'content' => $this->load->view("fileview/templateviewfile", $view, TRUE)
			);
			// print_r($view);exit;
			
			$this->load->view('fileview/index', $data);
		}
		else
		{
			// kalau lolos maka masuk no page
			$this->load->view('nopage/index', $data);
		}

	}

}