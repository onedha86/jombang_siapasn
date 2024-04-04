<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once("functions/string.func.php");
include_once("functions/encrypt.func.php");

class Gapi
{
    function __construct() {
        $ci=& get_instance();
        $ci->load->model("base-new/SToken");
        $cq= new SToken();
        $cq->selectByParams();
        while($cq->nextRow())
        {
            $vkey= $cq->getField("VKEY");
            $vtoken= $cq->getField("VTOKEN");

            if($vkey == "vauth") $this->vauth= $vtoken;
            if($vkey == "vapws") $this->vapws= $vtoken;
        }
        // echo $this->vauth;exit;
        // echo $this->vapws;exit;
    }

    function dbtokengenerate()
    {
        $generatetokenauth= $this->generatetokenauth();
        $generatetokenauthichation= $this->generatetokenauthichation();

        // ---------------
        $key= "vauth";
        $statement= " AND A.VKEY = '".$key."'";
        $cq= new SToken();
        $cq->selectByParams(array(), -1,-1, $statement);
        // echo $cq->query;exit;
        $cq->firstRow();
        $vcheck= $cq->getField("VKEY");

        $set= new SToken();
        $set->setField("VKEY", $key);
        $set->setField("VTOKEN", $generatetokenauth);
        if(empty($vcheck))
        {
            $set->insert();
        }
        else
        {
            $set->update();
        }

        // ---------------
        $key= "vapws";
        $statement= " AND A.VKEY = '".$key."'";
        $cq= new SToken();
        $cq->selectByParams(array(), -1,-1, $statement);
        // echo $cq->query;exit;
        $cq->firstRow();
        $vcheck= $cq->getField("VKEY");

        $set= new SToken();
        $set->setField("VKEY", $key);
        $set->setField("VTOKEN", $generatetokenauthichation);
        if(empty($vcheck))
        {
            $set->insert();
        }
        else
        {
            $set->update();
        }

        $this->vauth= $generatetokenauth;
        $this->vapws= $generatetokenauthichation;

        return "1";
    }

