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
    _.bulan =1;

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
                    isi:
                        _inpComboBox({
                            judul:"Pilih Bulan",
                            id:"kdDinas",
                            color:"black",  
                            data:bulan,
                            change:"_changeSubOPD(this)",
                            bg:"bg-warning text-dark",
                            method:"sejajar",
                            attr:"font-size:15px;",
                            index:true
                        })
                        +(
                            _.dinas[_.ind].sub != undefined ?
                            _inpSejajar({
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
                            }):''
                        )
                        +_inpImageView({
                            attrRow:"margin-top:10px;",
                            id:"file",
                            idView:"files",
                            judul:"Pilih File Excell",
                            color:"black",
                            func:"_selected(this)"
                        })
                        // +_inpSejajar({
                        //     attrRow:"margin-top:10px;",
                        //     attrCol:"",
                        //     attrLabel:"color:black",
                        //     judul:"Status",
                        //     isi:"Berdasarkan tahun terpilih maka sistem memutuskan bahwa proses yang akan dilakukannya adalah pendataan APBD MURNI & PERUBAHAN Tahun "+_.tahunAPBD
                        // })
                        +_lines({attr:'background:white;'})
                        +`<div id='tabelShow' style="margin: auto;">`
                            
                        +`</div>`,
                })
            +`</div>`;
}
function _changeSubOPD(v) {
    // kdDinas
    _.bulan=Number(v.value);
    // find=Number(v.value);
    // _.kdDinas=_.dinas[find].value;
    // if(_.dinas[find].data==undefined ||_.dinas[find].data.length==0){
    //     _post('proses/getSubOpd',{kdDinas:_.dinas[find].value}).then(response=>{
    //         response=JSON.parse(response);
    //         if(response.exec){
    //             return _responDt(response.data,find);
    //         }else{
    //             return _toast({bg:'e', msg:response.msg});
    //         }
    //     })
    // }
    // return _responDt(null,find);
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
    var reader = new FileReader();
    reader.onload = onReaderLoad;
    reader.readAsText(v.files[0]); 
}
function onReaderLoad(event){
    // console.log(JSON.parse(event.target.result));
    _respon( JSON.parse(event.target.result));
    // alert_data(obj.name, obj.family);
    
}

function _respon(data){
    if(data!=null){
        _.files=data;
        _.kdDinas = data.kode_skpd; 
    } 

    // $('#tabelShow').html(`<pre>${JSON.stringify(_.files)}`);
    // _startTabel("dataTabel");
}

