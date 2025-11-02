function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    _.drenstra=data.drenstra[0];
    _.dapbd=data.dapbd;
    _.sfKdApbd='';
    _.dtDetailRincian=data.dtDetailRincian;
    // console.log(_.dtDetailRincian);
    _.dSdana=data.dSdana;
    _.dsshx=data.dssh; // ssh yang berpproses
    _.sfKeyUpdate='';
    _.totalPagu=0;
    _.noUser = data.noUser;
    _.act=Number(data.act);

    _.kdBidang = data.kdBidang
    _.today = data.today;

    _.tahapan=data.tahapan;
    _.tahun=data.tahun;
    _.nmTahapan=data.nmTahapan;
    _.totalRealisasi = 0;
    _.bulan = data.bulan;
    $('#bodyTM').html(newForm());
    $('#bodyTM').css("background","#b4b4b436")
    $('#footer').html(data.tmFooter+data.footer);
    
    _tabelPreview(null);
    _startTabel("dt");
    // saveDynamicDataToFile();
    // _startTabel("dtPreview"); 
    

    $('#lokasiP').val(_.drenstra.lokasiP);
    $('#waktuP').val(_.drenstra.waktuP);
    $('#kelompokS').val(_.drenstra.kelompokS);
    $('#keluaran').val(_.drenstra.keluaran);
    $('#hasil').val(_.drenstra.hasil);
    $('#keluaranT').val(_.drenstra.keluaranT);
    $('#hasilT').val(_.drenstra.hasilT); 
    $(document).ready(function() { 
        chartxx();
    })
    
}
function chartxx() {
    // _.Prealisasi = ((_.totalRealisasi/_.totalPagu)*100).toFixed(2);
    _.Prealisasi = ((_.totalRealisasi/_.totalPagu)*100).toFixed(2);
    $('#informasi').html(_infoBelanja()); 
    const ctx = document.getElementById("bar").getContext("2d");
    if(_.drenstra.dhasil.length!=0){
        const dkeluaran = JSON.parse(_.drenstra.dkeluaran);
        const dhasil = JSON.parse(_.drenstra.dhasil); 
        const getValue = (arr, index) => arr[index] ?? 0;

        const barChartData = {
            labels: ["pelaksanaan kegiatan", "dampak program"],
            datasets: [
                {
                    label: "Dataset 1",
                    backgroundColor: "rgba(220,220,220,0.5)",
                    borderColor: "rgba(220,220,220,1)",
                    data: [getValue(dkeluaran, 0), getValue(dhasil, 0)]
                },
                {
                    label: "Dataset 2",
                    backgroundColor: "rgba(151,187,205,0.5)",
                    borderColor: "rgba(151,187,205,1)",
                    data: [getValue(dkeluaran, 1), getValue(dhasil, 1)]
                }
            ]
        };


        const config = {
            type: "bar",
            data: barChartData,
            options: {
            responsive: true,
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        };

        new Chart(ctx, config);


    }
    $('#hero-donut').html('');
    Morris.Donut({
        element: 'hero-donut',
        data: [
        { label: "Total", value: _.totalPagu },
        { label: "Realisasi", value: _.totalRealisasi }
        ],
        colors: ['#0B62A4', '#7A92A3'],
        resize: true
    });


    param={ 
        kdKeg:_.drenstra.kdKeg,
        kdSub:_.drenstra.kdSub,
        kdDinas:_.drenstra.kdDinas, 
        prealisasi:_.Prealisasi
    }

    _postNoLoad('proses/setPersentaseSub',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){ 
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    }); 
}
function newForm() {
    // <li><a href="#trash" data-toggle="tab"><i class="fa fa-trash-o"></i> Trash</a></li> 

    return ` 
        <div class="row p-6" style="margin-top: 6%; margin-left: 10px; width: 97%; font-size:15px;">
            <div class="col-sm-3 " >
            
                <section class="panel">
                    <div class="panel-body"> 
                        <ul class="nav nav-pills nav-stacked mail-nav" role="tablist" style="flex-direction: column;">
                            <li class="active"><a href="#monitor" data-toggle="tab"><i class="fa fa-inbox"></i>Monitoring</a></li>    
                            <li class=""><a href="#informasi" data-toggle="tab"><i class="fa fa-inbox"></i>Informasi</a></li>
                            <li><a href="#formIndikator" data-toggle="tab"><i class="fa fa-inbox"></i>Form Indikator</a></li>
                           
                        </ul>
                    </div>
                </section>
            </div>

            <div class="col-sm-9">
                <div class="tab-content">
                    <div class="tab-pane active" id="monitor">
                        <div class="form-panel row">
                            <div class="col-md-6">
                                <h4 class="mb text-center">Monitoring Item Sub Kegiatan</h4>
                                <canvas id="bar" height="100px"></canvas> 
                            </div>
                            <div  class="col-md-6">
                                <h4 class="mb text-center">Serapan Anggaran (${_.bulan})</h4>
                                <div id="hero-donut" class="graph"  style="height: 200px;"></div>
                            </div> 
                        </div> 
                    </div> 
                    <div class="tab-pane " id="informasi">
                        ${_infoBelanja()}
                    </div> 

                    <div class="tab-pane" id="formIndikator">
                        <div class="form-panel">
                            <h4 class="mb">Form Indikator Kinerja</h4>
                            ${
                                _findikatorKinerjaUpd()
                                +`<hr/>
                                    <div class="row  pl-4">
                                        ${_btn({
                                                // color:"success shadow",
                                                judul:"Simpan",
                                                attr:"style='float:right; padding:5px;font-size: medium;' onclick='_goIndikatored()'",
                                                class:"btn btn-primary"
                                            })}
                                    </div>
                                `
                            } 
                            <h2 class="mb"></h2>
                        </div> 
                    </div> 
                </div>
            </div> 
        </div> 
        <hr/>
            
        ${_formPreview()}
    `;
 
    
}
function _form() {
    // <img class="img-fluid d-block mx-auto" src="`+assert+`fs_css/bgForm.png" alt="sasasa"></img>
    return `
    <div class="page-header" style="padding: 20px; margin-top: 4%;">
        <div class="page-block">`
            +_infoBelanja()
            +_formBelanja()
            +_formPreview()
        +`</div>
    </div>`;
}

