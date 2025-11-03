function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    
    _.tahun=data.tahun;
    _.bidang = data.bidang;
    _.data = data.data;
    _.month = data.month;
    _.bulan = data.bulan;
    _.triulan = data.triulan;
    
    
    _.tahun.forEach((v) => {
        v.url='control/sop/'+(Number(v.perubahan)==0?v.judul:v.judul+"-"+v.perubahan);
        v.img='<span class="mdi mdi-database" style="font-size: 40px;color: blue;"></span>';
    });
    
    $('#bodyTM').html(_formData());
    $('#footer').html(data.tmFooter+data.footer);
    
    // _startTabel("dt"); 
}
function _form() {
    // <img class="img-fluid d-block mx-auto" src="`+assert+`fs_css/bgForm.png" alt="sasasa"></img>
    return `
    
    <div class="page-header" style="padding: 20px; margin-top: 4%;">
        <div class="page-block">`
            +_formData()
        +`</div>
    </div>`;
}

function _formData() {
    return `<div class="row m-2 shadow">`
                +_formNoHeader({
                    shadow:false,
                    cls:"w-100 h-100",
                    id :"idContainer",
                    style:` min-height:600px; width: 100% !important;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        justify-content: center;
                        
                    `,
                    kolom:[
                        {
                            size:"12 h-100",form:newYear(),style:"padding: 20px; background:url('"+assert+"fs_css/bg11.jpg');"
                        }
                    ]
                })
                +_formNoHeader({
                    shadow:false,
                    cls:"w-100 h-100",
                    id :"idContainer",
                    style:` min-height:600px; width: 100% !important;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        justify-content: center;
                        padding:0px 5% !important;
                        background:url('${assert}fs_css/bg11.jpg');
                    `,
                    kolom:[
                        {
                            size:"7 h-100",form:organisasi(),style:"padding: 20px;background:none;"
                        },{
                            size:"5 h-100",form:info(),style:"padding:45px  20px;background:none; text-align"
                        }
                    ]
                }) 
            +`</div>`;
}
function _form2(){
    hicon="200px";
    fsize="180px";
    infoSupport1=[];
    infoSupport1.push({name:"Facebook",value:'Komplek KTC',icon:'<span class="mdi mdi-database" style="font-size: 40px;color: blue;"></span>'});
    // infoSupport1.push({name:"Instagram",value:'087-863-731-101',icon:'<span class="mdi mdi-instagram" style="font-size: 40px;color: cornflowerblue;"></span>'});
    // // infoSupport1.push({name:"Telegram",value:'bappedaKsb@gmail.com',icon:'<span class="mdi mdi-cellphone-basic" style="font-size: 40px;color: blue;"></span>'});
    // infoSupport1.push({name:"Twitter",value:'bappedaKsb@gmail.com',icon:'<span class="mdi mdi-twitter" style="font-size: 40px;color: blue;"></span>'});
    // infoSupport1.push({name:"Website",value:'bappedaKsb@gmail.com',icon:'<span class="mdi mdi-search-web" style="font-size: 40px;color: yellowgreen;"></span>'});

    return `
    <div class="" style="margin: auto;padding: 30px; min-height:600px; background: rgba(255, 255, 255, 0.30);">`
        +`<div class="menu" style="margin-top:100px;color:black;padding:5px;">`
            +_galeryx3({
                style:'background-color:rgba(135, 166, 160, 0.4);',
                row:6,
                url:router,
                data:_.tahun
            })
        +`</div>
    </div>`;
    // +_textCenter({text:` <a class="small" href="forgot-password.html">Forgot Password?</a>`})+
    //     _textCenter({text:` <a class="small" href="register.html">Create an Account!</a>`})
}

