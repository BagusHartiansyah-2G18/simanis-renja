<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Control extends CI_Controller {
    function __construct(){
        parent::__construct();
    
        $this->mbgs->_setBaseUrl(base_url());
        $_=array();
        $this->_['assert']=$this->mbgs->_getAssetUrl();
        $this->_['code']=$this->mbgs->_backCode($this->enc->encrypt($this->mbgs->_isCode()));
        $this->_=array_merge($this->_,$this->mbgs->_getBasisData());
        $this->_['param']=null;
        $this->_['qlogin']=true;
        $this->_['nm']="SI MANIS";
    }
	public function index(){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
		$this->_['html'] = $this->mbgs->_html($this->_);
        $this->_['page']="beranda";
		$this->load->view('index',$this->_);
    }
    public function agenda(){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="agenda";
        $this->load->view('indexMfc',$this->_);
    }
    public function agendad($val){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="agendaDetail";
        $this->_['param']=$val;
        $this->load->view('indexMfc',$this->_);
    }
    public function produk(){
        
        $this->_['qlogin']=false;
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="produk";
        $this->load->view('indexMfc',$this->_);
    }

    public function indexOld(){
        $this->_['qlogin']=false;
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="berandaOld";
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }
    public function agendaOld(){
        $this->_['qlogin']=false;
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="agendaOld";
        // $this->_['param']=$kdMember."/".$kdAgenda;
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }
    public function agendadOld($val){
        $this->_['qlogin']=false;
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="agendaDetailOld";
        $this->_['param']=$val;
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }
    public function produkOld(){
        $this->_['qlogin']=false;
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="produkOld";
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }


    public function profil(){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="profil";
        $this->load->view('indexMfc',$this->_);
    }
    public function ppid(){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="ppid";
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }
    public function kontak(){
        $this->_['qlogin']=false;
        
        if($this->sess->kdMemberMember!=null) {
            return redirect("control/dashboard/null");
        }
        $this->_['page']="kontak";
        $this->load->view('indexMfc',$this->_);
    }

    public function dashboard($val){
        // return print_r($this->_['code']);
        if($val!=null && $val!="null"){
            $baseEND=json_decode((base64_decode($val)));
            
            $username   =$baseEND->{'username'};
            $password   =$baseEND->{'password'};
            // $tahun   =$baseEND->{'tahun'};
            // $kdDinas   =$baseEND->{'kdDinas'};

            // untuk dev sebaiknya password nye berbeda tiap tahun ne
            // $q="select * from member where kdDinas='".$kdDinas."' and UPPER(nmMember)=UPPER('".$username."') and UPPER(password)=UPPER('".$password."') and kdApp='".$this->mbgs->app['kd']."'";
            $q="select * from member where UPPER(nmMember)=UPPER('".$username."') and UPPER(password)=UPPER('".$password."') and kdApp='".$this->mbgs->app['kd']."'";
            $member=$this->qexec->_func($q);
            // return print_r($q);
			if(count($member)==0){
				return $this->logout();
			}
            $sess=array(
                'kdMember'=>$member[0]['kdMember'],
                'kdMember1'=>$member[0]['kdMember1'],
                'nmMember'=>$member[0]['nmMember'],
                'password'=>$member[0]['password'],
                'kdDinas'=>$member[0]['kdDinas'],
                'email'=>$member[0]['email'],
                'kdJabatan'=>$member[0]['kdJabatan'],
                'kdBidang'=>$member[0]['kdBidang'],
                'tahun'=>0,
                'sistem'=>'renja'
            );
          
            // $res=$this->mbgs->_getAllFile("/fs_sistem/session");
            // $this->mbgs->_removeFile($res,$this->mbgs->_getIpClient()."=");
            
            // // return print_r($_SERVER);
            // $this->mbgs->_expTxt($this->mbgs->_getIpClient()."=",json_encode($sess));
            // // sess

            // return print_r($$portal);
            
            $this->sess->set_userdata($sess);
            $nama=$member[0]['kdMember'];
        }else{
            // $this->_keamanan("Bagus H");
            if($this->sess->kdMember==null) {
                return $this->logout();
            }
            $nama=$this->sess->nama;
        }

        $portal=$this->_keamanan(_getNKA("p-ssub",false));
        // return print_r(array("kdMember"=>$this->sess->kdMember1,"kdJabatan"=>$this->sess->kdJabatan));
        if(!$portal['exec'] && $portal['msg']=="keyForm"){
            // return print_r("Bagus H");
            // return print_r(array("kdMember"=>$this->sess->kdMember1,"kdJabatan"=>$this->sess->kdJabatan));
            $resp=$this->addKeySistem(base64_encode(json_encode(array("kdMember"=>$this->sess->kdMember1,"kdJabatan"=>$this->sess->kdJabatan))));
            //   return print_r("Bagus H");
            // return $this->mbgs->_log($resp);
            // return $this->logout();
        }
        // return print_r($this->sess->kdMember1);
        $this->_['page']="dashboard";
        $this->_['html']=$this->mbgs->_html($this->_);
		$this->load->view('index',$this->_);
    }
    public function setsub(){
        $portal=$this->_keamanan(_getNKA("p-ssub",false));
        if($portal['exec']){
            $this->_['page']="setsub";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        }
    }
    public function renstra(){
        $portal=$this->_keamanan(_getNKA("p-renj",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="renstra";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function sop($thn){ 
		if($thn!=null && !empty($thn) && $thn!="null"){
			$this->sess->tahun=$thn;
		}
        $portal=$this->_keamanan(_getNKA("p-renj",false));
		// return print_r($portal);
        if($portal['exec']){ 
            $this->_['page']="sop";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    function rincianBelanja($val){
        $portal=$this->_keamanan(_getNKA("p-ibel",false));
        // return print_r($portal);
        // if($portal['exec']){
        if(true){
            $nama=$this->sess->nmMember;
            $this->_['page']="rincianBelanja";
            $this->_['param']=$val;
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        }  
    }
    function rincianBPerubahan($val){
        $portal=$this->_keamanan(_getNKA("p-ibel",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="rincianBPerubahan";
            $this->_['param']=$val;
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function lapoOpd(){
        $portal=$this->_keamanan(_getNKA("p-lapo",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="lapoOpd";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function lapoBelanja(){
        $portal=$this->_keamanan(_getNKA("p-lapo",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="lapoBelanja";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function lapoPaguSub(){
        $portal=$this->_keamanan(_getNKA("p-lapo",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="lapoPaguSub";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function setting(){
        $portal=$this->_keamanan(_getNKA("p-peng",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="setting";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    public function expDpa(){
        $portal=$this->_keamanan(_getNKA("p-peng",false));
        if($portal['exec']){
            $nama=$this->sess->nmMember;
            $this->_['page']="expDpa";
            $this->_['html']=$this->mbgs->_html($this->_);
            $this->load->view('index',$this->_);
        }else{
            if($portal['msg']=="session"){
                return $this->logout();
            }else{
                return $this->dashboard("null");
            }
        } 
    }
    
    
    public function logout(){
        $this->sess->sess_destroy();
        return redirect("control");
    }


    
    function _keamanan($codeForm){
        // del jika dia dionline kan
        // $this->sess->set_userdata($sess);
        // $res=$this->mbgs->_getAllFile("/fs_sistem/session");
        // $data="";
        // foreach ($res as $key => $value) {
        //     $exp=explode($this->mbgs->_getIpClient()."=",$value['nama']);
        //     if(count($exp)>1){
        //         $data=$this->mbgs->_readFileTxt($value['file']);
        //     }
        // }
        // if(strlen($data)==0){
        //     return $this->mbgs->resF("session");
        // }
        // $data=json_decode($data);
        // $session=array(
        //     'kdMember'=>$data->{'kdMember'},
        //     'nmMember'=>$data->{'nmMember'},
        //     'kdJabatan'=>$data->{'kdJabatan'},
        //     'kdKantor'=>$data->{'kdKantor'},
        //     'nmKantor'=>$data->{'nmKantor'},
        //     'username'=>$data->{'username'},
        //     'password'=>$data->{'password'},
        // );
        // $this->sess->set_userdata($session);
        //btas dell

        // print_r($this->sess);
        $kdMember=$this->sess->kdMember1;
        if($kdMember==null) {
            return $this->mbgs->resF("sess");
        }
        if($this->_checkKeyApp($codeForm,$kdMember)==0){
            
            return $this->mbgs->resF("keyForm");
        }
        return $this->mbgs->resT("");
    }
    function _checkKeyApp($keyForm,$kdMember){
        $kodeForm=false;
        $kodeForm=$keyForm;
        $q=$this->mbgs->_qCekKey($kodeForm,$kdMember,$this->sess->tahun );
        $member=$this->qexec->_func($q);
        // return print_r(($q));
        if(count($member)==1){
            return true;
        }
        return false;
    }
    function addKeySistem($val){
        // $a=array();
        // $kdMember="2G18-memb-1";
        // $kdJabatan="4";
        // return print_r(base64_encode(json_encode($a)));
        // eyJrZE1lbWJlciI6IjJHMTgtbWVtYi0xIiwia2RKYWJhdGFuIjoiNiJ9

        $baseEND=json_decode((base64_decode($val)));
        $kdMember=$baseEND->{'kdMember'};
        $kdJabatan=$baseEND->{'kdJabatan'};
        // return print_r($baseEND);

        $nmApp=$this->qexec->_func("select * from app where kdApp='".$this->mbgs->app['kd']."'");
        $q="";
        if(count($nmApp)==0){
            $q.=" INSERT INTO app(kdApp,nmApp) VALUES ('".$this->mbgs->app['kd']."','".$this->mbgs->app['nm']."');";
        }


        $fitur=$this->qexec->_func("select * from appfitur where kdApp='".$this->mbgs->app['kd']."'");
        $fiturSystem=_getNKA("",true);
        // print_r($fitur);
        if(count($fitur)!=count($fiturSystem)){
            // print_r($fiturSystem);
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
        // print_r($q); $this->sess->tahun
        $kunci=$this->qexec->_func("select * from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember)." and ta=".$this->mbgs->_valforQuery($this->sess->tahun)." ");
        if(count($kunci)!=count($fiturSystem)){
            $q.=" delete from appkey where kdMember=".$this->mbgs->_valforQuery($kdMember)." and ta=".$this->mbgs->_valforQuery($this->sess->tahun).";";
            $q.=" INSERT INTO appkey(kdApp,kdMember, kdFitur, Kunci, ta) VALUES ";
            foreach ($fiturSystem as $key => $v) {
                foreach($v['kdJabatan'] as $key1 => $v1){
                    if($v1==$kdJabatan){
                        $q.="('".$this->mbgs->kdApp."',".$this->mbgs->_valforQuery($kdMember).",".$this->mbgs->_valforQuery($v['kd']).",'0',".$this->mbgs->_valforQuery($this->sess->tahun)."),"
                        ;
                    }
                }
            }
            $q=substr($q,0,strlen($q)-1);
        }
        // return print_r("kosong");
        if(strlen($q)==0){
            return true;
            // return print_r("Data Key Sudah Sesuai");
        }
        // return print_r($q);
        $this->qexec->_multiProc($q);
        // print_r("sukses");
        return true;
    }
}
