<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// sess enc mbgs lbgs qexec
class Proses extends CI_Controller {
    private $bgs;
    function __construct(){
        parent::__construct();
        $this->_=array();
        $this->load->model('Mkategori');
        $this->load->model('Msop');

        
        $this->kdMember=$this->sess->kdMember;
        $this->nmMember=$this->sess->nmMember;
        $this->kdJabatan=$this->sess->kdJabatan;
        $this->kdDinas=$this->sess->kdDinas;
        $this->kdBidang = $this->sess->kdBidang;
        $this->tahun=$this->sess->tahun;

        $this->qtbl=_getNKA("c-prod",true);
        // $this->qtbl['p-kant']['nm']
    }
	public function checkUser(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            $data=$_POST['data'];
            if(empty($_POST['data'])){
                return redirect("control");
            }
            
            $baseEND=json_decode((base64_decode($data)));

            $kdDinas   =$baseEND->{'kdDinas'};
            $password   =$baseEND->{'password'};
            $username   =$baseEND->{'username'};
            $kondisi=true;
        }else{
            $password   =$this->sess->password;
            $username   =$this->sess->nama;
            $kdDinas   =$this->sess->kdDinas;
        }
        $tq='';
        if(!$kdDinas=="-"){
            $tq="kodeDinas='".$kdDinas."' and status='adminSuper'";
        }
        $q="select * from member where ".$tq." UPPER(nmMember)=UPPER('".$username."') and UPPER(password)=UPPER('".$password."') and kdApp='".$this->mbgs->app['kd']."'";
        // return print_r($q);
        $member=$this->qexec->_func($q);
        if(count($member)==1){
        // if(count($member)>1){
            // if($kondisi){//for login awal no sess
            //     if(substr($member[0]['kdJabatan'],5)<3){
            //         $pembahasan=$this->qexec->_func("SELECT tahun,noPembahasan,progres,finals,files FROM pembahasan ORDER by ins desc limit 1");
            //         if(count($pembahasan)==0){
            //             return $this->mbgs->resFalse("Sistem Tidak Dapat Digunakan ");
            //         }
            //     }
            //     return $this->mbgs->resTrue("Sukses");
            // }
            return $this->mbgs->resTrue("Sukses");
        }else{
            if($kondisi){//for login awal no sess
                return $this->mbgs->resFalse("user tidak dapat ditemukan !!!");
            }
        }
        $this->logout();
        print_r(json_encode($this->_));
    }
    public function getRenstraOpd(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdDinas   =$baseEND->{'kdDinas'};
            
            $this->_['data']=$this->qexec->_func(_renstraOpdGet($kdDinas,$this->tahun,""));
            $this->_['tsub']=$this->qexec->_func(_tsub($kdDinas,$this->tahun,""))[0]['total'];
            $this->_['tsubProses']=count($this->qexec->_func(_tsubProses($kdDinas,$this->tahun,"")));

            $this->_['tpaguPra']=$this->qexec->_func(_tpagu($kdDinas,"1",$this->tahun,""))[0]['total'];
            $this->_['tpaguRka']=$this->qexec->_func(_tpagu($kdDinas,"2",$this->tahun,""))[0]['total'];
            $this->_['tpaguFinal']=$this->qexec->_func(_tpagu($kdDinas,"3",$this->tahun,""))[0]['total'];
            return $this->mbgs->resTrue($this->_);
        }
    }
    public function saveRenstraOpd(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdDinas   =$baseEND->{'kdDinas'};
            $kdBidang   =$baseEND->{'kdBidang'};
            $data       =$baseEND->{'data'};

            // return print_r($data[0]->act);
            $qadd='';
            $qdel='';
            $kondisi=true;
            foreach ($data as $key => $v) {
                if($v->act){
                    $kondisi=false;
                    $qadd.='update psub set kdBidang="'.$kdBidang.'" where kdBidang=0 and 
                        kdSub = '.$this->mbgs->_valforQuery($v->kdSub).' and
                        kdKeg = '.$this->mbgs->_valforQuery($v->kdKeg).' and
                        kdDinas = '.$this->mbgs->_valforQuery($kdDinas).' and
                        taSub = '.$this->mbgs->_valforQuery($this->tahun).'; ';
                }else{
                    $qdel.='update psub set kdBidang="0" where kdBidang="'.$kdBidang.'" and
                            kdSub = '.$this->mbgs->_valforQuery($v->kdSub).' and
                            kdKeg = '.$this->mbgs->_valforQuery($v->kdKeg).' and
                            kdDinas = '.$this->mbgs->_valforQuery($kdDinas).' and
                            taSub = '.$this->mbgs->_valforQuery($this->tahun).';';
                }
            }
            // return print_r($qadd.$qdel);
            $check=$this->qexec->_multiProc($qadd.$qdel);
            if($check){
                $this->_['data']=$this->qexec->_func(_renstraOpdBidangGet($kdDinas,"",$this->tahun,""));
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }
    }

    public function getRenstraRealOpd(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdDinas   =$baseEND->{'kdDinas'};
            
            $this->_['data']=$this->qexec->_func(_renstraOpd($kdDinas,$this->tahun,""));
            $this->_['tsub']=$this->qexec->_func(_tsub($kdDinas,$this->tahun,""))[0]['total'];
            $this->_['tsubProses']=count($this->qexec->_func(_tsubProses($kdDinas,$this->tahun,"")));
            $this->_['tpaguPra']=$this->qexec->_func(_tpagu($kdDinas,"1",$this->tahun,""))[0]['total'];
            $this->_['tpaguRka']=$this->qexec->_func(_tpagu($kdDinas,"2",$this->tahun,""))[0]['total'];
            $this->_['tpaguFinal']=$this->qexec->_func(_tpagu($kdDinas,"3",$this->tahun,""))[0]['total'];
            return $this->mbgs->resTrue($this->_);
        }
    }
    public function addKategori(){ 
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $values   =[
                "nmKate"=>$baseEND->{'judul'},
                "sumber"=>$this->kdMember
            ];
            $this->_['id']= $this->Mkategori->add($values);
            
            if($this->_['id']>0){
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }
    }
    

    function expBelanjaPersatu(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdSub   =$baseEND->{'kdSub'};
            $kdDinas =$baseEND->{'kdDinas'};
            $tahapan =$baseEND->{'tahapan'};
           
            $nmTabel=" qpra=1 ";
            if($tahapan==3){
                $nmTabel=" qrka=1 ";
            }

            $q="
                delete from ubjudul where 
                    kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    taJudul='".$this->tahun."' and 
                    tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                    status=1;
                delete from ubrincian where 
                    kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    taRincian='".$this->tahun."' and 
                    tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                    status=1;
            ";
            $check=$this->qexec->_multiProc($q);
            if($check){
                $q="
                    INSERT INTO `ubjudul` (kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total, tahapan, dateUpdate, kdJudul, status) (
                        SELECT 
                            kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total,".$tahapan.", dateUpdate, kdJudul, status 
                        FROM ubjudul where 
                        kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                        kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                        taJudul='".$this->tahun."' and 
                        tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                        status=1
                    );
                    INSERT INTO `ubrincian` (kdRincian, kdJudul, kdSub, kdDinas, uraian, total, jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, volume, satuanVol, harga, date, taRincian, status, tahapan)(
                        SELECT kdRincian, kdJudul, kdSub, kdDinas, uraian, total, jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, volume, satuanVol, 
                            harga, date, taRincian, status,".$tahapan."
                        FROM ubrincian where 
                        kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                        kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                        taRincian='".$this->tahun."' and 
                        tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                        status=1
                    );
                    update psub set ".$nmTabel." where 
                    kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                    taSub='".$this->tahun."'
                ";
                $check=$this->qexec->_multiProc($q);
                if($check){
                    return $this->mbgs->resTrue($this->_);
                }
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }
    }
    function saveExpBelanjaPersatu(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdSub   =$baseEND->{'kdSub'};
            $kdKeg   =$baseEND->{'kdKeg'};
            $kdDinas =$baseEND->{'kdDinas'};
            $tahapan =$baseEND->{'tahapan'};

            $lokasiP =$baseEND->{'lokasiP'};
            $waktuP =$baseEND->{'waktuP'};
            $kelompokS =$baseEND->{'kelompokS'};
            $keluaran =$baseEND->{'keluaran'};
            $hasil =$baseEND->{'hasil'};
            $keluaranT =$baseEND->{'keluaranT'};
            $hasilT =$baseEND->{'hasilT'};
            
            $dkeluaran =$baseEND->{'dkeluaran'};
            $dhasil =$baseEND->{'dhasil'};

            $export =$baseEND->{'export'};
            
            // return print_r($baseEND);
        
            $q="UPDATE psub SET 
                lokasiP='".$lokasiP."',
                waktuP='".$waktuP."',
                kelompokS='".$kelompokS."',
                keluaran='".$keluaran."',
                hasil='".$hasil."',
                keluaranT='".$keluaranT."',
                hasilT='".$hasilT."',
                dkeluaran='".$dkeluaran."',
                dhasil='".$dhasil."'
            WHERE kdDinas='".$kdDinas."'
                and kdSub ='".$kdSub."'
                and kdKeg ='".$kdKeg."'
                and taSub ='".$this->tahun."'
            ";
            $check=$this->qexec->_proc($q);
            if($check){
                if($export){
                    $nmTabel=" qpra=1 ";
                    if($tahapan==3){
                        $nmTabel=" qrka=1 ";
                    }
                    
                    $q="
                        delete from ubjudul where 
                            kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                            kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                            taJudul='".$this->tahun."' and 
                            tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                            status=1;
                        delete from ubrincian where 
                            kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                            kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                            taRincian='".$this->tahun."' and 
                            tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                            status=1;
                    ";
                    $check=$this->qexec->_multiProc($q);
                    if($check){
                        $q="
                            INSERT INTO `ubjudul` (kdSUb, kdDinas,  kdApbd6, kdSDana, nama, taJudul, total, tahapan, dateUpdate, kdJudul, status)(
                                SELECT 
                                    kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total,".$tahapan.", dateUpdate, kdJudul, status 
                                FROM ubjudul where 
                                kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                                taJudul='".$this->tahun."' and 
                                tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                                status=1
                            );
                            INSERT INTO `ubrincian` (kdRincian, kdJudul, kdSUb, kdDinas, uraian, total, jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, volume, satuanVol, harga, date, taRincian, status, tahapan)(
                                SELECT kdRincian, kdJudul, kdSub, kdDinas, uraian, total, jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, volume, satuanVol, 
                                    harga, date, taRincian, status,".$tahapan."
                                FROM ubrincian where 
                                kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                                taRincian='".$this->tahun."' and 
                                tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                                status=1
                            );
                            update psub set ".$nmTabel." where 
                            kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                            kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                            taSub='".$this->tahun."'
                        ";
                        // return print_r($q); 
                        // return print_r($q); 
                        $check=$this->qexec->_multiProc($q);
                        if($check){
                            return $this->mbgs->resTrue($this->_);
                        }
                    }
                    return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
                    
                    // $q="
                    //     delete from ubjudul where 
                    //         kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    //         taJudul='".$this->tahun."' and 
                    //         tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                    //         status=1;
                    //     delete from ubrincian where 
                    //         kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    //         taRincian='".$this->tahun."' and 
                    //         tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                    //         status=1;
                    //     INSERT INTO `ubjudul` (
                    //         SELECT 
                    //             kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total,".$tahapan.", dateUpdate, kdJudul, status 
                    //         FROM ubjudul where 
                    //         kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    //         taJudul='".$this->tahun."' and 
                    //         tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                    //         status=1
                    //     );
                    //     INSERT INTO `ubrincian` (
                    //         SELECT kdRincian, kdJudul, kdSub, kdDinas, uraian, total, jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, volume, satuanVol, 
                    //             harga, date, taRincian, status,".$tahapan."
                    //         FROM ubrincian where 
                    //         kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and
                    //         taRincian='".$this->tahun."' and 
                    //         tahapan=".$this->mbgs->_valforQuery($tahapan-1)." and
                    //         status=1
                    //     );
                    //     update psub set ".$nmTabel." where 
                    //     kdSUb=".$this->mbgs->_valforQuery($kdSub)." and
                    //     kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                    //     taSub='".$this->tahun."'
                    // ";
                    // $check=$this->qexec->_multiProc($q);
                }
                
                if($check){
                    return $this->mbgs->resTrue($this->_);
                }else{
                    return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
                }
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan pada sistem");
            }
            
        }
    }
    
    function insBelanja(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        // $portal=$this->_keamanan($_POST['code'],_getNKA("c-prod",false));
        // if($portal['exec']){
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $qdel   =$baseEND->{'qdel'};
        $judul   =$baseEND->{'judul'};
        $rincian   =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        
        $q=substr($judul,0,strlen(trim($judul))-1).";";
        $q.=substr($rincian,0,strlen(trim($rincian))-1);

        $check=$this->qexec->_multiProc($qdel);
        if($check){
			// return print_r($q);
            $check=$this->qexec->_multiProc($q);
            if($check){
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
                $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                    $v['kdJudul']=$v1['kdJudul'];
                    $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                return $this->mbgs->resTrue($this->_);
            }
            // $this->_['ddata']=$this->qexec->_func(_dproduk($this->kdKantor,""));
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
        }
        // }return $this->mbgs->resFalse($portal['msg']);
    }
    function insBelanjaP(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        // $portal=$this->_keamanan($_POST['code'],_getNKA("c-prod",false));
        // if($portal['exec']){
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $qdel   =$baseEND->{'qdel'};
        $judul   =$baseEND->{'judul'};
        $rincian   =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        
        $q=substr($judul,0,strlen(trim($judul))-1).";";
        $q.=substr($rincian,0,strlen(trim($rincian))-1);

        $check=$this->qexec->_multiProc($qdel);
        if($check){
			// return print_r($q);
            $check=$this->qexec->_multiProc($q);
            if($check){
                $spl=explode("-",$tahun);
                $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]); 
        
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
                $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                    $v['kdJudul']=$v1['kdJudul'];
                    $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
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
                
                return $this->mbgs->resTrue($this->_);
            }
            // $this->_['ddata']=$this->qexec->_func(_dproduk($this->kdKantor,""));
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
        }
        // }return $this->mbgs->resFalse($portal['msg']);
    }
    function updBelanja(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
    
        $judul      =$baseEND->{'judul'};
        $rincian    =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        $kdJudul    =$baseEND->{'kdJudul'};
        
        // mengamankan data
        // update ubjudul set
        //         status=0
        //     where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
        //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //         taJudul=".$this->mbgs->_valforQuery($tahun)." and
        //         tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //         kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        // delete from ubjudul 
        //             where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
        //                 kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //                 taJudul=".$this->mbgs->_valforQuery($tahun)."   and
        //                 tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //                 kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
        //                 status=0;
        $q="
            update ubrincian set
                status=0
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taRincian=".$this->mbgs->_valforQuery($tahun)." and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        ";
        $check=$this->qexec->_multiProc($q);
        // $check=true;
        if($check){

            // set data baru
            $q=trim($judul);
            $q.=substr($rincian,0,strlen(trim($rincian))-1);
            // return print_r($q);
            $check=$this->qexec->_multiProc($q);
            if($check){
                // hapus data lama
                $q="
                    delete from ubrincian 
                    where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                        kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                        taRincian=".$this->mbgs->_valforQuery($tahun)." and
                        tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                        kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
                        status=0;
                ";
                
                $check=$this->qexec->_multiProc($q);
                
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
                $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                    $v['kdJudul']=$v1['kdJudul'];
                    $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan saat mengamankan data");
        }
        // $q=substr($judul,0,strlen(trim($judul))-1).";";
        // $q.=substr($rincian,0,strlen(trim($rincian))-1);

        
    }
    function updBelanjaP(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
    
        $judul      =$baseEND->{'judul'};
        $rincian    =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        $kdJudul    =$baseEND->{'kdJudul'};
        
        // mengamankan data
        // update ubjudul set
        //         status=0
        //     where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
        //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //         taJudul=".$this->mbgs->_valforQuery($tahun)." and
        //         tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //         kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        // delete from ubjudul 
        //             where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
        //                 kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //                 taJudul=".$this->mbgs->_valforQuery($tahun)."   and
        //                 tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //                 kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
        //                 status=0;
        
        $spl=explode("-",$tahun);
        $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]); 
        
        $q="
            update ubrincian set
                status=0
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taRincian=".$this->mbgs->_valforQuery($tahun)." and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        ";
        $check=$this->qexec->_multiProc($q);
        // $check=true;
        if($check){

            // set data baru
            $q=trim($judul);
            $q.=substr($rincian,0,strlen(trim($rincian))-1);
            // return print_r($q);
            $check=$this->qexec->_multiProc($q);
            if($check){
                // hapus data lama
                $q="
                    delete from ubrincian 
                    where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                        kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                        taRincian=".$this->mbgs->_valforQuery($tahun)." and
                        tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                        kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
                        status=0;
                ";
                
                $check=$this->qexec->_multiProc($q);
                
                // $v=array();
                // $v['kdSub']=$kdSub;
                // $v['tahapan']=$tahapan;
                // $v['kdDinas']=$kdDinas;
                // $v['tahun']=$tahun;
                // $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                // foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                //     $v['kdJudul']=$v1['kdJudul'];
                //     $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                // }
                // return $this->mbgs->resTrue($this->_);
                
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
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
                
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan saat mengamankan data");
        }
        // $q=substr($judul,0,strlen(trim($judul))-1).";";
        // $q.=substr($rincian,0,strlen(trim($rincian))-1);

        
    }
    function delBelanja(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        $kdJudul    =$baseEND->{'kdJudul'};

        $q="
            delete from ubjudul 
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taJudul=".$this->mbgs->_valforQuery($tahun)."   and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul).";
            delete from ubrincian 
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taRincian=".$this->mbgs->_valforQuery($tahun)." and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul).";
        ";
        $check=$this->qexec->_multiProc($q);
        if($check){
            
            $v=array();
            $v['kdSub']=$kdSub;
            $v['tahapan']=$tahapan;
            $v['kdDinas']=$kdDinas;
            $v['tahun']=$tahun;
            $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
            foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                $v['kdJudul']=$v1['kdJudul'];
                $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
            }
            return $this->mbgs->resTrue($this->_);
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }
    }
    function insBPerubahan(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        // $portal=$this->_keamanan($_POST['code'],_getNKA("c-prod",false));
        // if($portal['exec']){
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $qdel   =$baseEND->{'qdel'};
        $judul   =$baseEND->{'judul'};
        $rincian   =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        
        $spl=explode("-",$tahun);
        $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]);
        
        $q=substr($judul,0,strlen(trim($judul))-1).";";
        $q.=substr($rincian,0,strlen(trim($rincian))-1);

        $check=$this->qexec->_multiProc($qdel);
        if($check){
            $check=$this->qexec->_multiProc($q);
            if($check){
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
                $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                    $v['kdJudul']=$v1['kdJudul'];
                    if($v1['qdel']){
                        $v['tahun']=$tahunOld;
                        $this->_['dtDetailRincian'][$key]['old']=$this->qexec->_func(_judulRBelanjaOld($v));
                        $this->_['dtDetailRincian'][$key]['old'][0]['detail']=$this->qexec->_func(_detailRBelanja($v));
                    }
                    $v['tahun']=$this->tahun;
                    $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                return $this->mbgs->resTrue($this->_);
            }
            // $this->_['ddata']=$this->qexec->_func(_dproduk($this->kdKantor,""));
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
        }
        // }return $this->mbgs->resFalse($portal['msg']);
    }
    function updBPerubahan(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
    
        $judul      =$baseEND->{'judul'};
        $rincian    =$baseEND->{'rincian'};
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        $kdJudul    =$baseEND->{'kdJudul'};
        
        $spl=explode("-",$tahun);
        $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]);

        // mengamankan data
        // update ubjudul set
        //         status=0
        //     where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
        //         kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //         taJudul=".$this->mbgs->_valforQuery($tahun)." and
        //         tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //         kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        // delete from ubjudul 
        //             where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
        //                 kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
        //                 taJudul=".$this->mbgs->_valforQuery($tahun)."   and
        //                 tahapan=".$this->mbgs->_valforQuery($tahapan)." and
        //                 kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
        //                 status=0;
        $q="
            update ubrincian set
                status=0
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)." and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taRincian=".$this->mbgs->_valforQuery($tahun)." and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul)." ;
        ";
        $check=$this->qexec->_multiProc($q);
        // $check=true;
        if($check){

            // set data baru
            $q=trim($judul);
            $q.=substr($rincian,0,strlen(trim($rincian))-1);
            // return print_r($q);
            $check=$this->qexec->_multiProc($q);
            if($check){
                // hapus data lama
                $q="
                    delete from ubrincian 
                    where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                        kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                        taRincian=".$this->mbgs->_valforQuery($tahun)." and
                        tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                        kdJudul=".$this->mbgs->_valforQuery($kdJudul)." and
                        status=0;
                ";
                
                $check=$this->qexec->_multiProc($q);
                
                $v=array();
                $v['kdSub']=$kdSub;
                $v['tahapan']=$tahapan;
                $v['kdDinas']=$kdDinas;
                $v['tahun']=$tahun;
                $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
                foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                    $v['kdJudul']=$v1['kdJudul'];
                    if($v1['qdel']){
                        $v['tahun']=$tahunOld;
                        $this->_['dtDetailRincian'][$key]['old']=$this->qexec->_func(_judulRBelanjaOld($v));
                        $this->_['dtDetailRincian'][$key]['old'][0]['detail']=$this->qexec->_func(_detailRBelanja($v));
                    }
                    $v['tahun']=$this->tahun;
                    $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan saat mengamankan data");
        }
        // $q=substr($judul,0,strlen(trim($judul))-1).";";
        // $q.=substr($rincian,0,strlen(trim($rincian))-1);

        
    }
    function delBPerubahan(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $kdDinas    =$baseEND->{'kdDinas'};
        $kdSub      =$baseEND->{'kdSub'};
        $tahapan    =$baseEND->{'tahapan'};
        $tahun      =$baseEND->{'tahun'};
        $kdJudul    =$baseEND->{'kdJudul'};

        $spl=explode("-",$tahun);
        $tahunOld=($spl[1]>1? $spl[0]."-".($spl[1]-1) : $spl[0]);
        
        $q="
            delete from ubjudul 
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taJudul=".$this->mbgs->_valforQuery($tahun)."   and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul).";
            delete from ubrincian 
            where kdSUb=".$this->mbgs->_valforQuery($kdSub)."   and  
                kdDinas=".$this->mbgs->_valforQuery($kdDinas)." and 
                taRincian=".$this->mbgs->_valforQuery($tahun)." and
                tahapan=".$this->mbgs->_valforQuery($tahapan)." and
                kdJudul=".$this->mbgs->_valforQuery($kdJudul).";
        ";
        $check=$this->qexec->_multiProc($q);
        if($check){
            
            $v=array();
            $v['kdSub']=$kdSub;
            $v['tahapan']=$tahapan;
            $v['kdDinas']=$kdDinas;
            $v['tahun']=$tahun;
            $this->_['dtDetailRincian']=$this->qexec->_func(_judulRBelanja($v));
            // foreach ($this->_['dtDetailRincian'] as $key => $v1) {
            //     $v['kdJudul']=$v1['kdJudul'];
            //     $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
            // }
            foreach ($this->_['dtDetailRincian'] as $key => $v1) {
                $v['kdJudul']=$v1['kdJudul'];
                if($v1['qdel']){
                    $v['tahun']=$tahunOld;
                    $this->_['dtDetailRincian'][$key]['old']=$this->qexec->_func(_judulRBelanjaOld($v));
                    $this->_['dtDetailRincian'][$key]['old'][0]['detail']=$this->qexec->_func(_detailRBelanja($v));
                }
                $v['tahun']=$this->tahun;
                $this->_['dtDetailRincian'][$key]['detail']=$this->qexec->_func(_detailRBelanja($v));
            }
            
            return $this->mbgs->resTrue($this->_);
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }
    }

    function prosesCair(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $kdJudul    =$baseEND->{'kdJudul'};
        $kdSub    =$baseEND->{'kdSub'};
        $kdDinas    =$baseEND->{'kdDinas'};

        $tahapan    =$baseEND->{'tahapan'};
        $status    =$baseEND->{'status'};
        $date    =$baseEND->{'date'};
        $cair    =$baseEND->{'cair'};
        $tahun =$baseEND->{'tahun'};
        $kdRincian =$baseEND->{'kdRincian'}; 

        $check=$this->qexec->_proc("update ubrincian set Rdate='".$date."', realisasi='".$cair."', Ruser='".$this->kdMember."' where 
                kdSub='".$kdSub."'
                and kdDinas='".$kdDinas."'
                and tahapan='".$tahapan."'
                and kdJudul='".$kdJudul."'
                and taRincian='".$tahun."' 
                and kdRincian='".$kdRincian."'
        ");
        if($check){
            return $this->mbgs->resTrue($this->_);
        }
        return $this->mbgs->resFalse("terjadi kesalahan pada proses tersebut !!!");
    }
    function updRealisasiBelanja(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $kdJudul    =$baseEND->{'kdJudul'};
        $kdSub    =$baseEND->{'kdSub'};
        $kdDinas    =$baseEND->{'kdDinas'};

        $tahapan    =$baseEND->{'tahapan'};
        $jumlah    =$baseEND->{'jumlah'};
        $tahun =$baseEND->{'tahun'}; 
        date_default_timezone_set("Asia/Jakarta");
        $month = date("m");

        $check=$this->qexec->_proc("update ubjudul set total='".$jumlah."' where 
                kdSub='".$kdSub."'
                and kdDinas='".$kdDinas."'
                and tahapan='".$tahapan."'
                and kdJudul='".$kdJudul."'
                and taJudul='".$tahun."' 
                and bulan='".$month."'
        ");
        if($check){
            return $this->mbgs->resTrue($this->_);
        }
        return $this->mbgs->resFalse("terjadi kesalahan pada proses tersebut !!!");
    }

    function setPersentaseSub() {
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        $kdKeg    =$baseEND->{'kdKeg'}; 
        $kdSub    =$baseEND->{'kdSub'};
        $kdDinas    =$baseEND->{'kdDinas'};

        $prealisasi    =$baseEND->{'prealisasi'};
        

        $check=$this->qexec->_proc("update psub set prealisasi='".$prealisasi."'  where 
                kdSub='".$kdSub."'
                and kdKeg='".$kdKeg."'
                and kdDinas='".$kdDinas."' 
                and taSub='".$this->tahun."' 
        ");
        if($check){
            return $this->mbgs->resTrue($this->_);
        }
        return $this->mbgs->resFalse("terjadi kesalahan pada proses tersebut !!!");
    }
    function perbaruiAkun(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $username    =$baseEND->{'username'};
        $passOld    =$baseEND->{'passOld'};
        $passNew    =$baseEND->{'passNew'};
        

        $q="select * from member where kdDinas='".$this->kdDinas."' and UPPER(nmMember)=UPPER('".$this->nmMember."') and UPPER(password)=UPPER('".$passOld."')";
        // return print_r($q);
        $member=$this->qexec->_func($q);
        if(count($member)>0){
            $pass = "";
            if(strlen($passNew)>0){
                $pass = " , password='".$passNew."'";
            }
            $check=$this->qexec->_proc("update member set nmMember='".$username."' ".$pass." where 
                kdMember='".$this->kdMember."'
                and kdApp='".$this->mbgs->app['kd']."'
            ");
            if($check){
                return $this->mbgs->resTrue($this->_);
            }
            return $this->mbgs->resFalse("terjadi kesalahan pada proses tersebut !!!");
        }else{
            return $this->mbgs->resFalse("Password Lama,tidak sesuai !!!");
        }
    }

    public function realisasiPerMount(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $bulan   =$baseEND->{'bulan'};
            
            $qbidang = " and kdDBidang='".$this->kdBidang."'";
            $wherebidang = " and a.kdBidang='".$this->kdBidang."'";
            if($this->kdJabatan==2){ 
                $qbidang = "";
                $wherebidang = "";
            }elseif($this->kdJabatan==3){
                $qbidang = "";
                $wherebidang = ""; 
            }
 
            // return print_r(_renstraOpdBidang($this->kdDinas,$this->tahun,$wherebidang,$bulan));
            $this->_['data']=$this->qexec->_func(_renstraOpdBidang($this->kdDinas,$this->tahun,$wherebidang,$bulan));
            return $this->mbgs->resTrue($this->_);
        }
    }

    // expDt
    public function getSubOpd(){
        $kondisi=false;
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }else{
            $baseEND=json_decode((base64_decode($_POST['data'])));
            $kdDinas   =$baseEND->{'kdDinas'};
            
            $this->_['data']=$this->qexec->_func(_cbSub($kdDinas,$this->tahun,""));
            return $this->mbgs->resTrue($this->_);
        }
    }
    function saveImportExcell(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        // $portal=$this->_keamanan($_POST['code'],_getNKA("c-prod",false));
        // if($portal['exec']){
        $baseEND=json_decode((base64_decode($_POST['data'])));
        
        $qdel       =$baseEND->{'qdel'};
        $q          =$baseEND->{'query'};
        
        $check=$this->qexec->_multiProc($qdel);
        if($check){
            $check=$this->qexec->_multiProc($q);
            if($check){
                return $this->mbgs->resTrue($this->_);
            }
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
        }
    }
    function saveImportExcellSIPD(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        } 
        $baseEND=json_decode((base64_decode($_POST['data']))); 
        if(count((array) $baseEND)>0){
            $qexec          =$baseEND->{'qexec'}; 
            
            $check=$this->qexec->_multiProc($qexec);
            if($check){
                return $this->mbgs->resTrue($this->_); 
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
            }
        } else{
          return print_r((base64_decode($_POST['data'])));
        }
        
    }
    
    function saveImportJsonRealisasi(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        } 
        $json = file_get_contents('php://input');
        $data = json_decode($json, true); 
        $dt = $data['dt']; 
        $bulan = $data['bulan'];  
        $qaddSub = "";
        if(count($data)>0){
            $qdel="delete from ubjudul where kdDinas='".$this->kdDinas."' and taJudul='".$this->tahun."' and bulan='".$bulan."'; ";
            if($bulan=="1"){
                $qdel.="delete from psub where kdDinas='".$this->kdDinas."' and taSub='".$this->tahun."'";
                $qaddSub =" insert into psub (kdDinas,kdKeg,kdSub,nmSub,taSub,pagu) values ";
            }
            $q=" insert into ubjudul (kdDinas, kdSub, kdApbd6, kdJudul, nama, taJudul,total,tahapan,bulan,pagu) values";
            foreach ($dt as $key => $v) { 
                $i = 1;
                if($bulan=="1"){ 
                    $qaddSub.=" 
                    (
                        '".$this->kdDinas."',
                        '".substr($v['kd'],0,12)."', 
                        '".$v['kd']."',
                        '".$v['nm']."',
                        '".$this->tahun."',
                        '".$v['pagu']."'
                    ),";
                }
                foreach ($v['judul'] as $k => $val) {
                    $code = explode("-",$val['kode_unik']);
                    $q.=" 
                    (
                        '".$code[0]."',
                        '".$code[3]."', 
                        '".$code[4]."',
                        '".$i."',
                        '".$val['nama_akun']."',
                        
                        '".$this->tahun."',
                        '".$val['jumlah_sd_saat_ini']."',
                        '1',
                        '".$bulan."',
                        '".$val['alokasi_anggaran']."'
                    ),";
                    $i++;
                }
                
            }
            $q = substr($q,0,strlen($q)-1)."; "; 
            $check=$this->qexec->_multiProc($qdel);
            if($check){
                if($bulan=="1"){ 
                    $q.=substr($qaddSub,0,strlen($qaddSub)-1).";";
                } 
                // return print_r($q);
                $check=$this->qexec->_multiProc($q);
                if($check){
                    return $this->mbgs->resTrue($this->_); 
                }else{
                    return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
                }
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan sistem");
            }
        } else{
          return print_r((base64_decode($_POST['data'])));
        }
        
    }
    
    function inpSlider(){
        $portal=$this->_keamanan($_POST['code'],_getNKA("c-sett",false));
        if($portal['exec']){
    
            $file=$_POST['file'];
            $namaFile="";
            if(!empty($file)){
                // return print_r($file['data']);
                foreach ($file as $key => $v) {
                    if($key>0){
                        $namaFile.="/";
                    }
                    // $namaFile.=$this->_uploadImage($v['src'],$v['nama'])."<2G18>";
                    $namaFile.=$this->_uploadImage($v['src'],"fs_sistem/slider/".$v['nama']);
                }
            }
            // return print_r($namaFile);
            $split=explode("/",$namaFile);
            if(count($split)>1){
                $q=" INSERT INTO slider (img) VALUES ";
                foreach($split as $key =>$v){
                    $q.="('".$v."'),";  
                };
                $q=substr($q,0,strlen($q)-1);
                // return print_r($q);
                $check=$this->qexec->_multiProc($q);
            }else{
                $check=$this->qexec->_proc("
                    INSERT INTO slider (img) VALUES 
                        (
                            '".$namaFile."'
                        )
                    ");
            }
            // return print_r($check);
            if($check){
                $this->_['slider']     =$this->qexec->_func("SELECT * FROM slider");
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }
        return $this->mgbs->resFalse($portal['msg']);
    }
    function delSlider(){
        $portal=$this->_keamanan($_POST['code'],_getNKA("d-sett",false));
        if($portal['exec']){
            $baseEND=json_decode((base64_decode($_POST['data'])));
            
            $id       =$baseEND->{'id'};
            $check=$this->qexec->_proc("delete from slider where id=".$id);
            if($check){
                $this->_['slider']     =$this->qexec->_func("SELECT * FROM slider");
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }return $this->mgbs->resFalse($portal['msg']);
    }

    function mengertiInfo(){
        $portal=$this->_keamanan($_POST['code'],$this->mbgs->_getNKA("p-usul"));
        if($portal['exec']){
            $check=$this->qexec->_proc($this->mbgs->_updDateInformasiDimengerti($this->kdMember,""));
            if($check){
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }return $this->mbgs->resFalse($portal['msg']);

    }

    function _settingKeyMember($member,$kodePage,$kunci){
        // $kodePage=;
        $q="";
        foreach ($member as $key => $v) {
            $q.=" update appkey set 
                    kunci=".$kunci."
                where kdMember=".$this->mbgs->_valforQuery($v['kdMember'])." and 
                    kdFitur!=".$this->mbgs->_valforQuery($kodePage)." and
                    kdFitur like '%".explode("/",$kodePage)[0]."%';";
        }
        return $q;
    }
    function addSop(){
        if($this->sess->kdMember==null){
            return $this->mbgs->resFalse("maaf, Pengguna tidak terdeteksi !!!");
        }
        $input = json_decode(file_get_contents("php://input"), true);

        // $baseEND=json_decode((base64_decode($_POST['data'])));
    
        // return print_r($baseEND);
        $judul=$input['judul'];
        $kategori  =$input['kategori'];
        $kdBidang   =$input['kdBidang']; 
        
        $file=$input['dt'];
        $namaFile="";
        if(!empty($file)){
            $namaFile.=",file='";
            foreach ($file as $key => $v) {
                // $namaFile.=$this->_uploadImage($v['src'],$v['nama'])."<2G18>";
                $namaFile=$this->_uploadFiles($v['data'],$v['nama']);
            }
            $namaFile.="";

        }

        $this->_['data'] = [
            "kdDinas"=>$this->kdDinas,
            "kdBidang"=>$kdBidang,
            "kategori"=>$kategori,
            "judul"=>$judul,
            "file"=>$namaFile
        ];
        // return print_r($this->_['data'] );
        $id = $this->Msop->add($this->_['data']);
        
        if($id>0){
            $this->_['data']['id']=$id;
            return $this->mbgs->resTrue($this->_);
        }else{
            return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
        } 
        
    }
    public function _uploadFiles($file,$nama){
        $pdf_decoded = base64_decode($file,true);
        $nama=explode(".",$nama);
        date_default_timezone_set("America/New_York");
        $namaFile=$nama[count($nama)-2]."-".date("Y-m-d-h-i-sa").".".$nama[count($nama)-1];
        $lokasiFile='/fs_sistem/upload/files/'.$namaFile;
        file_put_contents("./assets".$lokasiFile, $pdf_decoded);
        return substr($lokasiFile,1);
    }


    public function _setNotification($fitur,$info,$nmBtn,$tingkatJabatan){
        $keyTabel="kdNotif";
        $kdTabel=$this->qexec->_func("
            select ".$keyTabel." 
            from notif
            ORDER BY ".$keyTabel." DESC limit 1"
        );
        if(count($kdTabel)>0){
            $kdTabel=$kdTabel[0][$keyTabel]+1;
        }else{
            $kdTabel=1;
        }

        $qNotif=" INSERT INTO notif
                    (kdNotif,fitur, isiNotif, nmTombol, url)
                VALUES 
                    (
                        ".$this->mbgs->_valforQuery($kdTabel).",
                        ".$this->mbgs->_valforQuery($fitur).",
                        ".$this->mbgs->_valforQuery($info).",
                        ".$this->mbgs->_valforQuery($nmBtn).",
                        ".$this->mbgs->_valforQuery($this->mbgs->_getUrl($fitur))."
                    );";
        $qNotif.=" INSERT INTO notifuser(kdMember, kdNotif) (".$this->mbgs->_dmemberSetingkat($tingkatJabatan,$kdTabel).")"; // tingkat 3 bisa dicek di tabel jabatan kolom setingkat

        return $this->qexec->_multiProc($qNotif);
    }
    function refreshHakAkses(){
        $portal=$this->_keamanan($_POST['code'],_getNKA("d-memb",false));
        if($portal['exec']){
            $baseEND=json_decode((base64_decode($_POST['data'])));
        
            $kdJabatan  =$baseEND->{'kdJabatan'};
            $kdMember   =$baseEND->{'kdMember'};
            $a=array();
            $a['kdMember']=$kdMember;
            $a['kdJabatan']=substr($kdJabatan,strlen($kdJabatan)-1);
            // return print_r($a);
            $check=$this->addKeySistemPaksa(base64_encode(json_encode($a)));
            if($check){
                return $this->mbgs->resTrue($this->_);
            }else{
                return $this->mbgs->resFalse("Terjadi Kesalahan di penyimpanan sistem");
            }
        }return $this->mbgs->resFalse($portal['msg']);
    }
    public function _uploadImage($file,$nama){
        $split=explode("/",$nama); 
        $flokasi="fs_sistem/upload/image/";// default foldar jika ber ubah maka tambahakan dinamanya
        if(count($split)>1){
            $flokasi='';
            foreach ($split as $key => $v) {
                if($key==count($split)-1){
                    $nama=$v;
                }else{
                    $flokasi.=$v."/";
                }
            }
            // $flokasi.=$split[0]."/";
            // $nama=$split[count($split)-1];
        }
        $nama=explode(".",$nama);
        switch($nama[count($nama)-1]){
            case "png":$image=substr($file,22);break;
            case "PNG":$image=substr($file,22);break;
            case "pdf":$image=substr($file,22);break;
            default:$image=substr($file,23);break;
        }
        // $image=substr($file,23);
        // return print_r($nama[1]);
        date_default_timezone_set("America/New_York");
        $namaFile=$nama[count($nama)-2]."-".date("Y-m-d-h-i-sa").".".$nama[count($nama)-1];

        
        $delspace=explode(" ",$namaFile);
        $namaFile="";
        foreach ($delspace as $key => $value) {
            $namaFile.=$value;
        }
        $lokasiFile='./assets/'.$flokasi.$namaFile;
        write_file($lokasiFile,base64_decode($image));
        return $namaFile;
    }
    function _checkKeyApp($keyForm,$kdMember){
        $kodeForm=false;
        $kodeForm=$keyForm;
        // return print_r($this->mbgs->_qCekKey($kodeForm,$kdMember));
        $q=$this->mbgs->_qCekKey($kodeForm,$kdMember);
        $member=$this->qexec->_func($q);
        // return count($member);
        if(count($member)==1){
            return true;
        }
        return false;
    }
    function _keamanan($code,$codeForm){
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
        $this->nmMember=$this->sess->nmMember;
        $this->kdJabatan=$this->sess->kdMemberJabatan;
        $this->kdKantor=$this->sess->kdMemberKantor;
        $this->nmKantor=$this->sess->nmKantor;
        $kdMember=$this->sess->kdMember;
        if($kdMember==null) {
            return $this->mbgs->resF("can't access !!!");
        }
        
        if(!$this->mbgs->_backCodes(base64_decode($code))){
            return $this->mbgs->resF("Tidak Sesuai Keamanan Sistem !!!");
        }
        if($this->_checkKeyApp($codeForm,$kdMember)==0){
            return $this->mbgs->resF("Anda tidak memiliki ijin !!!");
        }
        return $this->mbgs->resT("");
    }
    function addKeySistem($val){
        // $a=array();
        // $a['kdMember']="2G18-memb-1";
        // $a['kdJabatan']="6";
        // return print_r(base64_encode(json_encode($a)));
        // eyJrZE1lbWJlciI6IjJHMTgtbWVtYi0xIiwia2RKYWJhdGFuIjoiNiJ9

        $baseEND=json_decode((base64_decode($val)));
        // return print_r($baseEND);
        $kdMember=$baseEND->{'kdMember'};
        $kdJabatan=$baseEND->{'kdJabatan'};

        $nmApp=$this->qexec->_func("select * from app where kdApp='".$this->mbgs->app['kd']."'");
        $q="";
        if(count($nmApp)==0){
            $q.=" INSERT INTO app(kdApp,nmApp) VALUES ('".$this->mbgs->app['kd']."','".$this->mbgs->app['nm']."');";
        }


        $fitur=$this->qexec->_func("select * from appfitur where kdApp='".$this->mbgs->app['kd']."'");
        $fiturSystem=_getNKA("",true);
        // return $this->mbgs->_log($q);
        if(count($fitur)!=count($fiturSystem)){
            $q.=" delete from appfitur where kdApp='".$this->mbgs->app['kd']."';";
            $q.=" INSERT INTO appfitur(kdApp, kdFitur, nmFitur) VALUES ";
            foreach ($fiturSystem as $key => $v) {
                $q.="(
                        ".$this->mbgs->_valforQuery($this->mbgs->app['kd']).",
                        ".$this->mbgs->_valforQuery($v['kd']).",
                        ".$this->mbgs->_valforQuery($v['page'])."
                    ),";
            }
        }
        if(strlen($q)>0){
            $q=substr($q,0,strlen($q)-1).";";
        }
        
        $kunci=$this->qexec->_func("select * from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember)."");
        if(count($kunci)!=count($fiturSystem)){
            $q.=" delete from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember).";";
            $q.=" INSERT INTO appkey(kdApp,kdMember, kdFitur, Kunci) VALUES ";
            foreach ($fiturSystem as $key => $v) {
                foreach($v['kdJabatan'] as $key1 => $v1){
                    // print_r($v1."|".$kdJabatan."<br>");
                    if($v1==$kdJabatan){
                        $q.="('".$this->mbgs->app['kd']."',".$this->mbgs->_valforQuery($kdMember).",".$this->mbgs->_valforQuery($v['kd']).",'0'),";
                    }
                }
            }
            $q=substr($q,0,strlen($q)-1);
        }
        if(strlen($q)==0){
            return true;
        }
        // return $this->mbgs->_log($q);
        $check=$this->qexec->_multiProc($q);
        if($check){
            return true;
        }
        return false;
        // print_r("sukses");
    }
    function addKeySistemPaksa($val){
        // $a=array();
        // $a['kdMember']="2G18-memb-1";
        // $a['kdJabatan']="5";
        // return print_r(base64_encode(json_encode($a)));
        // eyJrZE1lbWJlciI6IjJHMTgtbWVtYi0xIiwia2RKYWJhdGFuIjoiNSJ9
        // eyJrZE1lbWJlciI6IjJHMTgtbWVtYi05Iiwia2RKYWJhdGFuIjoiMSJ9

        $baseEND=json_decode((base64_decode($val)));
        // return print_r($baseEND);
        $kdMember=$baseEND->{'kdMember'};
        $kdJabatan=$baseEND->{'kdJabatan'};

        $nmApp=$this->qexec->_func("select * from app where kdApp='".$this->mbgs->app['kd']."'");
        $q="";
        if(count($nmApp)==0){
            $q.=" INSERT INTO app(kdApp,nmApp) VALUES ('".$this->mbgs->app['kd']."','".$this->mbgs->app['nm']."');";
        }


        $fitur=$this->qexec->_func("select * from appfitur where kdApp='".$this->mbgs->app['kd']."'");
        $fiturSystem=_getNKA("",true);
        if(count($fitur)!=count($fiturSystem)){
            $q.=" delete from appfitur where kdApp='".$this->mbgs->app['kd']."';";
            $q.=" INSERT INTO appfitur(kdApp, kdFitur, nmFitur) VALUES ";
            foreach ($fiturSystem as $key => $v) {
                $q.="(
                        ".$this->mbgs->_valforQuery($this->mbgs->app['kd']).",
                        ".$this->mbgs->_valforQuery($v['kd']).",
                        ".$this->mbgs->_valforQuery($v['page'])."
                    ),";
            }
        }
        if(strlen($q)>0){
            $q=substr($q,0,strlen($q)-1).";";
        }
        $kunci=$this->qexec->_func("select * from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember)."");
        $q.=" delete from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember).";";
        $q.=" INSERT INTO appkey(kdApp,kdMember, kdFitur, Kunci) VALUES ";
        foreach ($fiturSystem as $key => $v) {
            foreach($v['kdJabatan'] as $key1 => $v1){
                if($v1==$kdJabatan){
                    $q.="('".$this->mbgs->app['kd']."',".$this->mbgs->_valforQuery($kdMember).",".$this->mbgs->_valforQuery($v['kd']).",'0'),";
                }
            }
        }
        $q=substr($q,0,strlen($q)-1);
        return $this->qexec->_multiProc($q);
    }
    public function logout(){
        $this->sess->sess_destroy();
    }
}


