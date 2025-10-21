function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    
    _.dinas=data.dinas;
    _.ind=0;
    _.files=[];
    _.stMurni=true;
    _.tahun=data.tahun;
    split=_.tahun.split("-");
    _.tahunAPBD=split[0];
    _.ckErrorFile="";
    _.kdDinas=_.dinas[0].value;

    $('#bodyTM').html(_form());
    $('#footer').html(data.tmFooter+data.footer);
    
    _startTabel("dt");
    $('#username').val(_nama);
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
                +_formIcon({
                    icon:'<i class="mdi mdi-file-check"></i>'
                    ,text:"<h3>Import Data DPA</h3>",
                    classJudul:' p-2',
                    id:"form1",
                    btn:_btn({
                        color:"success shadow",
                        judul:"Upload Data",
                        attr:"style='float:right; padding:5px;font-size: medium;' onclick='uploadFile()'",
                        // class:"btn btn-success btn-block"
                    }),
                    sizeCol:undefined,
                    bgHeader:"bg-info text-light",
                    attrHeader:`style="height: max-content;"`,
                    bgForm:"#fff; font-size:15px;",
                    isi:_inpComboBox({
                            judul:"Dinas",
                            id:"kdDinas",
                            color:"black",  
                            data:_.dinas,
                            change:"_changeSubOPD(this)",
                            bg:"bg-warning text-dark",
                            method:"sejajar",
                            attr:"font-size:15px;",
                            index:true
                        })
                        +_inpSejajar({
                            attrRow:"margin-top:10px;",
                            attrCol:"",
                            attrLabel:"color:black",
                            judul:"Sub Kegiatan",
                            isi:_inpDropdonwSelected({
                                judul:"Sub Kegiatan",
                                id:"subc",
                                idJudul:"sub",
                                bg:"bg-warning fzMfc",
                                idData:"msData",
                                data:_.dinas[_.ind].sub,
                                bgSearch:"white; color:black !important;"
                            })
                        })
                        +_inpImageView({
                            attrRow:"margin-top:10px;",
                            id:"file",
                            idView:"files",
                            judul:"Pilih File Excell",
                            color:"black",
                            func:"_selected(this)"
                        })
                        +_inpSejajar({
                            attrRow:"margin-top:10px;",
                            attrCol:"",
                            attrLabel:"color:black",
                            judul:"Status",
                            isi:"Berdasarkan tahun terpilih maka sistem memutuskan bahwa proses yang akan dilakukannya adalah pendataan APBD MURNI & PERUBAHAN Tahun "+_.tahunAPBD
                        })
                        +_lines({attr:'background:white;'})
                        +`<div id='tabelShow' style="margin: auto;">`
                            
                        +`</div>`,
                })
            +`</div>`;
}
function _changeSubOPD(v) {
    // kdDinas
    
    find=Number(v.value);
    _.kdDinas=_.dinas[find].value;
    if(_.dinas[find].data==undefined ||_.dinas[find].data.length==0){
        _post('proses/getSubOpd',{kdDinas:_.dinas[find].value}).then(response=>{
            response=JSON.parse(response);
            if(response.exec){
                return _responDt(response.data,find);
            }else{
                return _toast({bg:'e', msg:response.msg});
            }
        })
    }
    return _responDt(null,find);
}
function _perbaruiAkun() {
    param={
        username:$('#username').val(),
        passOld:$('#passwordOld').val(),
        passNew:$('#passwordNew').val()
    }
    _post('proses/perbaruiAkun',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            // _modalHide('modal');
            _redirect("control/logout");
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}
function setTabel(){
    full=false;
    if (_.files.length>0 && Object.keys(_.files[0]).length>10) {
        full=true;
        _.stMurni=false;
    }
    //  
    html=`
      <thead style="font-size: small;">
        <tr>            
            <th colspan="5">Keterangan</th>
            <th colspan="6">APBD Murni</th>
            `+(full?`<th colspan="6">APBD Perubahan</th>`:"")+`
        </tr>
        <tr>            
            <th>Ind</th>
            <th>Status</th>
            <th>No Judul</th>
            <th>No Rincian</th>
            <th>No Rek</th>
            <th>Judul</th>
            <th>Volume</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>PPN</th>
            <th>Total</th>
            `+(
                full?
                `<th>Volume</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>PPN</th>
                <th>Total</th>`:""
            )+`
        </tr>
        </thead>
        
      <tbody style="font-size: small;">`;
        _.files.forEach((v,i) => {
            if(i>0){ // menghapus judul
            // if(i==36){
                fkondisi=(v[0]=="judul"?true:fkondisi=false);
                // update data 
                updJudul=(fkondisi?
                        splitInd(v[4].trim(),"[-] ",1):
                        splitInd(v[4].trim(),"Spesifikasi :",0)
                    );
                v[4]=String(updJudul).replace(/(\r\n|\n|\r)/gm, " ");

                updVol=(fkondisi?
                    "":splitVolume(_rmSpace(String(v[5]).replace(/(\r\n|\r\r|\n|\r)/gm, " ")),i,true)
                )
                v[5]={v:updVol};

                updSat=(fkondisi?"":v[6]);
                v[6]=updSat;

                updHarga=(fkondisi?"":v[7]);
                v[7]=updHarga;

                updPpn=(fkondisi?"":v[8]);
                v[8]=updPpn;

                updVol1=(fkondisi?
                    "":
                    splitVolume(_rmSpace(String(v[10]).replace(/(\r\n|\n|\r)/gm," ")),i,false)
                )
                v[10]={v:updVol1};

                updSat1=(fkondisi?"":v[11]);
                v[11]=updSat1;

                updHarga1=(fkondisi?"":v[12]);
                v[12]=updHarga1;

                updPpn1=(fkondisi?"":v[13]);
                v[13]=updPpn1;

                html+=`
                    <tr>            
                        <td>`+i+`</td>
                        <td>`+(fkondisi?v[0]:"")+`</td>
                        <td>`+v[2]+`</td>
                        <td>`+(fkondisi?"":v[3])+`</td>
                        <td>`+v[1]+`</td>
                        
                        <td>`+v[4]+`</td>
                        <td>`+v[5].v+`</td>
                        <td>`+v[6]+`</td>
                        <td>`+v[7]+`</td>
                        <td>`+v[8]+`</td>
                        <td>`+v[9]+`</td>
                        `+(
                            full?
                            `<td>`+v[10].v+`</td>
                            <td>`+v[11]+`</td>
                            <td>`+v[12]+`</td>
                            <td>`+v[13]+`</td>
                            <td>`+v[14]+`</td>`:""
                        )+`
                    </tr>
                `;
            }
        });
    html+=`</tbody>`;
    // infoSupport1=[];
    // infoSupport1.push({ 
    //     clsBtn:`btn-outline-warning fzMfc`
    //     ,func:"updData()"
    //     ,icon:`<i class="mdi mdi-grease-pencil"></i>`
    //     ,title:"Perbarui"
    // });
    // infoSupport1.push({ 
    //     clsBtn:`btn-outline-danger fzMfc`
    //     ,func:"delData()"
    //     ,icon:`<i class="mdi mdi-delete-forever"></i>`
    //     ,title:"Hapus"
    // });
    return _tabelResponsive(
        {
            id:"dt"
            ,isi:html
        });;
}
function splitInd(text,split,ind) {
    try {
        ftam=text.split(split);
        // console.log(ftam);
        if (ftam.length==1) {
            ftam=text.split("\r");
            return String(ftam[ind]).trim();
        }
       return ftam[ind];
    } catch (error) {
        return text;
    }
}
function splitVolume(text,ind,sebelum) {
    ftam=text.split("x"); // 1. PISAHKAN beberapa satuannya
    resp=[];
    fkondisi=false;
    fvol=0;
    fsat="";
    for (let i=0; i<3;i++) {
        ftam1=String(ftam[i]).trim().split(" "); // 2. PISAHKAN volume dan satuannya 
        if(ftam1.length==2){
            if(i>0){ // karena perkalian
                fvol*=Number(ftam1[0]);
            }else{
                fvol=Number(ftam1[0]);
            }
            fsat+=String(ftam1[1]).substring(0,1);
            resp[i]={
                vol:ftam1[0],
                sat:ftam1[1]
            }
        }else{
            if(ftam1[0]=="undefined"){
                resp[i]={
                    vol:"",
                    sat:""
                }
            }else{
                if(text.trim().length==0 || Number(text)==0){ // adanya ini karena ada yangg volume nya "" 
                    resp[i]={
                        vol:"",
                        sat:""
                    }
                }else{
                    fkondisi=true;
                    resp[i]={
                        er:"volume dan satuannya tidak terdeteksi"
                    }   
                }
            }
            
        }
        
    }
    // ftam.forEach((v,i) => {
    //     ftam1=String(v).trim().split(" "); // 2. PISAHKAN volume dan satuannya
        // try {
        //     resp[i]={
        //         ex:true,
        //         vol:ftam1[0],
        //         sat:ftam1[1]
        //     }
        // } catch (error) {
        //     fkondisi=true;
        //     resp[i]={
        //         ex:false,
        //         er:"volume dan satuannya tidak terdeteksi"
        //     }
        // }
    // });

    if (fkondisi) {
        _.ckErrorFile+=`baris ke `+ind+`. volume dan satuannya tidak terdeteksi <br>`;
        return "error";
    }
    // console.log(resp);
    // console.log({vol:fvol,sat:fsat});
    if(sebelum){
        _.files[ind].satvolx=resp;
        _.files[ind].satvolx1={vol:fvol,sat:fsat};
    }else{
        _.files[ind].satvoly1={vol:fvol,sat:fsat};
        _.files[ind].satvoly=resp;
    }
    return text;
}
function _selected(v) {
    _.ckErrorFile="";
    _respon([]);
    _readExcel(v).then(v=>{
        if(v.exec){
            // $('#modal').modal("hide");
            _respon(v.data);
        }else{
            _toast({msg:"Error while parsing Excel file. See console output for the error stack trace"});
        }
    })
    // $('#modal').modal("hide");
}

function _respon(data){
    if(data!=null){
        // console.log(data);
        _.files=data;
    }
    // console.log(_.files);
    $('#tabelShow').html(setTabel());
    _startTabel("dataTabel");
}

function uploadFile() {
    param={
        kdDinas:_.kdDinas,
        kdSub:_tamp1,
    }
    if (!_.ckErrorFile=="") {
        return _modalEx1({
            judul:"List Error".toUpperCase(),
            icon:`<i class="mdi mdi-note-plus"></i>`,
            cform:`text-light`,
            bg:"bg-danger",
            minWidth:"500px; font-size: medium;",
            isi:_.ckErrorFile,
            footer:_btn({
                        color:"primary shadow",
                        judul:"Close",
                        attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                        class:"btn btn-secondary"
                    })
        });
    }
    if(_isNull(param.kdDinas))return _toast({bg:'e',msg:'Pilih Dinas !!!'});
    if(_isNull(param.kdSub))return _toast({bg:'e',msg:'Pilih Sub Kegiatan !!!'});
    if (_.files.length==0) return _toast({bg:'e',msg:'Pilih File Excell !!!'});
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-success",
        minWidth:"500px; font-size: medium;",
        isi:_inpComboBox({
                judul:"Data APBD",
                id:"ktData",
                color:"black",  
                data:(
                        _.stMurni?
                        [
                            {value:"murni",valueName:"MURNI"},
                            {value:"perubahan",valueName:"PERUBAHAN"},
                        ]:
                        [
                            {value:"perubahan",valueName:"PERUBAHAN"},
                            {value:"saduana",valueName:"MURNI & PERUBAHAN"},
                        ]
                    ),
                bg:"bg-warning text-dark",
                method:"sejajar",
                attr:"font-size:15px;",
                // index:true
            })
            +"<br>upload data "+(_.stMurni?" APBD MURNI":" APBD MURNI & PERUBAHAN ")+" ???",
        footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"success shadow",
                    judul:"SIMPAN",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='uploadFileed()'",
                    class:"btn btn-success"
                })
    });
}
function uploadFileed() {
    ktData=$('#ktData').val();
    param={
        kdDinas:_.kdDinas,
        kdSub:_tamp1,
        tahun:_.tahunAPBD,
        tahunP:_.tahunAPBD+"-1",
        kdSDana:1,
        thMurni:4,
        thPerubahan:1,
    }
    
    var judulM=`INSERT INTO ubjudul(kdSUb, kdDinas, kdApbd6, kdSDana, nama, taJudul, total, tahapan, kdJudul,qdel) VALUES `,
        rincianM=`INSERT INTO ubrincian(
                    kdRincian, kdJudul, kdSub, kdDinas, uraian, total, 
                    jumlah1, jumlah2, jumlah3, satuan1, satuan2, satuan3, 
                    volume, satuanVol, harga,taRincian,tahapan,qdel
                ) VALUES `,
        qdel=``;
    _.files.forEach((v,i) => {
        if (i>0) { // hilangkan judulnya
        // if (i==36) { // hilangkan judulnya
            if (ktData=="murni" || ktData=="saduana") {
                if (i==1) { // for q del saja
                    qdel+=`delete from ubjudul where kdSUb=`+_valforQuery(param.kdSub)+` and kdDinas=`+_valforQuery(param.kdDinas)+` 
                            and taJudul=`+_valforQuery(param.tahun)+` and tahapan=`+_valforQuery(param.thMurni)+`;
                        delete from ubrincian where kdSUb=`+_valforQuery(param.kdSub)+` and kdDinas=`+_valforQuery(param.kdDinas)+` 
                            and taRincian=`+_valforQuery(param.tahun)+` and tahapan=`+_valforQuery(param.thMurni)+`;`;
                }
                // console.log(v);
                if(Number(v[9])>0){ // get qdelete  >0 artinya ada total belanjanya 
                    // dan untuk tidak menambahkan data ini ke murni sebab data ini hanya ada pada APBDP
                    
                    if(v[0]=="judul"){
                        judulM+=`(
                                `+_valforQuery(param.kdSub)+`,`+_valforQuery(param.kdDinas)+`,`+_valforQuery(v[1])+`,
                                `+_valforQuery(param.kdSDana)+`,`+_valforQuery(v[4])+`,`+_valforQuery(param.tahun)+`,
                                `+_valforQuery(v[9])+`,`+_valforQuery(param.thMurni)+`,`+v[2]+`,`+_valforQuery("")+`
                            ),`;
                    }else{
                        rincianM+=`(
                                `+_valforQuery(v[3])+`,`+_valforQuery(v[2])+`,`+_valforQuery(param.kdSub)+`,
                                `+_valforQuery(param.kdDinas)+`,`+_valforQuery(v[4])+`,`+_valforQuery(v[9])+`,
                                `+_valforQuery(v.satvolx[0].vol)+`,`+_valforQuery(v.satvolx[1].vol)+`,`+_valforQuery(v.satvolx[2].vol)+`,
                                `+_valforQuery(v.satvolx[0].sat)+`,`+_valforQuery(v.satvolx[1].sat)+`,`+_valforQuery(v.satvolx[2].sat)+`,
                                `+_valforQuery(v.satvolx1.vol)+`,`+_valforQuery(v.satvolx1.sat)+`,`+_valforQuery(v[7])+`,
                                `+_valforQuery(param.tahun)+`,`+_valforQuery(param.thMurni)+`,`+_valforQuery("")+`
                            ),`;
                    }
                }
            }
            if (ktData=="perubahan" || ktData=="saduana") {
                if (i==1) { // for q del saja
                    qdel+=`delete from ubjudul where kdSUb=`+_valforQuery(param.kdSub)+` and kdDinas=`+_valforQuery(param.kdDinas)+` 
                            and taJudul=`+_valforQuery(param.tahunP)+` and tahapan=`+_valforQuery(param.thPerubahan)+`;
                        delete from ubrincian where kdSUb=`+_valforQuery(param.kdSub)+` and kdDinas=`+_valforQuery(param.kdDinas)+` 
                            and taRincian=`+_valforQuery(param.tahunP)+` and tahapan=`+_valforQuery(param.thPerubahan)+`;`;
                }
                fqdel=0;
                if(Number(v[9])>0){ // get qdelete  >0 artinya ada total belanjanya
                    fqdel=1;
                }
                if(v[0]=="judul"){
                    judulM+=`(
                            `+_valforQuery(param.kdSub)+`,`+_valforQuery(param.kdDinas)+`,`+_valforQuery(v[1])+`,
                            `+_valforQuery(param.kdSDana)+`,`+_valforQuery(v[4])+`,`+_valforQuery(param.tahunP)+`,
                            `+_valforQuery(v[14])+`,`+_valforQuery(param.thPerubahan)+`,`+v[2]+`,`+_valforQuery(fqdel)+`
                        ),`;
                }else{
                    rincianM+=`(
                            `+_valforQuery(v[3])+`,`+_valforQuery(v[2])+`,`+_valforQuery(param.kdSub)+`,
                            `+_valforQuery(param.kdDinas)+`,`+_valforQuery(v[4])+`,`+_valforQuery(v[14])+`,
                            `+_valforQuery(v.satvoly[0].vol)+`,`+_valforQuery(v.satvoly[1].vol)+`,`+_valforQuery(v.satvoly[2].vol)+`,
                            `+_valforQuery(v.satvoly[0].sat)+`,`+_valforQuery(v.satvoly[1].sat)+`,`+_valforQuery(v.satvoly[2].sat)+`,
                            `+_valforQuery(v.satvoly1.vol)+`,`+_valforQuery(v.satvoly1.sat)+`,`+_valforQuery(v[12])+`,
                            `+_valforQuery(param.tahunP)+`,`+_valforQuery(param.thPerubahan)+`,`+_valforQuery(fqdel)+`
                        ),`;
                }
            }
        }
    });
    judulM  =judulM.substring(0,judulM.length-1);
    rincianM=rincianM.substring(0,rincianM.length-1);
    // return $('.modal-body').html();
    param={qdel:qdel,query:judulM+";"+rincianM};
    
    // return console.log(param);   
    // return console.log(param);
    _post('proses/saveImportExcell',param).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            _modalHide('modal');
            _respon([]);
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
}

function _responDt(data,ind){
    _.ind=ind;
    if(data!=null){
        _.dinas[_.ind].sub=data.data;
    }
    if(_.dinas[_.ind].sub==undefined){
        _.dinas[_.ind].sub=[];
    }

    $('#kdDinas').html(_inpComboBox({
        id:"kdDinas",
        data:_.dinas,
        change:"_changeSubOPD(this)",
        index:true,
        inSelect:"bagus H"
    }));
    $('#kdDinas').val(ind);
    dropdonw.data=_.dinas[_.ind].sub;
    _inpDropdonwSelectedSearch({value:""})
    _tamp1=null;
    // _multiDropdonwSearch({
    //     data:_.dinas[_.ind].sub,
    //     idData:"dsub",
    //     id:"subc",
    //     value:"",
    //     cls:'btn-primary fzMfc',
    //     idDropdonw:"idInpDropSub",
    // })
}



