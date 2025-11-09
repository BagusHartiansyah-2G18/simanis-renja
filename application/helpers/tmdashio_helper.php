<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function _tmHead(){
        $CI =& get_instance();
        $furl=$CI->mbgs->_getAssetUrl()."thema/Dashio/";
        return '
            <link href="'.$furl.'lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
            
            <!--external css-->
            <link href="'.$furl.'lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
            <link rel="stylesheet" type="text/css" href="'.$furl.'css/zabuto_calendar.css">
            <link rel="stylesheet" type="text/css" href="'.$furl.'lib/gritter/css/jquery.gritter.css" />
            
            <!-- Custom styles for this template -->
            <link href="'.$furl.'css/style.css" rel="stylesheet">
            <link href="'.$furl.'css/style-responsive.css" rel="stylesheet">
            <script src="'.$furl.'lib/chart-master/Chart.js"></script>
    
        ';
    }
    function _tmFooter(){
        $CI =& get_instance();
        $furl=$CI->mbgs->_getAssetUrl()."thema/Dashio/";
        return '
                <script src="'.$furl.'lib/jquery/jquery.min.js"></script>

                <script src="'.$furl.'lib/bootstrap/js/bootstrap.min.js"></script>
                <script class="include" type="text/javascript" src="'.$furl.'lib/jquery.dcjqaccordion.2.7.js"></script>
                <script src="'.$furl.'lib/jquery.scrollTo.min.js"></script>
                <script src="'.$furl.'lib/jquery.nicescroll.js" type="text/javascript"></script>
                <script src="'.$furl.'lib/jquery.sparkline.js"></script>
                <!--common script for all pages-->
                <script src="'.$furl.'lib/common-scripts.js"></script>
                <script type="text/javascript" src="'.$furl.'lib/gritter/js/jquery.gritter.js"></script>
                <script type="text/javascript" src="'.$furl.'lib/gritter-conf.js"></script>
                <!--script for this page-->
                <script src="'.$furl.'lib/sparkline-chart.js"></script>
                <script src="'.$furl.'lib/zabuto_calendar.js"></script>
                <script type="text/javascript" src="'.$furl.'lib/jquery.backstretch.min.js"></script>
  
        ';  
    }
    function _tmLoader(){
        return '';
    }
    function _tmSetting($p){
        $CI =& get_instance();
        // hg height
        // bg background,
        // wd width
        // nm nama 
        // pg page 
        // ic icon 
        // ac active
        // ha hak akses 
        // kdJab kd jabatan 
        $_=array();
        $router=base_url();
        $fs_css=$router."assets/fs_css/";

        $user=[1,2,3,4,5];
        $admin=[2,3,4,5];
        $monitor=[3,4,5];
        $super=[3,4,5];
        $dev=[4];

        $_['kdJab']=$p['kdJab'];
        $_['nav']=[
            "bg"=>"style='background-color:none;'",
            // "logo"=>$fs_css.'logo/'.$p['logo'],
            "logo"=>$fs_css.'round-tecn2.gif',
            
            "cls"=>"",
            "hgLogo2"=>"150px",
            "wdLogo"=>"50px;",
            "nm"=>$p['nm'],
            "nama"=>$p['nama'],
            "user"=>$p['user'],
            "bgNama"=>"text-light",
            "pgStart"=>$p['pgStart'],
            "pgEnd"=>$p['pgEnd'],
            "form"=>"",
            "moto"=>"..."
        ];
        $_['menu']=array();
        
        // menu 1
        
        
        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"Set Sub Kegiatan",
            "ic"=>'<i class="mdi mdi-air-filter menu-icon"></i>',
            "cls"=>'',
            "url"=>$router."control/setsub",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);

        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"Serapan Anggaran",
            "ic"=>'<i class="mdi mdi-airballoon-outline menu-icon"></i>',
            "cls"=>'',
            "url"=>$router."control/renstra",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);

        // menu 2
        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"Laporan",
            "ic"=>'<i class="mdi mdi-database-plus menu-icon"></i>',
            "url"=>"#",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[
                [
                    "url"=>$router."control/lapoSerapan",
                    "menu"=>"BPKAD",
                    "ha"=>$user,
                    "status"=>""
                ],[
                    "url"=>$router."control/lapoBelanja",
                    "menu"=>"SKPKD",
                    "ha"=>$admin,
                    "status"=>""
                // ],[
                //     "url"=>$router."laporan/lapoBelanjaAllOpd",
                //     "menu"=>"Rekap Total Belanja ",
                //     "ha"=>$admin,
                //     "status"=>""
                // ],[
                //     "url"=>$router."control/lapoPaguSub",
                //     "menu"=>"Rekap Kegiatan",
                //     "ha"=>$admin,
                //     "status"=>""
                ]
                // [
                //     "url"=>$router."control/lapoOpd",
                //     "menu"=>"OPD",
                //     "ha"=>$user,
                //     "status"=>""
                // ],[
                //     "url"=>$router."control/lapoBelanja",
                //     "menu"=>"Rekap Belanja",
                //     "ha"=>$admin,
                //     "status"=>""
                // ],[
                //     "url"=>$router."laporan/lapoBelanjaAllOpd",
                //     "menu"=>"Rekap Total Belanja ",
                //     "ha"=>$admin,
                //     "status"=>""
                // ],[
                //     "url"=>$router."control/lapoPaguSub",
                //     "menu"=>"Rekap Kegiatan",
                //     "ha"=>$admin,
                //     "status"=>""
                // ]
            ]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);

        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"Pengaturan",
            "ic"=>'<i class="mdi mdi-wrench menu-icon"></i>',
            "cls"=>'text-dark',
            "url"=>$router."control/setting",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);

        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"Tahun ".$CI->sess->tahun,
            "ic"=>'<i class="mdi mdi-calendar menu-icon"></i>',
            "cls"=>'',
            "url"=>$router."control/dashboard/null",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);
        
        
        // return print_r($p['kdJab'])
        if($p['kdJab']==3){
            $menuSupport=array();
            array_push($menuSupport,[
                "nm"=>"Import DPA",
                "ic"=>'<i class="mdi mdi-cloud-upload menu-icon"></i>',
                "cls"=>'text-dark',
                "url"=>$router."control/expDpa",
                "ac"=>"",
                "ha"=>$user,
                "subMenu"=>[]
            ]);
            array_push($_['menu'],[
                "nm"=>null,
                "menu"=>$menuSupport
            ]);
        }
        if($p['kdJab']==3){
            $menuSupport=array();
            array_push($menuSupport,[
                "nm"=>"E-MASTER",
                "ic"=>'<i class="mdi mdi-cloud-tags menu-icon"></i>',
                "cls"=>'text-dark',
                "url"=>$router."master/control/dinas",
                "ac"=>"",
                "ha"=>$user,
                "subMenu"=>[]
            ]);
            array_push($_['menu'],[
                "nm"=>null,
                "menu"=>$menuSupport
            ]);
        }

        $menuSupport=array();
        array_push($menuSupport,[
            "nm"=>"SOP",
            "ic"=>'<i class="fa fa-th-list"></i>',
            "cls"=>'',
            "url"=>$router."control/sop/null",
            "ac"=>"",
            "ha"=>$user,
            "subMenu"=>[]

        ]);
        array_push($_['menu'],[
            "nm"=>null,
            "menu"=>$menuSupport
        ]);
        
        // header
        $_['header']=[
            "nama"=>"",
            "ic"=>$fs_css."/boy.png",
            "cls"=>" black-bg",
            "style"=>"background-color: #3a4f5573;",
            "style1"=>'style="background-image:url('.$fs_css."bgForm.png".'); height:'.$_['nav']['hgLogo2'].';"',
            "contentDropList"=>[
                [
                    "url"=>"",
                    "onclick"=>"",
                    "icon"=>'<i class="mdi mdi-face"></i>',
                    "nama"=>"Profile"
                ],
                [
                    "url"=>"",
                    "onclick"=>"",
                    "icon"=>'<i class="mdi mdi-settings"></i>',
                    "nama"=>"Settings"
                ],
                [
                    "url"=>"",
                    "onclick"=>"",
                    "icon"=>'<i class="mdi mdi-exit-to-app"></i>',
                    "nama"=>"Logout"
                ]
            ]
        ];

        // notif
        $_['notif']=[
            [
                "url"=>"",
                "bg"=>"",
                "icon"=>'<i class="fa fa-bolt"></i>',
                "src"=>$fs_css."informasi.png",
                "textSmall"=>"Nama Sistem",
                "text"=>"E-Budgeting"
            ],
            // [
            //     "url"=>"",
            //     "bg"=>"",
            //     "icon"=>'<i class="fa fa-bolt"></i>',
            //     "src"=>$fs_css."informasi.png",
            //     "textSmall"=>"Mei 25, 2021",
            //     "text"=>"Dikembangkan oleh : Tim IT MFC"
            // ],
            // [
            //     "url"=>"",
            //     "bg"=>"",
            //     "icon"=>'<i class="fa fa-bolt"></i>',
            //     "src"=>$fs_css."informasi.png",
            //     "textSmall"=>"Mei 25, 2021",
            //     "text"=>"Sistem di Luncurkan"
            // ],
        ];
        $_['notifT']=true;
        $_['copyright']=$p['copyright'];
        return $_;
    }
    function _tmHeader($st){
        // $st=_tmSetting($p);
        $CI =& get_instance();
        $fdata='
            <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                <i class="fa fa-bell-o"></i>Informasi System
                <span class="badge bg-warning">'.count($st['notif']).'</span>
            </a>
        ';
        $fdata1='
            <li>
                <p class="yellow">'.count($st['notif']).' Informasi</p>
            </li>
        ';
        foreach ($st['notif'] as $key => $v) {
            $fdata1.='
                <li>
                    <a href="'.$v['url'].'">
                        <span class="photo"><img alt="avatar" src="'.$v['src'].'" width="30px"></span>
                        <span class="subject">
                            <span class="from">'.$v['text'].'</span>
                        </span>
                        <span class="message"><br>
                            '.$v['textSmall'].'
                        </span>
                    </a>
                </li>
                
            ';
        }
        if($st['notifT']){
            $fdata1.='
            <li class="bg-secondary btn-block">
                <button type="button" class="btn btn-sm btn-success btn-block p-4" 
                    onclick="_mengertiNotif()" title="Preview Document">
                        <i class="mdi mdi-comment-check-outline"></i>
                        Saya Mengerti
                </button>
            </li>';
        }
    
    
        // $fdata1="";
        // foreach ($st['header']['contentDropList'] as $key => $v) {
        //     $url="#";
        //     if($v['url']!=""){
        //         $url=$v['url'];
        //     }
        //     $fdata1.='
        //         <li class="waves-effect waves-light">
        //             <a href="'.$v['url'].'" '.$v['onclick'].'>
        //                 '.$v['icon'].$v['nama'].'
        //             </a>
        //         </li>
        //     ';
        // }
        return '
            <header class="header  '.$st['header']['cls'].'" >
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
                </div>
                <!--logo start-->
                <a href="#" style="margin-top: 10px;" class="logo"><b>'.substr($st['nav']['nm'],0,2).'<span>'.substr($st['nav']['nm'],2,6).'</span></b></a>
                <!--logo end-->
                <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- settings start -->
                    <li id="header_notification_bar" class="dropdown">
                        '.$fdata.'
                        <ul class="dropdown-menu extended notification" style="min-width:300px !important">
                            '.$fdata1.'
                        </ul>
                    </li>
                    <li   class="dropdown">
                        <li class="breadcrumb-item">
                            <p class="animet1" style="">
                                '.$st['nav']['moto'].'
                            </p>
                        </li>
                    </li>
                </ul>
                <!--  notification end -->
                </div>
                <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="'.base_url()."control/logout".'">Logout</a></li>
                </ul>
                </div>
            </header>
        ';
    }
    function _tmNavbar($st){
        // $st=_tmSetting($p);
        $fdata="";
        foreach ($st['menu'] as $key => $v) {
            $faktifMenu=$v['menu'][0]['ac']." ".$st['menu'][0]['menu'][0]['cls'];
            $ftamSubMenu="";
            $menu=$v['menu'][0];
            
            $fcls="sub-menu";
            if($key==0){
                $fcls="mt";
            }
            foreach ($menu['ha'] as $key1 => $vx) {
                if($st['kdJab']==$vx){
                    // print_r($st['kdJab']."  |  ".$vx." <br>");
                    if(count($menu['subMenu'])>0){
                        $fdata.='
                            <li class="'.$fcls.'">
                                <a href="javascript:;" class="'.$faktifMenu.'">
                                    '.$menu['ic'].'
                                <span>'.$menu['nm'].'</span>
                                </a>
                                <ul class="sub">';
                                
                                    foreach ($menu['subMenu'] as $key2 => $vm) {
                                        foreach ($vm['ha'] as $key3 => $vx3) {
                                            if($st['kdJab']==$vx3){
                                                $fdata.='
                                                <li class="'.$vm['status'].'">
                                                    <a href="'.$vm['url'].'">'.$vm['menu'].'</a>
                                                </li>';
                                            }
                                        }
                                    }
                            $fdata.='
                                </ul>
                            </li>
                            ';
                    }else{
                        $fdata.='
                            <li class="'.$fcls.'">
                                <a class="'.$faktifMenu.'" href="'.$menu['url'].'">
                                '.$menu['ic'].'
                                <span>'.$menu['nm'].'</span>
                                </a>
                            </li>
                        ';
                    }
                }
            }
        }
        // return print_r($fdata)
       // return `
       // <ul class="navbar-nav sidebar sidebar-light accordion col" id="accordionSidebar" style="padding:0px;max-width:max-content;">
       //     <a class="sidebar-brand d-flex align-items-center justify-content-center" `+navBar.BG+` href="index.html">
       //         <div class="sidebar-brand-icon">
       //             <img src="`+navBar.Logo+`">
       //         </div>
       //         <div class="sidebar-brand-text mx-3">`+navBar.nama+`</div>
       //     </a>
       //     <hr class="sidebar-divider my-0">
       //     `+fdata+`
       //     <div class="version" id="version-ruangadmin">2G18/V1</div>
       // </ul>
       // `;
        //    <img src="http://localhost:8080/notaris/assets/fs_css/1.gif" class="img-circle">
       return '
            <aside>
                <div id="sidebar" class="nav-collapse '.$st['nav']['cls'].'">
                    <!-- sidebar menu start-->
                    <ul class="sidebar-menu" id="nav-accordion">
                        <p class="centered"><a href="profile.html"><img class="img-circle" src="'.$st['nav']['logo'].'"  width="80"></a></p>
                        <h5 class="centered"><b>'.strtoupper($st['nav']['user']).'</b></h5>
                        '.$fdata.'
                    </ul>
                    <!-- sidebar menu end-->
                </div>
                </aside>
       ';
       
    }
    function _pgFooter($st){
        return '
            <footer class="site-footer">
                <div class="text-center">
                <p>
                    '.$st['copyright'].'
                </p>
                <a href="index.html#" class="go-top">
                    <i class="fa fa-angle-up"></i>
                    </a>
                </div>
            </footer>
        ';
    }
    function _startTm($p){
        // $p=[
        //     "pgStart"=>"",
        //     "pgEnd"=>"",
        //     "nm"=>"",
        //     "kdJab"=>3,
        //     "idBody"=>"bodyTM1" // body content
        // ];
        // return print_r($p);
        $st=_tmSetting($p);
        
        $st['menu'][$p['ind']]['menu'][0]['ac']='active';
        // return print_r($st['kdJab']);
        if($p['index']!=null){
            $st['menu'][$p['ind']]['menu'][0]['subMenu'][$p['index']]['ac']='active';
        }
        // 
        return [
            "head"=>_tmHead(),
            "tmFooter"=>_tmFooter(),
            "tmBody"=>_tmHeader($st)
                        ._tmNavbar($st)
                        .'<section id="main-content">
                            <section class="wrapper" id="'.$p['idBody'].'" style="padding: 0px;margin-top: 0px;">
                            </section>
                        </section>'
                        ._pgFooter($st) 
        ];
    }
    function _startTmx($p){
        // $p=[
        //     "pgStart"=>"",
        //     "pgEnd"=>"",
        //     "nm"=>"",
        //     "kdJab"=>3,
        //     "idBody"=>"bodyTM1" // body content
        // ];
        // return print_r($p);
        $st=_tmSetting($p);
        
        $st['menu'][$p['ind']]['menu'][0]['ac']='active';
        // return print_r($st['kdJab']);
        if($p['index']!=null){
            $st['menu'][$p['ind']]['menu'][0]['subMenu'][$p['index']]['ac']='active';
        }
        // 
        return [
            "head"=>_tmHead(),
            "tmFooter"=>_tmFooter(),
            "tmBody"=>_tmHeader($st)
                        .'<section class="wrapper" id="'.$p['idBody'].'" style="padding: 0px;margin-top: 0px;">
                        </section>'
                        ._pgFooter($st) 
        ];
    }
?>