function _infoBelanja() {
    return `<div class="row ml-2 shadow" >`
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Informasi Sub Kegiatan</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    sizeCol:undefined,
                    bgHeader:"",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:_getInfoRenstra()
                })
            +`</div>`;
}
function _getInfoRenstra() {
    infoSupport=[];
    infoSupport.push({name:"Data",value:_.bulan+" "+_.tahun});
    infoSupport.push({name:"Urusan",value:_.drenstra.nmUrusan});
    infoSupport.push({name:"Bidang",value:_.drenstra.nmBidang});
    infoSupport.push({name:"Program",value:_.drenstra.nmProg});
    infoSupport.push({name:"Kegiatan",value:_.drenstra.nmKeg});
    infoSupport.push({name:"Sub Kegiatan",value:_.drenstra.nmSub});
    infoSupport.push({name:"Total Pagu",value:_$(_.totalPagu)});
    infoSupport.push({name:"Total Realisasi",value:_$(_.totalRealisasi)}); 
    infoSupport.push({name:"Realisasi %",value:(_.Prealisasi+" %")}); 
    return _tbl2Col(infoSupport);
}
function _formBelanja(){
    fbtnAdd="";
    if(!_.act){
        fbtnAdd=_inpSejajar({
            attrRow:"margin-left:5px;margin-bottom:10px;",
            attrCol:"margin-left:5px;margin-bottom:10px;",
            attrLabel:"color:black",
            judul:"",
            isi:_btn({
                judul:"Tambah Rincian",
                attr:"style='float:right;' onclick='_addJudul()'",
                class:"btn btn-primary btn-block fzMfc"
            })
        });
    }

    return `<div class="row ml-2 shadow" style="margin-top:20px;">`
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Form Belanja</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    sizeCol:undefined,
                    bgHeader:"",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:`<div id="formAdd">`
                            +_inpSejajar({
                                attrRow:"margin-left:5px;margin-bottom:10px;",
                                attrCol:"margin-left:5px;margin-bottom:10px;",
                                attrLabel:"color:black",
                                judul:"Rekening Belanja",
                                isi:_inpDropdonwSelected({
                                        inputType:true,
                                        inputChange:"_changeValRekening",
                                        attrInput:"border-color: yellowgreen; font-size:medium; margin-bottom:20px",
                                        classDropdonw:"form-control p-0 fzMfc",
                                        judul:"Rekening Belanja",
                                        id:"rekening",
                                        idJudul:"jrekening",
                                        idData:"drekening",
                                        data:_.dapbd,
                                        bgSearch:"#283941",
                                        bg:" btn-primary fzMfc",
                                        idDropdonw:"idInpDropRekening",
                                        func:"_selectRekening",
                                        funcSearch:"_formSearchRekening(this)"
                                    })
                            })
                            +_inpSejajar({
                                attrRow:"margin-left:5px;margin-bottom:10px;",
                                attrCol:"margin-left:5px;margin-bottom:10px;",
                                attrLabel:"color:black",
                                judul:"Judul Uraian",
                                isi:_inp({
                                    type:"text",
                                    cls:'form-control fzMfc',
                                    hint:"Judul Uraian",
                                    id:"judul",
                                })
                            })
                            +fbtnAdd
                            +_lines({attr:'background:white;'})
                        +`</div>
                        <div id="formSetting">`
                            
                        +`</div>`
                    
                })
            +`</div>`;
}
function _formPreview(){
    infoSupport1=[];
    // infoSupport1.push({ 
    //     clsBtn:`btn-warning fzMfc`
    //     ,func:"_goIndikator()"
    //     ,icon:`<i class="mdi mdi-file-check"></i>Indikator`
    //     ,title:"Perbarui Indikator"
    // });
    infoSupport1.push({ 
        clsBtn:`btn-primary fzMfc`
        ,func:"_lapoPDF()"
        ,icon:`<i class="mdi mdi-file-check"></i>PDF`
        ,title:"Donwload PDF"
    });
    infoSupport1.push({ 
        clsBtn:`btn-success fzMfc`
        ,func:"_lapoExcell()"
        ,icon:`<i class="mdi mdi-file-check"></i>Excell`
        ,title:"Donwload Excell"
    });
    return `<div class="row ml-2 shadow"  style="margin-top:20px;width: 98%;margin: 0px;padding: 20px;">`
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Dokumen PA</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    btn:_btnGroup(infoSupport1,0),
                    sizeCol:undefined,
                    bgHeader:"bg-info text-light",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:`<div id="formPreview">`
                        +`</div>`                        
                })
            +`</div>`;
}
function _tabelPreview(data) {
    _.totalRealisasi = 0;
    _.totalPagu = 0;
    if(data!=null){
        $('#formSetting').html('');
        _.dtDetailRincian=data.dtDetailRincian;
    }
    $('#formPreview').html(
        _tabelResponsive({
            id:"dtPreview"
            ,isi:_previewRBelanja()
        })
    );
    $('#informasi').html(_infoBelanja()); 
    chartxx();
    // _startTabel("dtPreview");
}

function _changeValRekening(v) {
    if(!$('#rekening').hasClass('show')){
        $('#rekening').addClass("show");
    }
    _multiDropdonwSearch({
        data:_.dapbd,
        idData:"drekening",
        id:"rekening",
        value:v.value,
        cls:'btn-primary fzMfc',
        func:"_selectRekening",
        idDropdonw:"idInpDropRekening",
    })
}
function _selectRekening(idForDrop,id,value,valueName){
    _.sfKdApbd=value;
    $("#"+id).val(valueName.substring(0,50));
    return _showForDropSelect(idForDrop);
}
function _formSearchRekening(v){
    _multiDropdonwSearch({
        data:_.dapbd,
        idData:"drekening",
        id:"rekening",
        value:v.value,
        cls:'btn-primary fzMfc',
        func:"_selectRekening",
        idDropdonw:"idInpDropRekening",
    })
}

function _addJudul(){    
    if(_isNull(_.sfKdApbd))return _toast({bg:'e',msg:'Pilih Rekening Belanja !!!'});
    if(_isNull($('#judul').val()))return _toast({bg:'e',msg:'Judul belum diisi !!!'});

    kdJudul=1;
    _.dtDetailRincian.forEach(v => {
        if(Number(v.kdJudul)>=Number(kdJudul)){
            kdJudul=Number(v.kdJudul)+1;
        }
    });
    _.dtDetailRincian.push({
        nama    :$('#judul').val(),
        jumlah  :0,
        kdSDana:_.dSdana[0].value,
        kdApbd:_.sfKdApbd,
        detail:[],
        status:"belum",
        kdJudul:kdJudul
    });
    _dataTableDetail();
    $('#judul').val('');
}
function _dataTableDetail(){
    var html=_getHeadRincian(),
    tamJudul="",tamDetail="",selected="";
    if(_.dtDetailRincian.length!=0){

        _.dtDetailRincian.forEach((v,i) => {
            if(v.status!="sudah"){
                tamJudul=_getJudulRincian(i,false);
            }
            if(tamJudul.length!=0){
                html+=tamJudul;
            }
            tamDetail="";
            v.detail.forEach((v1,i1) => {
                if(v1.status!="sudah"){
                    selected="";
                    tamDetail+=_setBodyRincian(i,i1,false);
                }
            });
            if(tamDetail.length!=0){
                html+=tamDetail;
            }
        });
    }
    html+=`<tr class="bg-gray-200">
                <td colspan="14" class="text-right">
                    <button class="btn btn-success btn-m btn-icon-split fzMfc" onclick="_save()">
                        <span class="text">Simpan Uraian Belanja</span>
                    </button>
                </td>
            </tr>
        </body>`;
    
    $('#formSetting').html(
        _tabelResponsive({
            id:"dt"
            ,isi:html
        })
    );
    // $('#tabelDetailRincian').html(html);
}


