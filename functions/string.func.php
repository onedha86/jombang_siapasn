<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: string.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */



/* fungsi untuk mengatur tampilan mata uang
 * $value = string
 * $digit = pengelompokan setiap berapa digit, default : 3
 * $symbol = menampilkan simbol mata uang (Rupiah), default : false
 * $minusToBracket = beri tanda kurung pada nilai negatif, default : true
 */
function ifZero2($var =''){
	$value=0;
	if(!empty($var)){
		$value=$var;
	}

	return $value;
}

function multi_array_search($array, $search)
{
    $result = array();

    foreach ($array as $key => $val)
    {
        foreach ($search as $k => $v)
        {
            // We check if the $k has an operator.
            $operator = '=';
            if (preg_match('(<|<=|>|>=|!=|=)', $k, $m) === 1)
            {
                // We change the operator.
                $operator = $m[0];

                // We trim $k to remove white spaces before and after.
                $k = trim(str_replace($m[0], '', $k));
            }

            switch ($operator)
            {
                case '=':
                    $cond = ($val[$k] != $v);
                    break;

                case '!=':
                    $cond = ($val[$k] == $v);
                    break;

                case '>':
                    $cond = ($val[$k] <= $v);
                    break;

                case '<':
                    $cond = ($val[$k] >= $v);
                    break;

                case '>=':
                    $cond = ($val[$k] < $sv);
                    break;

                case '<=':
                    $cond = ($val[$k] > $sv);
                    break;
            }

            if (( ! isset($val[$k]) && $val[$k] !== null) OR $cond)
            {
                continue 2;
            }
        }

        $result[] = $val ;
    }

    return $result;
}  

function currencyToPage($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = "Rp. ".$resValue."";
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";
	$resValue = str_replace("..", ",", $resValue);
	return $resValue;
}

function nomorDigit($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arrValue = explode(".", $value);
	$value = $arrValue[0];
	if(count($arrValue) == 1)
		$belakang_koma = "";
	else
		$belakang_koma = $arrValue[1];
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($belakang_koma == "")
		$resValue = $symbol." ".$resValue;
	else
		$resValue = $symbol." ".$resValue.",".$belakang_koma;
	
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}
	
	$resValue = $neg.$resValue;
	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}


function numberToIna($value, $symbol=true, $minusToBracket=true, $minusLess=false, $digit=3)
{
	$arr_value = explode(".", $value);
	
	if(count($arr_value) > 1)
		$value = $arr_value[0];
	
	if($value < 0)
	{
		$neg = "-";
		$value = str_replace("-", "", $value);
	}
	else
		$neg = false;
		
	$cntValue = strlen($value);
	//$cntValue = strlen($value);
	
	if($cntValue <= $digit)
		$resValue =  $value;
	
	$loopValue = floor($cntValue / $digit);
	
	for($i=1; $i<=$loopValue; $i++)
	{
		$sub = 0 - $i; //ubah jadi negatif
		$tempValue = $endValue;
		$endValue = substr($value, $sub*$digit, $digit);
		$endValue = $endValue;
		
		if($i !== 1)
			$endValue .= ".";
		
		$endValue .= $tempValue;
	}
	
	$beginValue = substr($value, 0, $cntValue - ($loopValue * $digit));
	
	if($cntValue % $digit == 0)
		$resValue = $beginValue.$endValue;
	else if($cntValue > $digit)
		$resValue = $beginValue.".".$endValue;
	
	//additional
	if($symbol == true && $resValue !== "")
	{
		$resValue = $resValue;
	}
	
	if($minusToBracket && $neg)
	{
		$resValue = "(".$resValue.")";
		$neg = "";
	}
	
	if($minusLess == true)
	{
		$neg = "";
	}

	if(count($arr_value) == 1)
		$resValue = $neg.$resValue;
	else
		$resValue = $neg.$resValue.",".$arr_value[1];
	

	
	//$resValue = "<span style='white-space:nowrap'>".$resValue."</span>";

	return $resValue;
}

function getNameValueYaTidak($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}

function getNameValueKategori($number) {
	$number = (int)$number;
	$arrValue = array("1"=>"Sangat Baik", "2"=>"Baik", "3"=>"Cukup", "4"=>"Kurang");
	return $arrValue[$number];
}	

function getNameValue($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak", "1"=>"Ya");
	return $arrValue[$number];
}	

function getNameValueAktif($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Tidak Aktif", "1"=>"Aktif");
	return $arrValue[$number];
}

function getNameValidasi($number) {
	$number = (int)$number;
	$arrValue = array("0"=>"Menunggu Konfirmasi","1"=>"Disetujui", "2"=>"Ditolak");
	return $arrValue[$number];
}	

function getNameInputOutput($char) {
	$arrValue = array("I"=>"Datang", "O"=>"Pulang");
	return $arrValue[$char];
}		
	
function dotToComma($varId)
{
	$newId = str_replace(".", ",", $varId);	
	return $newId;
}

function CommaToQuery($varId)
{
	$newId = str_replace(",", "','", $varId);	
	return $newId;
}

function dotToNo($varId)
{
	$newId = str_replace(".", "", $varId);	
	$newId = str_replace(",", ".", $newId);	
	return $newId;
}
function CommaToNo($varId)
{
	$newId = str_replace(",", "", $varId);	
	return $newId;
}
function CommaToDot($varId)
{
	$newId = str_replace(",", ".", $varId);	
	return $newId;
}

function CrashToNo($varId)
{
	$newId = str_replace("#", "", $varId);	
	return $newId;
}

