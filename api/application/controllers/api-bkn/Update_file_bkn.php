<?php
require APPPATH . '/libraries/REST_Controller.php';
include_once("functions/string.func.php");
include_once("functions/date.func.php");
 
class Update_file_bkn extends REST_Controller {
 
    function __construct() {
        parent::__construct();

        $this->load->library('gapi');
    }
 
    // show data entitas
    function index_get() {
        $reqId= $this->input->get("reqId");
        $reqRowId= $this->input->get("reqRowId");
        $id= $this->input->get("id");
        $vlink= $this->input->get("vlink");

        if(empty($id)) $id= -1;

        $query= $this->db->query("select * from ref_bkn_file where id in (".$id.")");
        $arrjenisbkn= $query->result_array();
        $this->db->close();
        // print_r($arrjenisbkn);exit;

        $vreturn= [];
        if(!empty($arrjenisbkn) && !empty($vlink))
        {
            $vjenisbkn= $arrjenisbkn[0];
            $reqRiwayatTable= $vjenisbkn["riwayat_table"];
            $reqRiwayatField= $vjenisbkn["riwayat_field"];
            $reqKategoriFileId= $vjenisbkn["kategori_file_id"];
            $reqKualitasFileId= 1;
            $reqPrioritas= "1";
            $reqRiwayatId= $reqRowId;

            if(!empty($reqRiwayatTable))
            {
                $this->load->model("base-new/PegawaiBknFile");

                // cek kalau tidak ada di database lewati untuk simpan file
                $statement= " AND A.V_BKN_LINK = '".$vlink."'";
                $checkfile= new PegawaiBknFile();
                $pernahsimpan= $checkfile->getCountByParams(array(), $statement);
                // echo $pernahsimpan;exit;

                if($pernahsimpan > 0)
                {

                }
                else
                {
                    $configdata= $this->config;
                    $settingurlupload= $configdata->config["settingurlupload"];

                    $gp= new Gapi();
                    $vlink= urldecode($vlink);
                    $arrparam= ["detil"=>"download-dok?filePath=".$vlink];
                    $getfile= urldecode($gp->getdatadownload($arrparam));

                    $target_dir= $settingurlupload."uploads/".$reqId."/";
                    if(file_exists($target_dir)){}
                    else
                    {
                        makedirs($target_dir);
                    }

                    // untuk membuat file
                    $infoext= pathinfo($vlink);
                    // print_r($infoext);exit;
                    $ext= $infoext["extension"];
                    $target_file_asli= $infoext["basename"];
                    $namagenerate= generateRandomString().".".$ext;
                    // $namagenerate= "ye7SQ5WTFv.".$ext;
                    $namafile= $target_dir.$namagenerate;
                    file_put_contents($namafile, $getfile);

                    $setfile= new PegawaiBknFile();
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
                    $setfile->setField("V_BKN_LINK", $vlink);

                    $setfile->setField("IPCLIENT", sfgetipaddress());
                    $setfile->setField("MACADDRESS", sfgetmac());
                    $setfile->setField("NAMACLIENT", getHostName());
                    $setfile->setField("PRIORITAS", $reqPrioritas);

                    $setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);

                    $setfile->setField('PATH', str_replace($settingurlupload, "", $namafile));
                    $setfile->setField('PATH_ASLI', $target_file_asli);
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
        }
        /*

        if(!empty($id))
        {
            $arrparam= ["ctrl"=>"kursus/id", "value"=>$id];
            $vreturn= $gp->getdataParam($arrparam);
        }
        else
        {
            $arrparam= ["vjenis"=>"rw-kursus", "nip"=>$nip, "lihatdata"=>""];
            $vreturn= $gp->getdata($arrparam);
        }
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));*/
    }
    
    // insert new data to entitas
    function index_post() {
        /*$id= $this->input->post('id');
        $instansiId= $this->input->post('instansiId');
        $institusiPenyelenggara= $this->input->post('institusiPenyelenggara');
        $jenisDiklatId= $this->input->post('jenisDiklatId');
        $jenisKursus= $this->input->post('jenisKursus');
        $jenisKursusSertipikat= $this->input->post('jenisKursusSertipikat');
        $jumlahJam= (int)$this->input->post('jumlahJam');
        $lokasiId= $this->input->post('lokasiId');
        $namaKursus= $this->input->post('namaKursus');
        $nomorSertipikat= $this->input->post('nomorSertipikat');
        $pnsOrangId= $this->input->post('pnsOrangId');
        $tahunKursus= (int)$this->input->post('tahunKursus');
        $tanggalKursus= $this->input->post('tanggalKursus');
        $tanggalSelesaiKursus= $this->input->post('tanggalSelesaiKursus');

        $dok_id=$this->input->post('dok_id');
        $dok_nama=$this->input->post('dok_nama');
        $dok_uri=$this->input->post('dok_uri');
        $object=$this->input->post('object');
        $slug=$this->input->post('slug');

        $path[]= array("dok_id"=>$dok_id,"dok_nama"=>$dok_nama,"dok_uri"=>$dok_uri,"object"=>$object,"slug"=>$slug);
            
        $id=$id?$id:null;    

        $arrData = array(
            "id"=>$id
            , "instansiId"=>$instansiId
            , "institusiPenyelenggara"=>$institusiPenyelenggara
            , "jenisDiklatId"=>$jenisDiklatId
            , "jenisKursus"=>$jenisKursus
            , "jenisKursusSertipikat"=>$jenisKursusSertipikat
            // , "path"=>$path
            , "jumlahJam"=>$jumlahJam
            , "lokasiId"=>$lokasiId
            , "namaKursus"=>$namaKursus
            , "nomorSertipikat"=>$nomorSertipikat
            , "pnsOrangId"=>$pnsOrangId
            , "tahunKursus"=>$tahunKursus
            , "tanggalKursus"=>$tanggalKursus
            , "tanggalSelesaiKursus"=>$tanggalSelesaiKursus
        );
        $jsonData= json_encode($arrData);
        // print_r($jsonData);exit;

        $arrparam= ["ctrl"=>"kursus/save"];
        $gp= new gapi();
        $vreturn= $gp->postdata($arrparam,$jsonData);
        
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));*/
    }
 
    // update data entitas
    function index_put() {
    }
 
    // delete entitas
    function index_delete() {
    }
 
}