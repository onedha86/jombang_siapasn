<?
include_once("functions/default.func.php");
include_once("functions/date.func.php");

$this->load->library("kauth");
$this->load->model("Menu");
$this->load->model('Pegawai');

if($this->USER_LOGIN_ID == "")
    redirect('app');

$reqId = $this->input->get("reqId");
$reqData = $this->input->get("reqData");

$tempInfoTab= "SIAP ASN Kab. Jombang";
if($reqId == ""){}
else
{
    $CI =& get_instance();
    $CI->checkpegawai($reqId);

    $set= new Pegawai();
    $set->selectByParams(array("A.PEGAWAI_ID"=>$reqId));
    // echo $set->query;exit;
    $set->firstRow();
    $reqNama= $set->getField("NAMA");
    $reqNipBaru= $set->getField("NIP_BARU");
    $reqStatusPegawaiId= $set->getField("STATUS_PEGAWAI_ID");
    $tempInfoTab= $reqNama." - ".$reqNipBaru;
}
// echo $reqStatusPegawaiId;exit;
$reqAksesAppSimpegId= $this->AKSES_APP_SIMPEG_ID;

$arrexceptpp3= array("010201", "0103", "0104");

$arrgajipp3= array("010203");

$index_set=0;
$arrMenu= array();
$set= new Menu();
//selectByParamsMenu(1, $akses_id, "AKSES_APP_ZIS", " AND A.MENU_PARENT_ID = '".$id_induk."'");
// $set->selectByParamsMenu(1, 1, "AKSES_APP_SIMPEG", " AND A.STATUS = 1", "ORDER BY A.URUT");
$set->selectByParamsMenu(1, $reqAksesAppSimpegId, "AKSES_APP_SIMPEG", " AND A.STATUS = 1", "ORDER BY A.URUT, A.MENU_ID");
// echo $set->query;exit;
while($set->nextRow())
{
    $infomenuid= $set->getField("MENU_ID");
    if($set->getField("MENU_PARENT_ID") == "0" || $infomenuid == "011305" || $set->getField("AKSES") == "D")
     continue;


    // khusus admin yg bisa lihat pegawai status
    if($infomenuid == "010303")
    {
        if($this->USER_LOGIN_ID == "1" || $this->USER_LOGIN_ID == "411"){}
        else
            continue;
    }

    // kalau pppk
    if($reqStatusPegawaiId == "6" && in_array($infomenuid, $arrexceptpp3))
    {
        continue;
    }

    if(in_array($infomenuid, $arrgajipp3))
    {
        if($reqStatusPegawaiId == "6"){}
        else
        continue;
    }

    $arrMenu[$index_set]["MENU_ID"]= $infomenuid;
    $arrMenu[$index_set]["MENU_PARENT_ID"]= $set->getField("MENU_PARENT_ID");
    $arrMenu[$index_set]["NAMA"]= $set->getField("NAMA");
    $arrMenu[$index_set]["LINK_FILE"]= $set->getField("LINK_FILE");
    $arrMenu[$index_set]["LINK_DETIL_FILE"]= $set->getField("LINK_DETIL_FILE");
    $arrMenu[$index_set]["AKSES"]= $set->getField("AKSES");
    $arrMenu[$index_set]["JUMLAH_MENU"]= $set->getField("JUMLAH_MENU");
    $arrMenu[$index_set]["JUMLAH_DISABLE"]= $set->getField("JUMLAH_DISABLE");
    $arrMenu[$index_set]["ICON"]= $set->getField("ICON");
    $index_set++;

    if($reqId == "")
       break;
}
$jumlah_menu= $index_set;
unset($set);
//print_r($arrMenu);exit;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Simpeg Jombang">
    <meta name="keywords" content="Simpeg Jombang">
    <title><?=$tempInfoTab?></title>
    <base href="<?=base_url()?>" />
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    

    <!-- CORE CSS-->    
    <link href="lib/materializetemplate/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="lib/materializetemplate/css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- CSS style Horizontal Nav-->    
    <link href="lib/materializetemplate/css/layouts/style-horizontal.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->    
    <link href="lib/materializetemplate/css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <script type="text/javascript">
        var anchorValue= "";
        function setInfoPegawaiData()
        {
            $("#profile-label").text("");
            $('#profile-dropdown').empty();
            $.ajax({'url': "pegawai_json/set_info_pegawai_nama_data/?reqId=<?=$reqId?>",'success': function(datahtml) {
                $("#profile-label").text(datahtml);
                $.ajax({'url': "pegawai_json/set_info_pegawai_data/?reqId=<?=$reqId?>",'success': function(datahtml) {
                    $('#profile-dropdown').append(datahtml);
                }});
            }});
        }
        
        function executeOnClick(varItem){
            anchorValue= varItem;
            $("a").removeClass("aktif");
            if(varItem == ''){}
            <?
            for($index_loop=0; $index_loop < $jumlah_menu; $index_loop++)
            {
                $tempMenuId= $arrMenu[$index_loop]["MENU_ID"];
                $arrMenu[$index_loop]["MENU_PARENT_ID"];
                $tempNama= $arrMenu[$index_loop]["NAMA"];
                $tempLinkFile= $arrMenu[$index_loop]["LINK_FILE"];
                $tempLinkDetilFile= $arrMenu[$index_loop]["LINK_DETIL_FILE"];
            ?>
                else if(varItem == '<?=$tempMenuId?>'){
                    $("#<?=$tempMenuId?>").addClass("aktif");
                    $('#<?=$tempMenuId?>').css({'background-position': '0 -27px'});

            <?
                    if($tempLinkDetilFile == "")
                    {
                        ?>
                        mainFrame.location.href='app/loadUrl/app/<?=$tempLinkFile?>/?reqId=<?=$reqId?>';
                        //mainFrameDetil.location.href='';
                        //document.getElementById('trdetil').style.display = 'none';    
            <?
                    }
                    else
                    {
            ?>
                        mainFrame.location.href='app/loadUrl/app/<?=$tempLinkFile?>/?reqId=<?=$reqId?>';
                        //mainFrameDetil.location.href='app/loadUrl/app/<?=$tempLinkDetilFile?>/?reqId=<?=$reqId?>';
                        //document.getElementById('trdetil').style.display = '';    
            <?
                    }
            ?>
                }
            <?
            }
            ?>
            return true;
        }

        function setload(linkfile)
        {
            mainFrame.location.href='app/loadUrl/app/'+linkfile;
        }

        // function openPopup(page) {
        //     eModal.iframe(page, 'SIMPEG KABUPATEN JOMBANG')
        // }

    </script>

    <style type="text/css">
        #profile-dropdown{
            padding: 10px;
            position: relative !important; 
            top: 20px !important; 
            left: 0 !important;
        }

        .profile-image{
            width: 130px;
        }

        .menu-utama{
            font-size:10pt
        }

        .d-down{
            line-height: 20px;
        }

        .content-wrap{
            padding: 10px;
        }

        .profil-photo-wrap{
            background-image: url("images/profpic-bg.jpg");
            background-size: 100%;
            background-repeat: no-repeat;
            padding: 15px;
        }

        @media only screen and (max-width: 1200px) {
            .menu-utama{
                font-size:7pt
            }
        }
    </style>

    <style type="text/css">
        @media screen and (max-width:767px) {
            .white.hide-on-med-and-down {
                /*border: 2px solid red;*/
                height: auto !important;
                /*line-height: normal !important;*/
            }
            .white.hide-on-med-and-down #ul-horizontal-nav {
                padding-left: 2px;
                padding-right: 2px;
            }
            .white.hide-on-med-and-down #ul-horizontal-nav > li {
                /*border: 2px solid red;*/
                width: 25%;
                height: 50px;
                padding: 2px;
            }
            .white.hide-on-med-and-down #ul-horizontal-nav > li > a {
                border: 1px solid #dadada;
                display: block;

                position: relative;
                /*border: 1px solid red;*/
            }
            .white.hide-on-med-and-down #ul-horizontal-nav > li > a.span i.mdi-navigation-arrow-drop-down.right:before {
                border: 1px solid red;
            }
            .mdi-navigation-arrow-drop-down::before {
                /*border: 1px solid purple;*/
                position: absolute !important;
                top: -5px;
                right: -10px;
            }
            #main {
                padding-top: 175px;
            }

            /****/
            ul.side-nav.leftside-navigation li a {
                /*border: 1px solid red;*/
                border-bottom: 1px solid rgba(255,255,255,0.2);
                color: #FFFFFF;
            }
            ul.side-nav.leftside-navigation li.active > a {
                /*color: #1c8500;*/
                color: orange;
            }
            .side-nav .collapsible-body li a {
                /*margin: 0 1rem 0 3rem;*/
                margin: 0 0;
            }
        }
    </style>