function StarToNo($varId)
{
	$newId = str_replace("* ", "", $varId);	
	return $newId;
}

function NullDotToNo($varId)
{
	$newId = str_replace(".00", "", $varId);
	return $newId;
}

function ExcelToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNo($varId)
{
	$newId = NullDotToNo($varId);
	$newId = CommaToNo($newId);
	$newId = StarToNo($newId);
	return $newId;
}

function ValToNull($varId)
{
	if($varId == '')
		return 0;
	else
		return $varId;
}

function ValToNullDB($varId)
{
	if($varId == '')
		return 'NULL';
	elseif($varId == 'null')
		return 'NULL';
	else
		return "'".$varId."'";
}

function setQuote($var, $status='')
{	
	if($status == 1)
		$tmp= str_replace("\'", "''", $var);
	else
		$tmp= str_replace("'", "''", $var);
	return $tmp;
}

// fungsi untuk generate nol untuk melengkapi digit

function generateZero($varId, $digitGroup, $digitCompletor = "0")
{
	$newId = "";
	
	$lengthZero = $digitGroup - strlen($varId);
	
	for($i = 0; $i < $lengthZero; $i++)
	{
		$newId .= $digitCompletor;
	}
	
	$newId = $newId.$varId;
	
	return $newId;
}

// truncate text into desired word counts.
// to support dropDirtyHtml function, include default.func.php
function truncate($text, $limit, $dropDirtyHtml=true)
{
	$text = ($text);
	$tmp_truncate = array();
	$text = str_replace("&nbsp;", " ", $text);
	$tmp = explode(" ", $text);
	
	for($i = 0; $i <= $limit; $i++)		//truncate how many words?
	{
		$tmp_truncate[$i] = $tmp[$i];
	}
	
	$truncated = implode(" ", $tmp_truncate);
	
	if ($dropDirtyHtml == true and function_exists('dropAllHtml'))
		return dropAllHtml($truncated);
	else
		return $truncated;
}

function arrayMultiCount($array, $field_name, $search)
{
	$summary = 0;
	for($i = 0; $i < count($array); $i++)
	{
		if($array[$i][$field_name] == $search)
			$summary += 1;
	}
	return $summary;
}

function getValueArray($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= $var[$i];
		else
			$tmp .= ",".$var[$i];
	}
	
	return $tmp;
}

function getValueArrayMonth($var)
{
	//$tmp = "";
	for($i=0;$i<count($var);$i++)
	{			
		if($i == 0)
			$tmp .= "'".$var[$i]."'";
		else
			$tmp .= ", '".$var[$i]."'";
	}
	
	return $tmp;
}

function getColoms($var)
{
	$tmp = "";
	if($var == 1)	$tmp = 'A';
	elseif($var == 2)	$tmp = 'B';
	elseif($var == 3)	$tmp = 'C';
	elseif($var == 4)	$tmp = 'D';
	elseif($var == 5)	$tmp = 'E';
	elseif($var == 6)	$tmp = 'F';
	elseif($var == 7)	$tmp = 'G';
	elseif($var == 8)	$tmp = 'H';
	elseif($var == 9)	$tmp = 'I';
	elseif($var == 10)	$tmp = 'J';
	elseif($var == 11)	$tmp = 'K';
	elseif($var == 12)	$tmp = 'L';
	elseif($var == 13)	$tmp = 'M';
	elseif($var == 14)	$tmp = 'N';
	elseif($var == 15)	$tmp = 'O';
	elseif($var == 16)	$tmp = 'P';
	elseif($var == 17)	$tmp = 'Q';
	elseif($var == 18)	$tmp = 'R';
	elseif($var == 19)	$tmp = 'S';
	elseif($var == 20)	$tmp = 'T';
	elseif($var == 21)	$tmp = 'U';
	elseif($var == 22)	$tmp = 'V';
	elseif($var == 23)	$tmp = 'W';
	elseif($var == 24)	$tmp = 'X';
	elseif($var == 25)	$tmp = 'Y';
	elseif($var == 26)	$tmp = 'Z';
	elseif($var == 27)	$tmp = 'AA';
	elseif($var == 28)	$tmp = 'AB';
	elseif($var == 29)	$tmp = 'AC';
	elseif($var == 30)	$tmp = 'AD';
	elseif($var == 31)	$tmp = 'AE';
	elseif($var == 32)	$tmp = 'AF';
	elseif($var == 33)	$tmp = 'AG';
	elseif($var == 34)	$tmp = 'AH';
	elseif($var == 35)	$tmp = 'AI';
	elseif($var == 36)	$tmp = 'AJ';
	elseif($var == 37)	$tmp = 'AK';
	elseif($var == 38)	$tmp = 'AL';
	elseif($var == 39)	$tmp = 'AM';
	elseif($var == 40)	$tmp = 'AN';
	elseif($var == 41)	$tmp = 'AO';
	elseif($var == 42)	$tmp = 'AP';
	elseif($var == 43)	$tmp = 'AQ';
	elseif($var == 44)	$tmp = 'AR';
	elseif($var == 45)	$tmp = 'AS';
	elseif($var == 46)	$tmp = 'AT';
	elseif($var == 47)	$tmp = 'AU';
	elseif($var == 48)	$tmp = 'AV';
	elseif($var == 49)	$tmp = 'AW';
	elseif($var == 50)	$tmp = 'AX';
	elseif($var == 51)	$tmp = 'AY';
	
	return $tmp;
}

function setNULL($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = $var;
	
	return $tmp;
}

