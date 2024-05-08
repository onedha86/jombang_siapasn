<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Info_presensi_json extends REST_Controller {
 
    function __construct() {
        parent::__construct();
        // $this->db->query("alter session set nls_date_format='DD-MM-YYYY'"); 
    }
 
    // show data entitas
    function index_get() {
        $this->load->model('UserLoginLog');
        $this->load->model('base/Pegawai');
        $this->load->model('base/SatuanKerja');

        $user_login_log= new UserLoginLog;
        
        $reqToken = $this->input->get("reqToken");
        $reqMode = $this->input->get("reqMode");
        $nip = $this->input->get("nip");
        $tanggalawal= $this->input->get("tanggalawal");
        $tanggalakhir= $this->input->get("tanggalakhir");

        $user_login_log = new UserLoginLog();
        $reqSatuanKerjaId = $user_login_log->getTokenSatuanKerjaId(array("TOKEN" => $reqToken, "STATUS" => '1'));

        if($reqSatuanKerjaId == "")
        {
            $this->response(array('status' => 'fail', 'message' => 'Sesi anda telah berakhir', 'code' => 502));
        }
        else
        {
            // echo $reqSatuanKerjaId;exit();
            $statement= "";
            if(!empty($nip))
            {
                // $statementsatuankerja= " AND A.PEGAWAI_ID = ".$id;
                $statement.= " AND A.NIP_BARU = '".$nip."'";
            }

            $statementdetil= "";
            if(!empty($tanggalawal))
            {
                $statementdetil.= " AND TO_DATE(TO_CHAR(JAM, 'YYYY-MM-DD'), 'YYYY-MM-DD') >= TO_DATE('".$tanggalawal."', 'DD-MM-YYYY')";
            }

            if(!empty($tanggalakhir))
            {
                $statementdetil.= " AND TO_DATE(TO_CHAR(JAM, 'YYYY-MM-DD'), 'YYYY-MM-DD') <= TO_DATE('".$tanggalakhir."', 'DD-MM-YYYY')";
            }
            
            /*if($reqSatuanKerjaId !== "-1" && !empty($reqSatuanKerjaId))
            {
                $skerja= new SatuanKerja();
                $reqSatuanKerjaId= $skerja->getSatuanKerja($reqSatuanKerjaId);
                unset($skerja);
                $statementsatuankerja.= " AND PEGAWAI.SATUAN_KERJA_ID IN (".$reqSatuanKerjaId.")";
                // echo $statementsatuankerja;exit;
            }*/
            // echo $statementsatuankerja;exit();
            
            $set = new Pegawai;
            $aColumns = array("PEGAWAI_ID", "NIP_BARU", "NAMA_LENGKAP", "TANGGAL_INFO", "TIPE_ABSEN", "TIPE_ABSEN_INFO", "JAM_INFO", "JADWAL_MASUK", "JADWAL_PULANG", "CEKLOG_MASUK", "CEKLOG_PULANG", "STATUS_MASUK", "STATUS_PULANG", "MT", "PC");

            $set->selectPresensi(array(), -1, -1, $statement, $statementdetil);
            // echo $set->query;exit();

            $total = 0;
            while($set->nextRow())
            {
                $row = array();
               for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    if($aColumns[$i] == "TMT")
                        $row[trim($aColumns[$i])] = getFormattedDateView($set->getField(trim($aColumns[$i])));
                    else
                        $row[trim($aColumns[$i])] = $set->getField(trim($aColumns[$i]));
                }
                
                $result[] = $row;

                $total++;
            }
            
            if($total == 0)
            {
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                    $row[trim($aColumns[$i])] = "";
                }
                $result[] = $row;
            }
            
            $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'count' => $total ,'result' => $result));
        }

    }

    
    // insert new data to entitas
    function index_post() {
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}