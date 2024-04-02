<? 
include_once(APPPATH.'/models/CurlData.php');

class DataCombo extends CurlData{

  var $query;
  var $id;

  function DataCombo()
  {
    $this->CurlData(); 
  }

  function selectby($token, $mode, $arrdata=[], $lihat="", $lihathasil="")
  {
    $infoparam= "&reqMode=".$mode;
    if(!empty($arrdata))
    {
      $vurl= $arrdata["vurl"];
      foreach ($arrdata as $key => $value)
      {
            $infoparam.= "&".$key."=".urlencode($value);
        }
        // print_r($infoparam);exit;
    }

    $arrhasil= array("json", "file");
    $arrhasildetil= array("data");
    if(in_array($lihathasil, $arrhasil))
    {
      return $this->selectLimit("combo_json", $token.$infoparam, $lihat, $lihathasil);
    }
    else if(in_array($lihathasil, $arrhasildetil))
    {
      return $this->selectLimit($vurl, $token.$infoparam, $lihat, $lihathasil);
    }
    else
      $this->selectLimit("combo_json", $token.$infoparam, $lihat);
  }

  function selectdata($arrparam=[], $lihat="", $lihathasil="")
  {
    $token= $arrparam["token"];
    $vurl= $arrparam["vurl"];
    $id= $arrparam["id"];
    $vid= $arrparam["vid"];
    $rowid= $arrparam["rowid"];
    $nip= $arrparam["nip"];
    $vlink= $arrparam["vlink"];
    // echo $nip;exit;

    if(!empty($id))
    {
      $token.= "&reqId=".$id;
    }
    if(!empty($rowid))
    {
      $token.= "&reqRowId=".$rowid;
    }
    if(!empty($nip))
    {
      $token.= "&nip=".$nip;
    }
    if(!empty($vid))
    {
      $token.= "&id=".$vid;
    }
    if(!empty($vlink))
    {
      $vlink= urlencode($vlink);
      $token.= "&vlink=".$vlink;
    }
    $this->selectLimit($vurl, $token, $lihat, $lihathasil);
  }

  function updatepersonal($vrl, $data)
  {
    return $this->curlpost($vrl, $data);
  }
} 
?>