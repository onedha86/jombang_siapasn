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
        $this->load->model("base-new/PegawaiBknFile");

        $reqId= $this->input->get("reqId");
        $reqRowId= $this->input->get("reqRowId");
        $id= $this->input->get("id");
        $vlink= $this->input->get("vlink");
        $vmode= $this->input->get("m");

        if(empty($vmode)) $vmode= "download";
        if(empty($id)) $id= -1;

        $query= $this->db->query("select * from ref_bkn_file where id in (".$id.")");
        $arrjenisbkn= $query->result_array();
        $this->db->close();
        // print_r($arrjenisbkn);exit;

        $configdata= $this->config;
        $settingurlupload= $configdata->config["settingurlupload"];

        $vreturn= [];

        // khusus download
        if($vmode == "download")
        {
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
                    // cek kalau tidak ada di database lewati untuk simpan file
                    $statement= " AND A.V_BKN_LINK = '".$vlink."'";
                    $checkfile= new PegawaiBknFile();
                    // $pernahsimpan= $checkfile->getCountByParams(array(), $statement);
                    $checkfile->selectparam(array(), -1, -1, $statement);
                    $checkfile->firstRow();
                    $reqDokumenFileId= $checkfile->getField("PEGAWAI_FILE_ID");
                    // echo $pernahsimpan;exit;

                    // kalau ada maka update untuk jadi prioritas
                    if(!empty($reqDokumenFileId))
                    {
                        $setfile= new PegawaiBknFile();
                        $setfile->setField("PEGAWAI_ID", $reqId);
                        $setfile->setField("RIWAYAT_FIELD", $reqRiwayatField);
                        $setfile->setField("KATEGORI_FILE_ID", $reqKategoriFileId);
                        $setfile->setField("RIWAYAT_ID", ValToNullDB($reqRiwayatId));
                        $setfile->setField("PRIORITAS", $reqPrioritas);
                        $setfile->setField("PEGAWAI_FILE_ID", $reqDokumenFileId);
                        if($setfile->updatebknprioritas())
                        {

                        }
                    }
                    // kalau belum ada maka simpan data
                    else
                    {
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
        }
        else if($vmode == "upload")
        {
            if(!empty($arrjenisbkn))
            {
                $vjenisbkn= $arrjenisbkn[0];
                $reqRiwayatTable= $vjenisbkn["riwayat_table"];
                $reqRiwayatField= $vjenisbkn["riwayat_field"];
                $reqKategoriFileId= $vjenisbkn["kategori_file_id"];
                $vdocid= $vjenisbkn["id"];
                $vdocument= $vjenisbkn["vdocument"];

                $reqKualitasFileId= 1;
                $reqPrioritas= "1";
                $reqRiwayatId= $reqRowId;

                // $statement= " AND A.V_BKN_LINK = '".$vlink."'";
                $statement= " AND A.RIWAYAT_TABLE = '".$reqRiwayatTable."' AND A.PEGAWAI_ID = ".$reqId." AND A.RIWAYAT_ID = ".$reqRiwayatId;
                $sorder= "ORDER BY A.RIWAYAT_TABLE, A.RIWAYAT_FIELD, CASE WHEN COALESCE(NULLIF(A.PRIORITAS, ''), NULL) IS NULL THEN '2' ELSE A.PRIORITAS END::NUMERIC, A.LAST_DATE DESC";
                $checkfile= new PegawaiBknFile();
                // $pernahsimpan= $checkfile->getCountByParams(array(), $statement);
                $checkfile->selectparam(array(), -1, -1, $statement, $sorder);
                // echo $checkfile->query;exit;
                $checkfile->firstRow();
                $vbknlink= $checkfile->getField("V_BKN_LINK");
                $vpath= $checkfile->getField("PATH");

                if(!empty($vbknlink))
                {
                    $arrdata= [];
                    $arrdata["dok_id"]= $vdocid;
                    $arrdata["dok_nama"]= $vdocument;
                    $arrdata["dok_uri"]= $vbknlink;
                    $arrdata["object"]= $vbknlink;
                    $arrdata["slug"]= $vdocid;
                    array_push($vreturn, $arrdata);
                }
                else
                {
                    $fileName = $settingurlupload.$vpath;;
                    $fileSize = filesize($fileName);

                    if(!file_exists($fileName)) {
                        /*$out['status'] = 'error';
                        $out['message'] = 'File not found.';
                        exit(json_encode($out));*/
                    }

                    $finfo= finfo_open(FILEINFO_MIME_TYPE);
                    $finfo= finfo_file($finfo, $fileName);

                    // $cFile= new CURLFile($fileName, $finfo, basename($fileName));
                    $cFile= new CURLFile(realpath($fileName));

                    $arrData = array(
                        "id_ref_dokumen"=>$id
                        , "file"=>$cFile
                    );
                    // $jsonData= json_encode($arrData);
                    $jsonData= $arrData;
                    // print_r($jsonData);exit;

                    $arrparam= ["ctrl"=>"upload-dok", "method"=> "multipart/form-data"];
                    $gp= new gapi();
                    $vdata= $gp->postdata($arrparam, $jsonData);
                    $vdata= $vdata->data;

                    $vdocid= $vdata->dok_id;
                    $vdocument= $vdata->dok_nama;
                    $vdokuri= $vdata->dok_uri;
                    $vobject= $vdata->object;
                    $vslug= $vdata->slug;

                    $arrdata= [];
                    $arrdata["dok_id"]= $vdocid;
                    $arrdata["dok_nama"]= $vdocument;
                    $arrdata["dok_uri"]= $vdokuri;
                    $arrdata["object"]= $vobject;
                    $arrdata["slug"]= $vslug;
                    array_push($vreturn, $arrdata);
                }
            }
        }
        
        // print_r($vreturn);exit;
        $this->response(array('status' => 'success', 'message' => 'success', 'code' => 200, 'result' => $vreturn));
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