</head>
<body id="layouts-horizontal" onLoad="setInfoPegawaiData()">
    <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color ubah-color-warna" <?php /*?>id="ubah-color-warna"<?php */?>>
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12 m4">
                            <ul id="profile-dropdown" class="dropdown-content center z-depth-3 d-down">
                            </ul>
                            <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-constrainwidth="false" data-activates="profile-dropdown"><span id="profile-label"></span><i class="mdi-navigation-arrow-drop-down right"></i></a>
                        </div>
                    </div>

                </div>
            </nav>

            <!-- HORIZONTL NAV START-->
            <nav id="horizontal-nav" class="white hide-on-med-and-down">
                <div class="nav-wrapper-center">
                    <ul id="ul-horizontal-nav" class="left hide-on-med-and-down">
                        <?
                        $arrayKey= [];
                        $arrayKey= in_array_column("01", "MENU_PARENT_ID", $arrMenu);
                        // print_r($arrayKey);exit;
                        if(!empty($arrayKey))
                        {
                            for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                            {
                                $index_row= $arrayKey[$index_detil];
                                $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                                $arrMenu[$index_row]["MENU_PARENT_ID"];
                                $tempNama= $arrMenu[$index_row]["NAMA"];
                                $arrMenu[$index_row]["LINK_FILE"];
                                $arrMenu[$index_row]["LINK_DETIL_FILE"];
                                $arrMenu[$index_row]["AKSES"];
                                $tempJumlahMenu= $arrMenu[$index_row]["JUMLAH_MENU"];
                                $tempJumlahDisable= $arrMenu[$index_row]["JUMLAH_DISABLE"];
                                $tempIcon= $arrMenu[$index_row]["ICON"];

                                $arrayKeyChild= [];
                                $arrayKeyChild= in_array_column($tempMenuId, "MENU_PARENT_ID", $arrMenu);
                                // print_r($arrayKey);exit;
                                if(empty($arrayKeyChild))
                                {
                        ?>
                                    <li>
                                        <a class="dropdown-menu ubah-color-warna <?php /*?>green-text<?php */?> text-darken-1 menu-utama waves-effect waves-cyan" onClick="executeOnClick('<?=$tempMenuId?>');">
                                            <!-- <i class="mdi-action-invert-colors"></i> -->
                                            <?=$tempIcon?>
                                            <span><?=$tempNama?></span>
                                        </a>
                                    </li>
                        <?
                                }
                                else
                                {
                        ?>
                                    <li>
                                        <a class="dropdown-menu ubah-color-warna <?php /*?>green-text<?php */?> text-darken-1 menu-utama" data-activates="<?=$tempMenuId?>">
                                            <!-- <i class="mdi-action-invert-colors"></i> -->
                                            <?=$tempIcon?>
                                            <span><?=$tempNama?><i class="mdi-navigation-arrow-drop-down right"></i></span>
                                        </a>
                                    </li>
                        <?
                                }
                            }
                        }
                        ?>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </nav>

            <?
            $arrayKey= [];
            $arrayKey= in_array_column("01", "MENU_PARENT_ID", $arrMenu);
            // print_r($arrayKey);exit;
            if(!empty($arrayKey))
            {
                for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                {
                    $index_row= $arrayKey[$index_detil];
                    $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                    getMenuByParent($tempMenuId, $arrMenu);
                }
            }

            function getMenuByParent($id_induk, $arrMenu)
            {
                $arrayKey= [];
                $arrayKey= in_array_column($id_induk, "MENU_PARENT_ID", $arrMenu);
                // print_r($arrayKey);exit;
                if(!empty($arrayKey))
                {
                ?>
                    <!-- CSSdropdown -->
                    <ul id="<?=$id_induk?>" class="dropdown-content dropdown-horizontal-list">
                <?
                    for($index_detil=0; $index_detil < count($arrayKey); $index_detil++)
                    {
                        $index_row= $arrayKey[$index_detil];
                        $tempMenuId= $arrMenu[$index_row]["MENU_ID"];
                        $arrMenu[$index_row]["MENU_PARENT_ID"];
                        $tempNama= $arrMenu[$index_row]["NAMA"];
                        $tempLinkFile= $arrMenu[$index_row]["LINK_FILE"];
                        $arrMenu[$index_row]["AKSES"];
                        $tempJumlahMenu= $arrMenu[$index_row]["JUMLAH_MENU"];
                        $tempJumlahDisable= $arrMenu[$index_row]["JUMLAH_DISABLE"];
                ?>
                        <li><a class="ubah-color-warna text-darken-1 waves-effect waves-cyan" onClick="executeOnClick('<?=$tempMenuId?>');"><?=$tempNama?></a></li>
                <?
                    }
                ?>
                    </ul>
                <?
                }
            }
            ?>
            <!-- HORIZONTL NAV END-->
        </div>
    <!-- end header nav-->
    </header>
    <!-- END HEADER -->

    <div id="main">
            <!-- START WRAPPER -->
        <div class="wrapper">
            <!-- START CONTENT -->
            <section id="content">
                <!--start container-->
                <div id="infocontainer" class="container">

                    <?
                    $setsessionriwayat= $this->session->userdata("setsessionriwayat");
                    if(!empty($setsessionriwayat))
                    {
                        $vlinkfile= $setsessionriwayat;
                        $this->session->unset_userdata('setsessionriwayat');
                    }
                    else
                    {
                        $vlinkfile= $arrMenu[0]["LINK_FILE"]."/?reqId=".$reqId;
                    }
                    // echo $vlinkfile;exit;
                    ?>
                    <iframe src="app/loadUrl/app/<?=$vlinkfile?>" name="mainFrame" id="mainFrame" style="border: none; width: calc(100% + 40px); height: calc(100vh - 110px); margin-top: -55px; display: block; margin-left: -20px; margin-right: -20px;" scrolling="yes"></iframe>

                </div>
                <!--end container-->
            </section>
            <!-- END CONTENT -->
        </div>
        <!-- END WRAPPER -->
    </div>
    <!-- END MAIN -->