function newYear() {
    // <div class="page-header" style="padding: 20px; margin-top: 4%;">
    //     <div class="page-block">`
    //         +_formData()
    //     +`</div>
    // </div>`;
    // console.log(_.tahun);
    const dthn =["2025","2026","2027","2028","2029"];
    const textThn =dthn.map((v)=>{
        return _.tahun.filter((x)=>x.judul==v).length>0?"akses":"tidak ada akses";
    });
    const btn="akses";
    return `
        <div class="row"> 
            <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                    <div class="profile-pic">
                        <img src="`+assert+`/fs_css/bpt.jpg" style="border-radius: 0px; height:250px; width:250px;">
                    </div>
                    <h2>Bupati - Wakil Bupati</h2>
                    <h4 class="p-0 m-0 text-danger">H. Amar Nurmansyah, ST., M.Si. <br/> Hj. Hanipah, S.Pt., M.M.Inov</h4>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 profile-text">
                        <h2>H. Amir Sarifuddin</h2>
                        <h4 class="p-0 m-0">Kepala Badan Pengelola Keuangan dan Aset Daerah</h4>
                        <br>
                        <p>mengukur dan mengevaluasi kemajuan terhadap target yang telah ditetapkan, memastikan akuntabilitas, mengidentifikasi masalah, dan memungkinkan pengambilan tindakan perbaikan demi mencapai tujuan yang efektif dan efisien</p>
                        <br>
                    </div>
                    <!-- /col-md-4 -->
                    <div class="col-md-6 centered">
                        <div class="profile-pic">
                            <p><img src="`+assert+`/fs_css/bpkad.jpg" class="img-circle"></p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="content-panel">
                            <h4><i class="fa fa-angle-right"></i> Priode Jabatan 2025 - 2029</h4>
                            <hr>
                            <table class="table">
                                <thead>
                                <tr>${dthn.map((v,i)=>`<th>${v}</th>`).join('')}</tr> 
                                </thead>
                                <tbody>
                                    <tr>${textThn.map((v,i)=>`
                                        <td><a class="btn bg-success text-white" href="${v=="akses"?router+"control/sop/"+dthn[i]:"#"}">${v}</a></td>
                                    `).join('')}</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>  
            </div> 
        </div> 
    `;
}