function setNULLModif($var)
{	
	if($var == '')
		$tmp = 'NULL';
	else
		$tmp = "'".$var."'";
	
	return $tmp;
}

function setVal_0($var)
{	
	if($var == '')
		$tmp = '0';
	else
		$tmp = $var;
	
	return $tmp;
}

function get_null_10($varId)
{
	if($varId == '') return '';
	if($varId < 10)	$temp= '0'.$varId;
	else			$temp= $varId;
			
	return $temp;
}

function _ip( )
{
    return ( preg_match( "/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'] );
}

function getFotoProfile($id)
{
	$filename = "uploads/foto_fix/".$id.".jpg";
	if (file_exists($filename)) {
	} else {
		$filename = "images/foto-profile.jpg";
	}	
	return $filename;
}

function searchWordDelimeter($varSource, $varSearch, $varDelimeter=",")
{

	$arrSource = explode($varDelimeter, $varSource);
	
	for($i=0; $i<count($arrSource);$i++)
	{
		if(trim($arrSource[$i]) == $varSearch)
			return true;
	}
	
	return false;
}

function getZodiac($day,$month){
	if(($month==1 && $day>20)||($month==2 && $day<20)){
	$mysign = "Aquarius";
	}
	if(($month==2 && $day>18 )||($month==3 && $day<21)){
	$mysign = "Pisces";
	}
	if(($month==3 && $day>20)||($month==4 && $day<21)){
	$mysign = "Aries";
	}
	if(($month==4 && $day>20)||($month==5 && $day<22)){
	$mysign = "Taurus";
	}
	if(($month==5 && $day>21)||($month==6 && $day<22)){
	$mysign = "Gemini";
	}
	if(($month==6 && $day>21)||($month==7 && $day<24)){
	$mysign = "Cancer";
	}
	if(($month==7 && $day>23)||($month==8 && $day<24)){
	$mysign = "Leo";
	}
	if(($month==8 && $day>23)||($month==9 && $day<24)){
	$mysign = "Virgo";
	}
	if(($month==9 && $day>23)||($month==10 && $day<24)){
	$mysign = "Libra";
	}
	if(($month==10 && $day>23)||($month==11 && $day<23)){
	$mysign = "Scorpio";
	}
	if(($month==11 && $day>22)||($month==12 && $day<23)){
	$mysign = "Sagitarius";
	}
	if(($month==12 && $day>22)||($month==1 && $day<21)){
	$mysign = "Capricorn";
	}
	return $mysign;
}

function getValueANDOperator($var)
{
	$tmp = ' AND ';
	
	return $tmp;
}

function getValueKoma($var)
{
	if($var == '')
		$tmp = '';
	else
		$tmp = ',';	
	
	return $tmp;
}

function import_format($val)
{
	if($val == ":02")
	{
		$temp= str_replace(":02","24:00",$val);
	}
	else
	{	
		$temp="";
		if($val == "[hh]:mm" || $val == "[h]:mm"){}
		else
			$temp= $val;
	}
	return $temp;
	//return $val;
}

function kekata($x) 
{
	$x = abs($x);
	$angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($x <12) 
	{
		$temp = " ". $angka[$x];
	} 
	else if ($x <20) 
	{
		$temp = kekata($x - 10). " belas";
	} 
	else if ($x <100) 
	{
		$temp = kekata($x/10)." puluh". kekata($x % 10);
	} 
	else if ($x <200) 
	{
		$temp = " seratus" . kekata($x - 100);
	} 
	else if ($x <1000) 
	{
		$temp = kekata($x/100) . " ratus" . kekata($x % 100);
	} 
	else if ($x <2000) 
	{
		$temp = " seribu" . kekata($x - 1000);
	} 
	else if ($x <1000000) 
	{
		$temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
	} 
	else if ($x <1000000000) 
	{
		$temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
	} 
	else if ($x <1000000000000) 
	{
		$temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
	} 
	else if ($x <1000000000000000) 
	{
		$temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
	}      
	
	return $temp;
}

function terbilang($x, $style=4) 
{
	if($x < 0) 
	{
		$hasil = "minus ". trim(kekata($x));
	} 
	else 
	{
		$hasil = trim(kekata($x));
	}      
	switch ($style) 
	{
		case 1:
			$hasil = strtoupper($hasil);
			break;
		case 2:
			$hasil = strtolower($hasil);
			break;
		case 3:
			$hasil = ucwords($hasil);
			break;
		default:
			$hasil = ucfirst($hasil);
			break;
	}      
	return $hasil;
}

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
}

function getExe($tipe)
{
	switch ($tipe) {
	  case "application/pdf": $ctype="pdf"; break;
	  case "application/octet-stream": $ctype="exe"; break;
	  case "application/zip": $ctype="zip"; break;
	  case "application/msword": $ctype="doc"; break;
	  case "application/vnd.ms-excel": $ctype="xls"; break;
	  case "application/vnd.ms-powerpoint": $ctype="ppt"; break;
	  case "image/gif": $ctype="gif"; break;
	  case "image/png": $ctype="png"; break;
	  case "image/jpeg": $ctype="jpeg"; break;
	  case "image/jpg": $ctype="jpg"; break;
	  case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": $ctype="xlsx"; break;
	  case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": $ctype="docx"; break;
	  default: $ctype="application/force-download";
	} 
	
	return $ctype;
} 

function getExtension($varSource)
{
	$temp = explode(".", $varSource);
	return end($temp);
}


function coalesce($varSource, $varReplace)
{
	if($varSource == "")
		return $varReplace;
		
	return $varSource;
}

function getconcatseparator($var, $vadd, $separator=",")
{
	$vreturn= "";
	if(empty($var))
		$vreturn = $vadd;
	else
	{
		$vreturn = $var.$separator.$vadd;
	}

	return $vreturn;
}

function in_array_column($text, $column, $array)
{
    if (!empty($array) && is_array($array))
    {
        for ($i=0; $i < count($array); $i++)
        {
            if ($array[$i][$column]==$text || strcmp($array[$i][$column],$text)==0) 
				$arr[] = $i;
        }
		return $arr;
    }
    // print_r($arr);exit;
    return "";
}

function makedirs($dirpath, $mode=0755)
{
    return is_dir($dirpath) || mkdir($dirpath, $mode, true);
}

function lihatfiledirektori($path, &$arrdata=[], &$index=0)
{
	$allowed= array('.jpg', '.jpeg', '.png', '.pdf');

	$scans= glob($path . "*");
	foreach($scans as $scan)
    {
		$new_path= $scan;
		// echo checkallowedfile($new_path, $allowed);exit();
		// echo $new_path;exit();

		if(checkallowedfile($new_path, $allowed) == "1")
		{
			if(is_dir($new_path))
			{
				lihatfiledirektori($new_path."/", $arrdata, $index);
			}
			else
			{
				$arrdata[$index]= $new_path;
				$index++;
			}
		}

	}
	return $arrdata;
}

function isStrContain($string, $keyword)
{
	if (empty($string) || empty($keyword)) return false;
	$keyword_first_char = $keyword[0];
	$keyword_length = strlen($keyword);
	$string_length = strlen($string);
	
	// case 1
	if ($string_length < $keyword_length) return false;
	
	// case 2
	if ($string_length == $keyword_length) {
	  if ($string == $keyword) return true;
	  else return false;
	}
	
	// case 3
	if ($keyword_length == 1) {
	  for ($i = 0; $i < $string_length; $i++) {
	
		// Check if keyword's first char == string's first char
		if ($keyword_first_char == $string[$i]) {
		  return true;
		}
	  }
	}
	
	// case 4
	if ($keyword_length > 1) {
	  for ($i = 0; $i < $string_length; $i++) {
		/*
		the remaining part of the string is equal or greater than the keyword
		*/
		if (($string_length + 1 - $i) >= $keyword_length) {
	
		  // Check if keyword's first char == string's first char
		  if ($keyword_first_char == $string[$i]) {
			$match = 1;
			for ($j = 1; $j < $keyword_length; $j++) {
			  if (($i + $j < $string_length) && $keyword[$j] == $string[$i + $j]) {
				$match++;
			  }
			  else {
				return false;
			  }
			}
	
			if ($match == $keyword_length) {
			  return true;
			}
	
			// end if first match found
		  }
	
		  // end if remaining part
		}
		else {
		  return false;
		}
	
		// end for loop
	  }
	
	  // end case4
	}
	
	return false;
}

function likeMatch($pattern, $subject)
{
    $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
    return (bool) preg_match("/^{$pattern}$/i", $subject);
}

function setjenisusulan($info)
{
	$tempJenis= "";
	if($info == 6)
	$tempJenis= "4";
	elseif($info == 8 || $info == 12)
	$tempJenis= "7";
	elseif($info == 9)
	$tempJenis= "3";
	elseif($info == 11 || $info == 13)
	$tempJenis= "10";
	
	return $tempJenis;
}

function setkategorinama($info)
{
	$tempJenis= "";
	if($info == "bup")
	$tempJenis= "BUP";
	elseif($info == "meninggal")
	$tempJenis= "Janda / Duda";
	
	return $tempJenis;
}

function setjeniskanregusulan($info)
{
	$tempJenis= "";
	if($info == 4)//"Usul Permohonan Karpeg"
	$tempJenis= "6";//"Ke Kanreg II BKN Surabaya"
	elseif($info == 7)//"Usul Permohonan Pensiun"
	$tempJenis= "8";//"Ke Kanreg II BKN Surabaya"
	elseif($info == 7)//"Usul Permohonan Pensiun"
	$tempJenis= "8";//"Ke Kanreg II BKN Surabaya"
	elseif($info == 12)//"Usul Permohonan Pensiun"
	$tempJenis= "12";//"Ke BKN Pusat"
	elseif($info == 3)//"Usul Permohonan Karis/Karsu"
	$tempJenis= "9";//"Ke Kanreg II BKN Surabaya"

	elseif($info == 10)//"Usul Permohonan Kenaikan Pangkat"
	$tempJenis= "11";//"Ke Kanreg II BKN Surabaya Kenaikan Pangkat"
	elseif($info == 13)//"Usul Permohonan Kenaikan Pangkat"
	$tempJenis= "13";//"Ke BKN Pusat"
	
	return $tempJenis;
}

function setjenisusulanpilih($info)
{
	$tempJenis= "";
	if($info == 4)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_karpeg";
	elseif($info == 7 || $info == 12)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_pensiun";
	elseif($info == 3)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_karsu";
	elseif($info == 10 || $info == 13)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_kenaikan_pangkat";
	
	return $tempJenis;
}

function setjenisinfo($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "Ijin Belajar";
	elseif($info == 2)
	$tempJenis= "Ijin Cuti";
	elseif($info == 3)
	$tempJenis= "Karis/Karsu";
	elseif($info == 4)
	$tempJenis= "Karpeg";
	elseif($info == 6)
	$tempJenis= "Karpeg";
	elseif($info == 7)
	$tempJenis= "Pensiun";
	elseif($info == 12)
	$tempJenis= "Pensiun";
	elseif($info == 8)
	$tempJenis= "Pensiun";
	elseif($info == 10)
	$tempJenis= "Kenaikan Pangkat";
	elseif($info == 11)
	$tempJenis= "Kenaikan Pangkat";
	elseif($info == 13)
	$tempJenis= "Kenaikan Pangkat";
	
	return $tempJenis;
}

function setjenissuratrekomendasiinfo($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_surat_rekomendasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "";
	elseif($info == 4)
	$tempJenis= "ijin_belajar_surat_rekomendasi_karpeg";
	
	return $tempJenis;
}

function setjenisperihalinfo($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "Usul Permohonan Izin/Tugas Belajar";
	elseif($info == 2)
	$tempJenis= "Usul Permohonan Ijin Cuti";
	elseif($info == 3)
	$tempJenis= "Usul Permohonan Karis/Karsu";
	elseif($info == 4)
	$tempJenis= "Usul Permohonan Karpeg";
	elseif($info == 6)
	$tempJenis= "Usul Permohonan Karpeg";
	elseif($info == 7)
	$tempJenis= "Usul Permohonan Pensiun";
	elseif($info == 8 || $info == 12)
	$tempJenis= "Usul Permohonan Pensiun";
	elseif($info == 10)
	$tempJenis= "Usul Permohonan Kenaikan Pangkat";
	elseif($info == 11 || $info == 13)
	$tempJenis= "Usul Permohonan Kenaikan Pangkat";
	
	return $tempJenis;
}

function seturllink($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_upt_add_pegawai_pendidikan_data";
	elseif($info == 2)
	$tempJenis= "surat_masuk_upt_add_pegawai_cuti_data";
	elseif($info == 3)
	$tempJenis= "surat_masuk_upt_add_pegawai_karis_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_upt_add_pegawai_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_upt_add_pegawai_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_upt_add_pegawai_kenaikan_pangkat";
	
	return $tempJenis;
}

function seturllinkBkd($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_bkd_add_pegawai_pendidikan_data";
	elseif($info == 2)
	$tempJenis= "surat_masuk_bkd_add_pegawai_cuti_data";
	elseif($info == 3)
	$tempJenis= "surat_masuk_bkd_add_pegawai_karis_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_bkd_add_pegawai_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_bkd_add_pegawai_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_bkd_add_pegawai_kenaikan_pangkat";
	
	return $tempJenis;
}

function setlinksuratpengantar($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_uptd_1_org";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	{
		if($jenis == 1)
		$tempJenis= "karsu_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karsu_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karsu_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karsu_smpn_dinas_4";
	}
	elseif($info == 4)
	{
		if($jenis == 1)
		$tempJenis= "karpeg_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karpeg_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karpeg_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karpeg_smpn_dinas_4";
	}
	elseif($info == 7)
	{
		$tempJenis= "pensiun_smpn_dinas";
	}
	elseif($info == 10)
	{
		$tempJenis= "kenaikan_pangkat_smpn_dinas";
	}
	
	return $tempJenis;
}