<script type="text/javascript" src="lib/materializetemplate/js/plugins/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
    function closeparenttab()
{
    if (window.opener && window.opener.document)
    {
        if (typeof window.opener.setCariInfo === 'function')
        {
            window.opener.setCariInfo();
        }
    }
    window.close();
}

function reloadparenttab()
{
    if (window.opener && window.opener.document)
    {
        if (typeof window.opener.setCariInfo === 'function')
        {
            window.opener.setCariInfo();
        }
    }
}

function iframeLoaded() {
    var iFrameID = document.getElementById('mainFrame');
    if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            // alert(iFrameID.contentWindow.document.body.scrollHeight);
            // alert(iFrameID.contentWindow.document.body.scrollHeight+"--"+anchorValue);
            iFrameID.height = "";
            if(anchorValue == "0112")
            {
                iFrameID.height = parseInt(iFrameID.contentWindow.document.body.scrollHeight) + parseInt(100) + "px";
            }
            else
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        }   
    }
</script>
    
<script type="text/javascript" src="lib/materializetemplate/js/my-materialize.min.js"></script>
<script type="text/javascript" src="lib/materializetemplate/js/plugins.min.js"></script>
    
<style type="text/css">
    #my-modal{
        height: 100%;
    }

    .modal-content{
        height: 88%;
    }

    #judul-modal{
        font-size: 14pt;
    }

    .judul{
        padding: 15px;
    }

    @media only screen and (max-width:320px) {
        .infocontainer
        {
            clear:none; padding-top: 20px !important;
        }
    }

    @media only screen and (min-width:321px) and (max-width:768px) {
        .infocontainer
        {
            clear:none; padding-top: 20px !important;
        }
    }

    @media only screen and (min-width:769px) {
        .infocontainer
        {
            clear:none; padding-top: 0px !important;
        }
    }

</style>
<script type="text/javascript">
    function showhidemenu()
    {
        if($("#infocontainer").hasClass('infocontainer'))
        {
            $("#main, #infocontainer").removeClass('infocontainer');
            $("#horizontal-nav").show();
        }
        else
        {

            $("#main, #infocontainer").addClass('infocontainer');
            $("#horizontal-nav").hide();
        }
    }

    function openModal(url){
        $('.modal-place').html('<div id="my-modal" class="modal"><div class="judul"><span id="judul-modal">SIAP ASN KABUPATEN JOMBANG</span><a class="modal-action modal-close grey-text right" title="Keluar"><i class="mdi-navigation-close"></i></a></div><div class="modal-content"><iframe src="'+url+'" id="m-iframe" width="100%" height="100%" frameBorder="1"></iframe></div></div>')
        $('#my-modal').openModal();
    }
    
    function setCariInfo()
    {
        $("iframe#mainFrame")[0].contentWindow.setCariInfo();
    }
</script>
<div class="modal-place"></div>

<link rel="stylesheet" href="lib/AdminLTE-2.4.0-rc/dist/css/skins/ubah-skin.css">
<script src="lib/AdminLTE-2.4.0-rc/dist/js/ubah-skin.js"></script>

</body>