function _setNama(index,next){
    // _log($('#judul'+index).val());
    _.dtDetailRincian[index].nama=$('#judul'+index).val();
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }
}
function _editDataTableDetailPerIndex(a){
    _.sfKeyUpdate=a;
    var html=_getHeadRincian();
    if(_.dtDetailRincian.length!=0){
        html+=_getJudulRincian(a,true);
        for(let b=0;b<_.dtDetailRincian[a].detail.length;b++){
            html+=_setBodyRincian(a,b,true);
        }
    }
    // html+=_getButtonSaveTabelForm("modalUpdate");
    html+=`<tr class="bg-gray-200">
                <td colspan="14" class="text-right">
                    <button class="btn btn-warning btn-sm btn-icon-split fzMfc" onclick="_saveUpd(`+a+`)">
                        <span class="text">Simpan Perubahan</span>
                    </button>
                </td>
            </tr>
        </body>`;
    $('#formSetting').html(
        _tabelResponsive({
            id:"dt"
            ,isi:html
        })
    );
    $('#judul'+a).focus();
    // $('#tabelDetailRincian').html(html);
}

function _setSumberDana(val,index){
    var value = val.value;    
    _.dtDetailRincian[index].nmSDana=$('#kodeSumber')[0][0].lastChild.data;
    _.dtDetailRincian[index].kdSDana=value;
}