function setlinklebihsuratpengantar($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_uptd_lebih_1_org";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	{
		if($jenis == 1)
		$tempJenis= "karsu_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karsu_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karsu_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karsu_smpn_dinas_4";
	}
	elseif($info == 4)
	{
		if($jenis == 1)
		$tempJenis= "karpeg_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karpeg_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karpeg_smpn_dinas_3";
	}
	elseif($info == 7)
	{
		$tempJenis= "pensiun_smpn_dinas";
	}
	elseif($info == 10)
	{
		$tempJenis= "kenaikan_pangkat_smpn_dinas";
	}
	
	return $tempJenis;
}

function setlinksuratpengantarbkd($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_dinas_1_org";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	{
		if($jenis == 1)
		$tempJenis= "karsu_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karsu_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karsu_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karsu_smpn_dinas_4";
	}
	elseif($info == 4)
	{
		if($jenis == 1)
		$tempJenis= "karpeg_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karpeg_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karpeg_smpn_dinas_3";
	}
	elseif($info == 7)
	{
		$tempJenis= "pensiun_smpn_dinas";
	}
	elseif($info == 10)
	{
		$tempJenis= "kenaikan_pangkat_smpn_dinas";
	}
	
	return $tempJenis;
}

function setlinksuratpengantarbkdlebih($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_dinas_lebih_1_org";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	{
		if($jenis == 1)
		$tempJenis= "karsu_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karsu_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karsu_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karsu_smpn_dinas_4";
	}
	elseif($info == 4)
	{
		if($jenis == 1)
		$tempJenis= "karpeg_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karpeg_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karpeg_smpn_dinas_3";
	}
	elseif($info == 7)
	{
		$tempJenis= "pensiun_smpn_dinas";
	}
	elseif($info == 10)
	{
		$tempJenis= "kenaikan_pangkat_smpn_dinas";
	}
	
	return $tempJenis;
}

