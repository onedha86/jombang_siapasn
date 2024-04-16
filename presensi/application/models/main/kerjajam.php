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
include_once(APPPATH.'/models/Entity.php');

class KerjaJam extends Entity{ 

	var $query;
	var $id;

	/**
	* Class constructor.
	**/
	function KerjaJam()
	{
	  $this->Entity(); 
	}

	function insert()
	{
		$this->setField("KERJA_JAM_ID", $this->getNextId("KERJA_JAM_ID","presensi.KERJA_JAM"));

		$str= "
		INSERT INTO presensi.KERJA_JAM
		(
			KERJA_JAM_ID, NAMA_JAM_KERJA, JENIS_JAM_KERJA, HARI_KHUSUS, MULAI_BERLAKU
			, AKHIR_BERLAKU, STATUS_JAM_KERJA, MASUK_NORMAL, MULAI_MASUK_NORMAL
			, AKHIR_MASUK_NORMAL, KELUAR_NORMAL, MULAI_KELUAR_NORMAL, AKHIR_KELUAR_NORMAL
			, KELUAR_GANTI_HARI_NORMAL, STATUS_ASK_NORMAL, AKHIR_ASK_NORMAL
			, STATUS_CEK_NORMAL, AWAL_CEK_NORMAL, AKHIR_CEK_NORMAL
			, MASUK_RAMADHAN, MULAI_MASUK_RAMADHAN, AKHIR_MASUK_RAMADHAN, KELUAR_RAMADHAN
			, MULAI_KELUAR_RAMADHAN, AKHIR_KELUAR_RAMADHAN, KELUAR_GANTI_HARI_RAMADHAN
			, STATUS_ASK_RAMADHAN, AKHIR_ASK_RAMADHAN, STATUS_CEK_RAMADHAN
			, AWAL_CEK_RAMADHAN, AKHIR_CEK_RAMADHAN, STATUS_JAM_KERJA_RAMADHAN
			--, MULAI_RAMADHAN_BERLAKU, AKHIR_RAMADHAN_BERLAKU
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("KERJA_JAM_ID")."'
			, '".$this->getField("NAMA_JAM_KERJA")."'
			, '".$this->getField("JENIS_JAM_KERJA")."'
			, '".$this->getField("HARI_KHUSUS")."'
			, ".$this->getField("MULAI_BERLAKU")."
			, ".$this->getField("AKHIR_BERLAKU")."
			, '".$this->getField("STATUS_JAM_KERJA")."'
			, '".$this->getField("MASUK_NORMAL")."'
			, '".$this->getField("MULAI_MASUK_NORMAL")."'
			, '".$this->getField("AKHIR_MASUK_NORMAL")."'
			, '".$this->getField("KELUAR_NORMAL")."'
			, '".$this->getField("MULAI_KELUAR_NORMAL")."'
			, '".$this->getField("AKHIR_KELUAR_NORMAL")."'
			, '".$this->getField("KELUAR_GANTI_HARI_NORMAL")."'
			, '".$this->getField("STATUS_ASK_NORMAL")."'
			, '".$this->getField("AKHIR_ASK_NORMAL")."'
			, '".$this->getField("STATUS_CEK_NORMAL")."'
			, '".$this->getField("AWAL_CEK_NORMAL")."'
			, '".$this->getField("AKHIR_CEK_NORMAL")."'
			, '".$this->getField("MASUK_RAMADHAN")."'
			, '".$this->getField("MULAI_MASUK_RAMADHAN")."'
			, '".$this->getField("AKHIR_MASUK_RAMADHAN")."'
			, '".$this->getField("KELUAR_RAMADHAN")."'
			, '".$this->getField("MULAI_KELUAR_RAMADHAN")."'
			, '".$this->getField("AKHIR_KELUAR_RAMADHAN")."'
			, '".$this->getField("KELUAR_GANTI_HARI_RAMADHAN")."'
			, '".$this->getField("STATUS_ASK_RAMADHAN")."'
			, '".$this->getField("AKHIR_ASK_RAMADHAN")."'
			, '".$this->getField("STATUS_CEK_RAMADHAN")."'
			, '".$this->getField("AWAL_CEK_RAMADHAN")."'
			, '".$this->getField("AKHIR_CEK_RAMADHAN")."'
			, '".$this->getField("STATUS_JAM_KERJA_RAMADHAN")."'
			--, ".$this->getField("MULAI_RAMADHAN_BERLAKU")."
			--, ".$this->getField("AKHIR_RAMADHAN_BERLAKU")."
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->id= $this->getField("KERJA_JAM_ID");
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function update()
	{
		$str= "
		UPDATE presensi.KERJA_JAM
		SET
			NAMA_JAM_KERJA= '".$this->getField("NAMA_JAM_KERJA")."'
			, JENIS_JAM_KERJA= '".$this->getField("JENIS_JAM_KERJA")."'
			, HARI_KHUSUS= '".$this->getField("HARI_KHUSUS")."'
			, MULAI_BERLAKU= ".$this->getField("MULAI_BERLAKU")."
			, AKHIR_BERLAKU= ".$this->getField("AKHIR_BERLAKU")."
			, STATUS_JAM_KERJA= '".$this->getField("STATUS_JAM_KERJA")."'
			, MASUK_NORMAL= '".$this->getField("MASUK_NORMAL")."'
			, MULAI_MASUK_NORMAL= '".$this->getField("MULAI_MASUK_NORMAL")."'
			, AKHIR_MASUK_NORMAL= '".$this->getField("AKHIR_MASUK_NORMAL")."'
			, KELUAR_NORMAL= '".$this->getField("KELUAR_NORMAL")."'
			, MULAI_KELUAR_NORMAL= '".$this->getField("MULAI_KELUAR_NORMAL")."'
			, AKHIR_KELUAR_NORMAL= '".$this->getField("AKHIR_KELUAR_NORMAL")."'
			, KELUAR_GANTI_HARI_NORMAL= '".$this->getField("KELUAR_GANTI_HARI_NORMAL")."'
			, STATUS_ASK_NORMAL= '".$this->getField("STATUS_ASK_NORMAL")."'
			, AKHIR_ASK_NORMAL= '".$this->getField("AKHIR_ASK_NORMAL")."'
			, STATUS_CEK_NORMAL= '".$this->getField("STATUS_CEK_NORMAL")."'
			, AWAL_CEK_NORMAL= '".$this->getField("AWAL_CEK_NORMAL")."'
			, AKHIR_CEK_NORMAL= '".$this->getField("AKHIR_CEK_NORMAL")."'
			, MASUK_RAMADHAN= '".$this->getField("MASUK_RAMADHAN")."'
			, MULAI_MASUK_RAMADHAN= '".$this->getField("MULAI_MASUK_RAMADHAN")."'
			, AKHIR_MASUK_RAMADHAN= '".$this->getField("AKHIR_MASUK_RAMADHAN")."'
			, KELUAR_RAMADHAN= '".$this->getField("KELUAR_RAMADHAN")."'
			, MULAI_KELUAR_RAMADHAN= '".$this->getField("MULAI_KELUAR_RAMADHAN")."'
			, AKHIR_KELUAR_RAMADHAN= '".$this->getField("AKHIR_KELUAR_RAMADHAN")."'
			, KELUAR_GANTI_HARI_RAMADHAN= '".$this->getField("KELUAR_GANTI_HARI_RAMADHAN")."'
			, STATUS_ASK_RAMADHAN= '".$this->getField("STATUS_ASK_RAMADHAN")."'
			, AKHIR_ASK_RAMADHAN= '".$this->getField("AKHIR_ASK_RAMADHAN")."'
			, STATUS_CEK_RAMADHAN= '".$this->getField("STATUS_CEK_RAMADHAN")."'
			, AWAL_CEK_RAMADHAN= '".$this->getField("AWAL_CEK_RAMADHAN")."'
			, AKHIR_CEK_RAMADHAN= '".$this->getField("AKHIR_CEK_RAMADHAN")."'
			, STATUS_JAM_KERJA_RAMADHAN= '".$this->getField("STATUS_JAM_KERJA_RAMADHAN")."'
			--, MULAI_RAMADHAN_BERLAKU= ".$this->getField("MULAI_RAMADHAN_BERLAKU")."
			--, AKHIR_RAMADHAN_BERLAKU= ".$this->getField("AKHIR_RAMADHAN_BERLAKU")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE KERJA_JAM_ID = '".$this->getField("KERJA_JAM_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function insertJamShift()
	{
		$this->setField("KERJA_JAM_SHIFT_ID", $this->getNextId("KERJA_JAM_SHIFT_ID","presensi.KERJA_JAM_SHIFT"));

		$str= "
		INSERT INTO presensi.KERJA_JAM_SHIFT
		(
			KERJA_JAM_SHIFT_ID, NAMA_JAM_KERJA, MULAI_BERLAKU, AKHIR_BERLAKU, STATUS_JAM_KERJA
			, MASUK_NORMAL, MULAI_MASUK_NORMAL, AKHIR_MASUK_NORMAL, KELUAR_NORMAL
			, MULAI_KELUAR_NORMAL, AKHIR_KELUAR_NORMAL, KELUAR_GANTI_HARI_NORMAL, STATUS_ASK_NORMAL
			, AKHIR_ASK_NORMAL, STATUS_CEK_NORMAL, AWAL_CEK_NORMAL, AKHIR_CEK_NORMAL
			, MASUK_RAMADHAN, MULAI_MASUK_RAMADHAN, AKHIR_MASUK_RAMADHAN, KELUAR_RAMADHAN
			, MULAI_KELUAR_RAMADHAN, AKHIR_KELUAR_RAMADHAN, KELUAR_GANTI_HARI_RAMADHAN
			, STATUS_ASK_RAMADHAN, AKHIR_ASK_RAMADHAN, STATUS_CEK_RAMADHAN
			, AWAL_CEK_RAMADHAN, AKHIR_CEK_RAMADHAN, STATUS_JAM_KERJA_RAMADHAN
			--, MULAI_RAMADHAN_BERLAKU, AKHIR_RAMADHAN_BERLAKU
			, SATUAN_KERJA_ID
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("KERJA_JAM_SHIFT_ID")."'
			, '".$this->getField("NAMA_JAM_KERJA")."'
			, ".$this->getField("MULAI_BERLAKU")."
			, ".$this->getField("AKHIR_BERLAKU")."
			, '".$this->getField("STATUS_JAM_KERJA")."'
			, '".$this->getField("MASUK_NORMAL")."'
			, '".$this->getField("MULAI_MASUK_NORMAL")."'
			, '".$this->getField("AKHIR_MASUK_NORMAL")."'
			, '".$this->getField("KELUAR_NORMAL")."'
			, '".$this->getField("MULAI_KELUAR_NORMAL")."'
			, '".$this->getField("AKHIR_KELUAR_NORMAL")."'
			, '".$this->getField("KELUAR_GANTI_HARI_NORMAL")."'
			, '".$this->getField("STATUS_ASK_NORMAL")."'
			, '".$this->getField("AKHIR_ASK_NORMAL")."'
			, '".$this->getField("STATUS_CEK_NORMAL")."'
			, '".$this->getField("AWAL_CEK_NORMAL")."'
			, '".$this->getField("AKHIR_CEK_NORMAL")."'
			, '".$this->getField("MASUK_RAMADHAN")."'
			, '".$this->getField("MULAI_MASUK_RAMADHAN")."'
			, '".$this->getField("AKHIR_MASUK_RAMADHAN")."'
			, '".$this->getField("KELUAR_RAMADHAN")."'
			, '".$this->getField("MULAI_KELUAR_RAMADHAN")."'
			, '".$this->getField("AKHIR_KELUAR_RAMADHAN")."'
			, '".$this->getField("KELUAR_GANTI_HARI_RAMADHAN")."'
			, '".$this->getField("STATUS_ASK_RAMADHAN")."'
			, '".$this->getField("AKHIR_ASK_RAMADHAN")."'
			, '".$this->getField("STATUS_CEK_RAMADHAN")."'
			, '".$this->getField("AWAL_CEK_RAMADHAN")."'
			, '".$this->getField("AKHIR_CEK_RAMADHAN")."'
			, '".$this->getField("STATUS_JAM_KERJA_RAMADHAN")."'
			--, ".$this->getField("MULAI_RAMADHAN_BERLAKU")."
			--, ".$this->getField("AKHIR_RAMADHAN_BERLAKU")."
			, '".$this->getField("SATUAN_KERJA_ID")."'
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->id= $this->getField("KERJA_JAM_SHIFT_ID");
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function updateJamShift()
	{
		$str= "
		UPDATE presensi.KERJA_JAM_SHIFT
		SET
			NAMA_JAM_KERJA= '".$this->getField("NAMA_JAM_KERJA")."'
			, MULAI_BERLAKU= ".$this->getField("MULAI_BERLAKU")."
			, AKHIR_BERLAKU= ".$this->getField("AKHIR_BERLAKU")."
			, STATUS_JAM_KERJA= '".$this->getField("STATUS_JAM_KERJA")."'
			, MASUK_NORMAL= '".$this->getField("MASUK_NORMAL")."'
			, MULAI_MASUK_NORMAL= '".$this->getField("MULAI_MASUK_NORMAL")."'
			, AKHIR_MASUK_NORMAL= '".$this->getField("AKHIR_MASUK_NORMAL")."'
			, KELUAR_NORMAL= '".$this->getField("KELUAR_NORMAL")."'
			, MULAI_KELUAR_NORMAL= '".$this->getField("MULAI_KELUAR_NORMAL")."'
			, AKHIR_KELUAR_NORMAL= '".$this->getField("AKHIR_KELUAR_NORMAL")."'
			, KELUAR_GANTI_HARI_NORMAL= '".$this->getField("KELUAR_GANTI_HARI_NORMAL")."'
			, STATUS_ASK_NORMAL= '".$this->getField("STATUS_ASK_NORMAL")."'
			, AKHIR_ASK_NORMAL= '".$this->getField("AKHIR_ASK_NORMAL")."'
			, STATUS_CEK_NORMAL= '".$this->getField("STATUS_CEK_NORMAL")."'
			, AWAL_CEK_NORMAL= '".$this->getField("AWAL_CEK_NORMAL")."'
			, AKHIR_CEK_NORMAL= '".$this->getField("AKHIR_CEK_NORMAL")."'
			, MASUK_RAMADHAN= '".$this->getField("MASUK_RAMADHAN")."'
			, MULAI_MASUK_RAMADHAN= '".$this->getField("MULAI_MASUK_RAMADHAN")."'
			, AKHIR_MASUK_RAMADHAN= '".$this->getField("AKHIR_MASUK_RAMADHAN")."'
			, KELUAR_RAMADHAN= '".$this->getField("KELUAR_RAMADHAN")."'
			, MULAI_KELUAR_RAMADHAN= '".$this->getField("MULAI_KELUAR_RAMADHAN")."'
			, AKHIR_KELUAR_RAMADHAN= '".$this->getField("AKHIR_KELUAR_RAMADHAN")."'
			, KELUAR_GANTI_HARI_RAMADHAN= '".$this->getField("KELUAR_GANTI_HARI_RAMADHAN")."'
			, STATUS_ASK_RAMADHAN= '".$this->getField("STATUS_ASK_RAMADHAN")."'
			, AKHIR_ASK_RAMADHAN= '".$this->getField("AKHIR_ASK_RAMADHAN")."'
			, STATUS_CEK_RAMADHAN= '".$this->getField("STATUS_CEK_RAMADHAN")."'
			, AWAL_CEK_RAMADHAN= '".$this->getField("AWAL_CEK_RAMADHAN")."'
			, AKHIR_CEK_RAMADHAN= '".$this->getField("AKHIR_CEK_RAMADHAN")."'
			, STATUS_JAM_KERJA_RAMADHAN= '".$this->getField("STATUS_JAM_KERJA_RAMADHAN")."'
			--, MULAI_RAMADHAN_BERLAKU= ".$this->getField("MULAI_RAMADHAN_BERLAKU")."
			--, AKHIR_RAMADHAN_BERLAKU= ".$this->getField("AKHIR_RAMADHAN_BERLAKU")."
			, SATUAN_KERJA_ID= '".$this->getField("SATUAN_KERJA_ID")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE KERJA_JAM_SHIFT_ID = '".$this->getField("KERJA_JAM_SHIFT_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	/*function delete()
    {
        $str = "DELETE FROM presensi.KLARIFIKASI WHERE  KLARIFIKASI_ID = ".$this->getField("KLARIFIKASI_ID").""; 
                  
        $this->query = $str;
        return $this->execQuery($str);
    }*/

	function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
		A.*
		, TO_CHAR(MULAI_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') MULAI_BERLAKU_INFO
		, TO_CHAR(AKHIR_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') AKHIR_BERLAKU_INFO
		, TO_CHAR(MULAI_RAMADHAN_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') MULAI_RAMADHAN_BERLAKU_INFO
		, TO_CHAR(AKHIR_RAMADHAN_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') AKHIR_RAMADHAN_BERLAKU_INFO
		, TO_CHAR(LAST_DATE, 'YYYY-MM-DD HH24:MI:SS') LAST_DATE_INFO
		, 
		CASE A.JENIS_JAM_KERJA
		WHEN 'normal_5_hari' THEN 'Normal 5 Hari Kerja'
		WHEN 'normal_6_hari_pendidikan' THEN 'Normal 6 Hari Kerja Pendidikan'
		WHEN 'normal_6_hari_kesehatan' THEN 'Normal 6 Hari Kerja Kesehatan'
		WHEN 'shift_5_hari' THEN 'Shift 5 Hari Kerja'
		ELSE '' END JENIS_JAM_KERJA_INFO
		, 
		CASE A.HARI_KHUSUS
		WHEN '1' THEN 'Jumat'
		WHEN '2' THEN 'Sabtu'
		ELSE '' END HARI_KHUSUS_INFO
		, 
		CASE A.STATUS_JAM_KERJA
		WHEN '1' THEN 'Tidak Aktif'
		ELSE 'Aktif' END STATUS_JAM_KERJA_INFO
		,
		CASE A.STATUS_JAM_KERJA_RAMADHAN
		WHEN '1' THEN 'Tidak Aktif'
		ELSE 'Aktif' END STATUS_JAM_KERJA_RAMADHAN_INFO
		,
		CASE A.STATUS_ASK_NORMAL
		WHEN '1' THEN 'Aktif'
		ELSE 'Tidak Aktif' END STATUS_ASK_NORMAL_INFO
		,
		CASE A.STATUS_ASK_RAMADHAN
		WHEN '1' THEN 'Aktif'
		ELSE 'Tidak Aktif' END STATUS_ASK_RAMADHAN_INFO
		FROM presensi.KERJA_JAM A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM presensi.KERJA_JAM A
		WHERE 1 = 1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function selectByParamsJamShift($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
		A.*
		, TO_CHAR(MULAI_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') MULAI_BERLAKU_INFO
		, TO_CHAR(AKHIR_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') AKHIR_BERLAKU_INFO
		, TO_CHAR(MULAI_RAMADHAN_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') MULAI_RAMADHAN_BERLAKU_INFO
		, TO_CHAR(AKHIR_RAMADHAN_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') AKHIR_RAMADHAN_BERLAKU_INFO
		, TO_CHAR(LAST_DATE, 'YYYY-MM-DD HH24:MI:SS') LAST_DATE_INFO
		, 
		CASE A.STATUS_JAM_KERJA
		WHEN '1' THEN 'Tidak Aktif'
		ELSE 'Aktif' END STATUS_JAM_KERJA_INFO
		,
		CASE A.STATUS_JAM_KERJA_RAMADHAN
		WHEN '1' THEN 'Tidak Aktif'
		ELSE 'Aktif' END STATUS_JAM_KERJA_RAMADHAN_INFO
		,
		CASE A.KELUAR_GANTI_HARI_NORMAL
		WHEN '1' THEN 'Ya'
		ELSE 'Tidak' END KELUAR_GANTI_HARI_NORMAL_INFO
		,
		CASE A.KELUAR_GANTI_HARI_RAMADHAN
		WHEN '1' THEN 'Ya'
		ELSE 'Tidak' END KELUAR_GANTI_HARI_RAMADHAN_INFO
		,
		CASE A.STATUS_ASK_NORMAL
		WHEN '1' THEN 'Aktif'
		ELSE 'Tidak Aktif' END STATUS_ASK_NORMAL_INFO
		,
		CASE A.STATUS_ASK_RAMADHAN
		WHEN '1' THEN 'Aktif'
		ELSE 'Tidak Aktif' END STATUS_ASK_RAMADHAN_INFO
		FROM presensi.KERJA_JAM_SHIFT A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParamsJamShift($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM presensi.KERJA_JAM_SHIFT A
		WHERE 1 = 1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function insertpegawai()
	{
		$str= "
		INSERT INTO presensi.KERJA_JAM_PEGAWAI
		(
			PEGAWAI_ID, JENIS_JAM_KERJA
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("PEGAWAI_ID")."'
			, '".$this->getField("JENIS_JAM_KERJA")."'
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function updatepegawai()
	{
		$str= "
		UPDATE presensi.KERJA_JAM_PEGAWAI
		SET
			JENIS_JAM_KERJA= '".$this->getField("JENIS_JAM_KERJA")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function selectByParamsJamPegawaiData($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
			*
		FROM presensi.KERJA_JAM_PEGAWAI A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function selectByParamsJamPegawai($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='ORDER BY A.PEGAWAI_ID')
	{
		$str = "
		SELECT
			A.PEGAWAI_ID, A.NIP_BARU, A.NAMA_LENGKAP, A.JABATAN_RIWAYAT_NAMA, A.SATUAN_KERJA_ID
			, CASE WHEN A.STATUS_PEGAWAI_ID IN (1,2) THEN 'Aktif' ELSE 'Tidak Aktif' END STATUS_PEGAWAI_INFO
			, 
			CASE B.JENIS_JAM_KERJA
			WHEN 'normal_5_hari' THEN 'Normal 5 Hari Kerja'
			WHEN 'normal_6_hari_pendidikan' THEN 'Normal 6 Hari Kerja Pendidikan'
			WHEN 'normal_6_hari_kesehatan' THEN 'Normal 6 Hari Kerja Kesehatan'
			WHEN 'shift_5_hari' THEN 'Shift 5 Hari Kerja'
			WHEN 'normal_5_hk_smpn' THEN 'Normal 5 HK SMPN'
			WHEN 'normal_5_hk_sdn' THEN 'Normal 5 HK SDN'
			WHEN 'normal_5_hk_tk' THEN 'Normal 5 HK TK/PAUD'
			WHEN 'normal_5_hk_kesehatan' THEN 'Normal 5 HK Kesehatan'
			ELSE 'Normal 5 Hari Kerja' END JENIS_JAM_KERJA_INFO
			, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_INFO
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.KERJA_JAM_PEGAWAI B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParamsJamPegawai($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.KERJA_JAM_PEGAWAI B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function selectByParamsAwfhJamPegawai($paramsArray=array(),$limit=-1,$from=-1, $periode, $statement='', $order='')
	{
		$str = "
		SELECT
		A.PEGAWAI_ID, A.NIP_BARU, A.NAMA_LENGKAP, A.SATUAN_KERJA_ID
		, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_INFO
		, presensi.ambilstatusinfojadwal(B.HARI1) HARIINFO1, presensi.ambilstatusinfojadwal(B.HARI2) HARIINFO2, presensi.ambilstatusinfojadwal(B.HARI3) HARIINFO3, presensi.ambilstatusinfojadwal(B.HARI4) HARIINFO4, presensi.ambilstatusinfojadwal(B.HARI5) HARIINFO5, presensi.ambilstatusinfojadwal(B.HARI6) HARIINFO6, presensi.ambilstatusinfojadwal(B.HARI7) HARIINFO7, presensi.ambilstatusinfojadwal(B.HARI8) HARIINFO8, presensi.ambilstatusinfojadwal(B.HARI9) HARIINFO9, presensi.ambilstatusinfojadwal(B.HARI10) HARIINFO10
		, presensi.ambilstatusinfojadwal(B.HARI11) HARIINFO11, presensi.ambilstatusinfojadwal(B.HARI12) HARIINFO12, presensi.ambilstatusinfojadwal(B.HARI13) HARIINFO13, presensi.ambilstatusinfojadwal(B.HARI14) HARIINFO14, presensi.ambilstatusinfojadwal(B.HARI15) HARIINFO15, presensi.ambilstatusinfojadwal(B.HARI16) HARIINFO16, presensi.ambilstatusinfojadwal(B.HARI17) HARIINFO17, presensi.ambilstatusinfojadwal(B.HARI18) HARIINFO18, presensi.ambilstatusinfojadwal(B.HARI19) HARIINFO19, presensi.ambilstatusinfojadwal(B.HARI20) HARIINFO20
		, presensi.ambilstatusinfojadwal(B.HARI21) HARIINFO21, presensi.ambilstatusinfojadwal(B.HARI22) HARIINFO22, presensi.ambilstatusinfojadwal(B.HARI23) HARIINFO23, presensi.ambilstatusinfojadwal(B.HARI24) HARIINFO24, presensi.ambilstatusinfojadwal(B.HARI25) HARIINFO25, presensi.ambilstatusinfojadwal(B.HARI26) HARIINFO26, presensi.ambilstatusinfojadwal(B.HARI27) HARIINFO27, presensi.ambilstatusinfojadwal(B.HARI28) HARIINFO28, presensi.ambilstatusinfojadwal(B.HARI29) HARIINFO29, presensi.ambilstatusinfojadwal(B.HARI30) HARIINFO30
		, presensi.ambilstatusinfojadwal(B.HARI31) HARIINFO31
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.vkerjajamawfhpegawai('".$periode."') B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParamsAwfhJamPegawai($paramsArray=array(), $periode, $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM PINFOAKHIR() A
		WHERE 1=1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function insertawfhpegawai()
	{
		$str= "
		INSERT INTO presensi.KERJA_JAM_AWFH_PEGAWAI
		(
			HARI, PERIODE, PEGAWAI_ID, STATUS
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("HARI")."'
			, '".$this->getField("PERIODE")."'
			, '".$this->getField("PEGAWAI_ID")."'
			, ".$this->getField("STATUS")."
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function updateawfhpegawai()
	{
		$str= "
		UPDATE presensi.KERJA_JAM_AWFH_PEGAWAI
		SET
			STATUS= ".$this->getField("STATUS")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE HARI = '".$this->getField("HARI")."' AND PERIODE = '".$this->getField("PERIODE")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function deleteawfhpegawai()
	{
		$str= "
		DELETE FROM presensi.KERJA_JAM_AWFH_PEGAWAI
		WHERE HARI = '".$this->getField("HARI")."' AND PERIODE = '".$this->getField("PERIODE")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function selectByParamsJamAwfhPegawaiData($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
			*
		FROM presensi.KERJA_JAM_AWFH_PEGAWAI A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function selectByParamsAwfhJamPegawaiView($paramsArray=array(),$limit=-1,$from=-1, $periode, $statement='', $order='ORDER BY A.PEGAWAI_ID')
	{
		$str = "
		SELECT
		A.PEGAWAI_ID, A.NIP_BARU, A.NAMA_LENGKAP, A.SATUAN_KERJA_ID
		, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_INFO
		, B.HARI1, B.HARI2, B.HARI3, B.HARI4, B.HARI5, B.HARI6, B.HARI7, B.HARI8, B.HARI9, B.HARI10
		, B.HARI11, B.HARI12, B.HARI13, B.HARI14, B.HARI15, B.HARI16, B.HARI17, B.HARI18, B.HARI19, B.HARI20
		, B.HARI21, B.HARI22, B.HARI23, B.HARI24, B.HARI25, B.HARI26, B.HARI27, B.HARI28, B.HARI29, B.HARI30
		, B.HARI31
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.vkerjajamawfhpegawai('".$periode."') B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function selectByParamsShiftJamPegawai($paramsArray=array(),$limit=-1,$from=-1, $periode, $statement='', $order='')
	{
		$str = "
		SELECT
		A.PEGAWAI_ID, A.NIP_BARU, A.NAMA_LENGKAP, A.SATUAN_KERJA_ID
		, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_INFO
		, presensi.ambilstatusinfojadwalshift(B.HARI1) HARIINFO1, presensi.ambilstatusinfojadwalshift(B.HARI2) HARIINFO2, presensi.ambilstatusinfojadwalshift(B.HARI3) HARIINFO3, presensi.ambilstatusinfojadwalshift(B.HARI4) HARIINFO4, presensi.ambilstatusinfojadwalshift(B.HARI5) HARIINFO5, presensi.ambilstatusinfojadwalshift(B.HARI6) HARIINFO6, presensi.ambilstatusinfojadwalshift(B.HARI7) HARIINFO7, presensi.ambilstatusinfojadwalshift(B.HARI8) HARIINFO8, presensi.ambilstatusinfojadwalshift(B.HARI9) HARIINFO9, presensi.ambilstatusinfojadwalshift(B.HARI10) HARIINFO10
		, presensi.ambilstatusinfojadwalshift(B.HARI11) HARIINFO11, presensi.ambilstatusinfojadwalshift(B.HARI12) HARIINFO12, presensi.ambilstatusinfojadwalshift(B.HARI13) HARIINFO13, presensi.ambilstatusinfojadwalshift(B.HARI14) HARIINFO14, presensi.ambilstatusinfojadwalshift(B.HARI15) HARIINFO15, presensi.ambilstatusinfojadwalshift(B.HARI16) HARIINFO16, presensi.ambilstatusinfojadwalshift(B.HARI17) HARIINFO17, presensi.ambilstatusinfojadwalshift(B.HARI18) HARIINFO18, presensi.ambilstatusinfojadwalshift(B.HARI19) HARIINFO19, presensi.ambilstatusinfojadwalshift(B.HARI20) HARIINFO20
		, presensi.ambilstatusinfojadwalshift(B.HARI21) HARIINFO21, presensi.ambilstatusinfojadwalshift(B.HARI22) HARIINFO22, presensi.ambilstatusinfojadwalshift(B.HARI23) HARIINFO23, presensi.ambilstatusinfojadwalshift(B.HARI24) HARIINFO24, presensi.ambilstatusinfojadwalshift(B.HARI25) HARIINFO25, presensi.ambilstatusinfojadwalshift(B.HARI26) HARIINFO26, presensi.ambilstatusinfojadwalshift(B.HARI27) HARIINFO27, presensi.ambilstatusinfojadwalshift(B.HARI28) HARIINFO28, presensi.ambilstatusinfojadwalshift(B.HARI29) HARIINFO29, presensi.ambilstatusinfojadwalshift(B.HARI30) HARIINFO30
		, presensi.ambilstatusinfojadwalshift(B.HARI31) HARIINFO31
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.vkerjajamshiftpegawai('".$periode."') B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParamsShiftJamPegawai($paramsArray=array(), $periode, $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM PINFOAKHIR() A
		WHERE 1=1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function insertshiftpegawai()
	{
		$str= "
		INSERT INTO presensi.KERJA_JAM_SHIFT_PEGAWAI
		(
			HARI, PERIODE, PEGAWAI_ID, STATUS
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("HARI")."'
			, '".$this->getField("PERIODE")."'
			, '".$this->getField("PEGAWAI_ID")."'
			, ".$this->getField("STATUS")."
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function updateshiftpegawai()
	{
		$str= "
		UPDATE presensi.KERJA_JAM_SHIFT_PEGAWAI
		SET
			STATUS= ".$this->getField("STATUS")."
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE HARI = '".$this->getField("HARI")."' AND PERIODE = '".$this->getField("PERIODE")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function deleteshiftpegawai()
	{
		$str= "
		DELETE FROM presensi.KERJA_JAM_SHIFT_PEGAWAI
		WHERE HARI = '".$this->getField("HARI")."' AND PERIODE = '".$this->getField("PERIODE")."' AND PEGAWAI_ID = '".$this->getField("PEGAWAI_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function selectByParamsJamShiftPegawaiData($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
			*
		FROM presensi.KERJA_JAM_SHIFT_PEGAWAI A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function selectByParamsShiftJamPegawaiView($paramsArray=array(),$limit=-1,$from=-1, $periode, $statement='', $order='ORDER BY A.PEGAWAI_ID')
	{
		$str = "
		SELECT
		A.PEGAWAI_ID, A.NIP_BARU, A.NAMA_LENGKAP, A.SATUAN_KERJA_ID
		, AMBIL_SATKER_NAMA_DETIL(A.SATUAN_KERJA_ID) SATUAN_KERJA_INFO
		, B.HARI1, B.HARI2, B.HARI3, B.HARI4, B.HARI5, B.HARI6, B.HARI7, B.HARI8, B.HARI9, B.HARI10
		, B.HARI11, B.HARI12, B.HARI13, B.HARI14, B.HARI15, B.HARI16, B.HARI17, B.HARI18, B.HARI19, B.HARI20
		, B.HARI21, B.HARI22, B.HARI23, B.HARI24, B.HARI25, B.HARI26, B.HARI27, B.HARI28, B.HARI29, B.HARI30
		, B.HARI31
		FROM PINFOAKHIR() A
		LEFT JOIN presensi.vkerjajamshiftpegawai('".$periode."') B ON A.PEGAWAI_ID = CAST(B.PEGAWAI_ID AS NUMERIC)
		WHERE 1=1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function selectByParamsJamRamadhan($paramsArray=array(),$limit=-1,$from=-1, $statement='', $order='')
	{
		$str = "
		SELECT
		A.*
		, TO_CHAR(MULAI_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') MULAI_BERLAKU_INFO
		, TO_CHAR(AKHIR_BERLAKU, 'YYYY-MM-DD HH24:MI:SS') AKHIR_BERLAKU_INFO
		--, TO_CHAR(MULAI_BERLAKU, 'YYYY-MM-DD') MULAI_BERLAKU_INFO
		--, TO_CHAR(AKHIR_BERLAKU, 'YYYY-MM-DD') AKHIR_BERLAKU_INFO
		, 
		CASE A.STATUS_JAM_KERJA
		WHEN '1' THEN 'Tidak Aktif'
		ELSE 'Aktif' END STATUS_JAM_KERJA_INFO
		FROM presensi.JADWAL_RAMADHAN A
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		// echo $str;exit();
		return $this->selectLimit($str,$limit,$from);
	}

	function getCountByParamsJamRamadhan($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM presensi.JADWAL_RAMADHAN A
		WHERE 1 = 1 ".$statement;
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		$this->query = $str;
		// echo $str;exit();
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0;  
	}

	function insertJamRamadhan()
	{
		$this->setField("JADWAL_RAMADHAN_ID", $this->getNextId("JADWAL_RAMADHAN_ID","presensi.JADWAL_RAMADHAN"));

		$str= "
		INSERT INTO presensi.JADWAL_RAMADHAN
		(
			JADWAL_RAMADHAN_ID, MULAI_BERLAKU, AKHIR_BERLAKU, STATUS_JAM_KERJA
			, LAST_CREATE_USER, LAST_CREATE_DATE, LAST_USER, LAST_DATE
		) 
		VALUES 
		(
			'".$this->getField("JADWAL_RAMADHAN_ID")."'
			, ".$this->getField("MULAI_BERLAKU")."
			, ".$this->getField("AKHIR_BERLAKU")."
			, '".$this->getField("STATUS_JAM_KERJA")."'
			, '".$this->getField("LAST_CREATE_USER")."'
			, ".$this->getField("LAST_CREATE_DATE")."
			, '".$this->getField("LAST_USER")."'
			, ".$this->getField("LAST_DATE")."
		)
		";

		$this->id= $this->getField("JADWAL_RAMADHAN_ID");
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

	function updateJamRamadhan()
	{
		$str= "
		UPDATE presensi.JADWAL_RAMADHAN
		SET
			MULAI_BERLAKU= ".$this->getField("MULAI_BERLAKU")."
			, AKHIR_BERLAKU= ".$this->getField("AKHIR_BERLAKU")."
			, STATUS_JAM_KERJA= '".$this->getField("STATUS_JAM_KERJA")."'
			, LAST_UPDATE_USER= '".$this->getField("LAST_UPDATE_USER")."'
			, LAST_UPDATE_DATE= ".$this->getField("LAST_UPDATE_DATE")."
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
		WHERE JADWAL_RAMADHAN_ID = '".$this->getField("JADWAL_RAMADHAN_ID")."'
		";
		
		$this->query= $str;
		// echo $str;exit();
		return $this->execQuery($str);
	}

} 
?>