function _setSHH(indexJudul,next){
    if(_.dtDetailRincian[indexJudul].kdSDana==0){
        return _toast({bg:'e',msg:'Pilih Sumber Dana !!!'});
    }
    _.dtDetailRincian[indexJudul].detail.push({
        // uraian  :$('#judul').val(),
        uraian  :'',
        status  :"belum",
        jumlah  :"",
        jumlah1 :1,
        satuan1 :"",
        jumlah2 :"",
        satuan2 :"",
        jumlah3 :"",
        satuan3 :"",
        volume  :"",
        satuanVol:"",
        harga   :"",
        idSsh   :0,
        indexJudul:indexJudul
    })
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _dataTableDetail();
    }
}
function _getSHH(indexJudul,next){
    _pageLength=10;
    _.dsshx.forEach(v => {
        v.checked=0;
    });
    
    _.sfKeyUpdate=indexJudul+"|"+next;
    if(_.dtDetailRincian[indexJudul].kdSDana==0){
        return _toast({bg:'e',msg:'Pilih Sumber Dana !!!'});
    }
    _modalEx1({
        judul:"Pilih SSH ".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-warning",
        minWidth:"500px; ",
        isi:_tabelResponsive(
            {
                id:"dtSsh",
                attr:'fzMfc'
                ,isi:_tabel(
                    {
                        // data:_filterSSH(indexJudul)
						data:_.dsshx
                        ,no:1
                        ,kolom:[
                            "nama","satuan","keterangan","harga","checkbox"
                        ]
                        ,namaKolom:[
                            "Nama","Satuan","Keterangan","Harga","Pilih"
                        ],
                        func:'_sshCheck()'
                        // action:infoSupport1
                    })
            }),
        footer:_btn({
                    color:"primary shadow",
                    judul:"Batalkan",
                    attr:`style='float:right; padding:5px;;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"primary shadow",
                    judul:"Tambahkan SSH",
                    attr:"style='float:right; padding:5px;;' onclick='_sshChecked("+indexJudul+","+next+")'",
                    class:"btn btn-primary"
                })
    });
    _startTabel("dtSsh");
    _pageLength=25;
}
function _filterSSH(indJudul){
	// console.log(_.dtDetailRincian[indJudul].kdApbd6);
	ftam =  _.dsshx.filter(v=>v.kodeRekening.split(_.dtDetailRincian[indJudul].kdApbd6).length>1)
	if(ftam.length == 0){
		return _.dsshx;
	}
	return ftam;
}
function _sshCheck(ind,v){
    _.dsshx[ind].checked=v.checked;
}
function _sshChecked(indexJudul,next){
    _modalHide('modal');
    _.dsshx.forEach((v,i) => {
        if(Number(v.checked)){
            _.dtDetailRincian[indexJudul].detail.push({
                uraian  :v.nama,
                status  :"belum",
                jumlah  :v.harga,
                jumlah1 :1,
                satuan1 :v.satuan,
                jumlah2 :"",
                satuan2 :"",
                jumlah3 :"",
                satuan3 :"",
                volume  :1,
                satuanVol:v.satuan.substring(0,1),
                harga   :v.harga,
                idSsh   :Number(v.id),
                indexJudul:indexJudul
            })
        }
    });
    _.dtDetailRincian[indexJudul].jumlah=_getTotalJudul(indexJudul);
    if(next){
        _editDataTableDetailPerIndex(indexJudul);
    }else{
        _dataTableDetail();
    }
    
}


function _setvaluraian(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].uraian=$('#uraian'+index+indexSub).val();
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#jumlah1"+index+indexSub).focus();
}
function _getTotalJudul(index){
    var total=0;
    for(let a=0;a<_.dtDetailRincian[index].detail.length;a++){
        total+=parseFloat(_.dtDetailRincian[index].detail[a].jumlah);
    }
    return total;
}
function _setvaljumlah1(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].jumlah1=$('#jumlah1'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#satuan1"+index+indexSub).focus();
}

function _setvaljumlah2(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].jumlah2=$('#jumlah2'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#satuan2"+index+indexSub).focus();
}

function _setvaljumlah3(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].jumlah3=$('#jumlah3'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#satuan3"+index+indexSub).focus();
}

function _setvalsatuan1(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].satuan1=$('#satuan1'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#jumlah2"+index+indexSub).focus();
}

function _setvalsatuan2(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].satuan2=$('#satuan2'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#jumlah3"+index+indexSub).focus();
}

function _setvalsatuan3(index,indexSub,next){
    _.dtDetailRincian[index].detail[indexSub].satuan3=$('#satuan3'+index+indexSub).val();
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
    $( "#harga"+index+indexSub).focus();
}

function _setvalharga(index,indexSub,next){
    // _log($('#harga'+index+indexSub).val());
    _.dtDetailRincian[index].detail[indexSub].harga=$('#harga'+index+indexSub).val();
    // _log(_.dtDetailRincian[index].detail[indexSub].harga);
    if(next){
        _updateDataEditingTabel(index,indexSub);
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _setUraianDetail(index,indexSub);
    }
}

function _updateDataEditingTabel(a,b){
    var res=_getSatuanTotalHarga(a,b);
    _.dtDetailRincian[a].detail[b].volume=res.volume;
    _.dtDetailRincian[a].detail[b].satuanVol=res.satuanVol;
    _.dtDetailRincian[a].detail[b].jumlah=res.jumlah;
    _.dtDetailRincian[a].jumlah=_totalJumlahDetail(a);
    return null;
}
function _totalJumlahDetail(ind){
    var tot=0;
    for(let a=0;a<_.dtDetailRincian[ind].detail.length;a++){
        tot+=parseInt(_.dtDetailRincian[ind].detail[a].jumlah);
    }
    return tot;
}
function _setUraianDetail(index,indexSub){
    var res=_getSatuanTotalHarga(index,indexSub);
    _.dtDetailRincian[index].detail[indexSub].volume=res.volume;
    _.dtDetailRincian[index].detail[indexSub].satuanVol=res.satuanVol;

    if(res.harga>0){
        _.dtDetailRincian[index].detail[indexSub].jumlah=res.jumlah;
    }
    _.dtDetailRincian[index].jumlah=_getTotalJudul(index);
    _dataTableDetail();
}
function _getSatuanTotalHarga(index,indexSub){
    var 
        jum1=$('#jumlah1'+index+indexSub).val(),
        jum2=$('#jumlah2'+index+indexSub).val(),
        jum3=$('#jumlah3'+index+indexSub).val(),

        sat1=$('#satuan1'+index+indexSub).val(),
        sat2=$('#satuan2'+index+indexSub).val(),
        sat3=$('#satuan3'+index+indexSub).val(),

        sat1=$('#satuan1'+index+indexSub).val(),
        
        harga=$('#harga'+index+indexSub).val(),

        satuan="",
        total=0;
    
    if(jum1.length!=0 && jum1!=0){
        total=jum1;
    }
    if(jum2.length!=0 && jum2!=0){
        total=total*jum2;
    }
    if(jum3.length!=0 && jum3!=0){
        total=total*jum3;
    }

    if(sat1.length!=0){
        satuan=sat1.substring(0,1);
    }
    if(sat2.length!=0){
        satuan=satuan+sat2.substring(0,1);
    }
    if(sat3.length!=0){
        satuan=satuan+sat3.substring(0,1);
    }    
    // _log(_$(double(harga)),"h")
    return {
        volume:total,
        satuanVol:satuan,
        jumlah:harga*total,
        harga:harga
    }
}


function _posisiUp(index,indexDetail,next){
    var tam=_.dtDetailRincian[index].detail[indexDetail];
    _.dtDetailRincian[index].detail[indexDetail]=_.dtDetailRincian[index].detail[indexDetail-1];
    _.dtDetailRincian[index].detail[indexDetail-1]=tam;
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _dataTableDetail();
    }
}
function _posisiDonw(index,indexDetail,next){
    var tam=_.dtDetailRincian[index].detail[indexDetail];
    _.dtDetailRincian[index].detail[indexDetail]=_.dtDetailRincian[index].detail[indexDetail+1];
    _.dtDetailRincian[index].detail[indexDetail+1]=tam;
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _dataTableDetail();
    }
}
function _delete(index,indexDetail,next){
    _.sfKeyUpdate=index+"|"+indexDetail+"|"+next;
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-danger",
        minWidth:"500px; font-size: medium;",
        isi:`Apakah anda ingin menghapus data ini ?`,
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"primary shadow",
                    judul:"SIMPAN",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_deleleUmum()'",
                    class:"btn btn-danger"
                })
    });
    // $('#modalDelete').modal('show');
}
function _deleleUmum(){
    _modalHide('modal');
    var ind=_.sfKeyUpdate.split("|");
    _.dtDetailRincian[ind[0]].jumlah=parseInt(_.dtDetailRincian[ind[0]].jumlah-_.dtDetailRincian[ind[0]].detail[ind[1]].jumlah);
    _.dtDetailRincian[ind[0]].detail.splice(ind[1],1);
    if(ind[2]){
        _editDataTableDetailPerIndex(ind[0]);
    }else{
        _dataTableDetail();
    }
}
function _copyAsNew(index,indexDetail,next){
    // _.dtDetailRincian[index].detail.push(_.dtDetailRincian[index].detail[indexDetail]);
    _.dtDetailRincian[index].detail.push({
        uraian  :_.dtDetailRincian[index].detail[indexDetail].uraian,
        status  :_.dtDetailRincian[index].detail[indexDetail].status,
        jumlah  :_.dtDetailRincian[index].detail[indexDetail].jumlah,
        jumlah1 :_.dtDetailRincian[index].detail[indexDetail].jumlah1,
        satuan1 :_.dtDetailRincian[index].detail[indexDetail].satuan1,
        jumlah2 :_.dtDetailRincian[index].detail[indexDetail].jumlah2,
        satuan2 :_.dtDetailRincian[index].detail[indexDetail].satuan2,
        jumlah3 :_.dtDetailRincian[index].detail[indexDetail].jumlah3,
        satuan3 :_.dtDetailRincian[index].detail[indexDetail].satuan3,
        volume  :_.dtDetailRincian[index].detail[indexDetail].volume,
        satuanVol:_.dtDetailRincian[index].detail[indexDetail].satuanVol,
        harga   :_.dtDetailRincian[index].detail[indexDetail].harga,
        indexJudul:index
    });
    if(next){
        _editDataTableDetailPerIndex(_.sfKeyUpdate);
    }else{
        _dataTableDetail();
    }
} 

function _save(){
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-success",
        minWidth:"500px; font-size: medium;",
        isi:`Simpan uraian belanja ?`,
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"primary shadow",
                    judul:"SIMPAN",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_saveed()'",
                    class:"btn btn-success"
                })
    });
}
function _saveed(){
    var values=`INSERT INTO ubjudul(kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total, tahapan, kdJudul) VALUES `,
        valuesDetail=`INSERT INTO ubrincian(
                    kdRincian, kdJudul, kdSub, kdDinas, uraian, total, 
                    jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, 
                    volume, satuanVol, harga,taRincian,tahapan,idSsh
                ) VALUES `,
        qdel=``;
                
        fkondisi=true;
        _.dtDetailRincian.forEach((v,i) => {
            if(v.status!="sudah" && v.detail.length>0){// judul
                qdel+=`DELETE FROM ubjudul WHERE 
                    kdSUb= `+_valforQuery(_.drenstra.kdSub)+` 
                    and kdDinas=`+_valforQuery(_.drenstra.kdDinas)+`
                    and taJudul=`+_valforQuery(_.tahun)+`
                    and tahapan=`+_valforQuery(_.tahapan)+`
                    and kdJudul=`+v.kdJudul+`
                    and status=1;
                `;
                values+=`
                    (
                        `+_valforQuery(_.drenstra.kdSub)+`,`+_valforQuery(_.drenstra.kdDinas)+`,`+_valforQuery(v.kdApbd)+`,
                        `+_valforQuery(v.kdSDana)+`,`+_valforQuery(v.nama)+`,`+_valforQuery(_.tahun)+`,
                        `+_valforQuery(v.jumlah)+`,`+_valforQuery(_.tahapan)+`,`+v.kdJudul+`
                    ),
                `;

                v.detail.forEach((v1,i1) => {
                    if(v1.status!="sudah" && v.detail.length>0 ){
                        fkondisi=false;
                        if(i1==0){
                            qdel+=`DELETE FROM ubrincian WHERE 
                                kdSUb= `+_valforQuery(_.drenstra.kdSub)+` 
                                and kdDinas=`+_valforQuery(_.drenstra.kdDinas)+`
                                and taRincian=`+_valforQuery(_.tahun)+`
                                and tahapan=`+_valforQuery(_.tahapan)+`
                                and kdJudul=`+v.kdJudul+`
                                and status=1;
                            `;
                        }
                        valuesDetail+=`
                            (
                                `+_valforQuery(i1+1)+`,`+_valforQuery(v.kdJudul)+`,`+_valforQuery(_.drenstra.kdSub)+`,
                                `+_valforQuery(_.drenstra.kdDinas)+`,`+_valforQuery(v1.uraian)+`,`+_valforQuery(v1.jumlah)+`,
                                `+_valforQuery(v1.jumlah1)+`,`+_valforQuery(v1.jumlah2)+`,`+_valforQuery(v1.jumlah3)+`,
                                `+_valforQuery(v1.satuan1)+`,`+_valforQuery(v1.satuan2)+`,`+_valforQuery(v1.satuan3)+`,
                                `+_valforQuery(v1.volume)+`,`+_valforQuery(v1.satuanVol)+`,`+_valforQuery(v1.harga)+`,
                                `+_valforQuery(_.tahun)+`,`+_valforQuery(_.tahapan)+`,`+_valforQuery(v1.idSsh)+`
                            ),
                        `;
                    }
                });
            }
        });
        if(fkondisi){
            return _toast({bg:'e', msg:"Rincian belanja harap ditambahkan !!!"});
        }
        param={
            qdel:qdel,
            judul:values,
            rincian:valuesDetail,
            kdDinas:_.drenstra.kdDinas,
            kdSub:_.drenstra.kdSub,
            tahapan:_.tahapan,
            tahun:_.tahun
        }
        // return console.log(param);
        _post('proses/insBelanja',param).then(res=>{
            res=JSON.parse(res);
            if(res.exec){
                _modalHide('modal');
                _tabelPreview(res.data);
            }else{
                return _toast({bg:'e', msg:res.msg});
            }
        });
        // _ajax("WsBelanjaPegawai/addRincian",{
            // values:values,
            // valuesDetail:valuesDetail
        // }).then(res=>{            
        //     res=JSON.parse(res);
        //     $('#mdlLoad').modal("hide");
        //     if(res.status){
        //       return showNotif(res.msg);
        //     }
        //     _.dtDetailRincian=res[0];
        //     _dataTableDetail();
        //     _setForm("dataViewDetail");
        // })
}

function _saveUpd(index){
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-warning",
        minWidth:"500px; font-size: medium;",
        isi:`Simpan Perubahan pada uraian belanja ?`,
        footer:_btn({
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary shadow"
                })
                +_btn({
                    judul:"SIMPAN",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_saveUpded("+index+")'",
                    class:"btn btn-warning shadow"
                })
    });
}
function _saveUpded(index){
    if(_.dtDetailRincian[index].detail.length==0){
        return _toast({bg:'e', msg:"Rincian belanja harap ditambahkan !!!"});
    }
    var values=``,
        valuesDetail=`INSERT INTO ubrincian(
                    kdRincian, kdJudul, kdSub, kdDinas, uraian, total, 
                    jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, 
                    volume, satuanVol, harga,taRincian,tahapan,idSsh
                ) VALUES `;
        
        values=`update ubjudul set
                    kdSDana=`+_valforQuery(_.dtDetailRincian[index].kdSDana)+`, 
                    nama=`+_valforQuery(_.dtDetailRincian[index].nama)+`, 
                    total=`+_valforQuery(_.dtDetailRincian[index].jumlah)+`
                where kdSUb=`+_valforQuery(_.drenstra.kdSub)+` and  
                    kdDinas=`+_valforQuery(_.drenstra.kdDinas)+` and 
                    taJudul=`+_valforQuery(_.tahun)+` and
                    tahapan=`+_valforQuery(_.tahapan)+` and
                    kdJudul=`+_valforQuery(_.dtDetailRincian[index].kdJudul)+`;
            `;

        _.dtDetailRincian[index].detail.forEach((v1,i1) => {
            valuesDetail+=`
                    (
                        `+_valforQuery(i1+1)+`,`+_valforQuery(_.dtDetailRincian[index].kdJudul)+`,`+_valforQuery(_.drenstra.kdSub)+`,
                        `+_valforQuery(_.drenstra.kdDinas)+`,`+_valforQuery(v1.uraian)+`,`+_valforQuery(v1.jumlah)+`,
                        `+_valforQuery(v1.jumlah1)+`,`+_valforQuery(v1.jumlah2)+`,`+_valforQuery(v1.jumlah3)+`,
                        `+_valforQuery(v1.satuan1)+`,`+_valforQuery(v1.satuan2)+`,`+_valforQuery(v1.satuan3)+`,
                        `+_valforQuery(v1.volume)+`,`+_valforQuery(v1.satuanVol)+`,`+_valforQuery(v1.harga)+`,
                        `+_valforQuery(_.tahun)+`,`+_valforQuery(_.tahapan)+`,`+_valforQuery(v1.idSsh)+`
                    ),
                `;
        })
        param={
            judul:values,
            rincian:valuesDetail,
            kdDinas:_.drenstra.kdDinas,
            kdSub:_.drenstra.kdSub,
            tahapan:_.tahapan,
            tahun:_.tahun,
            kdJudul:_.dtDetailRincian[index].kdJudul
        }
        _post('proses/updBelanja',param).then(res=>{
            res=JSON.parse(res);
            if(res.exec){
                _modalHide('modal');
                _tabelPreview(res.data);
            }else{
                return _toast({bg:'e', msg:res.msg});
            }
        });
}

// setelah ada data 
function _previewRBelanja(){
    var html=`
        <thead style="font-size: small;">
            <tr class="text-center align-middle bg-gray-200">
                <th  width="10%">Kode Rekening</th>
                <th  width="45%">Uraian</th> 
                <th  width="15%">Pagu</th>
                <th   width="15%">Realisasi</th>
                <th   width="15%">Aksi</th>
            </tr>
           
        </thead>
        <tbody>`;
    var kdApbd6="",judul="",kdSDana="",kdApbd1="",kdApbd2="",kdApbd3="",kdApbd4="",kdApbd5;
    for(let a=0;a<_.dtDetailRincian.length;a++){
        if(a==0){ //for sub kegiatan saja
            html+=`
                <tr class="font-weight-bold">
                    <td width="10%"></td>
                    <td colspan="3" width="75%">`+_.dtDetailRincian[a].kdSub+` - `+_.dtDetailRincian[a].nmSub+`</td>
                    <td class="text-center" width="15%"></td>
                </tr>
            `;
        }
        if(kdApbd1!=_.dtDetailRincian[a].kdApbd1){
            _.totalPagu=_getTotalAnakReal(0,_.dtDetailRincian[a].kdApbd1);
             _.totalRealisasi=_getTotalAnak(0,_.dtDetailRincian[a].kdApbd1);
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd1+`</td>
                    <td class="flag1">`+_.dtDetailRincian[a].nmApbd1+`</td>               
                    <td class="text-right">`+_$(_.totalPagu)+`</td>
                    <td class="text-right">`+_$(_.totalRealisasi)+`</td>
                    <td class="text-right"></td>
                </tr>
            `;
            kdApbd1=_.dtDetailRincian[a].kdApbd1;
        }
        if(kdApbd2!=_.dtDetailRincian[a].kdApbd2){
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd2+`</td>
                    <td class="flag1">
                    `+_.dtDetailRincian[a].nmApbd2+`
                    </td>               
                    <td class="text-right">`+_$(_getTotalAnakReal(1,_.dtDetailRincian[a].kdApbd2))+`</td>
                    <td class="text-right">`+_$(_getTotalAnak(1,_.dtDetailRincian[a].kdApbd2))+`</td>
                    <td class="text-right">
                    </td>
                </tr>
            `;
            kdApbd2=_.dtDetailRincian[a].kdApbd2;
        }
        if(kdApbd3!=_.dtDetailRincian[a].kdApbd3){
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd3+`</td>
                    <td class="flag1">
                    `+_.dtDetailRincian[a].nmApbd3+`
                    </td>               
                    <td class="text-right">`+_$(_getTotalAnakReal(2,_.dtDetailRincian[a].kdApbd3))+`</td>
                    <td class="text-right">`+_$(_getTotalAnak(2,_.dtDetailRincian[a].kdApbd3))+`</td>
                    <td class="text-right">
                    </td>
                </tr>
            `;
            kdApbd3=_.dtDetailRincian[a].kdApbd3;
        }
        if(kdApbd4!=_.dtDetailRincian[a].kdApbd4){
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd4+`</td>
                    <td class="flag1">
                    `+_.dtDetailRincian[a].nmApbd4+`
                    </td>               
                    <td class="text-right">`+_$(_getTotalAnakReal(3,_.dtDetailRincian[a].kdApbd4))+`</td>
                    <td class="text-right">`+_$(_getTotalAnak(3,_.dtDetailRincian[a].kdApbd4))+`</td>
                    <td class="text-right">
                    </td>
                </tr>
            `;
            kdApbd4=_.dtDetailRincian[a].kdApbd4;
        }
        if(kdApbd5!=_.dtDetailRincian[a].kdApbd5){
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd5+`</td>
                    <td class="flag1">
                    `+_.dtDetailRincian[a].nmApbd5+`
                    </td>               
                    <td class="text-right">`+_$(_getTotalAnakReal(4,_.dtDetailRincian[a].kdApbd5))+`</td>
                    <td class="text-right">`+_$(_getTotalAnak(4,_.dtDetailRincian[a].kdApbd5))+`</td>
                    <td class="text-right">
                    </td>
                </tr>
            `;
            kdApbd5=_.dtDetailRincian[a].kdApbd5;
        }

        
        if(kdApbd6!=_.dtDetailRincian[a].kdApbd6){
            html+=`
                <tr class="font-weight-bold">
                    <td class="pl-1">`+_.dtDetailRincian[a].kdApbd6+`</td>
                    <td class="flag1">
                    `+_.dtDetailRincian[a].nmApbd6+`
                    </td>               
                    <td class="text-right">`+_$(_getTotalAnakReal(5,_.dtDetailRincian[a].kdApbd6))+`</td>
                    <td class="text-right">`+_$(_getTotalAnak(5,_.dtDetailRincian[a].kdApbd6))+`</td>
                    <td class="text-right">
                    </td>
                </tr>
            `;
            kdApbd6=_.dtDetailRincian[a].kdApbd6;
        } 
        // if(kdSDana!=_.dtDetailRincian[a].kdSDana){
        //     html+=`
        //         <tr class="font-weight-bold">
        //             <td class="pl-1"></td>
        //             <td colspan="5" class="flag1">
        //             `+_.dtDetailRincian[a].nmSDana+`
        //             </td>               
        //             <td class="text-right"></td>
        //             <td class="text-right">
        //             </td>
        //         </tr>
        //     `;
        //     kdSDana=_.dtDetailRincian[a].kdSDana;
        // }       
        if(judul!=_.dtDetailRincian[a].nama){ 
            html+=`
                <tr style="background-color: lightblue;">
                    <td class="pl-1"></td>
                    <td class="flag4">
                    `+_.dtDetailRincian[a].nama+`
                    </td>
                    <td class="text-right pr-1">`+_$(_.dtDetailRincian[a].pagu)+`</td>
                    <td class="text-right pr-1">`+_$(_.dtDetailRincian[a].jumlah)+`</td>
                    <td class="text-right">`;
                    if(!_.act && _.today!=_.dtDetailRincian[a].dateUpdate && _.dtDetailRincian[a].pagu != _.dtDetailRincian[a].jumlah){
                        // if(_.dtDetailRincian[0].keyForPraRka=="0"){
                        
                        html+=`<button title="perbarui nominal realisasi" class="btn btn-success btn-sm" onclick="_goUPBelanja(${a})"><i class="fa fa-check-square"></i></button>`;
                        // html+=`
                        // <div style="margin:auto">
                        //     <button title="Edit Rincian Rekening" class="btn btn-warning btn-sm" onclick="_setEditViewTabel(`+a+`)"><i class="mdi mdi-grease-pencil"></i></button>
                        //     <button title="Hapus Rincian Rekening" class="btn btn-danger btn-sm" onclick="_deleteViewTabel(`+a+`)"><i class="mdi mdi-delete-forever"></i></button>
                        // </div>`;
                    }else{
                        // html+=`<span class="badge badge-danger">TERKUNCI</span>`
                    }
                    
                    html+=`</td>
                </tr>
            `;
            judul=_.dtDetailRincian[a].nama;
        }
        
        // for(let b=0;b<_.dtDetailRincian[a].detail.length;b++){
        //     if(_.dtDetailRincian[a].detail[b].realisasi>0){
        //         _.totalRealisasi += parseFloat(_.dtDetailRincian[a].detail[b].jumlah);
        //     }
        //     const keyCair =  Number(_.dtDetailRincian[a].detail[b].realisasi);
        //     html+=`
        //         <tr class="font-weight-bold">
        //             <td class="pl-1"></td>
        //             <td class="flag4 ${keyCair && 'text-success'}" width="30%">
        //             - `+_.dtDetailRincian[a].detail[b].uraian+`
        //             </td>
        //             <td width="15%">
        //                 `+_getDetailVolume(_.dtDetailRincian[a].detail[b])+`
        //             </td>
        //             <td width="10%">
        //                 `+_.dtDetailRincian[a].detail[b].volume+`
        //             </td>
        //             <td width="10%">
        //                 `+_.dtDetailRincian[a].detail[b].satuanVol+`
        //             </td>
        //             <td width="10%">
        //                 `+_$(_.dtDetailRincian[a].detail[b].harga)+`
        //             </td>
        //             <td class="text-right pr-1">`+_$(_.dtDetailRincian[a].detail[b].jumlah)+`</td>
        //             <td class="text-right">
        //                 ${(
        //                     keyCair == 0 ?
        //                     `<button title="Tandai, dicairkan" class="btn btn-success btn-sm" onclick="_goCair(${a},${b})"><i class="fa fa-check-square"></i></button>`:
        //                     (_.noUser ? `<button title="Tandai, belum dicairkan" class="btn btn-primary btn-sm" onclick="_salahCair(${a},${b})"><i class="fa fa-check-square"></i></button>`:'')
        //                 )}
        //             </td>
        //         </tr>
        //     `;
        // }
    }
    return html+"</tbody>";

}
function _getTotalAnak(anak,kode){ 
    let total=0;
    for(let a=0;a<_.dtDetailRincian.length;a++){
        
        switch(anak){
            case 1:
                if(_.dtDetailRincian[a].kdApbd2==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
            break
            case 2:
                if(_.dtDetailRincian[a].kdApbd3==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
            break;
            case 3:
                if(_.dtDetailRincian[a].kdApbd4==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
            break
            case 4:
                if(_.dtDetailRincian[a].kdApbd5==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
            break;
            case 5:
                if(_.dtDetailRincian[a].kdApbd6==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
            default:
                if(_.dtDetailRincian[a].kdApbd1==kode){
                    total+=parseFloat(_.dtDetailRincian[a].jumlah);
                }
                break
        }
    }
    
    return total;
}
function _getTotalAnakReal(anak,kode){ 
    let total=0;
    for(let a=0;a<_.dtDetailRincian.length;a++){
        
        switch(anak){
            case 1:
                if(_.dtDetailRincian[a].kdApbd2==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
            break
            case 2:
                if(_.dtDetailRincian[a].kdApbd3==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
            break;
            case 3:
                if(_.dtDetailRincian[a].kdApbd4==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
            break
            case 4:
                if(_.dtDetailRincian[a].kdApbd5==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
            break;
            case 5:
                if(_.dtDetailRincian[a].kdApbd6==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
            default:
                if(_.dtDetailRincian[a].kdApbd1==kode){
                    total+=parseFloat(_.dtDetailRincian[a].pagu);
                }
                break
        }
    }
    
    return total;
}
function _getDetailVolume(data){
    var res="";
    if(data.jumlah1>0){
        res+=data.jumlah1+" "+data.satuan1;
    }if(data.jumlah2>0){
        res+=" x "+data.jumlah2+" "+data.satuan2;
    }if(data.jumlah3>0){
        res+=" x "+data.jumlah3+" "+data.satuan3;
    }
    return res;
}

// action preview data
function _setEditViewTabel(index){
    // _setForm("rincianRek");
    _editDataTableDetailPerIndex(index);
    // $( "#judul").focus();
}
function _deleteViewTabel(index){
    _.sfKeyUpdate=index
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-danger",
        minWidth:"500px; font-size: medium;",
        isi:`Hapus Uraian Belanja berdasarkan judul uraian ini ???`,
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"primary shadow",
                    judul:"HAPUS",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_deleteViewTabeled("+index+")'",
                    class:"btn btn-danger"
                })
    });
}
function _deleteViewTabeled(index){
    param={
        kdDinas:_.drenstra.kdDinas,
        kdSub:_.drenstra.kdSub,
        tahapan:_.tahapan,
        tahun:_.tahun,
        kdJudul:_.dtDetailRincian[index].kdJudul
    }
    _post('proses/delBelanja',param).then(res=>{
        _modalHide('modal');
        res=JSON.parse(res);
        if(res.exec){
            _tabelPreview(res.data);
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}


function _lapoPDF() {
    var data =btoa(JSON.stringify({
        kdDinas:_.drenstra.kdDinas,
        kdSub:_.drenstra.kdSub,
        tahapan:_.tahapan,
        tahun:_.tahun,
        nmTahapan:_.nmTahapan,
        totalPagu:_.totalPagu,
        pdf:true
        // tabel:_previewRBelanjaForPDF(),
        // renstra:_getInfoRenstra()
    }));
    _redirectOpen("laporan/rincianBelanja/"+data);
}
function _lapoExcell() {
    var data =btoa(JSON.stringify({
        kdDinas:_.drenstra.kdDinas,
        kdSub:_.drenstra.kdSub,
        tahapan:_.tahapan,
        tahun:_.tahun,
        nmTahapan:_.nmTahapan,
        totalPagu:_.totalPagu,
        pdf:false
    }));
    _redirectOpen("laporan/rincianBelanja/"+data);
}

function _goUPBelanja(Ijudul) {
    _.Ijudul= Ijudul;  
    _modalEx1({
        judul:"Perbarui Realisasi Anggaran".toUpperCase(),
        icon:`<i class="mdi mdi-check"></i>`,
        cform:`text-light`,
        bg:"success",
        minWidth:fsize+"; font-size: medium;",
        isi:`<p>${_.dtDetailRincian[_.Ijudul].nama}</p>`
            +_inpGroupPrepend({
                id:"nowjumlah",placeholder:_.dtDetailRincian[_.Ijudul].jumlah,
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
}
function _goUPBelanjaed() {
    let nowjumlah = $('#nowjumlah').val();
    param={ 
        kdSub:_.drenstra.kdSub,
        kdDinas:_.drenstra.kdDinas,
        tahapan:Number(_.tahapan),  
        jumlah:nowjumlah,
        tahun:_.tahun,
        kdJudul:_.dtDetailRincian[_.Ijudul].kdJudul
    }
    // return console.log(param);
    
    if(_isNull(param.jumlah))return _toast({bg:'e',msg:'Tambahkan Nominal Realisasi Belanja !!!'}); 

    console.log(param.jumlah,_.dtDetailRincian[_.Ijudul].pagu);
    
    if(Number(param.jumlah)>Number(_.dtDetailRincian[_.Ijudul].pagu))return _toast({bg:'e',msg:'nominal melebihi maksimal Realisasi !!!'}); 

    _post('proses/updRealisasiBelanja',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            _modalHide('modal');
            // return _toast({bg:'i', msg:"indikator talah diperbarui"});
            // _reload();
            _.dtDetailRincian[_.Ijudul].jumlah = nowjumlah;
            _tabelPreview();
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}
function _goCair(Ijudul, Idetail) {
    _.Ijudul= Ijudul; 
    _.Idetail=Idetail;
    _modalEx1({
        judul:"Konfirmasi Realisasi Anggaran".toUpperCase(),
        icon:`<i class="mdi mdi-check"></i>`,
        cform:`text-light`,
        bg:"success",
        minWidth:fsize+"; font-size: medium;",
        isi:_inpGroupPrepend({
                id:"Rdate",placeholder:"Tanggal Realisasi",
                cls:'mt-4',attr:";",type:"date",icon:'<i class="mdi mdi-home"></i>',
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
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_prosesCair()'",
                    class:"btn btn-primary"
                })
    }); 
}
function _salahCair(Ijudul, Idetail){
    _.Ijudul= Ijudul; 
    _.Idetail=Idetail;
    _modalEx1({
        judul:"Konfirmasi ".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-primary ",
        minWidth:"500px; font-size: medium; color:gray;",
        isi:`Data ini memang belum direalisasikan ?`,
        footer:_btn({
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary shadow"
                })
                +_btn({
                    judul:"PROSES",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_prosesCair(0)'",
                    class:"btn btn-primary shadow"
                })
    });
}
function _prosesCair(cair=1) {
    let pdate ='';
    if(cair ==1){
        pdate = $('#Rdate').val();
    }
    param={ 
        kdSub:_.drenstra.kdSub,
        kdDinas:_.drenstra.kdDinas,
        tahapan:Number(_.tahapan), 
        date:pdate,
        cair,
        tahun:_.tahun,
        kdJudul:_.dtDetailRincian[_.Ijudul].kdJudul,
        kdRincian:_.dtDetailRincian[_.Ijudul].detail[_.Idetail].kdRincian,
        status:_.dtDetailRincian[_.Ijudul].detail[_.Idetail].status
    }
    // return console.log(param);
    
    if(_isNull(param.date) && cair==1)return _toast({bg:'e',msg:'Tambahkan Tanggal Realisasi Anggaran !!!'}); 

    _post('proses/prosesCair',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            _modalHide('modal');
            // return _toast({bg:'i', msg:"indikator talah diperbarui"});
            // _reload();
            _.dtDetailRincian[_.Ijudul].detail[_.Idetail].realisasi =cair;
            _tabelPreview();
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}
function _goIndikator() {
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-check"></i>`,
        cform:`text-light`,
        bg:"success",
        minWidth:fsize+"; font-size: medium;",
        isi:_findikatorKinerjaUpd(),
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    // color:"success shadow",
                    judul:"Simpan",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='_goIndikatored()'",
                    class:"btn btn-primary"
                })
    });
    $('#lokasiP').val(_.drenstra.lokasiP);
    $('#waktuP').val(_.drenstra.waktuP);
    $('#kelompokS').val(_.drenstra.kelompokS);
    $('#keluaran').val(_.drenstra.keluaran);
    $('#hasil').val(_.drenstra.hasil);
    $('#keluaranT').val(_.drenstra.keluaranT);
    $('#hasilT').val(_.drenstra.hasilT);
}
function _goIndikatored() {
    param={
        kdKeg:_.drenstra.kdKeg,
        kdSub:_.drenstra.kdSub,
        kdDinas:_.drenstra.kdDinas,
        tahapan:Number(_.tahapan),
        lokasiP:$('#lokasiP').val(),
        waktuP:$('#waktuP').val(),
        kelompokS:$('#kelompokS').val(),
        keluaran :$('#keluaran').val(),
        hasil:$('#hasil').val(),
        keluaranT :$('#keluaranT').val(),
        hasilT:$('#hasilT').val(),
        export:0,
    }
    // return console.log(param);
    if(_isNull(param.lokasiP))return _toast({bg:'e',msg:'Tambahkan lokasi pelaksanaan !!!'});
    if(_isNull(param.waktuP))return _toast({bg:'e',msg:'Tambahkan Waktu pelaksanaan !!!'});
    if(_isNull(param.kelompokS))return _toast({bg:'e',msg:'Tambahkan Kelompok Sasaran !!!'});
    if(_isNull(param.keluaran))return _toast({bg:'e',msg:'Tambahkan Keluaran pelaksanaan!!!'});
    if(_isNull(param.hasil))return _toast({bg:'e',msg:'Tambahkan Hasil pelaksanaan!!!'});
    if(_isNull(param.keluaranT))return _toast({bg:'e',msg:'Tambahkan Target Keluaran !!!'});
    if(_isNull(param.hasilT))return _toast({bg:'e',msg:'Tambahkan Target Hasil !!!'});

    try {
        const keluaran = extractNumbers(param.keluaran+" "+param.keluaranT);
        const hasil = extractNumbers(param.hasil+" "+param.hasilT);
        
        param.dkeluaran =JSON.stringify(keluaran);
        param.dhasil =JSON.stringify(hasil);

        if(keluaran.length !=2) throw new Error('monitoring pelaksanaan kegiatan, Keluaran - target harus diisi !!!');
        if(hasil.length !=2) throw new Error('evaluasi dampak program, hasil - target harus diisi !!!');

    } catch (error) {
        _toast({bg:'e',msg:error.message});
    }
    _post('proses/saveExpBelanjaPersatu',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            // _modalHide('modal');
            // return _toast({bg:'i', msg:"indikator talah diperbarui"});
            _reload();
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}
