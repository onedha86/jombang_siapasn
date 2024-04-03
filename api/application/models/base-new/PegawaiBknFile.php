<? 
/* *******************************************************************************************************
MODUL NAME          : MTSN LAWANG
FILE NAME           : 
AUTHOR              : 
VERSION             : 1.0
MODIFICATION DOC    :
DESCRIPTION         : 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  // include_once('Entity.php');
  include_once(APPPATH.'/models/Entity.php');
  
  class PegawaiBknFile extends Entity{ 

    var $query;
    var $id;
    /**
    * Class constructor.
    **/
    function PegawaiBknFile()
    {
      $this->Entity(); 
    }

    function noketinsert()
    {
        /*Auto-generate primary key(s) by next max value (integer) */
        $this->setField("PEGAWAI_FILE_ID", $this->getNextId("PEGAWAI_FILE_ID","PEGAWAI_FILE")); 

        $str = "
        INSERT INTO PEGAWAI_FILE 
        (
            PEGAWAI_FILE_ID, PEGAWAI_ID, RIWAYAT_TABLE, RIWAYAT_FIELD, RIWAYAT_ID, FILE_KUALITAS_ID, KATEGORI_FILE_ID
            , PATH
            , LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID
            , USER_LOGIN_PEGAWAI_ID, IPCLIENT, MACADDRESS, NAMACLIENT, PATH_ASLI, EXT, CREATE_USER, PRIORITAS
            , V_BKN_LINK
        ) 
        VALUES 
        (
            ".$this->getField("PEGAWAI_FILE_ID")."
            , ".$this->getField("PEGAWAI_ID")."
            , '".$this->getField("RIWAYAT_TABLE")."'
            , '".$this->getField("RIWAYAT_FIELD")."'
            , ".$this->getField("RIWAYAT_ID")."
            , ".$this->getField("FILE_KUALITAS_ID")."
            , ".$this->getField("KATEGORI_FILE_ID")."
            , '".$this->getField("PATH")."'
            , '".$this->getField("LAST_USER")."'
            , ".$this->getField("LAST_DATE")."
            , ".$this->getField("LAST_LEVEL")."
            , ".$this->getField("USER_LOGIN_ID")."
            , ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
            , '".$this->getField("IPCLIENT")."'
            , '".$this->getField("MACADDRESS")."'
            , '".$this->getField("NAMACLIENT")."'
            , '".$this->getField("PATH_ASLI")."'
            , '".$this->getField("EXT")."'
            , '".$this->getField("CREATE_USER")."'
            , '".$this->getField("PRIORITAS")."'
            , '".$this->getField("V_BKN_LINK")."'
        )
        ";  
        $this->id = $this->getField("PEGAWAI_FILE_ID");
        $this->query = $str;
        // echo $str;exit;
        return $this->execQuery($str);
    }

    function updatebknprioritas()
    {
        $str1= "        
        UPDATE PEGAWAI_FILE
        SET    
            PRIORITAS= ''
        WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
        AND KATEGORI_FILE_ID = ".$this->getField("KATEGORI_FILE_ID")."
        AND RIWAYAT_ID = ".$this->getField("RIWAYAT_ID")."
        AND RIWAYAT_FIELD = '".$this->getField("RIWAYAT_FIELD")."'
        AND PEGAWAI_FILE_ID != ".$this->getField("PEGAWAI_FILE_ID")."
        AND PRIORITAS = '".$this->getField("PRIORITAS")."'
        ";
        $this->execQuery($str1);

        $str= "        
        UPDATE PEGAWAI_FILE
        SET    
            PRIORITAS= '".$this->getField("PRIORITAS")."'
        WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
        AND PEGAWAI_FILE_ID = ".$this->getField("PEGAWAI_FILE_ID")."
        ";
        $this->query = $str;
        // echo $str;exit();
        return $this->execQuery($str);
    }

    function updateprioritas()
    {
        $str = "        
        UPDATE PEGAWAI_FILE
        SET    
            PRIORITAS= ''
        WHERE PEGAWAI_ID = ".$this->getField("PEGAWAI_ID")."
        AND KATEGORI_FILE_ID = ".$this->getField("KATEGORI_FILE_ID")."
        AND RIWAYAT_ID = ".$this->getField("RIWAYAT_ID")."
        AND RIWAYAT_FIELD = '".$this->getField("RIWAYAT_FIELD")."'
        AND PEGAWAI_FILE_ID != ".$this->getField("PEGAWAI_FILE_ID")."
        AND PRIORITAS = '".$this->getField("PRIORITAS")."'
        ";
        $this->query = $str;
        // echo $str;exit();
        return $this->execQuery($str);
    }

    function selectparam($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
    {
        $str = "
        SELECT
            A.*
        FROM PEGAWAI_FILE A
        WHERE 1 = 1 ".$statement;
        
        foreach ($paramsArray as $key => $val)
        {
            $str .= " AND $key = '$val' ";
        }
        
        $str .= $statement." ".$order;
        $this->query = $str;
        return $this->selectLimit($str,$limit,$from);
    }

    function getCountByParams($paramsArray=array(), $statement='')
    {
        $str = "
        SELECT COUNT(1) AS ROWCOUNT 
        FROM PEGAWAI_FILE A
        WHERE 1 = 1 ".$statement;
        
        foreach ($paramsArray as $key => $val)
        {
            $str .= " AND $key = '$val' ";
        }
        $this->query = $str;
        $this->select($str); 
        if($this->firstRow()) 
            return $this->getField("ROWCOUNT"); 
        else 
            return 0;  
    }
}