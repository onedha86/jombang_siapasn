<? 
/* *******************************************************************************************************
MODUL NAME 			: MTSN LAWANG
FILE NAME 			: 
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: 
***************************************************************************************************** */

  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
  // include_once('Entity.php');
  include_once(APPPATH.'/models/Entity.php');
  
  class CutiUrutan extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function CutiUrutan()
	{
      $this->Entity(); 
    }
	
	function insert()
	{
		$str = "
		INSERT INTO cuti_urutan
		(
            MENU_ID, URUTAN, USER_LOGIN_ID
		) 
		VALUES 
		(
			'".$this->getField("MENU_ID")."'
			, ".$this->getField("URUTAN")."
			, ".$this->getField("USER_LOGIN_ID")."
		)
		"; 	
		// echo "xxx-".$str;exit;

		$this->id = $this->getField("MENU_ID");
		$this->query = $str;
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE cuti_urutan
		SET    
		 	URUTAN= ".$this->getField("URUTAN")."
		 	, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
		WHERE MENU_ID = '".$this->getField("MENU_ID")."'
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

	function delete()
	{
        $str = "
		DELETE FROM cuti_urutan
		WHERE MENU_ID = ".$this->getField("MENU_ID")."
		";
		$this->query = $str;
		return $this->execQuery($str);
    }

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.URUTAN, A.MENU_ID')
	{
		$str = "
		SELECT
			A1.NAMA, A2.LOGIN_USER, A2.NIP_BARU, A2.NIK, A2.NAMA_LENGKAP
			, A.* 
		FROM cuti_urutan A
		INNER JOIN menu A1 ON A.MENU_ID = A1.MENU_ID
		LEFT JOIN
		(
			SELECT
			A1.NIP_BARU, A1.NIK, A1.NAMA_LENGKAP, A2.LOGIN_USER
			, A.*
			FROM
			(
				SELECT
				USER_LOGIN_ID, PEGAWAI_ID
				, ROW_NUMBER () OVER (PARTITION BY USER_LOGIN_ID ORDER BY TANGGAL_AKHIR) URUTAN
				FROM
				(
					SELECT USER_LOGIN_ID, PEGAWAI_ID, COALESCE(TANGGAL_AKHIR, NOW()) TANGGAL_AKHIR
					FROM user_login_detil
				) A
			) A
			INNER JOIN
			(
				SELECT
				(CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
				, A.*
				FROM pegawai A
			) A1 ON A.PEGAWAI_ID = A1.PEGAWAI_ID
			INNER JOIN user_login A2 ON A.USER_LOGIN_ID = A2.USER_LOGIN_ID
			WHERE URUTAN = 1
		) A2 ON A.USER_LOGIN_ID = A2.USER_LOGIN_ID
		WHERE 1 = 1
		"; 
		
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
		FROM cuti_urutan A
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

    function selectuserlogin($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A2.LOGIN_USER')
	{
		$str = "
		SELECT
		A1.NIP_BARU, A1.NAMA_LENGKAP, A2.LOGIN_USER
		, A.*
		FROM
		(
			SELECT
			USER_LOGIN_ID, PEGAWAI_ID
			, ROW_NUMBER () OVER (PARTITION BY USER_LOGIN_ID ORDER BY TANGGAL_AKHIR) URUTAN
			FROM
			(
				SELECT USER_LOGIN_ID, PEGAWAI_ID, COALESCE(TANGGAL_AKHIR, NOW()) TANGGAL_AKHIR
				FROM user_login_detil
			) A
		) A
		INNER JOIN
		(
			SELECT
			(CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			, A.*
			FROM pegawai A
		) A1 ON A.PEGAWAI_ID = A1.PEGAWAI_ID
		INNER JOIN user_login A2 ON A.USER_LOGIN_ID = A2.USER_LOGIN_ID
		WHERE URUTAN = 1
		";
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from);
    }

  } 
?>