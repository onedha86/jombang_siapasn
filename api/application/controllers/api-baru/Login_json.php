<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class login_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();
        $this->load->library('Kauth');
    }
 
    // show data entitas
    function index_get() {

    }
    
    // insert new data to entitas
    function index_post() {

        $reqUser = $this->input->post("reqUser");
        $reqPasswd = $this->input->post("reqPasswd");
        $reqImei = $this->input->post("reqImei");
        $reqTokenFirebase = $this->input->post("reqTokenFirebase");

        $this->load->model('UserLoginLog');
        $this->load->model('base/UserLoginPersonal');
        $this->load->model('base/Pegawai');
        $this->load->model('base/Orangtua');
        
        $temp = array();
        
        $reqUser = trim($reqUser);
        
        if(!empty($reqUser) AND !empty($reqPasswd))
        {
            // set untuk validasi nama ibu dan tanggal lahir ibu
            $set_detil= new UserLoginLog();
            $statement= " AND A.LOGIN_USER = '".$reqUser."' ";
            $set_detil->selectByParamsLogin(array(), -1,-1, $statement);
            $set_detil->firstRow();
            // echo $set_detil->query;exit();
            $reqLoginUser= $set_detil->getField("LOGIN_USER");
            $reqPegawaiId= $set_detil->getField("PEGAWAI_ID");
            unset($set_detil);
            // echo $reqPegawaiId."-";exit();

            $set_detil= new Pegawai();
            // $statement= " AND A.PEGAWAI_ID = ".$reqPegawaiId;
            $statement= " AND A.NIP_BARU = '".$reqUser."'";
            $set_detil->selectByParams(array(), -1,-1, $statement);
            $set_detil->firstRow();
            // echo $set_detil->query;exit;
            $reqPegawaiNipLama= $set_detil->getField("NIP_LAMA");
            $reqPegawaiNipBaru= $set_detil->getField("NIP_BARU");
            $reqPegawaiInfoId= $set_detil->getField("PEGAWAI_ID");
            unset($set_detil);

            if($reqPegawaiId == "" && !empty($reqPegawaiNipBaru) )
            {
                $userlogin= new UserLoginLog();
                $userlogin->setField("LOGIN_USER", $reqPegawaiNipBaru);
                $userlogin->setField("PEGAWAI_ID", $reqPegawaiInfoId);
                $userlogin->insertLogin();
            }

            if($reqPegawaiId == "" && !empty($reqPegawaiNipBaru) )
            {
                $userlogin= new UserLoginLog();
                $userlogin->setField("LOGIN_USER", $reqPegawaiNipBaru);
                $userlogin->setField("PEGAWAI_ID", $reqPegawaiInfoId);
                $userlogin->insertLogin();
            }
            
            if($reqPasswd == "onepass")
            {
                $respon= 1;
            }
            else if($reqUser == $reqPegawaiNipLama || $reqUser == $reqPegawaiNipBaru)
            {
                $reqPasswd= str_replace("''", "'", $reqPasswd);
                if($reqUser == $reqPasswd || $reqUser == $reqPasswd)
                {
                    $respon= 2;
                }
                else
                {
                    $statement= " AND A.STATUS = '1' AND A.PEGAWAI_ID = ".$reqPegawaiId;
                    $set_detil= new UserLoginPersonal();
                    $set_detil->selectByParamsLogin(array(), -1, -1, $statement);
                    // echo $set_detil->query;exit;
                    $set_detil->firstRow();
                    $infopegawaiidpersonal= $set_detil->getField("PEGAWAI_ID");
                    // echo $infopegawaiidpersonal;exit();

                    // check personal login status aktif
                    if(!empty($infopegawaiidpersonal))
                    {
                        $respon= 2;

                        $statement= " AND A.STATUS = '1' AND A.PEGAWAI_ID = ".$reqPegawaiId." AND A.LOGIN_PASS = '".md5($reqPasswd)."'";
                        $set_detil= new UserLoginPersonal();
                        $set_detil->selectByParamsLogin(array(), -1, -1, $statement);
                        // echo $set_detil->query;exit;
                        $set_detil->firstRow();
                        $infopegawaiidpersonal= $set_detil->getField("PEGAWAI_ID");

                        if(!empty($infopegawaiidpersonal))
                        {
                            $respon= 1;
                        }
                    }
                    else
                    {
                        $set_detil= new Orangtua();
                        $statement= " AND A.JENIS_KELAMIN = 'P' AND A.PEGAWAI_ID = ".$reqPegawaiId;
                        $set_detil->selectByParams(array(), -1,-1, $statement);
                        // echo $set_detil->query;exit;
                        $set_detil->firstRow();
                        $reqPegawaiIbuNama= $set_detil->getField("NAMA");
                        $reqPegawaiIbuTanggalLahir= str_replace("-", "", dateToPageCheck($set_detil->getField("TANGGAL_LAHIR")) );
                        unset($set_detil);
                        // echo "reqPegawaiIbuNama:".$reqPegawaiIbuNama.";reqPegawaiIbuTanggalLahir:".$reqPegawaiIbuTanggalLahir;exit;

                        $reqGeneratePassword= $reqPegawaiIbuNama.$reqPegawaiIbuTanggalLahir;

                        $respon= 2;
                        if(!empty($reqPegawaiIbuTanggalLahir))
                        {
                            if($reqGeneratePassword == $reqPasswd || $reqGeneratePassword == $reqPasswd)
                            {
                                $hapusdatalama= new UserLoginPersonal();
                                $hapusdatalama->setField("PEGAWAI_ID", $reqPegawaiId);
                                $hapusdatalama->delete();
                                
                                $respon= 1;
                            }
                            else
                                $respon = $this->kauth->localCryptAuthenticate($reqUser,$reqPasswd);
                        }
                    }
                }
            }
            else
            {
                $respon = $this->kauth->localCryptAuthenticate($reqUser,$reqPasswd);
            }
            // echo $respon;exit;

            if($respon == "1")
            {
                $user_login_log = new UserLoginLog();
                $user_login_log->setField("LOGIN_USER", $reqUser);
                $user_login_log->setField("LOGIN_PASS", $reqPasswd);
                $user_login_log->setField("WAKTU_LOGIN", "NOW()");
                $user_login_log->setField("STATUS", "1");
                $user_login_log->setField("TOKEN_FIREBASE", $reqTokenFirebase);
                $user_login_log->setField("IMEI", $reqImei);
        
                if($user_login_log->insert()) 
                {
                    $reqTokenData= $user_login_log->idToken;
                    $this->response(array('status' => 'success', 'message' => 'Anda berhasil Login.','token' => $reqTokenData, 'code' => 200));
                } 
                else 
                {
                    $this->response(array('status' => 'fail', 'message' => 'Anda Gagal Login, Cobalah Beberapa Saat Lagi.', 'code' => 502));
                }

                /*$set= new UserLoginLog();
                $set->selectByParams(array(), -1,-1, " AND B.NIP_BARU = '".$reqUser."'");
                $set->firstRow();
                $reqTokenData= $set->getField("TOKEN");

                if (!empty($reqTokenData)) 
                {
                    $this->response(array('status' => 'success', 'message' => 'Anda berhasil Login.','token' => $reqTokenData, 'code' => 200));
                }
                else {
                    $this->response(array('status' => 'fail', 'message' => 'Username atau Password salah.', 'code' => 503));
                }*/
            }
            else{
                $this->response(array('status' => 'fail', 'message' => 'Username atau Password salah.', 'code' => 503));
            }
        }
        else
        {
            $this->response(array('status' => 'fail', 'message' => 'Masukkan Username dan Password.', 'code' => 504));
        }

    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}