<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Ganti_password_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();
    }
 
    // show data entitas
    
    
    // insert new data to entitas
    function index_post() {
        $this->load->model('UserLoginLog');

        $user_login_log= new UserLoginLog;

        $reqToken = $this->input->post("reqToken");
        // $this->response(array('reqToken' => $reqToken));exit();

        //CEK PEGAWAI ID DARI TOKEN
        $user_login_log = new UserLoginLog();
        $reqPegawaiId= $user_login_log->getTokenPegawaiId(array("TOKEN" => $reqToken, "STATUS" => '1'));
        // echo  $reqPegawaiId;exit;
        // echo $user_login_log->query;exit();

        if($reqPegawaiId == "")
        {
            $this->response(array('status' => 'fail', 'message' => 'Anda tidak berhak untuk mendapatkan info personal pegawai.', 'code' => 502));
        }
        else
        {
            $this->load->model('base-new/UserLoginPersonal');
            $this->load->model('base-new/Orangtua');

            $reqPasswordBaru= $this->input->post('reqPasswordBaru');
            $reqPasswordLama= $this->input->post('reqPasswordLama');
            $reqId = $this->input->post("reqId");
            $reqLoginUser = $this->input->post("reqLoginUser");
            $reqRowId = $this->input->post("reqRowId");
            $reqNama = $this->input->post("reqNama");
            $reqSatkerId = $this->input->post("reqSatkerId");

            $validasi= preg_match('#^(?=(.*[A-Za-z]){6})(?=[A-Za-z]*\d)[A-Za-z0-9]{7,}$#',$reqPasswordBaru);
            if(!$validasi) 
            {
                $this->response(array('status' => 'gagal','message' => 'Password harus kombinasi huruf dan angka, Huruf minimal 6 karakter dan angka minimal 1 karakter '.$reqPasswordBaru, 'code' =>  502));
            }

            $set_data = new UserLoginPersonal();
            $set_data->setField('LOGIN_PASS', md5($reqPasswordBaru));
            $set_data->setField("LOGIN_USER", $reqLoginUser);
            $set_data->setField("LAST_USER", $reqNama);
            $set_data->setField("PEGAWAI_ID", $reqRowId);
            $set_data->setField("STATUS", 1);
            $set_data->setField("LAST_DATE", "NOW()");
            $set_data->setField("SATUAN_KERJA_ID", $reqSatkerId);

            $set_check = new UserLoginPersonal();
            $statement=" AND A.PEGAWAI_ID=".$reqRowId;
            $set_check->selectByParamsLogin(array(),-1,-1,$statement);
            $set_check->firstRow();
            $reqPegawaiId= $set_check->getField('PEGAWAI_ID');

            if($set_check->getField('LOGIN_PASS') == md5($reqPasswordLama)){}
            else
            {
                // kalau tidak ada maka pakai pass orang tua
                if(empty($reqPegawaiId))
                {
                    $set_detil= new Orangtua();
                    $statement= " AND A.JENIS_KELAMIN = 'P' AND A.PEGAWAI_ID = ".$reqRowId;
                    $set_detil->selectByParams(array(), -1,-1, $statement);
                    // echo $set_detil->query;exit;
                    $set_detil->firstRow();
                    $reqPegawaiIbuNama= $set_detil->getField("NAMA");
                    $reqPegawaiIbuTanggalLahir= str_replace("-", "", dateToPageCheck($set_detil->getField("TANGGAL_LAHIR")) );
                    unset($set_detil);
                    // echo "reqPegawaiIbuNama:".$reqPegawaiIbuNama.";reqPegawaiIbuTanggalLahir:".$reqPegawaiIbuTanggalLahir;exit;

                    $reqGeneratePassword= $reqPegawaiIbuNama.$reqPegawaiIbuTanggalLahir;

                    if(!empty($reqPegawaiIbuTanggalLahir))
                    {
                        if($reqGeneratePassword == $reqPasswordLama){}
                        else
                            $this->response(array('status' => 'gagal','message' => ' Password Lama tidak cocok '.$reqPasswordLama, 'code' =>  502));
                    }
                    else
                    {
                        $this->response(array('status' => 'gagal','message' => ' Password Lama tidak cocok '.$reqPasswordLama, 'code' =>  502));
                    }
                }
                else
                {
                    $this->response(array('status' => 'gagal','message' => ' Password Lama tidak cocok '.$reqPasswordLama, 'code' =>  502));
                }
            }
            // exit;

            if(empty($reqPegawaiId))
            {
                if($set_data->insertpass())
                {
                    $reqsimpan= "1";
                    $reqTempValidasiId= "1";
                }
                // $this->response(array('status' => 'gagal','message' => $set_data->query, 'code' =>  502));
            }
            else
            {
                if($set_data->resetPassword())
                {
                    $reqsimpan= "1";
                    $reqTempValidasiId= "1";
                }

            }
            $query= $this->db->last_query();

            if(!empty($reqTempValidasiId))
            {
                $this->response(array('status' => 'success',  'message' => 'Data berhasil disimpan.', 'id' => $reqTempValidasiId));
            }
            else
            {
                $this->response(array('status' => 'fail', 'code' =>  502));
            }

        }
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}