function setlinksuratpengantarusulan($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_dinas_1_org";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	{
		if($jenis == 1)
		$tempJenis= "karsu_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karsu_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karsu_smpn_dinas_3";
		// elseif($jenis == 4)
		// $tempJenis= "karsu_smpn_dinas_4";
	}
	elseif($info == 4)
	{
		if($jenis == 1)
		$tempJenis= "karpeg_smpn_dinas_1";
		elseif($jenis == 2)
		$tempJenis= "karpeg_smpn_dinas_2";
		elseif($jenis == 3)
		$tempJenis= "karpeg_smpn_dinas_3";
	}
	elseif($info == 7)
	{
		$tempJenis= "pensiun_smpn_dinas";
	}
	elseif($info == 10)
	{
		$tempJenis= "kenaikan_pangkat_smpn_dinas";
	}
	
	return $tempJenis;
}

function setlinksuratpengantarlebih($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_uptd_nominatif";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karsu_smpn_dinas_nominatif";
	elseif($info == 4)
	$tempJenis= "karpeg_smpn_dinas_nominatif";
	elseif($info == 7)
	$tempJenis= "pensiun_smpn_dinas_nominatif";
	elseif($info == 10)
	$tempJenis= "kenaikan_pangkat_smpn_dinas_nominatif";
	
	return $tempJenis;
}