function uploadFile() {
    // param={
    //     kdDinas:_.kdDinas,
    //     kdSub:_tamp1,
    // }
    // if (!_.ckErrorFile=="") {
    //     return _modalEx1({
    //         judul:"List Error".toUpperCase(),
    //         icon:`<i class="mdi mdi-note-plus"></i>`,
    //         cform:`text-light`,
    //         bg:"bg-danger",
    //         minWidth:"500px; font-size: medium;",
    //         isi:_.ckErrorFile,
    //         footer:_btn({
    //                     color:"primary shadow",
    //                     judul:"Close",
    //                     attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
    //                     class:"btn btn-secondary"
    //                 })
    //     });
    // }
    // if(_isNull(param.kdDinas))return _toast({bg:'e',msg:'Pilih Dinas !!!'});
    // if(_isNull(param.kdSub))return _toast({bg:'e',msg:'Pilih Sub Kegiatan !!!'});
    // if (_.files.length==0) return _toast({bg:'e',msg:'Pilih File Excell !!!'});
    _modalEx1({
        judul:"Konfirmasi".toUpperCase(),
        icon:`<i class="mdi mdi-note-plus"></i>`,
        cform:`text-light`,
        bg:"bg-success",
        minWidth:"500px; font-size: medium;",
        isi:"Apakah anda yakin untuk mengupload data realisasi ini ?"
            // _inpComboBox({
            //     judul:"Data APBD",
            //     id:"ktData",
            //     color:"black",  
            //     data:(
            //             _.stMurni?
            //             [
            //                 {value:"murni",valueName:"MURNI"},
            //                 {value:"perubahan",valueName:"PERUBAHAN"},
            //             ]:
            //             [
            //                 {value:"perubahan",valueName:"PERUBAHAN"},
            //                 {value:"saduana",valueName:"MURNI & PERUBAHAN"},
            //             ]
            //         ),
            //     bg:"bg-warning text-dark",
            //     method:"sejajar",
            //     attr:"font-size:15px;",
            //     // index:true
            // })
            // +"<br>upload data "+(_.stMurni?" APBD MURNI":" APBD MURNI & PERUBAHAN ")+" ???",
        ,footer:_btn({
                    color:"primary shadow",
                    judul:"Close",
                    attr:`style='float:right; padding:5px;font-size: medium;' onclick="_modalHide('modal')"`,
                    class:"btn btn-secondary"
                })
                +_btn({
                    color:"success shadow",
                    judul:"upload",
                    attr:"style='float:right; padding:5px;font-size: medium;' onclick='uploadFileedNew()'",
                    class:"btn btn-success"
                })
    });
}
function uploadFileed() {
    ktData=$('#ktData').val();
    let th =_.tahun;
    if(ktData!="murni"){
        th+='-1';
    }
    let fquery = 'INSERT INTO psub (kdSub, kdKeg, kdDinas, nmSub, pagu,taSub) values '; 
    
    let fqueryJudul = `INSERT INTO ubjudul (
        kdSUb, kdDinas,kdApbd6, kdSDana,
        nama, taJudul,total,tahapan,kdJudul
    ) values `; 
    // const djudul = _.files.judul;

    const tblRincian =`INSERT INTO ubrincian (
        kdRincian, kdJudul, kdSUb, kdDinas, uraian, total, jumlah1, satuan1, jumlah2,satuan2,jumlah3,
        satuan3, volume, satuanVol, harga,taRincian,tahapan,idSsh
    ) values `;
    let fqueryJudulRincian = tblRincian, 
        dtamJudul=[],catatTotal=0, kdRincian=0,kdJudul=0,hitRincian=0,no=0; 
    let fqdel='';
    
    const qexec = [];
    hitRincian=1; 
    // .filter(v=>v.kode_sub_giat == '1.06.05.2.02.0003') 
    console.log(_.files.sub.filter(v=>v.kode_sub_giat == '1.06.05.2.02.0003'));
    _.files.sub.filter(v=>v.kode_sub_giat == '1.06.05.2.02.0003').forEach((v,i) => {
        if(i==0){ 
            fqdel=`
                DELETE FROM ubjudul  WHERE taJudul='${th}' and kdDinas='${v.kode_skpd}';
                DELETE FROM ubrincian WHERE taRincian='${th}' and kdDinas='${v.kode_skpd}';
                DELETE FROM psub WHERE kdDinas='${v.kode_skpd}' AND taSub='${th}';
            `;
        }
        try {
            if(v.judul.length!=0){
                fquery+=`(
                    '${v.kode_sub_giat}','${v.kode_giat}','${v.kode_skpd}',
                    '${v.nama_sub_giat}','${v.pagu}','${th}'
                ),`;
                // dtamJudul=v.rincian.map(({ id_subs_sub_bl }) => id_subs_sub_bl);
                
                
                // id_sub_bl: 20198
                // id_subs_sub_bl: 47470
                
                // dtamJudul=[...new Set(dtamJudul)]; && v.ket_bl_teks=="Belanja ATK Kegiatan"
                let kdJudul =1;
                v.judul.filter(v=>v.id_ket_sub_bl  ).forEach((v3,i3) => { 
                    kdRincian=1
                    // frincian = v.rincian.filter(fv=>fv.id_subs_sub_bl==v3.id_subs_sub_bl);
                    const frincian1 = v.rincian.filter(fv=>fv.id_ket_sub_bl==v3.id_ket_sub_bl);
                    
                    const countRekening = [...new Set(frincian1.map(v=>v.kode_akun))]; 
                    countRekening.forEach((v4,i4) => {
                        const frincian = frincian1.filter(fv=>fv.kode_akun== v4 && parseFloat(fv.total_harga)>0); 
                        catatTotal = 0; 
                        frincian.forEach((v2,i2) => { 
                            const { jumlah1,jumlah2,jumlah3,
                                satuan1,satuan2,satuan3,
                                volume,satuanVol } = hitungJumlah(v2.koefisien !=null?v2.koefisien:v2.koefisien_murni); 
                            let total = (v2.total_harga!=null?v2.total_harga:v2.total_harga_murni);
                            const harga = (v2.harga_satuan!=null?v2.harga_satuan:v2.harga_satuan_murni);
                            if(total != (harga*volume)){
                                total = (harga*volume);
                            } 
                            fqueryJudulRincian+=`(
                                '${kdRincian}','${kdJudul}','${v.kode_sub_giat}','${v.kode_skpd}',
                                '${_checkStrQuery((v2.nama_standar_harga==null?v2.nama_akun:v2.nama_standar_harga))}',
                                '${total}','${jumlah1}','${satuan1}','${jumlah2}','${satuan2}',
                                '${jumlah3}','${satuan3}',
                                '${volume}','${satuanVol}','${harga}','${th}',1,
                                ''
                            ),`;
                            kdRincian++;
                            catatTotal+=volume*harga;
                            
                            if (i2==(frincian.length-1)) { 
                                fqueryJudul+=`(
                                    '${v.kode_sub_giat}','${v.kode_skpd}','${v2.kode_akun}',1,
                                    '${_checkStrQuery("["+(kdJudul)+"] "+v3.ket_bl_teks)}','${th}','${catatTotal}',1,
                                    '${kdJudul}'
                                ),`;
                                kdJudul++;
                            }
                            if (no>(hitRincian*400)) {
                                qexec.push(fqueryJudulRincian.substring(0,fqueryJudulRincian.length-1));
                                fqueryJudulRincian=tblRincian;
                                hitRincian++;
                            }
                            no++;
                        })
                    }); 
                });
            }
        } catch (error) {
            
        }
         
    });

    if(fqueryJudulRincian.length>10){
        qexec.push(fqueryJudulRincian.substring(0,fqueryJudulRincian.length-1));
    }
    
    qexec.push(fquery.substring(0,fquery.length-1));
    qexec.push(fqueryJudul.substring(0,fqueryJudul.length-1));
    
    console.log(qexec[qexec.length-1]);
    // qexec.push(); 
    // 5.01.0.00.0.00.01.0000
    // $('#tabelShow').html(qexec[0]+"<br>"+qexec[1]); 

    // 197505072002121003
    // return qexec.forEach(async element => { console.log(element);})

   
    // new Promise((resolve, reject) => {
    //     param={  
    //         tahun:th,
    //         qexec:fqdel
    //     }
        // _post('proses/saveImportExcellSIPD',param).then(res=>{
        //     res=JSON.parse(res);
        //     if(res.exec){ 
        //         resolve({})
        //     }else{
        //         return _toast({bg:'e', msg:res.msg});
        //     }
        // });
        
    // }).then(v=>{
        // qexec.forEach(async element => {
        //     param={  
        //         tahun:th,
        //         qexec:element
        //     } 
        //     await _post('proses/saveImportExcellSIPD',param).then(res=>{
        //         res=JSON.parse(res);
        //         if(res.exec){ 
        //         }else{
        //             console.log(element);
        //             return _toast({bg:'e', msg:res.msg});
        //         }
        //     }); 
        // }) 
    // }) 
 
}
function uploadFileedNew() {
     _postFile('proses/saveImportJsonRealisasi',{bulan:_.bulan},rangkumDataClean()).then(res=>{
        res=JSON.parse(res);
        if(res.exec){ 
            resolve({})
        }else{
            return _toast({bg:'e', msg:res.msg});
        }
    });
    

}
function hitungJumlah(value) {
    const multi = value.split(" x ");
    let resp = [];
    if(multi.length>1){
        multi.forEach((v,i)=>{
            resp = resp.concat(hitungJumlahSpace(v));
        })
    }else{ 
        resp = resp.concat(hitungJumlahSpace(value));
    }

    let jumlah1=0,satuan1='',jumlah2=0,satuan2='',jumlah3=0,satuan3='',volume=0,satuanVol='';  
    resp.forEach((v,i) => {
        switch (i) {
            case 0:
                jumlah1=parseFloat(v);
                volume+=parseFloat(v);
            break;
            case 1:
                satuan1=v;
                satuanVol+=v.substring(0,1);
            break;
            case 2:
                jumlah2=parseFloat(v);
                volume*=parseFloat(v);
            break;
            case 3:
                satuan2=v;
                satuanVol+=v.substring(0,1);
            break;
            case 4:
                jumlah3=parseFloat(v);
                volume*=parseFloat(v);
            break;
            case 5:
                satuan3=v;
                satuanVol+=v.substring(0,1);
            break;
        }
    });
    return {
        jumlah1,jumlah2,jumlah3,
        satuan1,satuan2,satuan3,
        volume,satuanVol
    }
}
function hitungJumlahSpace(value){
    const multi = value.split(" "); 
    const multiRemove = multi.filter(v=>v!='' && v!='/' && v!='-'); 
    if(multiRemove.length>1 && (multiRemove.length%2)==0){ 
        if(!parseInt(multiRemove[2])>0){
            multi[1] =  multi.slice(1, multi.length).join(" "); 
            return [multi[0],multi[1]]
        }
        return  multiRemove;
    }else if(multiRemove.length>1){ 
        multi[1] =  multi.slice(1, multi.length).join(" "); 
        return [multi[0],multi[1]]
    };
    return [value,''];
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



function rangkumData() {
    const resp = {
        rek:{
            l1:[],
            l2:[],
            l3:[],
            l4:[],
            l5:[],
            l6:[],
        },
        urus:{
            u1:[],
            u2:[],
            u3:[],
            u4:[],
            u5:[],
        },
        judul:[]
    }
    Object.keys(_.files).forEach(x => {  
        if(typeof(_.files[x])==="object"){
            try {
                _.files[x].forEach(v => {
                    if(v.kode_akun!=undefined){
                        switch (v.kode_akun.length) {
                            case 1: resp.rek.l1.push({kd:v.kode_akun, nm:v.nama_akun}); break;
                            case 3: resp.rek.l2.push({kd:v.kode_akun, nm:v.nama_akun}); break;
                            case 6: resp.rek.l3.push({kd:v.kode_akun, nm:v.nama_akun}); break;
                            case 7:  resp.urus.u3.push({kd:v.kode_akun, nm:v.nama_akun}); break;
                            case 9:  resp.rek.l4.push({kd:v.kode_akun, nm:v.nama_akun}); break;
                            case 12: 
                                if(_.kdDinas.substring(0,3)==v.kode_akun.substring(0,3)){
                                    resp.urus.u4.push({kd:v.kode_akun, nm:v.nama_akun});
                                }else{
                                    resp.rek.l5.push({kd:v.kode_akun, nm:v.nama_akun});
                                }
                            break;
                            case 17: 
                                if(_.kdDinas.substring(0,3)==v.kode_akun.substring(0,3)){
                                    resp.urus.u5.push({kd:v.kode_akun, nm:v.nama_akun});
                                }else{
                                    resp.judul.push(v);
                                    resp.rek.l6.push({kd:v.kode_akun, nm:v.nama_akun});
                                }
                            break;
                            default:
                                break;
                        }
                    }
                });
            } catch (error) {
                console.log(_.files[x]);
                
            }
        }
    });
    return resp;
}
function rangkumDataClean() {
    const xdt = rangkumData();
    const resp =bersihkanDuplikat(xdt.urus.u5).map(v=>({...v, 
        judul:xdt.judul.filter(fv=>fv.kode_unik.split(v.kd).length>1)
    })); 
    return resp;
}
function bersihkanDuplikat(array) {
  const unik = [];
  const map = new Map();

  for (const item of array) {
    if (!map.has(item.kd)) {
      map.set(item.kd, true);
      unik.push(item);
    }
  }

  return unik;
}

function uploadFileedDoles() {
    let fquery = 'INSERT INTO psub (kdSub, kdKeg, kdDinas, nmSub, pagu,taSub) values '; 
    
    let fqueryJudul = `INSERT INTO ubjudul (
        kdSUb, kdDinas,kdApbd6, kdSDana,
        nama, taJudul,total,tahapan,kdJudul
    ) values `; 
    // const djudul = _.files.judul;

    const tblRincian =`INSERT INTO ubrincian (
        kdRincian, kdJudul, kdSUb, kdDinas, uraian, total, jumlah1, satuan1, jumlah2,satuan2,jumlah3,
        satuan3, volume, satuanVol, harga,taRincian,tahapan,idSsh
    ) values `;
    let fqueryJudulRincian = tblRincian, 
        dtamJudul=[],catatTotal=0, kdRincian=0,kdJudul=0,hitRincian=0,no=0; 
    let fqdel='';
    
    const qexec = [];
    hitRincian=1;  
    _.files.sub.filter(v=>v.kode_sub_giat == '1.06.05.2.02.0003').forEach((v,i) => {
        if(i==0){ 
            fqdel=`
                DELETE FROM ubjudul  WHERE taJudul='${th}' and kdDinas='${v.kode_skpd}';
                DELETE FROM ubrincian WHERE taRincian='${th}' and kdDinas='${v.kode_skpd}';
                DELETE FROM psub WHERE kdDinas='${v.kode_skpd}' AND taSub='${th}';
            `;
        }
        try {
            if(v.judul.length!=0){
                
                let kdJudul =1;
                v.judul.filter(v=>v.id_ket_sub_bl  ).forEach((v3,i3) => { 
                    kdRincian=1
                    // frincian = v.rincian.filter(fv=>fv.id_subs_sub_bl==v3.id_subs_sub_bl);
                    const frincian1 = v.rincian.filter(fv=>fv.id_ket_sub_bl==v3.id_ket_sub_bl);
                    
                    const countRekening = [...new Set(frincian1.map(v=>v.kode_akun))]; 
                    countRekening.forEach((v4,i4) => {
                        const frincian = frincian1.filter(fv=>fv.kode_akun== v4 && parseFloat(fv.total_harga)>0); 
                        catatTotal = 0; 
                        frincian.forEach((v2,i2) => { 
                            const { jumlah1,jumlah2,jumlah3,
                                satuan1,satuan2,satuan3,
                                volume,satuanVol } = hitungJumlah(v2.koefisien !=null?v2.koefisien:v2.koefisien_murni); 
                            let total = (v2.total_harga!=null?v2.total_harga:v2.total_harga_murni);
                            const harga = (v2.harga_satuan!=null?v2.harga_satuan:v2.harga_satuan_murni);
                            if(total != (harga*volume)){
                                total = (harga*volume);
                            } 
                            fqueryJudulRincian+=`(
                                '${kdRincian}','${kdJudul}','${v.kode_sub_giat}','${v.kode_skpd}',
                                '${_checkStrQuery((v2.nama_standar_harga==null?v2.nama_akun:v2.nama_standar_harga))}',
                                '${total}','${jumlah1}','${satuan1}','${jumlah2}','${satuan2}',
                                '${jumlah3}','${satuan3}',
                                '${volume}','${satuanVol}','${harga}','${th}',1,
                                ''
                            ),`;
                            kdRincian++;
                            catatTotal+=volume*harga;
                            
                            if (i2==(frincian.length-1)) { 
                                fqueryJudul+=`(
                                    '${v.kode_sub_giat}','${v.kode_skpd}','${v2.kode_akun}',1,
                                    '${_checkStrQuery("["+(kdJudul)+"] "+v3.ket_bl_teks)}','${th}','${catatTotal}',1,
                                    '${kdJudul}'
                                ),`;
                                kdJudul++;
                            }
                            if (no>(hitRincian*400)) {
                                qexec.push(fqueryJudulRincian.substring(0,fqueryJudulRincian.length-1));
                                fqueryJudulRincian=tblRincian;
                                hitRincian++;
                            }
                            no++;
                        })
                    }); 
                });
            }
        } catch (error) {
            
        }
         
    });

    if(fqueryJudulRincian.length>10){
        qexec.push(fqueryJudulRincian.substring(0,fqueryJudulRincian.length-1));
    }
    
    qexec.push(fquery.substring(0,fquery.length-1));
    qexec.push(fqueryJudul.substring(0,fqueryJudul.length-1));
    
    console.log(qexec[qexec.length-1]);
    // qexec.push(); 
    // 5.01.0.00.0.00.01.0000
    // $('#tabelShow').html(qexec[0]+"<br>"+qexec[1]); 

    // 197505072002121003
    // return qexec.forEach(async element => { console.log(element);})

   
    // new Promise((resolve, reject) => {
    //     param={  
    //         tahun:th,
    //         qexec:fqdel
    //     }
        // _post('proses/saveImportExcellSIPD',param).then(res=>{
        //     res=JSON.parse(res);
        //     if(res.exec){ 
        //         resolve({})
        //     }else{
        //         return _toast({bg:'e', msg:res.msg});
        //     }
        // });
        
    // }).then(v=>{
        // qexec.forEach(async element => {
        //     param={  
        //         tahun:th,
        //         qexec:element
        //     } 
        //     await _post('proses/saveImportExcellSIPD',param).then(res=>{
        //         res=JSON.parse(res);
        //         if(res.exec){ 
        //         }else{
        //             console.log(element);
        //             return _toast({bg:'e', msg:res.msg});
        //         }
        //     }); 
        // }) 
    // }) 
 
}


