<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'kloader.php';
include_once("functions/encrypt.func.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Kauth
 *
 * @author user
 */
class kauth {
    //put your code here
    private $ldap_config = array('server1'=>array(   'host'=>'10.0.0.11',
                                    'useStartTls'=>false,
                                    'accountDomainName'=>'pp3.co.id',
                                    'accountDomainNameShort'=>'PP3',
                                    'accountCanonicalForm'=>3,
                                    'baseDn'=>"DC=pp3,DC=co,DC=id"));


        function __construct() {
//        load the auth class
        kloader::load('Zend_Auth');
        kloader::load('Zend_Auth_Storage_Session');
        
//        set the unique storege
        Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session("shgfhgjhgjkhjrakkesan4kemasti"));
    }
    
    public function ldapAuthanticate($username,$credential){
        kloader::load('Zend_Ldap');
        kloader::load('Zend_Auth_Adapter_Ldap');
        
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        
        $adapter = new Zend_Auth_Adapter_Ldap($this->ldap_config,$username,$credential);
        $result = $auth->authenticate($adapter);
        if($result->isValid())
        {
            $identity = new stdClass();
            $identity->USERNAME = $adapter->getUsername();
            $identity->ID_GROUP = 'admin';
            $auth->getStorage()->write($identity);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function authanticate($username,$credential)
    {
        kloader::load('Zend_Auth_Adapter_DbTable');
        kloader::load('Zend_Db_Adapter_Oracle');
        $CI =& get_instance();
        
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        
//        load config
        $CI->load->database();
        $dbConfig = array(
//                'host'     => $CI->db->hostname,
                'username'  => $CI->db->username,
                'password'  => $CI->db->password,
                'dbname'    => $CI->db->hostname
            );
        $dbAdapter = new Zend_Db_Adapter_Oracle($dbConfig);
        $adapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $adapter->setTableName("USERS")
                ->setIdentityColumn("USERNAME")
                ->setCredentialColumn("PASSWORD")
                ->setIdentity($username)
                ->setCredential($credential)
                ->setCredentialTreatment('md5(?)')
        ;
        if($auth->authenticate($adapter)->isValid())
        {
            //autheticated
            $auth->getStorage()->write($adapter->getResultRowObject(null,"PASSWORD"));
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function localCryptAuthenticate($username,$credential) {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();

        $CI =& get_instance();        
        $CI->load->model("UserLoginLog");

        
        // tutup karena sudah model baru
        /*$setdetil= new UserLoginLog();
        $setdetil->setField("LOGIN_PASS", $credential);
        $setdetil->setField("LOGIN_USER", $username);
        $setdetil->updatepass();*/

        $user_login = new UserLoginLog();
        // $statement= " AND A.LOGIN_USER = '".$username."' AND A.LOGIN_PASS = CRYPT('".$credential."', A.LOGIN_PASS)";
        $statement= " AND A.LOGIN_USER = '".$username."'";
        $user_login->selectByParamsLogin(array(), -1,-1, $statement);
        // echo $user_login->query;exit;
        // echo $user_login->errorMsg;exit();
        if($user_login->firstRow())
        {
            // $identity = new stdClass();
            // $identity->PERSONAL_USER_LOGIN_ID= $user_login->getField("USER_LOGIN_ID");
            // $identity->PERSONAL_LOGIN_USER= $user_login->getField("LOGIN_USER");
            // $identity->PERSONAL_PEGAWAI_ID= $user_login->getField("PEGAWAI_ID");

            // // echo $identity->PERSONAL_USER_LOGIN_ID;exit();
            // $auth->getStorage()->write($identity);
            return 1;
        }
        else
        {
            return "";
            // return "Login gagal.";
        }
    }

    public function portalAuthenticate($username,$credential)
    {
        ini_set ('soap.wsdl_cache_enabled', 0);
        kloader::load('Zend_Soap_Client');
        $wsdl = base_url().'portal_login?wsdl';
        $CI =& get_instance();
        
        $cl = new SoapClient($wsdl);
        //$rv = $cl->__soapCall("loginAplikasi", array('aplikasiId'=>1,'userLogin'=>"xxx",'userPassword'=>$credential));
        /*BACKUP NVN*/
        $rv = $cl->loginAplikasi(1, $username, $credential);
        //print_r($rv); exit;
        // $rv->RESPONSE = "PAGE";
        // $rv->NID = $username;
        // $rv->APLIKASI_ID = '1';
        // $rv->RESPONSE_LINK = "http://essportal.centos.ptpjbs.com/login/autologin";
        if($rv->RESPONSE == "1")
        {
            $this->getLoginInformation($rv, $credential);
            return $rv;
        }
        else
        {
            return $rv;
        }
    }   

    public function autoAuthenticate($username,$credential)
    {
        ini_set ('soap.wsdl_cache_enabled', 0);
        kloader::load('Zend_Soap_Client');
        $wsdl = base_url().'portal_login?wsdl';
        $CI =& get_instance();
        
        $cl = new SoapClient($wsdl);
        $rv = $cl->loginToken(1, $username, $credential);
        if($rv->RESPONSE == "1")
        {
            $this->getLoginInformation($rv, $credential);
            return $rv;
        }
        else
            return $rv;
                
    }   

    public function autoGroupAuthenticate($username,$credential, $reqGroupId)
    {
        ini_set ('soap.wsdl_cache_enabled', 0);
        kloader::load('Zend_Soap_Client');
        $wsdl = base_url().'portal_login?wsdl';
        $CI =& get_instance();
        
        $cl = new SoapClient($wsdl);
        $rv = $cl->loginGroup(1, $username, $credential, $reqGroupId);
        if($rv->RESPONSE == "1")
        {
            $this->getLoginInformation($rv, $credential);
            return $rv;
        }
        else
            return $rv;
                
    }   
    
    public function getLoginInformation($rv, $credential)
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        
        $identity = new stdClass();
        $identity->NID = $rv->NID;
        $identity->PASSWORD = mencrypt($credential);
        
        if($rv->KODE_GROUP == "")
        {
            /* CHECK APAKAH PEGAWAI TERKAIT BISA MANAGE APLIKASI */ 
            $CI =& get_instance();
            $CI->load->model("portal/AplikasiPenanggungjawab");
            $aplikasi_penanggungjawab = new AplikasiPenanggungjawab();
            $aplikasiId = $aplikasi_penanggungjawab->getAplikasiIdByNID($rv->NID);
            if($aplikasiId == "")
            {
                $identity->KODE_GROUP = "PEGAWAI";
                $identity->NAMA_GROUP = "Pegawai";
            }
            else
            {
                $identity->KODE_GROUP = "APLIKASI";
                $identity->NAMA_GROUP = "Manajemen Aplikasi";
                $identity->APLIKASI_ID = $aplikasiId;
            }
        }
        else
        {
            $identity->KODE_GROUP = $rv->KODE_GROUP;
            $identity->NAMA_GROUP = $rv->NAMA_GROUP;
        }
        $identity->PEGAWAI = $rv->PEGAWAI;
        $identity->JABATAN = $rv->JABATAN;
        $identity->UNIT_KERJA = $rv->UNIT_KERJA;
        $identity->DIREKTORAT = $rv->DIREKTORAT;
        $identity->FUNGSI = $rv->FUNGSI;
        $identity->STAFF = $rv->STAFF;
        $identity->SUBDIT = $rv->SUBDIT;
        $identity->UNIT_KERJA_DESC = $rv->UNIT_KERJA_DESC;
        $identity->DIREKTORAT_DESC = $rv->DIREKTORAT_DESC;
        $identity->FUNGSI_DESC = $rv->FUNGSI_DESC;
        $identity->STAFF_DESC = $rv->STAFF_DESC;
        $identity->SUBDIT_DESC = $rv->SUBDIT_DESC;
        $identity->UMUR = $rv->UMUR;
        $identity->MASA_KERJA = $rv->MASA_KERJA;
        
        $auth->getStorage()->write($identity);
                
    }
    
    public function reAuthenticate($roleID='',$roleDESC='')
    {
        $auth = Zend_Auth::getInstance();
        
        if($roleID <> '')
        {
            $identity = new stdClass();
            $identity->NAME = $auth->getIdentity()->NAME;
            $identity->USERNAME = $auth->getIdentity()->USERNAME;
            $identity->HAK = $roleID;
            $identity->ID_GROUP = $roleDESC;
            $identity->KD_DIT = $auth->getIdentity()->KD_DIT;
            $identity->KD_SUB = $auth->getIdentity()->KD_SUB;
            $identity->KD_SEK = $auth->getIdentity()->KD_SEK;
            $identity->KD_CAB = $auth->getIdentity()->KD_CAB; //'3';
            $auth->clearIdentity();
            $auth->getStorage()->write($identity);
            return true;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function localAuthenticate($username,$credential) {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        
        $CI =& get_instance();
        $CI->load->model("portal/Users");
        
        $users = new Users();
        $users->selectByIdPassword($username, md5($credential));
        if($users->firstRow())
        {
            $identity = new stdClass();
            $identity->ID = $users->getField("USER_LOGIN_ID");
            $identity->PEGAWAI_ID = $users->getField("PEGAWAI_ID");
            $identity->DEPARTEMEN_ID = $users->getField("DEPARTEMEN_ID");
            $identity->USERNAME = $users->getField("USER_LOGIN");
            $identity->NRP = $users->getField("NRP");
            $identity->NAMA = $users->getField("NAMA");
            $identity->JABATAN = $users->getField("JABATAN");
            $identity->AKSES_APP_HELPDESK_ID = $users->getField("AKSES_APP_HELPDESK_ID");
            $identity->HAK_AKSES = $users->getField("HAK_AKSES");
            $identity->HAK_AKSES_DESC = $users->getField("HAK_AKSES_DESC");
            
            $auth->getStorage()->write($identity);
            return true;            
        }
        else
            return false;
    }
    
    public function getInstance(){
        return Zend_Auth::getInstance();
    }
}

?>