function setlinksuratpengantarlebihbkd($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_dinas_nominatif";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karsu_smpn_dinas_nominatif";
	elseif($info == 4)
	$tempJenis= "karpeg_smpn_dinas_nominatif";
	elseif($info == 7)
	$tempJenis= "pensiun_smpn_dinas_nominatif";
	elseif($info == 10)
	$tempJenis= "kenaikan_pangkat_smpn_dinas_nominatif";
	
	return $tempJenis;
}

function setlinksuratpengantarlebihusulan($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "ijin_belajar_pengantar_dinas_nominatif";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karsu_smpn_dinas_nominatif";
	elseif($info == 4)
	$tempJenis= "karpeg_smpn_dinas_nominatif";
	elseif($info == 7)
	$tempJenis= "pensiun_smpn_dinas_nominatif";
	elseif($info == 10)
	$tempJenis= "kenaikan_pangkat_smpn_dinas_nominatif";
	
	return $tempJenis;
}

function setlinksuratpengantarcss($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_pengantar";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karpeg";
	elseif($info == 4)
	$tempJenis= "karpeg";
	elseif($info == 7)
	$tempJenis= "karpeg";
	elseif($info == 10)
	$tempJenis= "karpeg";
	
	return $tempJenis;
}

function setlinksuratpengantarcssbkd($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_pengantar";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karpeg";
	elseif($info == 4)
	$tempJenis= "karpeg";
	elseif($info == 7)
	$tempJenis= "karpeg";
	elseif($info == 10)
	$tempJenis= "karpeg";
	
	return $tempJenis;
}

function setlinksuratpengantarcssusulan($info, $jenis)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_pengantar";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "karpeg";
	elseif($info == 4)
	$tempJenis= "karpeg";
	elseif($info == 7)
	$tempJenis= "karpeg";
	elseif($info == 10)
	$tempJenis= "karpeg";

	return $tempJenis;
}

function setlinkuptverifikasi($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_upt_add_pegawai_verfikasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "surat_masuk_upt_add_pegawai_verfikasi_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_upt_add_pegawai_verfikasi_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_upt_add_pegawai_verfikasi_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_upt_add_pegawai_verfikasi_kenaikan_pangkat";
	
	return $tempJenis;
}

function setlinkuptverifikasilookup($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_upt_add_pegawai_lookup_verfikasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "surat_masuk_upt_add_pegawai_lookup_verfikasi_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_upt_add_pegawai_lookup_verfikasi_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_upt_add_pegawai_lookup_verfikasi_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_upt_add_pegawai_lookup_verfikasi_kenaikan_pangkat";
	
	return $tempJenis;
}

function setlinkbkdverifikasi($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_bkd_add_pegawai_verfikasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "surat_masuk_bkd_add_pegawai_verfikasi_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_bkd_add_pegawai_verfikasi_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_bkd_add_pegawai_verfikasi_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_bkd_add_pegawai_verfikasi_kenaikan_pangkat";
	
	return $tempJenis;
}

function setlinkbkdverifikasilookup($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_bkd_add_pegawai_lookup_verfikasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_karpeg";
	elseif($info == 7 || $info == 8 || $info == 12)
	$tempJenis= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_pensiun";
	elseif($info == 10 || $info == 11 || $info == 13)
	$tempJenis= "surat_masuk_bkd_add_pegawai_lookup_verfikasi_kenaikan_pangkat";

	return $tempJenis;
}

function seturllinkteknis($info)
{
	$tempJenis= "";
	if($info == 1)
	$tempJenis= "surat_masuk_teknis_add_verifikasi";
	elseif($info == 2)
	$tempJenis= "";
	elseif($info == 3)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_karsu";
	elseif($info == 4)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_karpeg";
	elseif($info == 7)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_pensiun";
	elseif($info == 10)
	$tempJenis= "surat_masuk_teknis_add_verifikasi_kenaikan_pangkat";

	return $tempJenis;
}

