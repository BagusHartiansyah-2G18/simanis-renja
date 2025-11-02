function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;  
    
    _.kategori = data.kategori; 
    _.bidang=data.bidang;
    _.kdBidang = _.bidang[0].value;
    _.sop=data.sop.map((v,i)=>({...v,i})); 
    _.isAdm = data.isAdm;
    _file.data=[];
    
    _.kategoriAktif =0;
    // $('#bodyTM').html(`<div class="p-2"><div id="pdf-container"></div></div>`);
    $('#footer').html(`<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>`+data.tmFooter+data.footer);
    $(document).ready(function() { 
        $('#bodyTM').html(tabPanel()); 
    })
}    

function tabPanel(){
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-outline-primary fzMfc`
        ,func:"lapoOpdPDF()"
        ,icon:`<i class="mdi mdi-file-check"></i>pdf`
        ,title:"Lihat laporan"
    }); 
    return`
        <div class="row p-6" style="margin-top: 6%; margin-left: 10px; width: 97%; font-size:15px;">
            <div class="col-sm-3 " >
            
                <section class="panel">
                    <div class="panel-body"> 
                        <ul class="nav nav-pills nav-stacked mail-nav" role="tablist" style="flex-direction: column;">
                            ${_.isAdm ? `
                                <li class="active"><a href="#table" data-toggle="tab"><i class="fa fa-inbox"></i>Data SOP</a></li>    
                                <li class=""><a href="#form" data-toggle="tab"><i class="fa fa-inbox"></i>Form Entri</a></li>
                            `:''}
                            ${_.kategori.map(v=>`
                                <li class="${!_.isAdm && 'active'}">
                                    <a href="#kate${v.value}" data-toggle="tab" onclick="setPDF('${v.value}','${v.valueName}')"><i class="fa fa-inbox"></i> ${v.valueName} </a>
                                </li>    
                            `).join(" ")}
                        </ul>
                    </div>
                </section>
            </div>

            <div class="col-sm-9">
                <div class="tab-content"> 
                    ${_.isAdm ? `
                        <div class="tab-pane active" id="table"> 
                            <div class="form-panel">
                                ${
                                    _formIcon({
                                        icon:'<i class="mdi mdi-file-check"></i>'
                                        ,text:"<h3>Form Entri SOP</h3>",
                                        classJudul:' p-2',
                                        id:"form1",
                                        sizeCol:undefined,
                                        bgHeader:"",
                                        btn:_btn({
                                            color:"primary shadow",
                                            judul:"Entri",
                                            attr:`style='float:right; padding:5px;font-size: medium;' onclick="goForm()"`,
                                            // class:"btn btn-secondary"
                                        }),
                                        attrHeader:`style="height: max-content;"`,
                                        bgForm:"#fff; font-size:15px;",
                                        isi:`<div id='tabelShow' style="margin: auto;">
                                                ${setTabel()}
                                            </div>`
                                    })
                                }  
                            </div>  
                        </div> 
                        <div class="tab-pane" id="form">
                            <div class="form-panel">
                                ${formEntri()} 
                            </div>
                        </div> 
                    `:''} 
                    ${_.kategori.map((v,i)=>`
                        <div class="tab-pane ${!_.isAdm && i==0 ? 'active':''}" id="kate${v.value}">
                            <div class="form-panel">
                                ${
                                    _formIcon({
                                        icon:'<i class="mdi mdi-file-check"></i>'
                                        ,text:"<h3>Preview SOP</h3>",
                                        classJudul:' p-2',
                                        id:"form1",
                                        sizeCol:undefined,
                                        bgHeader:"",
                                        
                                        attrHeader:`style="height: max-content;"`,
                                        bgForm:"#fff; font-size:15px;",
                                        isi:_inpComboBox({
                                                judul:"Pilih Judul",
                                                id:"kdDinas",
                                                color:"black",  
                                                data:_.sop.filter(v1=>v1.valueName == v1.nmKate).map(v1=>({value:v1.file,valueName:v1.judul})),
                                                bg:"bg-info text-light",
                                                method:"sejajar",
                                                attr:"font-size:15px;",
                                                change:"_changeJudul(this)",
                                                // index:true
                                            })
                                            +`<br/>`
                                            +`<div class="p-2"><div id="pdf-container${v.value}">${_.sop.length == 0?'data belum tersedia':'memuat...'}</div></div>`
                                    })
                                }  
                            </div>  
                        </div>     
                    `)}
                    
                </div>
            </div> 
        </div> 
        <hr/>
    `;
}

function setPDF(id, nmKate) {
    _.kategoriAktif = 0;
    _.idKategoriAktif = id;
    _.sopAktif = _.sop.filter(v1 => v1.kategori === nmKate);

    if (_.sopAktif.length === 0) {
        console.warn('File PDF tidak ditemukan untuk kategori:', nmKate);
        return;
    }

    setTimeout(() => {
        goPDF( _.sopAktif[0].file);
    }, 500); // 500ms cukup, tidak perlu 5000ms
}

function goPDF(url) { 
    const containerId = '#pdf-container' + _.idKategoriAktif;
    const container = document.querySelector(containerId);

    if (!container) {
        console.error('Elemen container tidak ditemukan:', containerId);
        return;
    }

    // Reset isi container
    container.innerHTML = '';

    // Set gaya container
    $(containerId).css({
        'display': 'flex',
        'flex-direction': 'column',
        'gap': '20px'
    });

    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js';

    // Pastikan URL valid dan tidak pakai "assert" 
    
    const loadingTask = pdfjsLib.getDocument(assert+url);

    loadingTask.promise.then(pdf => {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(page => {
                const scale = 1.2;
                const viewport = page.getViewport({ scale });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Tambahkan gaya ke canvas
                canvas.style.border = '1px solid #ccc';
                canvas.style.boxShadow = '0 2px 6px rgba(0,0,0,0.1)';

                container.appendChild(canvas);
                page.render({ canvasContext: context, viewport });
            });
        }
    }).catch(error => {
        console.error('Gagal memuat PDF:', error);
    });
}
function _changeJudul(file){
    goPDF(file.value);
}
function goForm(){
    $('a[href="#form"]').tab('show');
}
function setTabel(){
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-outline-danger fzMfc`
        ,func:"_konfirDelSOP()"
        ,icon:`<i class="fa fa-trash"></i> Hapus`
        ,title:"Hapus data"
    });
    // infoSupport1.push({ 
    //     clsBtn:`btn-outline-success fzMfc`
    //     ,func:"lapoOpdExcel()"
    //     ,icon:`<i class="mdi mdi-file-check"></i>excell`
    //     ,title:"Lihat laporan"
    // });
    return _tabelResponsive(
        {
            id:"dt"
            ,isi:_tabel(
                {
                    data:_.sop
                    ,no:1
                    ,kolom:[
                        "kategori","judul"
                    ]
                    ,namaKolom:[
                        "Kategori","Judul"
                    ],
                    action:infoSupport1
                })
        });
}
function formEntri() { 
    return `
        <div>
            ${_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Form Entri SOP</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    sizeCol:undefined,
                    bgHeader:"",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:_inpComboBox({
                        judul:"Untuk Bidang",
                        id:"kdDinas",
                        color:"black",  
                        data:_.bidang,
                        bg:"bg-info text-light",
                        method:"sejajar",
                        attr:"font-size:15px;",
                        change:"_changeBidang(this)",
                        // index:true
                    })
                    +`<br/>`
                    +_inpSejajar({
                        attrRow:"margin-bottom:10px;",
                        attrCol:"margin-bottom:10px;",
                        attrLabel:" ",
                        judul:"Kategori",
                        isi:_inpDropdonwSelectedJJin({
                            idInp:"idInpDropJin" ,
                            onInput:"_inpSearchSatuan",
                            idMenu:"satuan",
                            idOpsMenu:"dsatuan",
                            ops:generateOpsKategori(_.kategori)
                        })
                    })
                    +_inpSejajar({
                        attrRow:"margin-bottom:10px;",
                        attrCol:"margin-bottom:10px;",
                        attrLabel:"",
                        judul:"Judul SOP",
                        isi:_inpGroupPrepend({
                                id:"judul",placeholder:"Judul SOP",
                                cls:'mt-4',attr:";",type:"text",icon:'<i class="fa fa-pencil"></i>',
                                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
                            })
                    })
                    +_inpSejajar({
                        attrRow:"margin-bottom:10px;",
                        attrCol:"margin-bottom:10px;",
                        attrLabel:"",
                        judul:"File SOP [PDF]",
                        isi:_inp({
                            attr:'onchange="readFile(this)"',
                            id:'vfilex',
                            type:'file',
                            cls:"form-control fzMfc",
                        })
                    })
                    +_inpSejajar({
                        attrRow:"margin-bottom:10px;",
                        attrCol:"margin-bottom:10px;",
                        attrLabel:"",
                        judul:"",
                        isi:_btn({
                                color:"primary shadow",
                                judul:"Tambahkan",
                                attr:`style='float:right; padding:5px;font-size: medium;' onclick="_konfirAddSOP()"`,
                                // class:"btn btn-secondary"
                            })
                    })
                    
                    
                })}
        </div> `;
}

