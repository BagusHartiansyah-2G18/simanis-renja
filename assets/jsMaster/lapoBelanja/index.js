function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code; 

    _.dinas=data.dinas;
    
    $('#bodyTM').html(_form());
    $('#footer').html(data.tmFooter+data.footer);
    
    _startTabel("dt",true);
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
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-secondary fzMfc`
        ,func:"lapoBelanjaPDFAll(1)"
        ,icon:`<i class="mdi mdi-file-check"></i>PRA`
        ,title:"Semua Dinas"
    });
    infoSupport1.push({ 
        clsBtn:`btn-primary fzMfc`
        ,func:"lapoBelanjaPDFAll(2)"
        ,icon:`<i class="mdi mdi-file-check"></i>RENJA`
        ,title:"Semua Dinas"
    });
    infoSupport1.push({ 
        clsBtn:`btn-success fzMfc`
        ,func:"lapoBelanjaPDFAll(3)"
        ,icon:`<i class="mdi mdi-file-check"></i>FINAL`
        ,title:"Semua Dinas"
    });
    return `<div class="row m-2 shadow">`
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Realisasi SKPKD</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    // btn:_btnGroup(infoSupport1),
                    // btn:_btn({
                    //     color:"primary shadow",
                    //     judul:"simpan Perubahan",
                    //     attr:"style='padding:5px;font-size:15px;' onclick='savedOPD()'",
                    //     // class:"btn btn-success btn-block"
                    // }),
                    sizeCol:undefined,
                    bgHeader:"bg-info text-light",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:`<div id='tabelShow' style="margin: auto;">`
                            +setTabel()
                        +`</div>`,
                })
            +`</div>`;
}
function setTabel(){
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-warning fzMfc`
        ,func:"_goUPBelanja()"
        ,icon:`<i class="mdi mdi-file-check"></i>Perbarui`
        ,title:"Perbarui Realisasi"
    });
    return _tabelResponsive(
        {
            id:"dt"
            ,isi:_tabel(
                {
                    data:_.dinas
                    ,no:1
                    ,kolom:[
                        "nmDinas","persen","pagu$","realisasi$"
                    ]
                    ,namaKolom:[
                        "Nama Dinas","Persentase","Pagu","Realisasi"
                    ],
                    action:infoSupport1
                })
        });
}
function lapoBelanjaPDF(tahapan,i) {
    var data =btoa(JSON.stringify({
        kdDinas:_.dinas[i].kdDinas,
        nmDinas:_.dinas[i].nmDinas,
        tahapan:tahapan,
        apbd:_.kdApbd
    }));
    _redirectOpen("laporan/lapoBelanja/"+data);
}
function lapoBelanjaPDFAll(tahapan) {
    var data =btoa(JSON.stringify({
        kdDinas:'',
        nmDinas:'',
        tahapan:tahapan,
        apbd:_.kdApbd
    }));
    _redirectOpen("laporan/lapoBelanja/"+data);
}
function _setApbd(v) {
    _.kdApbd=v.value;
}

function _goUPBelanja(Ijudul) {
    _.Ijudul= Ijudul;  
    _modalEx1({
        judul:"Perbarui Realisasi Anggaran".toUpperCase(),
        icon:`<i class="mdi mdi-check"></i>`,
        cform:`text-light`,
        bg:"success",
        minWidth:fsize+"; font-size: medium;",
        isi:`<p>${_.dinas[Ijudul].nmDinas}</p>`
            +_inpGroupPrepend({
                id:"pagu",placeholder:"pagu",
                cls:'mt-4',attr:";",type:"number",icon:'<i class="mdi mdi-home"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })    
            +_inpGroupPrepend({
                id:"realisasi",placeholder:"realisasi",
                cls:'mt-4',attr:";",type:"number",icon:'<i class="mdi mdi-home"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            }),
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    // color:"success shadow",
                    judul:"Simpan",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_goUPBelanjaed()'",
                    class:"btn btn-primary"
                })
    }); 

    $('#pagu').val(_.dinas[Ijudul].pagu);
    $('#realisasi').val(_.dinas[Ijudul].realisasi);
}
function _goUPBelanjaed() {
    let pagu = $('#pagu').val();
    let real = $('#realisasi').val();
    param={ 
        kdDinas:_.dinas[_.Ijudul].kdDinas,
        pagu:pagu,
        real:real,   
    }
    
    if(Number(real)>Number(pagu))return _toast({bg:'e',msg:'jangan melebihi pagu !!!'});   

    _post('proses/dinasview',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            _modalHide('modal');  
            respon(res.data.dinas);
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}

function respon(data) {
    _.dinas = data;
    $('#tabelShow').html(setTabel());
    _startTabel("dt",true);
}