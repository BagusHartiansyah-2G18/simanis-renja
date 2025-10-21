function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    
    _.tahun=data.tahun;
    
    
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
                            size:"12 h-100",form:newYear(),style:"padding: 20px;background:none;"
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
    console.log(_.tahun);
    const dthn =["2025","2026","2027","2028","2029"];
    const textThn =dthn.map((v)=>{
        return _.tahun.filter((x)=>x.judul==v).length>0?"akses":"tidak ada akses";
    });
    const btn="akses";
    return `
        <div class="row content-panel">
            <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                    <div class="profile-pic">
                        <img src="`+assert+`/fs_css/bpt.jpg" style="border-radius: 0px; height:250px; width:250px;">
                    </div>
                    <h2>Bupati - Wakil Bupati</h2>
                    <h4 class="p-0 m-0">H. Amar Nurmansyah, ST., M.Si. <br/> Hj. Hanipah, S.Pt., M.M.Inov</h4>
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
