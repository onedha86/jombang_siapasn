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
  
  class PenilaianSkp extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function PenilaianSkp()
	{
      $this->Entity(); 
    }

	function insert()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENILAIAN_SKP_ID", $this->getNextId("PENILAIAN_SKP_ID","PENILAIAN_SKP"));
     	$str = "
     	INSERT INTO PENILAIAN_SKP 
     	(
	     	PENILAIAN_SKP_ID, PEGAWAI_ID, TAHUN, PEGAWAI_PEJABAT_PENILAI_ID, PEGAWAI_ATASAN_PEJABAT_ID
	     	, SKP_NILAI, SKP_HASIL, ORIENTASI_NILAI, INTEGRITAS_NILAI, KOMITMEN_NILAI, DISIPLIN_NILAI
	     	, KERJASAMA_NILAI, KEPEMIMPINAN_NILAI, PERILAKU_NILAI
	     	, PERILAKU_HASIL, PRESTASI_HASIL, JUMLAH_NILAI, RATA_NILAI, KEBERATAN, KEBERATAN_TANGGAL
	     	, TANGGAPAN, TANGGAPAN_TANGGAL, KEPUTUSAN, KEPUTUSAN_TANGGAL, REKOMENDASI
	     	, PEGAWAI_PEJABAT_PENILAI_NIP, PEGAWAI_PEJABAT_PENILAI_NAMA, PEGAWAI_ATASAN_PEJABAT_NIP
	     	, PEGAWAI_ATASAN_PEJABAT_NAMA, LAST_USER, LAST_DATE, LAST_LEVEL, USER_LOGIN_ID
	     	, USER_LOGIN_PEGAWAI_ID, PEGAWAI_UNOR_ID, PEGAWAI_UNOR_NAMA, JENIS_JABATAN_DINILAI
	     	, PEGAWAI_UNOR_ID2, PEGAWAI_UNOR_NAMA2, JENIS_JABATAN_DINILAI2, SKP_NILAI2
	     	, SKP_HASIL2, ORIENTASI_NILAI2, KOMITMEN_NILAI2, KERJASAMA_NILAI2, KEPEMIMPINAN_NILAI2
	     	, INISIATIFKERJA_NILAI2, JUMLAH_NILAI2, RATA_NILAI2, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA
	     	, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID
	     	, PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA, PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA
	     	, PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID, PEGAWAI_PEJABAT_PENILAI_ID2
	     	, PEGAWAI_PEJABAT_PENILAI_NIP2, PEGAWAI_PEJABAT_PENILAI_NAMA2
	     	, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2
	     	, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2, PEGAWAI_ATASAN_PEJABAT_ID2
	     	, PEGAWAI_ATASAN_PEJABAT_NIP2, PEGAWAI_ATASAN_PEJABAT_NAMA2
	     	, PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2, PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2
	     	, PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2, NILAI_HASIL_KERJA, NILAI_HASIL_PERILAKU
     	) 
     	VALUES 
     	(
	     	".$this->getField("PENILAIAN_SKP_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, ".$this->getField("TAHUN")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID")."
	     	, ".$this->getField("PEGAWAI_ATASAN_PEJABAT_ID")."
	     	, ".$this->getField("SKP_NILAI")."
	     	, ".$this->getField("SKP_HASIL")."
	     	, ".$this->getField("ORIENTASI_NILAI")."
	     	, ".$this->getField("INTEGRITAS_NILAI")."
	     	, ".$this->getField("KOMITMEN_NILAI")."
	     	, ".$this->getField("DISIPLIN_NILAI")."
	     	, ".$this->getField("KERJASAMA_NILAI")."
	     	, ".$this->getField("KEPEMIMPINAN_NILAI")."
	     	, ".$this->getField("PERILAKU_NILAI")."
	     	, ".$this->getField("PERILAKU_HASIL")."
	     	, ".$this->getField("PRESTASI_HASIL")."
	     	, ".$this->getField("JUMLAH_NILAI")."
	     	, ".$this->getField("RATA_NILAI")."
	     	, '".$this->getField("KEBERATAN")."'
	     	, ".$this->getField("KEBERATAN_TANGGAL")."
	     	, '".$this->getField("TANGGAPAN")."'
	     	, ".$this->getField("TANGGAPAN_TANGGAL")."
	     	, '".$this->getField("KEPUTUSAN")."'
	     	, ".$this->getField("KEPUTUSAN_TANGGAL")."
	     	, '".$this->getField("REKOMENDASI")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NIP")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NAMA")."'
	     	, '".$this->getField("LAST_USER")."'
	     	, ".$this->getField("LAST_DATE")."
	     	, ".$this->getField("LAST_LEVEL")."
	     	, ".$this->getField("USER_LOGIN_ID")."
	     	, ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
	     	, ".$this->getField("PEGAWAI_UNOR_ID")."
	     	, '".$this->getField("PEGAWAI_UNOR_NAMA")."'
	     	, ".$this->getField("JENIS_JABATAN_DINILAI")."
	     	, ".$this->getField("PEGAWAI_UNOR_ID2")."
	     	, '".$this->getField("PEGAWAI_UNOR_NAMA2")."'
	     	, ".$this->getField("JENIS_JABATAN_DINILAI2")."
	     	, ".$this->getField("SKP_NILAI2")."
	     	, ".$this->getField("SKP_HASIL2")."
	     	, ".$this->getField("ORIENTASI_NILAI2")."
	     	, ".$this->getField("KOMITMEN_NILAI2")."
	     	, ".$this->getField("KERJASAMA_NILAI2")."
	     	, ".$this->getField("KEPEMIMPINAN_NILAI2")."
	     	, ".$this->getField("INISIATIFKERJA_NILAI2")."
	     	, ".$this->getField("JUMLAH_NILAI2")."
	     	, ".$this->getField("RATA_NILAI2")."
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA")."'
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID")."
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA")."'
	     	, ".$this->getField("PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID2")."
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP2")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA2")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2")."'
	     	, '".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2")."'
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2")."
	     	, ".$this->getField("PEGAWAI_ATASAN_PEJABAT_ID2")."
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NIP2")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NAMA2")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2")."'
	     	, '".$this->getField("PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2")."'
	     	, ".$this->getField("PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2")."
	     	, ".$this->getField("NILAI_HASIL_KERJA")."
	     	, ".$this->getField("NILAI_HASIL_PERILAKU")."
     	)
		"; 	
		$this->id = $this->getField("PENILAIAN_SKP_ID");
		$this->query = $str; 
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function update()
	{
		$str = "		
		UPDATE PENILAIAN_SKP 
		SET  
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, TAHUN= ".$this->getField("TAHUN")."
			, PEGAWAI_PEJABAT_PENILAI_ID= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID")."
			, PEGAWAI_ATASAN_PEJABAT_ID= ".$this->getField("PEGAWAI_ATASAN_PEJABAT_ID")."
			, SKP_NILAI= ".$this->getField("SKP_NILAI")."
			, SKP_HASIL= ".$this->getField("SKP_HASIL")."
			, ORIENTASI_NILAI= ".$this->getField("ORIENTASI_NILAI")."
			, INTEGRITAS_NILAI= ".$this->getField("INTEGRITAS_NILAI")."
			, KOMITMEN_NILAI= ".$this->getField("KOMITMEN_NILAI")."
			, DISIPLIN_NILAI= ".$this->getField("DISIPLIN_NILAI")."
			, KERJASAMA_NILAI= ".$this->getField("KERJASAMA_NILAI")."
			, KEPEMIMPINAN_NILAI= ".$this->getField("KEPEMIMPINAN_NILAI")."
			, PERILAKU_NILAI= ".$this->getField("PERILAKU_NILAI")."
			, PERILAKU_HASIL= ".$this->getField("PERILAKU_HASIL")."
			, PRESTASI_HASIL= ".$this->getField("PRESTASI_HASIL")."
			, JUMLAH_NILAI= ".$this->getField("JUMLAH_NILAI")."
			, RATA_NILAI= ".$this->getField("RATA_NILAI")."
			, KEBERATAN= '".$this->getField("KEBERATAN")."'
			, KEBERATAN_TANGGAL= ".$this->getField("KEBERATAN_TANGGAL")."
			, TANGGAPAN= '".$this->getField("TANGGAPAN")."'
			, TANGGAPAN_TANGGAL= ".$this->getField("TANGGAPAN_TANGGAL")."
			, KEPUTUSAN= '".$this->getField("KEPUTUSAN")."'
			, KEPUTUSAN_TANGGAL= ".$this->getField("KEPUTUSAN_TANGGAL")."
			, REKOMENDASI= '".$this->getField("REKOMENDASI")."'
			, PEGAWAI_PEJABAT_PENILAI_NIP= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP")."'
			, PEGAWAI_PEJABAT_PENILAI_NAMA= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA")."'
			, PEGAWAI_ATASAN_PEJABAT_NIP= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NIP")."'
			, PEGAWAI_ATASAN_PEJABAT_NAMA= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NAMA")."'
			, LAST_USER= '".$this->getField("LAST_USER")."'
			, LAST_DATE= ".$this->getField("LAST_DATE")."
			, USER_LOGIN_ID= ".$this->getField("USER_LOGIN_ID")."
			, USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID")."
			, LAST_LEVEL= ".$this->getField("LAST_LEVEL")."
			, PEGAWAI_UNOR_ID= ".$this->getField("PEGAWAI_UNOR_ID")."
			, PEGAWAI_UNOR_NAMA='".$this->getField("PEGAWAI_UNOR_NAMA")."'
			, JENIS_JABATAN_DINILAI= ".$this->getField("JENIS_JABATAN_DINILAI")."
			, PEGAWAI_UNOR_ID2= ".$this->getField("PEGAWAI_UNOR_ID2")."
			, PEGAWAI_UNOR_NAMA2= '".$this->getField("PEGAWAI_UNOR_NAMA2")."'
			, JENIS_JABATAN_DINILAI2= ".$this->getField("JENIS_JABATAN_DINILAI2")."
			, SKP_NILAI2= ".$this->getField("SKP_NILAI2")."
			, SKP_HASIL2= ".$this->getField("SKP_HASIL2")."
			, ORIENTASI_NILAI2= ".$this->getField("ORIENTASI_NILAI2")."
			, KOMITMEN_NILAI2= ".$this->getField("KOMITMEN_NILAI2")."
			, KERJASAMA_NILAI2= ".$this->getField("KERJASAMA_NILAI2")."
			, KEPEMIMPINAN_NILAI2= ".$this->getField("KEPEMIMPINAN_NILAI2")."
			, INISIATIFKERJA_NILAI2= ".$this->getField("INISIATIFKERJA_NILAI2")."
			, JUMLAH_NILAI2= ".$this->getField("JUMLAH_NILAI2")."
			, RATA_NILAI2= ".$this->getField("RATA_NILAI2")."
			, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA")."'
			, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA")."'
			, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID")."
			, PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA")."'
			, PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA")."'
			, PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID= ".$this->getField("PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID")."
			, PEGAWAI_PEJABAT_PENILAI_ID2= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID2")."
			, PEGAWAI_PEJABAT_PENILAI_NIP2= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP2")."'
			, PEGAWAI_PEJABAT_PENILAI_NAMA2= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA2")."'
			, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2")."'
			, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2= '".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2")."'
			, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2")."
			, PEGAWAI_ATASAN_PEJABAT_ID2= ".$this->getField("PEGAWAI_ATASAN_PEJABAT_ID2")."
			, PEGAWAI_ATASAN_PEJABAT_NIP2= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NIP2")."'
			, PEGAWAI_ATASAN_PEJABAT_NAMA2= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_NAMA2")."'
			, PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2")."'
			, PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2= '".$this->getField("PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2")."'
			, PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2= ".$this->getField("PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2")."
			, NILAI_HASIL_KERJA= ".$this->getField("NILAI_HASIL_KERJA")."
			, NILAI_HASIL_PERILAKU= ".$this->getField("NILAI_HASIL_PERILAKU")."
		WHERE PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
		"; 
		$this->query = $str;
		// echo $str;exit;
		// echo $this->errorMsg;exit;
		return $this->execQuery($str);
    }

    function insertDataBkn()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PENILAIAN_SKP_ID", $this->getNextId("PENILAIAN_SKP_ID","PENILAIAN_SKP"));
     	$str = "
     	INSERT INTO PENILAIAN_SKP 
     	(
	     	PENILAIAN_SKP_ID, PEGAWAI_ID, TAHUN, PEGAWAI_PEJABAT_PENILAI_NIP
	     	, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID, PEGAWAI_PEJABAT_PENILAI_NAMA
	     	, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA
	     	, PEGAWAI_PEJABAT_PENILAI_ID, NILAI_HASIL_PERILAKU, NILAI_HASIL_KERJA
     	) 
     	VALUES 
     	(
	     	".$this->getField("PENILAIAN_SKP_ID")."
	     	, ".$this->getField("PEGAWAI_ID")."
	     	, '".$this->getField("TAHUN")."'
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA")."
	     	, ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID")."
	     	, ".$this->getField("NILAI_HASIL_PERILAKU")."
	     	, ".$this->getField("NILAI_HASIL_KERJA")."
     	)
		"; 	
		$this->id = $this->getField("PENILAIAN_SKP_ID");
		$this->query = $str; 
		// echo $str;exit;
		return $this->execQuery($str);
    }

    function updateBknData()
    {
		$str = "		
		UPDATE PENILAIAN_SKP 
		SET  
			PEGAWAI_ID= ".$this->getField("PEGAWAI_ID")."
			, TAHUN= '".$this->getField("TAHUN")."'
			, PEGAWAI_PEJABAT_PENILAI_NIP= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_NIP")."
			, PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID")."
			, PEGAWAI_PEJABAT_PENILAI_NAMA= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_NAMA")."
			, PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA")."
			, PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA")."
			, PEGAWAI_PEJABAT_PENILAI_ID= ".$this->getField("PEGAWAI_PEJABAT_PENILAI_ID")."
			, NILAI_HASIL_PERILAKU= ".$this->getField("NILAI_HASIL_PERILAKU")."
			, NILAI_HASIL_KERJA= ".$this->getField("NILAI_HASIL_KERJA")."
			
		WHERE PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
		"; 
		$this->query = $str;
		 // echo $str;exit;
		// echo $this->errorMsg;exit;
		return $this->execQuery($str);
    }

    function updateIdSapk()
	{
		$str = "		
		UPDATE PENILAIAN_SKP
		SET
		ID_SAPK= '".$this->getField("ID_SAPK")."'
		WHERE  PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }

    function updateStatusSync()
	{
		$str = "		
		UPDATE PENILAIAN_SKP
		SET
			SYNC_ID= '".$this->getField("SYNC_ID")."'
			, SYNC_NAMA= '".$this->getField("SYNC_NAMA")."'
			, SYNC_WAKTU= NOW()
			, SYNC_STATUS= '".$this->getField("SYNC_STATUS")."'
		WHERE PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
		"; 
		$this->query = $str;
	 	// echo "xxx-".$str;exit;
		return $this->execQuery($str);
    }
	
    function updateStatus()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "		
				UPDATE PENILAIAN_SKP
				SET    
					   STATUS   	= ".$this->getField("STATUS").",
					   LAST_USER	= '".$this->getField("LAST_USER")."',
					   LAST_LEVEL	= ".$this->getField("LAST_LEVEL").",
					   USER_LOGIN_ID	= ".$this->getField("USER_LOGIN_ID").",
					   USER_LOGIN_PEGAWAI_ID	= ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
					   LAST_DATE	= ".$this->getField("LAST_DATE")."
				WHERE  PENILAIAN_SKP_ID    	= ".$this->getField("PENILAIAN_SKP_ID")."
				"; 
		$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "
				UPDATE PENILAIAN_SKP SET
					STATUS = '1',
					LAST_USER= '".$this->getField("LAST_USER")."',
					USER_LOGIN_ID= '".$this->getField("USER_LOGIN_ID")."',
					USER_LOGIN_PEGAWAI_ID= ".$this->getField("USER_LOGIN_PEGAWAI_ID").",
					LAST_DATE= ".$this->getField("LAST_DATE")."
				WHERE PENILAIAN_SKP_ID = ".$this->getField("PENILAIAN_SKP_ID")."
				";
		$this->query = $str;
		return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","MASTER_KATEGORI_METODE_EVALUASI_ID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 

    function selectByParamsRekap($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
			A.PEGAWAI_ID, A.NIP_LAMA, A.NIP_BARU, A.NAMA
			, (CASE WHEN COALESCE(NULLIF(A.GELAR_DEPAN,'') , NULL ) IS NULL THEN '' ELSE A.GELAR_DEPAN || ' ' END) || A.NAMA || (CASE WHEN COALESCE(NULLIF(A.GELAR_BELAKANG,'') , NULL ) IS NULL THEN '' ELSE '' || A.GELAR_BELAKANG END) NAMA_LENGKAP
			, SK.NAMA SATUAN_KERJA_NAMA, AMBIL_SATKER_INDUK(A.SATUAN_KERJA_ID) SATUAN_KERJA_INDUK
			, PSKP.TAHUN, PSKP.SKP_NILAI, PSKP.SKP_HASIL
			, PSKP.ORIENTASI_NILAI, PSKP.INTEGRITAS_NILAI, PSKP.KOMITMEN_NILAI, PSKP.DISIPLIN_NILAI, PSKP.KERJASAMA_NILAI, PSKP.KEPEMIMPINAN_NILAI
			, PSKP.JUMLAH_NILAI, PSKP.RATA_NILAI, PSKP.PERILAKU_NILAI, PSKP.PERILAKU_HASIL, PSKP.PRESTASI_HASIL
		FROM PEGAWAI A
		LEFT JOIN SATUAN_KERJA SK ON SK.SATUAN_KERJA_ID = A.SATUAN_KERJA_ID
		INNER JOIN
		(
			SELECT 	
				A.PEGAWAI_ID, A.TAHUN, A.SKP_NILAI, A.SKP_HASIL, 
				A.ORIENTASI_NILAI, A.INTEGRITAS_NILAI, A.KOMITMEN_NILAI, A.DISIPLIN_NILAI, A.KERJASAMA_NILAI, A.KEPEMIMPINAN_NILAI,
				A.JUMLAH_NILAI, A.RATA_NILAI, A.PERILAKU_NILAI, A.PERILAKU_HASIL, A.PRESTASI_HASIL
			FROM PENILAIAN_SKP A 
			WHERE 1=1
			AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')
		) PSKP ON A.PEGAWAI_ID = PSKP.PEGAWAI_ID
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		return $this->selectLimit($str,$limit,$from); 
    }
	

    function getCountByParamsRekap($paramsArray=array(), $statement='')
	{
		$str = "
		SELECT COUNT(1) AS ROWCOUNT 
		FROM PEGAWAI A
		LEFT JOIN SATUAN_KERJA SK ON SK.SATUAN_KERJA_ID = A.SATUAN_KERJA_ID
		INNER JOIN
		(
			SELECT 	
				A.PEGAWAI_ID, A.TAHUN, A.SKP_NILAI, A.SKP_HASIL, 
				A.ORIENTASI_NILAI, A.INTEGRITAS_NILAI, A.KOMITMEN_NILAI, A.DISIPLIN_NILAI, A.KERJASAMA_NILAI, A.KEPEMIMPINAN_NILAI,
				A.JUMLAH_NILAI, A.RATA_NILAI, A.PERILAKU_NILAI, A.PERILAKU_HASIL, A.PRESTASI_HASIL
			FROM PENILAIAN_SKP A 
			WHERE 1=1
			AND (COALESCE(NULLIF(A.STATUS, ''), NULL) IS NULL OR A.STATUS = '2')
		) PSKP ON A.PEGAWAI_ID = PSKP.PEGAWAI_ID
		WHERE 1=1 ".$statement; 
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

    function selectByParams($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order=' ORDER BY A.TAHUN DESC')
	{
		$str = "
		SELECT 	
		A.PENILAIAN_SKP_ID, A.STATUS, A.PEGAWAI_ID, A.TAHUN, A.PEGAWAI_PEJABAT_PENILAI_ID, A.PEGAWAI_ATASAN_PEJABAT_ID, A.SKP_NILAI, 
		ROUND(A.SKP_HASIL,2) SKP_HASIL,
		A.ORIENTASI_NILAI, A.INTEGRITAS_NILAI, A.KOMITMEN_NILAI, A.DISIPLIN_NILAI, A.KERJASAMA_NILAI, A.KEPEMIMPINAN_NILAI,
		ROUND(A.PERILAKU_NILAI,2) PERILAKU_NILAI, ROUND(A.PERILAKU_HASIL,2) PERILAKU_HASIL, ROUND(A.PRESTASI_HASIL,2) PRESTASI_HASIL,
		A.JUMLAH_NILAI, ROUND(A.RATA_NILAI,2) RATA_NILAI, A.KEBERATAN, A.KEBERATAN_TANGGAL, A.TANGGAPAN, A.TANGGAPAN_TANGGAL, 
		A.KEPUTUSAN, A.KEPUTUSAN_TANGGAL, A.REKOMENDASI, A.PEGAWAI_PEJABAT_PENILAI_NIP, A.PEGAWAI_PEJABAT_PENILAI_NAMA, A.PEGAWAI_ATASAN_PEJABAT_NIP, 
		A.PEGAWAI_ATASAN_PEJABAT_NAMA, A.LAST_USER, A.LAST_DATE, A.LAST_LEVEL, 

		A.PEGAWAI_UNOR_ID, A.PEGAWAI_UNOR_NAMA, A.JENIS_JABATAN_DINILAI, A.PEGAWAI_UNOR_ID2, A.PEGAWAI_UNOR_NAMA2, A.JENIS_JABATAN_DINILAI2, A.SKP_NILAI2,
		A.SKP_HASIL2, A.ORIENTASI_NILAI2, A.KOMITMEN_NILAI2, A.KERJASAMA_NILAI2, A.KEPEMIMPINAN_NILAI2, A.INISIATIFKERJA_NILAI2, A.JUMLAH_NILAI2,
		A.RATA_NILAI2, A.PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA, A.PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA, A.PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID,
		A.PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA, A.PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA, A.PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID, A.PEGAWAI_PEJABAT_PENILAI_ID2,
		A.PEGAWAI_PEJABAT_PENILAI_NIP2, A.PEGAWAI_PEJABAT_PENILAI_NAMA2, A.PEGAWAI_PEJABAT_PENILAI_JABATAN_NAMA2, A.PEGAWAI_PEJABAT_PENILAI_UNOR_NAMA2,
		A.PEGAWAI_PEJABAT_PENILAI_PANGKAT_ID2, A.PEGAWAI_ATASAN_PEJABAT_ID2, A.PEGAWAI_ATASAN_PEJABAT_NIP2, A.PEGAWAI_ATASAN_PEJABAT_NAMA2,
		A.PEGAWAI_ATASAN_PEJABAT_JABATAN_NAMA2, A.PEGAWAI_ATASAN_PEJABAT_UNOR_NAMA2, A.PEGAWAI_ATASAN_PEJABAT_PANGKAT_ID2, A.NILAI_HASIL_KERJA,	A.NILAI_HASIL_PERILAKU
		, C.PEGAWAI_ID_SAPK,A.ID_SAPK
		FROM PENILAIAN_SKP A 
		LEFT JOIN PEGAWAI C ON C.PEGAWAI_ID = A.PEGAWAI_ID
		WHERE 1=1
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		# echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }

    function getCountByParams($paramsArray=array(), $statement='')
	{
		$str = "
				SELECT COUNT(A.PENILAIAN_SKP_ID) AS ROWCOUNT 
				FROM PENILAIAN_SKP A
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

	function selectByParamsCariJabatan($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT 	
		A.*
		FROM
		(
			select jabatan_ft_id id, nama, '' nama_detil from jabatan_ft
			union all
			select
			satuan_kerja_id id, nama_jabatan nama
			, ambil_satker_nama_dynamic(a.satuan_kerja_id) nama_detil
			from satuan_kerja a where 1= 1 and (a.tipe_jabatan_id not in (2) or a.tipe_jabatan_id is null)
			and masa_berlaku_akhir IS NULL
		)
		A 
		WHERE 1=1
		"; 
/**
*		coalesce(a.masa_berlaku_awal, to_date('2021-12-31','yyyy/mm/dd'))
*			<= to_date('2021-12-31','yyyy/mm/dd')
*			and
*			coalesce(a.masa_berlaku_akhir, to_date('2021-12-31','yyyy/mm/dd'))
*			>= to_date('2021-12-31','yyyy/mm/dd')
* 
* 
***/		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		# echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }

	function selectByParamsCariUnor($paramsArray=array(),$limit=-1,$from=-1, $statement='',$order='')
	{
		$str = "
		SELECT
		satuan_kerja_id id, nama nama,
		ambil_satker_nama_dynamic(a.satuan_kerja_id) nama_detil
		from satuan_kerja a
		WHERE masa_berlaku_akhir IS NULL
		"; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$str .= $statement." ".$order;
		$this->query = $str;
		# echo $str;exit();
		return $this->selectLimit($str,$limit,$from); 
    }

  } 
?>