function organisasi() {
    const sekret = "Sekretariat";
    if(!_.bidang) return "";
    const {nm,nip,img} = _.bidang.filter((v)=>v.nmBidang.toLowerCase()==sekret.toLowerCase())[0];
    const bidang = _.bidang.filter((v)=>v.nmBidang.toLowerCase()!=sekret.toLowerCase());
    // _.bidang
    return `
        <div class="detailed mt">
                <h4>Struktur Organisasi</h4>
                <div class="recent-activity">
                <div class="activity-icon bg-theme">2</div>
                <div class="activity-panel">
                    <div class="row centered mt mb justify-content-center">
                          <div class="col-sm-4">
                            <img src="${img? img:assert + "fs_css/fr-05.jpg"}" class="img-circle" width="65">
                            <h3>${nm}</h3>
                            <h6>${nip}</h6>
                          </div>
                           
                    </div>
                </div>
                <div class="activity-icon bg-theme02">3</div>
                <div class="activity-panel">
                    <div class="row centered mt mb">
                      ${bidang.map((v)=>`
                        <div class="col-sm-3">
                            <img src="${v.img? v.img:assert + "fs_css/fr-05.jpg"}" class="img-circle" width="65">
                            <h5>${v.asBidang.toUpperCase()}</h5>
                            <h4>${v.nm}</h4>
                            <h6>${v.nip}</h6>
                          </div>
                        `).join('')}
                    </div>
                </div>
                <div class="activity-icon bg-theme04">4</div>
                <div class="activity-panel">
                    <h5>Staf / Pegawai</h5> 
                </div>
                </div>
                <!-- /recent-activity -->
            </div>
    `;
}
function info() {
    const { jumlahSubKegiatan,persentaseRealisasi,totalAnggaran,totalRealisasi,tahun } = __valuesInformasiSKPD();
    const infoBidang = __valueInformasiBidang(); 
    localStorage.setItem("triulan",JSON.stringify(infoBidang)); 
    return `
        <div class="detailed">
                        <h4>Informasi Sistem</h4>
                        <div class="row centered mt mb">
                          <div class="col-sm-4">
                            <h1><i class="fa fa-spinner"></i></h1>
                            <h3>${_.bidang.length}</h3>
                            <h6>Sekret - Bidang</h6>
                          </div>
                          <div class="col-sm-4">
                            <h1><i class="fa fa-table"></i></h1>
                            <h3>${jumlahSubKegiatan}</h3>
                            <h6>Sub Kagiatan</h6>
                          </div>
                          <div class="col-sm-4">
                            <h1><i class="fa fa-money"></i></h1>
                            <h3>${_$(totalAnggaran)}</h3>
                            <h6>Anggaran</h6>
                          </div>
                          
                        </div>
                        <div class="row centered mt mb">
                          <div class="col-sm-4">
                            <h1><i class="fa fa-shopping-cart"></i></h1>
                            <h3>${_$(totalRealisasi)}</h3>
                            <h6>Realisasi</h6>
                          </div>
                          <div class="col-sm-4">
                            <h1><i class="fa fa-bar-chart-o"></i></h1>
                            <h3>${persentaseRealisasi} %</h3>
                            <h6>Persentase</h6>
                          </div> 
                          <div class="col-sm-4">
                            <h1><i class="fa fa-calendar"></i></h1>
                            <h3>${_.month} (${_.bulan})</h3>
                            <h6>${tahun}</h6>
                          </div> 
                          
                        </div> 
                        <h4>Progres Realisasi Anggaran</h4>
                        <div class="row centered">
                          <div class="col-md-8 col-md-offset-2">
                            ${
                            infoBidang.map((v)=>`
                              <h5>${v.nmBidang} (${v.persen} %})</h5>
                              <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="${v.persen}" aria-valuemin="0" aria-valuemax="100" style="width: ${v.persen}%;">
                                  <span class="sr-only">${v.persen}% Complete</span>
                                </div>
                              </div>
                            `).join('')}
                          </div>
                          <!-- /col-md-8 -->
                        </div>
                        <!-- /row -->
                      </div>
    `;
}

function __valuesInformasiSKPD() {
  const tsub = _.data.length;
  let totalAnggaran = 0;
  let totalRealisasi = 0;

  _.data.forEach((v) => {
    totalAnggaran += Number(v.totalPRARKA);
    totalRealisasi += Number(v.totalR);
  });

  const persentase = totalAnggaran > 0 ? ((totalRealisasi / totalAnggaran) * 100).toFixed(2) : 0;

  return {
    jumlahSubKegiatan: tsub,
    totalAnggaran: totalAnggaran,
    totalRealisasi: totalRealisasi,
    persentaseRealisasi: persentase,
    tahun:_.data[0].taSub,
  };
}
function __valueInformasiBidang(){
  let resp = [];
  _.bidang.forEach(v=>{
    const bidang = _.data.filter(x=>Number(x.kdBidang) == Number(v.kdBidang)).map(x=>({
        total:x.totalPRARKA,
        realisasi:x.totalR,
        persen:(x.totalPRARKA==0?0:((x.totalR/x.totalPRARKA)*100).toFixed(2)),
    }));
    if(bidang.length>0){
        resp.push({
            nmBidang:v.nmBidang,
            kdBidang:v.kdBidang,
            ...__persentaseRealisasi(bidang)
        })
    }
  }); 
  
  return resp;
}
function __persentaseRealisasi(fdt) { 
    const pagu = fdt.reduce((sum, v) => sum + Number(v.total), 0); 
    const realisasi = fdt.reduce((sum, v) => sum + Number(v.realisasi), 0); 
    const triulan = fdt.filter(v=>v.persen< (25*_.triulan)); 
    return {persen:((realisasi/pagu)*100).toFixed(2),pagu,realisasi,sub:fdt.length,triulan:triulan}
}