function setmenusuratdinasupt($reqId="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("Usulan", "List Pegawai");
	$arrFile= array("surat_masuk_dinas_upt_add_data", "surat_masuk_dinas_upt_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function setmenusuratupt($reqId="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("Usulan", "List Pegawai");
	$arrFile= array("surat_masuk_upt_add_data", "surat_masuk_upt_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function setmenuusulansurat($reqId="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("Usulan", "List Pegawai");
	$arrFile= array("usulan_surat_add_data", "usulan_surat_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function setmenusuratbkd($reqId="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("Usulan", "List Pegawai");
	$arrFile= array("surat_masuk_bkd_add_data", "surat_masuk_bkd_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function setmenusuratteknis($reqId="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01");
	$arrParentId= array("0");
	$arrNama= array("List Pegawai");
	$arrFile= array("surat_masuk_teknis_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function setmenukgb()
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02", "03", "04");
	$arrParentId= array("0", "0", "0", "0");
	$arrNama= array("KGB", "CPNS/PNS", "Riwayat Gaji", "Riwayat Pangkat");
	$arrFile= array("kenaikan_gaji_berkala_add_data", "pegawai_add_cpns_pns_monitoring", "pegawai_add_gaji_monitoring", "pegawai_add_pangkat_monitoring");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
	}
	return $arrMenu;
}

function setmenuppkkgb()
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("KGB", "Riwayat Gaji");
	$arrFile= array("kenaikan_gaji_pppk_berkala_add_data", "pegawai_add_gaji_pppk_monitoring");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
	}
	return $arrMenu;
}

function setmenusuratbkpp($reqId="", $mode="")
{
	$arrId= $arrParentId= $arrNama= $arrFile= "";
	$arrId= array("01", "02");
	$arrParentId= array("0", "0");
	$arrNama= array("Usulan", "List Pegawai");
	
	if($reqId == "")
	{
		if($mode == "surat_keluar")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Keluar");
			$arrFile= array("surat_keluar_teknis_add_surat_data");
		}
		else if($mode == "surat_sediaan")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Masuk Sediaan");
			$arrFile= array("surat_masuk_sediaan_add_data");
		}
		else
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Masuk");
			$arrFile= array("surat_masuk_add_data_agenda");
		}
	}
	//elseif($mode == "1")
	else
	{
		if($mode == "surat_keluar")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Keluar");
			$arrFile= array("surat_keluar_teknis_add_data");
		}
		else if($mode == "surat_sediaan")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Masuk Sediaan");
			$arrFile= array("surat_masuk_sediaan_add_data");
		}
		elseif($mode == "surat_keluar_kgb")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Atur Nomor dan Tanggal KGB");
			$arrFile= array("surat_keluar_teknis_add_kgb_data");
		}
		elseif($mode == "surat_keluar_pppk_kgb")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Atur Nomor dan Tanggal KGB");
			$arrFile= array("surat_keluar_teknis_add_kgb_pppk_data");
		}
		elseif($mode == "surat_keluar_lihat")
		{
			$arrNama= $arrFile= [];
			$arrNama= array("Surat Keluar");
			$arrFile= array("surat_keluar_teknis_add_lihat");
		}
		else
		$arrFile= array("surat_masuk_add_data_agenda", "surat_masuk_add_pegawai");
	}
	//else
	//$arrFile= array("surat_masuk_add_data", "surat_masuk_bkd_add_pegawai");
	
	for($index_set=0; $index_set < count($arrId); $index_set++ )
	{
		$arrMenu[$index_set]["MENU_ID"]= $arrId[$index_set];
		$arrMenu[$index_set]["MENU_PARENT_ID"]= $arrParentId[$index_set];
		$arrMenu[$index_set]["NAMA"]= $arrNama[$index_set];
		$arrMenu[$index_set]["LINK_FILE"]= $arrFile[$index_set];
		$arrMenu[$index_set]["ICON"]= '<i class="mdi-action-dashboard"></i>';
		
		if($reqId == "")
     	break;
	}
	return $arrMenu;
}

function maybePrefixZero($input) {
    if( substr($input, 0, 1) === '.' ) return '0' . $input;
        else return $input;
}

function setLebihNol($input) {
	if($input > 0){}
	else
	$input= 0;
	
	return $input;
}

function strtocamel($str, $capitalizeFirst = true, $allowed = 'A-Za-z0-9') {
	$splitCamelArray = preg_split('/(?=[A-Z])/', $str);

    return ucwords(implode($splitCamelArray, ' '));

    /*return preg_replace(
        array(
            '/([A-Z][a-z])/e', // all occurances of caps followed by lowers
            '/([a-zA-Z])([a-zA-Z]*)/e', // all occurances of words w/ first char captured separately
            //'/[^'.$allowed.']+/e', // all non allowed chars (non alpha numerics, by default)
            '/^([a-zA-Z])/e' // first alpha char
        ),
        array(
            '" ".$1', // add spaces
            'strtoupper("$1").strtolower("$2")', // capitalize first, lower the rest
            //'', // delete undesired chars
            'strto'.($capitalizeFirst ? 'upper' : 'lower').'("$1")' // force first char to upper or lower
        ),
        $str
    );*/
}

function ucwordsPertama($text){
	/*$text= ucwords(strtolower($text));
	$text= preg_replace_callback("/(^|\\s+)'[a-z]/", create_function(
		'$matches',
		'return strtoupper($matches[0]);'
	), $text);*/
	
	$text= strtolower($text);
	$text= strtocamel($text, true, 'A-Za-z0-9-`');
	//$text= ucwords(strtolower($text));
	return $text;
}

function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

function deleteFileZip($arrFile)
{
	//$tempLokasi= "zis/";
	for($indexUnlink=0; $indexUnlink < count($arrFile); $indexUnlink++)
		unlink($tempLokasi.$arrFile[$indexUnlink]);
		
}

function substrfullword($str, $start, $end){
    $pos_ini = ($start == 0) ? $start : stripos(substr($str, $start, $end), ' ') + $start;
    if(strlen($str) > $end){ $pos_end = strrpos(substr($str, 0, ($end + 1)), ' '); } // IF STRING SIZE IS LESSER THAN END
    if(empty($pos_end)){ $pos_end = $end; } // FALLBACK
    return substr($str, $pos_ini, $pos_end);
}