    function generatetokenauth()
    {
        $ci=& get_instance();
        $sapkuserlogin= $ci->config->config["sapkuserlogin"];
        $sapkuserpass= $ci->config->config["sapkuserpass"];
        $sapkurl= $ci->config->config["sapkurl"];
        $sapkfield= $ci->config->config["sapkfield"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sapkurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("cache-control: no-cache",'Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sapkfield);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        $result= json_decode($response, 1);
        // print_r($result);exit;
        curl_close($ch);

        return $result['access_token'];
    }

    public function generatetokenauthichation(){
        $ci=& get_instance();
        $login= $ci->config->config["apimwsuserlogin"];
        $password= $ci->config->config["apimwsuserpass"];
        $apimwsurl= $ci->config->config["apimwsurl"];
        $apimwsfield= $ci->config->config["apimwsfield"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apimwsurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("cache-control: no-cache",'Content-Type:application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $apimwsfield);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        // var_dump($response);
        $result= json_decode($response, 1);
        // print_r($result);exit;
        curl_close($ch);

        return $result['access_token'];
    }

    function getdata($arrparam)
    {
        $ci=& get_instance();
        $urlpns= $ci->config->config["urlpns"]."".$arrparam["vjenis"]."/".$arrparam["nip"];
        // echo $urlpns;exit;

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $headers= [
            // 'User-Agent: NoBrowser v0.1 beta',
            // 'accept:application/json',
            'Auth:bearer ' . $generatetokenauth,
            'Authorization:Bearer ' . $generatetokenauthichation
            // , 'Content-Type:none'
        ];
        // print_r($headers);exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        $rs= json_decode($response);
        curl_close($ch);

        // pembaruan kode
        $vkode= $rs->code;
        // echo $vkode;exit;z
        if($vkode == "1")
        {
            if($arrparam["lihatdata"] == "1")
            {
                print_r($rs->data);exit;
            }
            return $rs->data;

        }
        // paggil ulang fungsi, sesuai token baru
        else
        {
            // echo $vkode; print_r($rs);exit;
            $ctoken= $this->dbtokengenerate();
            if($ctoken == "1")
            {
                return $this->getdata($arrparam);
            }
        }
    }

    function postdata($arrparam, $jsonPost)
    {
        $ci=& get_instance();
        $urlpns= $ci->config->config["urlsapi"]."".$arrparam["ctrl"];
        // echo $urlpns;exit;

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $vmethod= "application/json";
        if(!empty($arrparam["method"]))
            $vmethod= $arrparam["method"];
            
        $headers= [
            // 'User-Agent: NoBrowser v0.1 beta',
            'accept:application/json'
            , 'Auth:bearer ' . $generatetokenauth
            , 'Authorization:Bearer ' . $generatetokenauthichation
            , 'Content-Type:'.$vmethod
        ];

        $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $urlpns);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        // // curl_setopt($ch, CURLOPT_HEADER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPost);

        $response= curl_exec($ch);
        $verror= curl_errno($ch);
        $rs= json_decode($response);
        curl_close($ch);
         // print_r($rs);exit;
        // var_dump( $rs);exit;

        // return $rs;
        
        // pembaruan kode
        // $vkode= $rs->code;
        // echo $vkode;exit;
        if($rs)
        {
            return $rs;
        }
        // paggil ulang fungsi, sesuai token baru
        else
        {
            // echo $vkode; print_r($rs);exit;
            $ctoken= $this->dbtokengenerate();
            if($ctoken == "1")
            {
              //  return $this->postdata($arrparam, $jsonPost);
            }
        }
    }

    function getdataParam($arrparam)
    {
        $ci=& get_instance();
        $urlpns= $ci->config->config["urlsapi"]."".$arrparam["ctrl"]."/".$arrparam["value"];
        // echo $urlpns;exit;

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $headers= [
            'User-Agent: NoBrowser v0.1 beta',
            'accept:application/json',
            'Auth:bearer ' . $generatetokenauth,
            'Authorization:Bearer ' . $generatetokenauthichation,
            'Content-Type:none'
        ];
        // print_r($headers);exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        $rs= json_decode($response);
        curl_close($ch);

        // pembaruan kode
        $vkode= $rs->code;
        // echo $vkode;exit;
        if($vkode == "1")
        {
            if($arrparam["lihatdata"] == "1")
            {
                print_r($rs->data);exit;
            }
            return $rs->data;
        }
        // paggil ulang fungsi, sesuai token baru
        else
        {
            // echo $vkode; print_r($rs);exit;
            $ctoken= $this->dbtokengenerate();
            if($ctoken == "1")
            {
                return $this->getdataParam($arrparam);
            }
        }
    }

    function getDataDelete($arrparam){
         $ci=& get_instance();
        $urlpns= $ci->config->config["urlsapi"]."".$arrparam["ctrl"];
        

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $headers= [
            'User-Agent: NoBrowser v0.1 beta',
            'accept:application/json',
            'Auth:bearer ' . $generatetokenauth,
            'Authorization:Bearer ' . $generatetokenauthichation,
            'Content-Type:none'
        ];
        // print_r($headers);exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        $rs= json_decode($response);
        curl_close($ch);
          return $rs;
        // pembaruan kode
        // $vkode= $rs->code;
        // // echo $vkode;exit;
        // if($vkode == "1")
        // {
        //     if($arrparam["lihatdata"] == "1")
        //     {
        //         print_r($rs->data);exit;
        //     }
        //     return $rs->data;
        // }
        // // paggil ulang fungsi, sesuai token baru
        // else
        // {
        //     // echo $vkode; print_r($rs);exit;
        //     $ctoken= $this->dbtokengenerate();
        //     if($ctoken == "1")
        //     {
        //         // return $this->getdataParam($arrparam);
        //     }
        // }

    }


    function getdataRequest($arrparam, $reqParam='')
    {
        $ci=& get_instance();
        $urlpns= $ci->config->config["urlsapi"]."".$arrparam["ctrl"].$reqParam;
        // echo $urlpns;exit;

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $headers= [
            'User-Agent: NoBrowser v0.1 beta',
            'accept:application/json',
            'Auth:bearer ' . $generatetokenauth,
            'Authorization:Bearer ' . $generatetokenauthichation,
            'Content-Type:none'
        ];
        // print_r($headers);exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        // print_r($response);exit;
        $rs= json_decode($response, 1);
        // print_r($rs);exit;

        // pembaruan kode
        $vkode= $rs->code;
        // echo $vkode;exit;
        if($vkode == "1")
        {
            return $rs;
        }
        // paggil ulang fungsi, sesuai token baru
        else
        {
            // echo $vkode; print_r($rs);exit;
            $ctoken= $this->dbtokengenerate();
            if($ctoken == "1")
            {
                return $this->getdataRequest($arrparam, $reqParam);
            }
        }
    }

    function getdatadownload($arrparam)
    {
        $ci=& get_instance();
        $urlpns= $ci->config->config["urlsapi"]."".$arrparam["detil"];
        // echo $urlpns;exit;

        $generatetokenauth= $this->vauth;
        $generatetokenauthichation= $this->vapws;
        // $generatetokenauth= $this->generatetokenauth();
        // $generatetokenauthichation= $this->generatetokenauthichation();

        $headers= [
            // 'User-Agent: NoBrowser v0.1 beta',
            // 'accept:application/json',
            'Auth:bearer ' . $generatetokenauth,
            'Authorization:Bearer ' . $generatetokenauthichation,
            // 'Content-Type:application/pdf'
        ];
        // print_r($headers);exit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpns);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response= curl_exec($ch);
        $verror= curl_errno($ch);
        curl_close($ch);

        if($verror)
        {
            $ctoken= $this->dbtokengenerate();
            if($ctoken == "1")
            {
                return $this->getdatadownload($arrparam);
            }
        }
        else
        {
            return urlencode($response);
        }
    }

    function enkripdekripkunci()
    {
        return "KuNc1";
    }

    function enkripdata($arrparam)
    {
        $reqdata= urldecode($arrparam["reqdata"]);
        $reqkunci= urldecode($arrparam["reqkunci"]);

        return mencrypt($reqdata, $reqkunci);
    }

    function dekripdata($arrparam)
    {
        $reqdata= urldecode($arrparam["reqdata"]);
        $reqkunci= urldecode($arrparam["reqkunci"]);

        return mdecrypt($reqdata, $reqkunci);
    }

}