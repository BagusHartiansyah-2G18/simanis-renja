function _onload(data){
    $('#body').html(newPageLogin()); 
    // start 
    judul.nm=data.nm;
    judul.nama=data.nama;
    judul.Logo=data.logo;
    judul.copyright=data.copyright;


    _.slider=data.slider;
    // _.tahun=data.tahun;
    _.dinas=data.dinas;

    _.sfKdDinas=null;
    _.svKey=false; /// menandakan e master tanpa kode dinas
    // $('#menuAPP').html(newPageLogin());
    // $('#bodyTM').html(_form2());
    $('#footer').html(data.footer+data.tmFooter);

    _.sfUrl=router+'control/dashboard/';
    $.backstretch(assert+"fs_css/background-v12.png", {
      speed: 500
    });
    
}
function _form2(){
    hicon="40px";
    fsize="60px";
    fsizeW="160px";
   return `
    	<div class="formSet">
			<div class="form">
				<div class="info"> 
					<div class="groupicon" style="margin-top:15px;">
						<div class="subIcon">
							<h2>2025</h2>	
							<h6>Tahun Anggaran</h6>
						</div>
						<div class="subIcon">
							<h2>65</h2>	
							<h6>SKPD</h6>
						</div>
						<div class="subIcon">
							<h2>3</h2>	
							<h6>Tahapan</h6>
						</div>
					</div>
				</div>
				<div class="login">
					<div class="brand">
						<div class="nmApp">	
							<h1 class="h1-seo text-info">E RENJA</h1>
							<div class="nmKab">
								<span>BAPPEDA</span>
								<span>BADAN PERENCANAAN PEMBANGUNAN DAERAH</span>
								<span>SUMBAWA BARAT</span>
							</div>
						</div> 
					</div>
					${_flogin(true)}
					<div class="btnLogin">
						${
							_btn({
								color:"primary shadow",
								judul:"Login",
								attr:"style='float:right; padding:5px;;' onclick='_logined()'",
								class:"btn btn-primary"
							})
						}
					</div>
				</div>
			</div>
		</div>
	`;
}

function newPageLogin() {
    return `
        
  <div id="login-page">
    <div class="container">
      
      <div class="form-login" style="max-width:550px;">
        <div class="col-lg-12" style="margin-bottom:20px;">
          <div class="row content-panel">
           
            <div class="col-md-8 profile-text">
              <h2>SI MANIS</h2>
              <span>Sistem Monitoring Organisasi</span>
              <div class=""> 
                <div class="chart mt">
                  <div class="sparkline" data-type="line" data-resize="false" data-height="75" data-width="50%" data-line-width="1" data-line-color="#05c5ffff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,464,655]">
                    <canvas width="266" height="75" style="display: inline-block; width: height: 75px; vertical-align: top;"></canvas>
                  </div>
                </div> 
              </div>
            </div> 
            <div class="col-md-4 centered">
              <img src="${assert+`/fs_css/logo/logoKSB.png`}" height="150px">
            </div>
            <!-- /col-md-4 -->
          </div>
          <!-- /row -->
        </div> 
        <h2 class="form-login-heading">sign in now</h2>
        <div class="login-wrap">
          <input type="text" class="form-control" placeholder="Username" id="username" autofocus>
          <br>
          <input type="password" class="form-control" placeholder="Password" id="password">
          <label class="checkbox"  style="margin-left: 5%;">
            <input type="checkbox" value="remember-me"> Remember me
            <span class="pull-right">
            <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
            </span>
            </label>
          <button class="btn btn-theme btn-block" href="index.html"  onclick="_logined()"><i class="fa fa-lock"></i> SIGN IN</button>
          <hr>
          <div class="login-social-link centered">
            <p>or you can sign in via your social network</p>
            <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
            <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
          </div>
          <div class="registration">
            Don't have an account yet?<br/>
            <a class="" href="#">
              Create an account
              </a>
          </div>
        </div>
        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Forgot Password ?</h4>
              </div>
              <div class="modal-body">
                <p>Enter your e-mail address below to reset your password.</p>
                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
              </div>
              <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                <button class="btn btn-theme" type="button">Submit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- modal -->
      </div>
    </div>
  </div>
    `;
}

function _login(key) {
    _.sfUrl=router;
    fjudul="DATA KU";
    _.sfUrl+='dataku/control/dashboard/';
    _.svKey=true;
    _.sfKdDinas='-';
    switch (key) {
        case 1:
            // fjudul="E - MUSRENBANG";
            // _.sfUrl='emusrenbang/index.php/control/dashboard/';
            // _.svKey=true;
            return _redirectOpen("musrenbang");
        break;
        case 2:
            fjudul="E - RENJA";
            _.sfUrl='control/dashboard/';
            _.svKey=true;
        break;
        case 3:
            return _redirectOpen("dataku");
        break;
        case 4:
            return window.open("https://sumbawabaratkab.sipd.kemendagri.go.id/daerah?GqRjd5Q57KV1GhcAmGDFoMfL9PJSb16/gk6wdceyfIizsLDd9dM0KPn3CcCzOxL7T1e2ltEcdNdjZ8zKuYIvtGIzEjGl6nY6FSDrVeTQe@sA5@7c8DevqVA3xnqBNkXY", '_blank');
        break;
        case 5:
            fjudul="E-MASTER";
            _.sfUrl='master/control/dashboard/';
            _.svKey=false;
        break;
    }
    _modalEx1({
        judul:"SISTEM "+fjudul.toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-light",
        minWidth:"500px; ;",
        isi:_flogin(_.svKey),
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"primary shadow",
                    judul:"Login",
                    attr:"style='float:right; padding:5px;;' onclick='_logined()'",
                    class:"btn btn-primary"
                })
    });
}
function _changeValDinas(v) {
    if(!$('#dinas').hasClass('show')){
        $('#dinas').addClass("show");
    }
    _multiDropdonwSearch({
        data:_.dinas,
        idData:"ddinas",
        id:"dinas",
        value:v.value,
        func:"_selectDinas",
        idDropdonw:"idInpDropDinas",
    })
}
function _selectDinas(idForDrop,id,value,valueName){
    _.sfKdDinas=value;
    $("#"+id).val(valueName.substring(0,50));
    return _showForDropSelect(idForDrop);
}
function _formSearchDinas(v){
    _multiDropdonwSearch({
        data:_.dinas,
        idData:"ddinas",
        id:"dinas",
        value:v.value,
        func:"_selectDinas",
        idDropdonw:"idInpDropDinas",
    })
}
function _logined(){     
    param={
        username:$('#username').val(),
        password:$('#password').val(),
        kdDinas:'-',
        tahun:'-',
    }
    // if(param.kdDinas=='-')return _toast({bg:'e',msg:'Pilih Dinas !!!'});
	// if(_isNull(param.kdDinas))return _toast({bg:'e',msg:'Pilih Dinas !!!'});
    if(_isNull(param.username))return _toast({bg:'e',msg:'Tambahkan username !!!'});
    if(_isNull(param.password))return _toast({bg:'e',msg:'Tambahkan password !!!'});
    
    _post('proses/checkUser',param).then(response=>{
        response=JSON.parse(response);
        if(response.exec){
            // _redirect("control/dashboard/"+btoa(JSON.stringify(param)));
            window.location.href = _.sfUrl+btoa(JSON.stringify(param));
        }else{
            return _toast({bg:'e', msg:response.msg});
        }
    });
}  