function getpanjangword($str, $start, $end){
    if(strlen($str) > $end){ $pos_end = strrpos(substr($str, 0, ($end + 1)), ' '); } // IF STRING SIZE IS LESSER THAN END
    if(empty($pos_end)){ $pos_end = $end; } // FALLBACK
    return $pos_end;
}

function checkallowedfile($inage_name, $allowed)
{
	if (!in_array(strtolower(strrchr($inage_name, '.')), $allowed))
	{
     return "";
    }
    else 
    {
     return "1";
    }
}

function generaterandom($min = 1, $max = 1000) 
{
    if (function_exists('random_int')):
        return random_int($min, $max); // more secure
    elseif (function_exists('mt_rand')):
        return mt_rand($min, $max); // faster
    endif;
    return rand($min, $max); // old
}

function getgeneraterandom($dir, $needle)
{
	$ext= end(explode(".", $needle));
	$namafile= array_shift(explode(".", basename($needle)));
	$nextrandom= generateZero(generaterandom(1,1000), 4);
	$returnnamafile= $namafile."_delete_".$nextrandom.".".$ext;

	$lokasifile= $dir.$returnnamafile;
	if (file_exists($lokasifile))
	{
		return getgeneraterandom($dir, $needle);
	}
	else
	{
		return $returnnamafile;
	}
}
function setfiledeleteinfolder($dir, $needle)
{
	return getgeneraterandom($dir, $needle);
}

function setfiledeleteinfolderbak($dir, $needle)
{
	$i=0;
	$tempfile= "";
	if (is_dir($dir)) 
	{
    	if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) 
	        {
	            similar_text($file, $needle, $percent);
	            // if($percent < 90 && (float)$percent > 88.3)
	            if($percent < 90 && (float)$percent > 87.32)
	            {
	            	$tempfile[$i]["url"]= $file;
	            	$tempfile[$i]["percen"]= $percent;
	            	$i++;
	                // echo $file  . " similarity: " . $percent . "<br />";
	            }
	            // echo $file  . " similarity: " . $percent . "<br />";

	        }
	        closedir($dh);
	    }
	}
	// exit();

	$ext= end(explode(".", $needle));
	$namafile= array_shift(explode(".", basename($needle)));
	// echo $i."--".$namafile;exit();
	if($i == "0")
	{
		return $namafile."_delete_1.".$ext;
	}
	else
	{
		$orderfile= "";
		$orderfile= sksort($tempfile);
		// print_r($orderfile);exit();
		$indexdata= count($orderfile) - 1;
		$tempNamaFile= $orderfile[$indexdata]["url"];
		$tempNamaFile= array_shift(explode(".", basename($tempNamaFile)));
		$nextdelete= str_replace($namafile."_delete_", "", $tempNamaFile);
		// echo $nextdelete;exit();
		$nextdelete= ($nextdelete * 1) + 1;
		// echo $nextdelete;exit();
		return $namafile."_delete_".$nextdelete.".".$ext;
		// echo $nextdelete;exit();

		// $tempNamaFile= replace($namafile."")
		// $tempNamaFile
		// print_r($orderfile);exit();
	}
}

function sksort(&$array, $subkey="percen", $sort_ascending=false) 
{

    if (count($array))
        $temp_array[key($array)] = array_shift($array);
    // print_r($temp_array);exit();
    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);
    else $array = $temp_array;

    return $array;
}

function sfvalidateip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}

function sfgetipaddress() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                // trim for safety measures
                $ip = trim($ip);
                // attempt to validate IP
                if (sfvalidateip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}

function sfgetmac()
{

	

// 	// echo sfgetipaddress();exit;
// 	// $vmac= exec('getmac');
// 	echo "adasd".$vmac;exit;
	// $vmac= str_replace("-", "", strtok($vmac, ' '));
	return $vmac;
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function array_change_key_case_recursive_upper($arr)
{
	return array_map(function($item){
	  if(is_array($item))
	    $item = array_change_key_case_recursive_upper($item);
	  return $item;
	},array_change_key_case($arr,CASE_UPPER));
}

function setToAlpha($parse, $row, $temp="0")
{
	$value= $row + $temp;
	
	return toAlpha($parse).$value;
}

function toAlpha($data){
    $alphabet =   array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    $alpha_flip = array_flip($alphabet);
        if($data <= 25){
          return $alphabet[$data];
        }
        elseif($data > 25){
          $dividend = ($data + 1);
          $alpha = '';
          $modulo;
          while ($dividend > 0){
            $modulo = ($dividend - 1) % 26;
            $alpha = $alphabet[$modulo] . $alpha;
            $dividend = floor((($dividend - $modulo) / 26));
          } 
          return $alpha;
        }

}

function new_array_multisort(&$a, array $column_names) {
    /*usort($a, function($a, $b) use($column_names) {
        foreach ($column_names as $column_name => $order) {
            $result = ($a[$column_name] <=> $b[$column_name]) * ($order === SORT_DESC ? -1 : 1);
            if ($result) return $result;
        }
        return 0;
    });*/

    /*
    // contoh data
    $data[] = array('volume' => 67, 'edition' => 2);
	$data[] = array('volume' => 86, 'edition' => 1);
	$data[] = array('volume' => 85, 'edition' => 6);
	$data[] = array('volume' => 98, 'edition' => 2);
	$data[] = array('volume' => 86, 'edition' => 6);
	$data[] = array('volume' => 67, 'edition' => 7);


	print_r($data);
	new_array_multisort($data, ['volume' => SORT_ASC]);
	new_array_multisort($data, ['volume' => SORT_ASC, 'edition' => SORT_DESC]);
	print_r($data);exit;*/
}
?>