function _changeBidang(v){ 
    
    _.kdBidang = v.value;
} 
function generateOpsKategori(data){
    return data.map((v, i) => 
        _btn({
            color:"primary shadow",
            judul:v.valueName,
            attr:`style='float:right; padding:5px;font-size: medium;' onclick="optKategori('${v.valueName}')"`,
            // class:"btn btn-secondary"
        })).join(" ");
}
function _formSearchsatuan(input,idOpsMenu) {
    _.idOpsMenu = idOpsMenu; 
    const keyword = input.value.toLowerCase(); 
    const container = document.getElementById(idOpsMenu);
    container.innerHTML = ""; 
    let found = false;  
    
    $("#satuan").removeClass("hide-important");
    let html = generateOpsKategori(_.kategori.filter(v=>v.valueName.toLowerCase().includes(keyword)))
 
    console.log(html);
    

    if (!found && keyword.trim() !== "") {
        // const addBtn = document.createElement("button");
        // addBtn.className = "btn fzMfc btn-warning btn-sm w-100";
        // addBtn.innerText = `Tambah "${keyword}"`;
        // addBtn.onclick = function () {
        //     _tambahKategori(keyword, input);
        // };
        html+= _btn({
            color:"warning shadow",
            judul: `Tambah "${keyword}"`,
            attr:`style='float:right; padding:5px;font-size: medium;' onclick="_tambahKategori('${keyword}')"`,
            // class:"btn btn-secondary"
        })
        // container.appendChild(addBtn);
        
    }

    container.innerHTML =html;
}
function optKategori(kategori){
    _.idKategori =kategori; 

    document.getElementById("idInpDropJin") .value = kategori; 
    $("#satuan").addClass("hide-important");

}
function _tambahKategori(keyword, input) { 
    _.idKategori = keyword;
    $("#satuan").addClass("hide-important");

    // param={
    //     judul:keyword,
    // }
    // _post('proses/addKategori',param).then(res=>{
    //     res=JSON.parse(res);
    //     if(res.exec){
    //         _.idKategori = keyword;
    //         _.kategori.push({value:res.data.id, valueName:keyword});
    //         input.value = keyword;  
    //         document.getElementById("satuan").style.display = "none";
    //     }else{
    //         return _toast({bg:'e', msg:res.msg});
    //     }
    // }); 
} 

