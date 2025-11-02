<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WsKomponen extends CI_Controller {
    function __construct(){
        parent::__construct();	
        // $this->load->helper('url','html_helper','mbgs_helper');
        $this->load->model('Mkategori');
        $this->load->model('Msop');
        $this->load->helper("tmdashio_helper");
        $this->mbgs->_setBaseUrl(base_url());
        
        $_=array();
        $this->_['code']=$this->mbgs->_backCode($this->enc->encrypt($this->mbgs->_isCode()));
        $this->_=array_merge($this->_,$this->mbgs->_getBasisData());
        $this->_['footer']    =$this->mbgs->_getJs();

        $this->kdMember=$this->sess->kdMember;
        $this->kdMember1=$this->sess->kdMember1;
        $this->nmMember=$this->sess->nmMember;
        $this->kdJabatan=$this->sess->kdJabatan;
        $this->kdDinas=$this->sess->kdDinas;
        $this->kdBidang=$this->sess->kdBidang;
        $this->tahun=$this->sess->tahun;
        
        $this->qtbl=_getNKA("c-prod",true);
        // $username=$this->sess->username;
        // $password=$this->sess->password;
        // $this->startLokal();
    }
    function startLokal(){
        $res=$this->mbgs->_getAllFile("/fs_sistem/session");
        $data="";
        foreach ($res as $key => $value) {
            $exp=explode($this->mbgs->_getIpClient()."=",$value['nama']);
            if(count($exp)>1){
                $data=$this->mbgs->_readFileTxt($value['file']);
            }
        }
        if(strlen($data)==0){
            return $this->mbgs->resF("session");
        }
        $data=json_decode($data);
        $session=array(
            'kdMember'=>$data->{'kdMember'},
            'kdMember'=>$data->{'kdMember1'},
            'nmMember'=>$data->{'nmMember'},
            'kdJabatan'=>$data->{'kdJabatan'},
            'kdKantor'=>$data->{'kdKantor'},
            'nmKantor'=>$data->{'nmKantor'},
            'username'=>$data->{'username'},
            'password'=>$data->{'password'},
        );
        $this->sess->set_userdata($session);
        $this->kdMember=$this->sess->kdMember;
        $this->kdMember1=$this->sess->kdMember1;
        $this->nmMemberMember=$this->sess->nmMember;
        $this->kdJabatan=$this->sess->kdJabatan;
        $this->kdKantor=$this->sess->kdKantor;
        $this->nmMemberKantor=$this->sess->nmKantor;
    }
    function berandaOld($page){
        $this->_['head']        =$this->mbgs->_getJsMaster($page);
        $this->_['footer']      = $this->mbgs->_getJsPlus();
        $this->_['slider']      =$this->qexec->_func("select * from slider order by id asc");
        $this->_['tahun']      =$this->qexec->_func("select nama as value,nama as valueName from tahun order by nama desc");
        $this->_['dinas']      =$this->qexec->_func(_cbDinas(""));
        
        return print_r(json_encode($this->_));
    }
    function agenda($page){
        $this->_['head']    =$this->mbgs->_getJsMaster($page);
        $this->_['footer']  =$this->mbgs->_getJsPlus().$this->mbgs->_getJsTabel();
        
        $hariIni=$this->mbgs->_gdate("Y-m-d");
        $this->_['dt']=array([
            "value"=>0,
            "valueName"=>"Mendatang",
            // _agenda(' where tglS>"'.$hariIni.'" order by kdAgenda asc')
            "dt"=>$this->qexec->_func(
                _agenda(' where  
                    case when substring(tglE,1,4)="0000"
                        then tglS>"'.$hariIni.'"
                        else tglS<"'.$hariIni.'" and tglE>"'.$hariIni.'"
                    end
                    order by kdAgenda desc
            '))
        ],[
            "value"=>1,
            "valueName"=>"Berlalu",
            // _agenda(' where tglS<"'.$hariIni.'" order by kdAgenda desc')
            "dt"=>$this->qexec->_func(
                _agenda('where  
                    case when substring(tglE,1,4)="0000"
                        then tglS<"'.$hariIni.'"
                        else tglE<"'.$hariIni.'"
                    end
                    OR final=1
                    order by kdAgenda desc
                '))
        ]);
        $this->_['agenda']    =$this->qexec->_func(
            _agenda(' 
                where  
                    case when substring(tglE,1,4)="0000"
                        then tglS="'.$hariIni.'"
                        else tglS="'.$hariIni.'" OR tglE>="'.$hariIni.'"
                    end
                    and final=0
                order by waktu asc
            ')
        );
        return print_r(json_encode($this->_));
    }
    function agendaDetail($page,$val){
        $this->_['head']      =$this->mbgs->_getJsMaster($page);
        $this->_['footer']    =$this->mbgs->_getJsPlus();
        $baseEND=json_decode((base64_decode($val)));
        
        $kdAgenda   =$baseEND->{'kdAgenda'};
        $kdMember   =$baseEND->{'kdMember'};
        $this->_['agenda']    =$this->qexec->_func(
            _agenda(' 
                where kdAgenda="'.$kdAgenda.'"
                and kdMember="'.$kdMember.'"
            ')
        )[0];
        return print_r(json_encode($this->_));
    }
    function produk($page){
        $this->_['head']        =$this->mbgs->_getJsMaster($page);
        $this->_['produk']      =$this->qexec->_func("select * from produk order by kdProduk desc");
        return print_r(json_encode($this->_));
    }

    function beranda($page){
        $this->load->helper("nuikct_helper");
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>3,
                "kdJab"=>3,
                "idBody"=>"bodyTM",
                "ind"=>1,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTmx($this->_)
        );
        $this->_['head']      .='
            <link href="'.base_url().'assets/fs_componen/plugins/toastr//toastr.css" rel="stylesheet"/>
            <link href="'.base_url().'assets/fs_componen/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
        '.$this->mbgs->_getJsMaster($page);
        $this->_['slider']      =$this->qexec->_func("select * from slider order by id asc");
        $tahun =$this->qexec->_func("select nama as value,nama as valueName from tahun where selected=1 order by nama desc");
        $this->_['dinas']      =$this->qexec->_func(_cbDinas(" where taDinas='".$tahun[0]['value']."'"));
        
        return print_r(json_encode($this->_));
    }
    function agendaOld($page){
        $this->_['head']      =$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
        
        $hariIni=$this->mbgs->_gdate("Y-m-d");
        $this->_['dt']=array([
            "value"=>0,
            "valueName"=>"Mendatang",
            // _agenda(' where tglS>"'.$hariIni.'" order by kdAgenda asc')
            "dt"=>$this->qexec->_func(
                _agenda(' where  
                    case when substring(tglE,1,4)="0000"
                        then tglS>"'.$hariIni.'"
                        else tglS<"'.$hariIni.'" and tglE>"'.$hariIni.'"
                    end
                    order by kdAgenda desc
            '))
        ],[
            "value"=>1,
            "valueName"=>"Berlalu",
            // _agenda(' where tglS<"'.$hariIni.'" order by kdAgenda desc')
            "dt"=>$this->qexec->_func(
                _agenda('where  
                    case when substring(tglE,1,4)="0000"
                        then tglS<"'.$hariIni.'"
                        else tglE<"'.$hariIni.'"
                    end
                    OR final=1
                    order by kdAgenda desc
                '))
        ]);
        $this->_['agenda']    =$this->qexec->_func(
            _agenda(' 
                where  
                    case when substring(tglE,1,4)="0000"
                        then tglS="'.$hariIni.'"
                        else tglS="'.$hariIni.'" OR tglE>="'.$hariIni.'"
                    end
                    and final=0
                order by waktu asc
            ')
        );
        return print_r(json_encode($this->_));
    }
    function agendaDetailOld($page,$val){
        $this->_['head']      =$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer']  .=$this->mbgs->_getJsTabel();
        $baseEND=json_decode((base64_decode($val)));
        
        $kdAgenda   =$baseEND->{'kdAgenda'};
        $kdMember   =$baseEND->{'kdMember'};
        $this->_['agenda']    =$this->qexec->_func(
            _agenda(' 
                where kdAgenda="'.$kdAgenda.'"
                and kdMember="'.$kdMember.'"
            ')
        )[0];
        return print_r(json_encode($this->_));
    }
    function produkOld($page){
        $this->_['head']      =$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['produk']      =$this->qexec->_func("select * from produk order by kdProduk desc");
        return print_r(json_encode($this->_));
    }


    function profil($page){
        $this->_['head']        =$this->mbgs->_getJsMaster($page);
        return print_r(json_encode($this->_));
    }
    function ppid($page){
        $this->_['head']      =$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['slider']      =$this->qexec->_func("select * from slider order by id asc");
        $this->_['tahun']      =$this->qexec->_func("select nama as value,nama as valueName from tahun order by nama desc");
        $this->_['dinas']      =$this->qexec->_func(_cbDinas(""));
        
        return print_r(json_encode($this->_));
    }
    function kontak($page){
        $this->_['head']      =$this->mbgs->_getJsMaster($page);
        
        return print_r(json_encode($this->_));
    }
    // ('401','40101','PROGRAM ADMINISTRASI UMUM'), 
    // ('402','40201','PROGRAM ADMINISTRASI UMUM SEKRETARIAT DPRD KABUPATEN/KOTA'),

    // sub 
    // ('21503215','2150321502','Pemenuhan fasilitas Pelayanan Angkutan pelabuhan Pengumpan lokal'),
    // ('33007201','3300720103','Pemberdayaan Masyarakat dalam Peningkatan Penggunaan dan Pemanfaatan Sandang Produksi Dalam Negeri'),
    function dashboard($page){
        $this->load->helper("tmDashio_helper");
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>0,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTmx($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        $this->_['tahun']=$this->qexec->_func(_tahunForOption(""));
        
        $this->_['bidang']=$this->qexec->_func("select kdDBidang as kdBidang,nmBidang,asBidang,nm,nip,img from dinas_bidang where kdDinas ='".$this->kdDinas."'");
         
        date_default_timezone_set("Asia/Jakarta");
        $month = date("m");
        $this->_['month']= $month;
        $this->_['bulan']=$this->mbgs->_getBulan($month);   
        $this->_['triulan'] =floor(date("m") / 3);  
        $this->_['data']=$this->qexec->_func(_renstraOpdBidangAutoTahun($this->kdDinas,$month));

        // $this->_['dinas']=$this->qexec->_func(_cbDinas(" where kdDinas='".$this->kdDinas."'"));
        return print_r(json_encode($this->_));
    }
    function setsub($page){
        // 
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>0,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        
        
        $this->_['dinas']=$this->qexec->_func(_cbDinas(" where kdDinas='".$this->kdDinas."'"));
        $qbidang = " and kdDBidang='".$this->kdBidang."'";
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_cbDinasForAG($this->kdMember1,""));
            if(count($gadmin)>0){
                $this->_['dinas']=$gadmin;
            }
            $qbidang = "";
        }elseif($this->kdJabatan==3){
            $qbidang = "";
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
        }

        $this->_['bidang']=$this->qexec->_func(_cbBidangDinas(" where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."' ".$qbidang." "));
        
        
        $this->_['dinas'][0]['data']=$this->qexec->_func(_renstraOpdBidangGet($this->_['dinas'][0]['value'],"",$this->tahun,""));

        // $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['value'],$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['value'],$this->tahun,"")));


        // $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"1",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"2",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"3",$this->tahun,""))[0]['total'];
        
        return print_r(json_encode($this->_));
    }
    function renstra($page){
        // print_r($this->tahun);
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>1,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        $this->_['dinas']=$this->qexec->_func(_cbDinas(" where kdDinas='".$this->kdDinas."'"));
        $qbidang = " and kdDBidang='".$this->kdBidang."'";
        $wherebidang = " and a.kdBidang='".$this->kdBidang."'";
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_cbDinasForAG($this->kdMember1,""));
            if(count($gadmin)>0){
                // $this->_['dinas']=$gadmin;
                
            }
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
            $qbidang = "";
            $wherebidang = "";
        }elseif($this->kdJabatan==3){
            $qbidang = "";
            $wherebidang = "";
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
        }

        if($qbidang == ""){ 
            $this->_['bidang']=array_merge(
                array([
                    "value"=>"all",
                    "valueName"=>"all Bidang"
                ]),
                $this->qexec->_func(_cbBidangDinas(" where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."' ".$qbidang." "))
            );
        }else{  
            $this->_['bidang']=$this->qexec->_func(_cbBidangDinas(" where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."' ".$qbidang." "));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $month = date("m");
        $this->_['bulan']=$this->mbgs->_getBulan($month); 
    
        $this->_['tahun']=$this->tahun;  
        // return print_r(_renstraOpdBidang($this->_['dinas'][0]['value'],$this->tahun,$wherebidang));
        $this->_['dinas'][0]['data']=$this->qexec->_func(_renstraOpdBidang($this->_['dinas'][0]['value'],$this->tahun,$wherebidang,$month));

        // $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['value'],$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['value'],$this->tahun,"")));

        // $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"1",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"2",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"3",$this->tahun,""))[0]['total'];
        // // return print_r($this->tahun);
        return print_r(json_encode($this->_));
    }  
    function sop($page){
        // print_r($this->tahun);
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>5,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        
        
        $this->_['kategori']=$this->Msop->cbKategori();

        $this->_['isAdm']  = false;
        $kdBidang =$this->kdBidang;
        if($this->kdJabatan>1){
            $kdBidang ="";
            $this->_['isAdm']  = true;
        }
        $where = " where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."'"; 
        if ($kdBidang != "") {
            $where .= " and kdDBidang='".$kdBidang."'";
        } 
        $this->_['bidang']=$this->qexec->_func(_cbBidangDinas($where));
        $this->_['sop']=$this->Msop->all($kdBidang);
        
        // $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"1",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"2",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['value'],"3",$this->tahun,""))[0]['total'];
        // return print_r($this->tahun);
        return print_r(json_encode($this->_));
    }  
    function rincianBelanja($page,$val){
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>1,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        $baseEND=json_decode((base64_decode($val)));
        
        $kdSub   =$baseEND->{'kdSub'};
        $kdBidang   =$baseEND->{'kdBidang'};
        $kdDinas   =$baseEND->{'kdDinas'};
        $tahapan   =$baseEND->{'tahapan'};
        // $tahapan   =4;
        $this->_['tahapan']=$tahapan;
        $this->_['tahun']=$this->tahun;
        $this->_['kdBidang']=$kdBidang;
        
        
		
        $this->_['drenstra']=$this->qexec->_func(_renstraOpdBidang($kdDinas,$this->tahun," and a.kdSub=".$this->mbgs->_valforQuery($kdSub)));
        // return print_r($this->_['drenstra']);
        $dt=$this->_['drenstra'][0];
        // $this->_['act']=$dt['qrkaFinal'];
        $this->_['act']=true;
        $this->_['noUser']=$this->kdJabatan>1;
        if($this->kdJabatan==3){
            $this->_['act']=false;
        }
        $nmTahapan="RENJA FINAL";
        switch ($tahapan) {
            case 1:
                $this->_['act']=$dt['qpra'];
                $nmTahapan="PRA RENJA";
            break;
            case 2:
                $this->_['act']=$dt['qrka'];
                $nmTahapan="RENJA";
                if($this->kdJabatan==1){
                    $this->_['act']=true;
                }
            break;
        }
        $this->_['nmTahapan']=$nmTahapan;

        
        $this->_['dapbd']=$this->qexec->_func(_cbApbd6(" where taApbd6='".$this->tahun."'  GROUP BY nmApbd6 order by nmApbd6 asc"));
        $this->_['dSdana']=$this->qexec->_func(_cbSDana(" where taSD='".$this->tahun."' order by kdSDana asc"));
        $this->_['dssh']=$this->qexec->_func(_dssh(" where length(nama)>0 and taSsh='".$this->tahun."'"));

        $v=array();
        $v['kdSub']=$kdSub;
        $v['tahapan']=$tahapan;
        $v['kdDinas']=$kdDinas;
        $v['tahun']=$this->tahun; 
        

        date_default_timezone_set("Asia/Jakarta");
        $month = date("m");
        // $month = 11;
        $dtoday = $this->qexec->_func("select * from ubjudul where bulan='".$month."'");
        if(count($dtoday)==0){ 
            $this->qexec->_proc("insert into ubjudul (kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total, tahapan, dateUpdate, kdJudul, status, qdel, bulan, pagu)
                (SELECT kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total, tahapan, dateUpdate, kdJudul, status, qdel, ".$month.", pagu FROM ubjudul where bulan='".($month-1)."' )
            ");
        }

        $v['bulan']=$month; 
        $this->_['bulan']=$this->mbgs->_getBulan($month); 
        // return print_r(_judulRBelanja($v));
        $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
        $this->_['today']=date("d,m,Y");
        // return print_r($this->_['dtDetailRincian']);
        // foreach ($this->_['dtDetailRincian'] as $key => $v1) {
        //     $v['kdJudul']=$v1['kdJudul'];
		// 	// return print_r(_detailRBelanja($v));
        //     $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
        // }
        
        
        return print_r(json_encode($this->_));
    }
    function rincianBPerubahan($page,$val){
        
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>1,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();

        $baseEND=json_decode((base64_decode($val)));
        // return print_r($baseEND);
        $kdSub   =$baseEND->{'kdSub'};
        $kdDinas   =$baseEND->{'kdDinas'};
        $tahapan   =$baseEND->{'tahapan'};
        $this->_['tahapan']=$tahapan;
        $this->_['tahun']=$this->tahun;

        // return print_r(_renstraOpd($kdDinas,$this->tahun," and a.kdSub=".$this->mbgs->_valforQuery($kdSub)));
        $spl=explode("-",$this->tahun);
        $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]);
        $this->_['tahunOld']=$tahunOld;
        // return print_r($tahunOld);
        $this->_['drenstraOld']=$this->qexec->_func(_renstraOpd($kdDinas,$tahunOld," and a.kdSub=".$this->mbgs->_valforQuery($kdSub)));
        $this->_['drenstra']=$this->qexec->_func(_renstraOpd($kdDinas,$this->tahun," and a.kdSub=".$this->mbgs->_valforQuery($kdSub)));
        // return print_r($this->_['drenstraOld']);
        $dt=$this->_['drenstra'][0];
        // $this->_['act']=$dt['qrkaFinal'];
        $this->_['act']=true;
        if($this->kdJabatan==3){
            $this->_['act']=false;
        }
        $nmTahapan="RENJA FINAL";
        switch ($tahapan) {
            case 1:
                $this->_['act']=$dt['qpra'];
                $nmTahapan="PRA RENJA";
            break;
            case 2:
                $this->_['act']=$dt['qrka'];
                $nmTahapan="RENJA";
            break;
        }
        $this->_['nmTahapan']=$nmTahapan;

        // return print_r(_cbApbd6(" GROUP BY nmApbd6 order by nmApbd6 asc"));
        $this->_['dapbd']=$this->qexec->_func(_cbApbd6(" where taApbd6='".$this->tahun."' GROUP BY nmApbd6 order by nmApbd6 asc"));
        $this->_['dSdana']=$this->qexec->_func(_cbSDana(" where taSD='".$this->tahun."' order by kdSDana asc"));
        $this->_['dssh']=$this->qexec->_func(_dssh(" where length(nama)>0 and taSsh='".$this->tahun."'"));

        $v=array();
        $v['kdSub']=$kdSub;
        $v['tahapan']=$tahapan;
        $v['kdDinas']=$kdDinas;
        $v['tahun']=$this->tahun;
        $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
        // return print_r(_judulRBelanja($v));
        foreach ($this->_['dtDetailRincian'] as $key => $v1) {
            $v['kdJudul']=$v1['kdJudul'];
            if($v1['qdel']){
                $v['tahun']=$tahunOld;
                $v['tahapan']=3;
                $this->_['dtDetailRincian'][$key]['old']=$this->qexec->_func(_judulRBelanjaOld($v));
                $this->_['dtDetailRincian'][$key]['old'][0]['detail']=$this->qexec->_func(_detailRBelanja($v));
            }
            $v['tahapan']=$tahapan;
            $v['tahun']=$this->tahun;
            $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
        }
        
        
        return print_r(json_encode($this->_));
    }
    
    function lapoSerapan($page){
        
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>2,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
        

        $this->_['dinas']=$this->qexec->_func(_cbDinas(" where kdDinas='".$this->kdDinas."'"));
        $qbidang = " and kdDBidang='".$this->kdBidang."'";
        $wherebidang = " and a.kdBidang='".$this->kdBidang."'";
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_cbDinasForAG($this->kdMember1,""));
            if(count($gadmin)>0){
                // $this->_['dinas']=$gadmin;
                
            }
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
            $qbidang = "";
            $wherebidang = "";
        }elseif($this->kdJabatan==3){
            $qbidang = "";
            $wherebidang = "";
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
        }

        if($qbidang == ""){ 
            $this->_['bidang']=array_merge(
                array([
                    "value"=>"all",
                    "valueName"=>"all Bidang"
                ]),
                $this->qexec->_func(_cbBidangDinas(" where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."' ".$qbidang." "))
            );
        }else{  
            $this->_['bidang']=$this->qexec->_func(_cbBidangDinas(" where taDBidang='".$this->tahun."' and kdDinas='".$this->kdDinas."' ".$qbidang." "));
        }
        
        date_default_timezone_set("Asia/Jakarta");
        $month = date("m");
        $this->_['month']= $month;
        $this->_['bulan']=$this->mbgs->_getBulan($month); 
    
        $this->_['tahun']=$this->tahun;  
        // return print_r(_renstraOpdBidang($this->_['dinas'][0]['value'],$this->tahun,$wherebidang));
        $this->_['dinas'][0]['data']=$this->qexec->_func(_renstraOpdBidang($this->_['dinas'][0]['value'],$this->tahun,$wherebidang,$month));

        // return print_r($this->_['dinas']);
        // $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun," and a.kdDinas='".$this->kdDinas."'"));
        // if($this->kdJabatan==2){
        //     $gadmin=$this->qexec->_func(_rekapBelanjaAllOpdAG($this->tahun,$this->kdMember1,""));
        //     if(count($gadmin)>0){
        //         $this->_['dinas']=$gadmin;
        //     }
        // }elseif($this->kdJabatan==3){
        //     $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun,""));
        // }

        // return print_r($this->_['dinas']);
        // $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['kdDinas'],$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['kdDinas'],$this->tahun,"")));

        // $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"1",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"2",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"3",$this->tahun,""))[0]['total'];

        return print_r(json_encode($this->_));
    }
    function lapoOpd($page){
        
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>2,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
    

        $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun," and a.kdDinas='".$this->kdDinas."'"));
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_rekapBelanjaAllOpdAG($this->tahun,$this->kdMember1,""));
            if(count($gadmin)>0){
                $this->_['dinas']=$gadmin;
            }
        }elseif($this->kdJabatan==3){
            $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun,""));
        }
        // return print_r($this->_['dinas']);
        // $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['kdDinas'],$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['kdDinas'],$this->tahun,"")));

        // $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"1",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"2",$this->tahun,""))[0]['total'];
        // $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"3",$this->tahun,""))[0]['total'];

        return print_r(json_encode($this->_));
    }
    function lapoBelanja($page){
        
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>2,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
    

        // $this->_['dinas']=$this->qexec->_func(_dinas(" where kdDinas='".$this->kdDinas."'"));
        // if($this->kdJabatan==2){
        //     $gadmin=$this->qexec->_func(_dinasForAG($this->kdMember1,""));
        //     if(count($gadmin)>0){
        //         $this->_['dinas']=$gadmin;
        //     }
        // }elseif($this->kdJabatan==3){
        //     $this->_['dinas']=$this->qexec->_func(_dinas(""));
        // }
        $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun," and a.kdDinas='".$this->kdDinas."'"));
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_rekapBelanjaAllOpdAG($this->tahun,$this->kdMember1,""));
            if(count($gadmin)>0){
                $this->_['dinas']=$gadmin;
            }
        }elseif($this->kdJabatan==3){
            $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun,""));
        }

        $this->_['apbd']=array_merge(
            array([
                "value"=>"all",
                "valueName"=>"Tanpa FIlter"
            ]),
            $this->qexec->_func(_cbApbd("2"," where kdApbd1=5 and taApbd2='".$this->tahun."'"))
        );


        $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['kdDinas'],$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['kdDinas'],$this->tahun,"")));

        $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"1",$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"2",$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"3",$this->tahun,""))[0]['total'];

        return print_r(json_encode($this->_));
    }
    function lapoPaguSub($page){
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>2,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
    
        $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun," and a.kdDinas='".$this->kdDinas."'"));
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_rekapBelanjaAllOpdAG($this->tahun,$this->kdMember1,""));
            if(count($gadmin)>0){
                $this->_['dinas']=$gadmin;
            }
        }elseif($this->kdJabatan==3){
            $this->_['dinas']=$this->qexec->_func(_rekapBelanjaAllOpd($this->tahun,""));
        }

        $this->_['dinas'][0]['tsub']=$this->qexec->_func(_tsub($this->_['dinas'][0]['kdDinas'],$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tsubProses']=count($this->qexec->_func(_tsubProses($this->_['dinas'][0]['kdDinas'],$this->tahun,"")));

        $this->_['dinas'][0]['tpaguPra']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"1",$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tpaguRka']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"2",$this->tahun,""))[0]['total'];
        $this->_['dinas'][0]['tpaguFinal']=$this->qexec->_func(_tpagu($this->_['dinas'][0]['kdDinas'],"3",$this->tahun,""))[0]['total'];

        return print_r(json_encode($this->_));
    }

    function setting($page){
        
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>3,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );
        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
        return print_r(json_encode($this->_));
    }
    function expDpa($page){
        $this->_=array_merge(
            $this->_,
            [
                "pgStart"=>"Login",
                "pgEnd"=>"Dashboard",
                "user"=>$this->nmMember,
                "kdJab"=>$this->kdJabatan,
                "idBody"=>"bodyTM",
                "ind"=>5,
                "index"=>0
            ]
        );
        $this->_=array_merge(
            $this->_
            ,
            _startTm($this->_)
        );

        $this->_['tahun']=$this->tahun;
        $this->_['dinas']=$this->qexec->_func(_cbDinas(" where kdDinas='".$this->kdDinas."'"));
        if($this->kdJabatan==2){
            $gadmin=$this->qexec->_func(_cbDinasForAG($this->kdMember1,""));
            if(count($gadmin)>0){
                $this->_['dinas']=$gadmin;
            }
        }elseif($this->kdJabatan==3){
            $this->_['dinas']=$this->qexec->_func(_cbDinas(""));
        }
        if(count($this->_['dinas'])>0){
            $this->_['dinas'][0]['sub']=$this->qexec->_func(_cbSub($this->_['dinas'][0]['value'],$this->tahun,""));
        }

        $this->_['dinas']= array_merge(
            array([
                "value"=>"all",
                "valueName"=>"Semua Dinas"
            ]),
            $this->_['dinas']
        );

        $this->_['head'].=$this->mbgs->_getCss().$this->mbgs->_getJsMaster($page);
        $this->_['footer'].=$this->mbgs->_getJsChart();
        $this->_['footer'] .=$this->mbgs->_getJsTabel();
        return print_r(json_encode($this->_));
    }
}
    