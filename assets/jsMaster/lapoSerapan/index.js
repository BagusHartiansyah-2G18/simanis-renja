function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    // _.info=data.info;
    _.month = data.month;

    _.bidang = data.bidang
    // console.log(data.dinas[0].data);
    
    
    _.dinas=[];
    _.dbidang=[];
    _.filter = null ; 
    
    _.ind=0;
    
    $('#bodyTM').html(_form());
    setData(data.dinas[0].data);
    
    $('#footer').html(data.tmFooter+data.footer);
    $('#kdBulan').val(_.month);
    // _startTabel("dt",{});
    
}
function setData(xdata) {
    _.dinas=[];
    _.dbidang=[];
    _.bidang.forEach(v=>{
        const bidang = xdata.filter(x=>Number(x.kdBidang) == Number(v.value)).map(x=>{
            return ({
                kd:Number(v.value),
                nm:v.valueName,
                sub:x.nmSub,
                total:x.totalPRARKA,
                realisasi:x.totalR,
                persen:(Number(x.totalPRARKA)==0?0:((Number(x.totalR)/Number(x.totalPRARKA))*100).toFixed(2)),
            })
        });
        if(bidang.length>0){ 
            _.dbidang.push({
                nm:bidang[0].nm,
                kd:Number(v.value),
                ...__persentaseRealisasi(bidang)
            })
        }
        
        _.dinas.push(...bidang);
    });

    const lainnya = xdata.filter(v=>Number(v.kdBidang) == 0).map(v=>{ 
        return ({
            kd:0,
            nm:"lainnya",
            sub:v.nmSub,
            total:v.totalPRARKA,
            realisasi:v.totalR,
            persen:(Number(v.totalPRARKA)==0?0:((Number(v.totalR)/Number(v.totalPRARKA))*100).toFixed(2)),
        })
    });
    if(lainnya.length>0){
        _.dbidang.push({
                nm:"lainnya",
                kd:0,
                ...__persentaseRealisasi(lainnya)
            });
        _.dinas.push(...lainnya);
    }
    
    _generateTabel();
}
function _generateTabel() {
    $('#tabelLapoSerapan').html(setTabel());
    if(!_.filter){   
        $("#tabelLapoSerapanBidang").html(setTabelBidang());
        _startTabel("dtbidang",{});
    }
    
    _startTabel("dt",{});
    
}
function __persentaseRealisasi(fdt) {
    
    const totalfdt = fdt.reduce((sum, v) => sum + Number(v.persen), 0);  
    
    
    const pagu = fdt.reduce((sum, v) => sum + Number(v.total), 0); 
    const realisasi = fdt.reduce((sum, v) => sum + Number(v.realisasi), 0); 

    const persen= ((realisasi / pagu) * 100).toFixed(2);

      
    return {persen,pagu,realisasi,sub:fdt.length}
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
    const bulan = [
    { value: "1", valueName: "januari" },
    { value: "2", valueName: "februari" },
    { value: "3", valueName: "maret" },
    { value: "4", valueName: "april" },
    { value: "5", valueName: "mei" },
    { value: "6", valueName: "juni" },
    { value: "7", valueName: "juli" },
    { value: "8", valueName: "agustus" },
    { value: "9", valueName: "september" },
    { value: "10", valueName: "oktober" },
    { value: "11", valueName: "november" },
    { value: "12", valueName: "desember" }
    ];
    return `<div class="row m-2 shadow">`
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Rekapan BPKAD</h3>",
                    classJudul:' p-2',
                    id:"form1",
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
                    isi:_inpComboBox({
                            judul:"Pilih Bulan",
                            // id:"kdDinas",
                            id:"kdBulan",
                            color:"black",  
                            data:bulan,
                            change:"_changeMonthRealisasi(this)",
                            bg:"bg-warning text-dark",
                            method:"sejajar",
                            attr:"font-size:15px;",
                            // index:true
                        }) 
                        +_lines({attr:'background:white;'})
                        +`<h2>Rekapan Bidang</h2>`
                        +_lines({attr:'background:white;'})
                        +`<div id='tabelLapoSerapanBidang'></div>`
                         +_lines({attr:'background:white;'})
                         +` <div class="row">
                            <h2 class="col">Rekapan Sub Kegiatan</h2>
                            <div class="col d-flex justify-content-end" id="btnViewAll">
                                
                            </div>
                         </div>
                            `
                        +_lines({attr:'background:white;'})
                        +`
                        <div id='tabelLapoSerapan'></div>`
                        +`</div>`,
                })
            +`</div>`;
}
function setTabelBidang(){
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-outline-primary fzMfc`
        ,func:"selectBidang()"
        ,icon:`preview`
        ,title:"preview"
    }); 
    return _tabelResponsive(
        {
            id:"dtbidang"
            ,isi:_tabel(
                {
                    data:_.dbidang
                    ,no:1
                    ,kolom:[
                        "nm","sub","pagu$","realisasi$","persen"
                    ]
                    ,namaKolom:[
                        "Nama Bidang","SuB Kegiatan","Pagu","Realisasi","Persentase (%)"
                    ],
                    action:infoSupport1
                })
        });
}
function setTabel(){
    infoSupport1=[];
    infoSupport1.push({ 
        clsBtn:`btn-outline-primary fzMfc`
        ,func:"lapoOpdPDF()"
        ,icon:`<i class="mdi mdi-file-check"></i>pdf`
        ,title:"Lihat laporan"
    });
    infoSupport1.push({ 
        clsBtn:`btn-outline-success fzMfc`
        ,func:"lapoOpdExcel()"
        ,icon:`<i class="mdi mdi-file-check"></i>excell`
        ,title:"Lihat laporan"
    });
    console.log(_.filter);
    
    return _tabelResponsive(
        {
            id:"dt"
            ,isi:_tabel(
                {
                    data:(_.filter == null ? _.dinas: _.dinas.filter(v=>v.kd == _.filter))
                    ,no:1
                    ,kolom:[
                        "nm","sub","total$","realisasi$","persen"
                    ]
                    ,namaKolom:[
                        "Nama Bidang","SuB Kegiatan","Pagu","Realisasi","Persentase (%)"
                    ],
                    // action:infoSupport1
                })
        });
}
function lapoOpdPDF(i) {
    var data =btoa(JSON.stringify({
        kdDinas:_.dinas[i].kdDinas,
        nmDinas:_.dinas[i].nmDinas,
        pdf:true
    }));
    _redirectOpen("laporan/lapoOpd/"+data);
}
function lapoOpdExcel(i) {
    var data =btoa(JSON.stringify({
        kdDinas:_.dinas[i].kdDinas,
        nmDinas:_.dinas[i].nmDinas,
        pdf:false
    }));
    _redirectOpen("laporan/lapoOpd/"+data);
}

function _changeMonthRealisasi(v) { 
    _.bulan=Number(v.value); 
    _.filter =null;
    _post('proses/realisasiPerMount',{
        bulan:_.bulan
    }).then(response=>{
        response=JSON.parse(response);
        if(response.exec){ 
            return setData(response.data.data);
            
        }else{
            return _toast({bg:'e', msg:response.msg});
        }
    }) 
}
function selectBidang(i) { 
    _.filter = _.dbidang[i].kd;
    _generateTabel();
    $('#btnViewAll').html(
        _btn({
            color:"primary shadow",
            judul:"all Data",
            attr:"style='padding:5px;font-size:15px;width: fit-content;' onclick='clearFilter()'",
            // class:"btn btn-success btn-block"
        })
    )
}
function clearFilter(){
    _.filter = null;
    $('#btnViewAll').html('');
    _generateTabel();
}