function _konfirAddSOP() {
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-check"></i>`,
        cform:`text-light`,
        bg:"success",
        minWidth:fsize+"; font-size: medium;",
        isi:"ingin menambahkan data baru ?",
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    // color:"success shadow",
                    judul:"tambahkan",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_konfirAddSOPed()'",
                    class:"btn btn-primary"
                })
    }); 
}
function _konfirAddSOPed() {
    param={ 
        judul:$('#judul').val(),
        kdBidang:_.kdBidang,
        kategori:_.idKategori,
    } 
    if(_isNull(param.kdBidang))return _toast({bg:'e',msg:'Tambahkan Bidang !!!'});
    if(_isNull(param.judul))return _toast({bg:'e',msg:'Tambahkan Judul !!!'});
    if(_isNull(param.kategori))return _toast({bg:'e',msg:'Tambahkan Kategori !!!'});
      
    
    _postFile("proses/addSop",param,_file.data).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            // _.sop.push(res.data.data);
            // _.kategori.push({value:_.idKategori, valueName:_.idKategori});
            _modalHide('modal'); 
            // _generateTabel();
            $('a[href="#table"]').tab('show');
           _reload();
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    }) 
}
function _generateTabel() {
    
    $('#bodyTM').html(tabPanel()); 
    $('#tabelShow').html(setTabel());
    _startTabel("dt",{});
    
}
function _konfirDelSOP(i) {
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="fa fa-trash"></i>`,
        cform:`text-light`,
        bg:"danger",
        minWidth:fsize+"; font-size: medium;",
        isi:"ingin Menghapus data ini ?",
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    // color:"success shadow",
                    judul:"Hapus",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_konfirDelSOPed("+i+")'",
                    class:"btn btn-danger"
                })
    }); 
}
function _konfirDelSOPed(i) {
    param={ 
        id:_.sop[i].id
    } 
    
    _post("proses/delSop",param,_file.data).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            // _.sop.push(res.data.data);
            // _.kategori.push({value:_.idKategori, valueName:_.idKategori});
            _modalHide('modal');  
            $('a[href="#table"]').tab('show');
           _reload();
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    }) 
}