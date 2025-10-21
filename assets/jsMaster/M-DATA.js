function _themaPublicView(v){
    header_.hmenu=[];
    const active="text-primary", noactive="text-light";
    header_.hmenu.push({
        htmlLi:`<a href="${router}" class="nav-link ${(v.menu==1?active:noactive)} display-7 text-center">
            <span class="mdi mdi-office-building d-block mdi-18px"></span>
            <small>Home</small>
            </a>`
    });
    header_.hmenu.push({
        htmlLi:`<a href="${router+"control/agenda"}" class="nav-link ${(v.menu==2?active:noactive)} text-center">
            <span class="mdi mdi-chart-waterfall  d-block mdi-18px"></span>
            <small>Agenda</small>
            </a>`
    });
    header_.hmenu.push({
        htmlLi:`<a href="${router+"control/produk"}" class="nav-link ${(v.menu==3?active:noactive)} text-center">
            <span class="mdi mdi-text-box-check d-block mdi-18px"></span>
            <small>Produk</small>
            </a>`
    });
    header_.hmenu.push({
        htmlLi:`<a href="${router+"control/agenda"}" class="nav-link ${(v.menu==4?active:noactive)} text-center">
            <span class="mdi mdi-collage  d-block mdi-18px"></span>
            <small>PPID</small>
            </a>`
    });
    header_.hmenu.push({
        htmlLi:`<a href="${router+"control/profil"}" class="nav-link ${(v.menu==5?active:noactive)} text-center">
            <span class="mdi mdi-information-outline d-block mdi-18px"></span>
            <small>Profil</small>
            </a>`
    });
    header_.hmenu.push({
        htmlLi:`<a href="${router+"control/kontak"}" class="nav-link ${(v.menu==6?active:noactive)} text-center">
            <span class="mdi mdi-office-building-marker d-block mdi-18px"></span>
            <small>Kontak</small>
            </a>`
    });

    return header_.ex3({
        clsContainer:`container-fluid p-0 m-0 bgksb1 ${(v.menu==1?'mhight650':'')}`,
        clsHeader:"nav-pills d-flex p-3 bbOpa2 shadow" ,
        // tukar:"Bagus H",
        htmlJudul:`
          <a href="#" onclick="_login(5)" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="`+assert+`fs_css/logo/2W.png" width="300">
          </a>
        `,
        clsKeterangan:"d-flex flex-column align-items-center  text-white ",
        htmlKeterangan:v.htmlKeterangan,
        htmlMenu:header_.nav3({
                  clsUl:" ",
                  clsLi:""
                })
    });
}
function _mengertiNotif(){
    _postNoLoad("Proses/mengertiInfo",{}).then(res=>{
        res=JSON.parse(res);
        if(res.exec){
            // _respon(res.data);
        }else{
            return _toast({isi:res.msg});
        }
    })
}
function informasix() {
    // justify-content-center
    fdt=_.dinas[_.ind];
    return `
        <div class="col-md-2 mb" style='background-image:url("`+assert+`fs_css/bg1.jpg"); padding:0px;'>
            <div class="white-panel p-3 shadow" style='color: black;background-color: rgba(146, 201, 227, 0.47) !important;'>`
                +_sejajar({
                    data:[{
                        isi:`<div class="bg-primary" style='height:60px;margin: auto;border-radius: 20px;'>
                                <h1>`+fdt.tsub+`</h1>
                                <p><b>SUB KEGIATAN</b></p>
                            </div>`
                    }]
                })
            +`</div>
        </div>

        <div class="col-md-2 mb ml-3" style='background-image:url("`+assert+`fs_css/bg1.jpg"); padding:0px;'>
            <div class="white-panel p-3 shadow" style='color: black;background-color: rgba(146, 201, 227, 0.47) !important;'>`
                +_sejajar({
                    data:[{
                        isi:`<div class="bg-secondary text-light" style='height:60px;margin: auto;border-radius: 20px;'>
                                <h1>`+fdt.tsubProses+`</h1>
                                <p><b>SUB KEGIATAN TERPROSES</b></p>
                            </div>`
                    }]
                })
            +`</div>
        </div>

        <div class="col-md-2 mb ml-3" style='background-image:url("`+assert+`fs_css/bg1.jpg"); padding:0px;'>
            <div class="white-panel p-3 shadow" style='color: black;background-color: rgba(146, 201, 227, 0.47) !important;'>`
                +_sejajar({
                    data:[{
                        isi:`<div class="bg-success text-light" style='height:60px;margin: auto;border-radius: 20px;'>
                                <h1>`+_$(Number(fdt.tpaguPra))+`</h1>
                                <p><b>Total Belanja PRA Renja</b></p>
                            </div>`
                    }]
                })
            +`</div>
        </div>

        <div class="col-md-2 mb ml-3" style='background-image:url("`+assert+`fs_css/bg1.jpg"); padding:0px;'>
            <div class="white-panel p-3 shadow" style='color: black;background-color: rgba(146, 201, 227, 0.47) !important;'>`
                +_sejajar({
                    data:[{
                        isi:`<div class="bg-warning text-light" style='height:60px;margin: auto;border-radius: 20px;'>
                                <h1>`+_$(Number(fdt.tpaguRka))+`</h1>
                                <p><b>Total Belanja Renja</b></p>
                            </div>`
                    }]
                })
            +`</div>
        </div>

        <div class="col-md-2 mb ml-3" style='background-image:url("`+assert+`fs_css/bg1.jpg"); padding:0px;'>
            <div class="white-panel p-3 shadow" style='color: black;background-color: rgba(146, 201, 227, 0.47) !important;'>`
                +_sejajar({
                    data:[{
                        isi:`<div class="bg-info text-light" style='height:60px;margin: auto;border-radius: 20px;'>
                                <h1>`+_$(Number(fdt.tpaguFinal))+`</h1>
                                <p><b>Total Belanja Renja FINAL</b></p>
                            </div>`
                    }]
                })
            +`</div>
        </div>
    `;
}

function newInfo(persen) {  
    const all = persen[0].persentse;
    const allSisa = 100-all;
    let fhtml ='';
    fhtml=`
        <h4 class="centered mt">Serapan Anggaran Bidang</h4>
        ${persen.slice((persen.length==2?1:0),persen.length).map(v=>`
            <div class="desc">
                <div class="thumb">
                    <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                </div>
                <div class="details">
                    <p style="display: flex;justify-content: space-between;">
                        <b>${v.nm}</b>  <muted>${(v.persentse =='NaN'?0:v.persentse)} %</muted>
                    </p>
                </div>
            </div>
        `)}
    `;
    return `
        <div class="col-lg-3 ds" style="margin-top: 6%;">
            <!--COMPLETED ACTIONS DONUTS CHART-->
            <div class="donut-main">
              <h4>Progres Serapan Anggaran ${persen.length>2?"SKPD":"Bidang"}</h4>
              <h5>${all} of 100 %</h5>
              <canvas id="newchart" height="162" width="162" style="width: 130px; height: 130px;"></canvas>
              <script>
                var doughnutData = [{
                    value: ${all},
                    color: "#4ECDC4"
                  },
                  {
                    value: ${allSisa},
                    color: "#fdfdfd"
                  }
                ];
                var myDoughnut = new Chart(document.getElementById("newchart").getContext("2d")).Doughnut(doughnutData);
              </script>
            </div>
            ${fhtml}
          </div>
    `;
}
function _flogin(key){
    fsize="130px;";
    fcolor='text-dark';
    fbg="bg-secondary text-dark";
    ftam=_inpDropdonwSelected({
            inputType:true,
            inputChange:"_changeValDinas",
            attrInput:"border-color: yellowgreen;",
            classDropdonw:"form-control p-0",
            judul:"Dinas",
            id:"dinas",
            idJudul:"jdinas",
            idData:"ddinas",
            data:_.dinas,
            bgSearch:"#283941",
            bg:" btn-"+fcolor.split("-")[1],
            idDropdonw:"idInpDropDinas",
            func:"_selectDinas",
            funcSearch:"_formSearchDinas(this)"
        });
    if(!key){
        ftam='';
    }
    return ftam+_inpGroupPrepend({
                id:"username",placeholder:"Username",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home '+fcolor+'"></i>',
                bg:'bg-info text-light'
            })
            +_inpGroupPrepend({
                id:"password",placeholder:"Password",
                cls:'mt-4',attr:";",type:"password",icon:'<i class="mdi mdi-key '+fcolor+'"></i>',
                bg:'bg-info text-light'
            })
            // +_inpGroupPrepend({
            //     placeholder:"Tahun",
            //     icon:'<i class="mdi mdi-cube-outline text-primary"></i>',
            //     bg:"bg-dark text-light",
            //     isi:_inpComboBox({
            //         id:"tahun", 
            //         bg:"bg-primary text-light",
            //         data:_.tahun,
            //         getCombo:true,
            //         attr:"text-dark;"
            //     })
            // })
}
function _fupdMember(){
    fsize="180px;";
    fcolor='text-dark';
    fbg="bg-secondary text-dark";
    return _inpGroupPrepend({
                id:"username",placeholder:"Username",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc",attrSpan:`style="`+fsize+`"`,
            })
            +_inpGroupPrepend({
                id:"passwordOld",placeholder:"Password Lama",
                cls:'mt-4',attr:";",type:"password",icon:'<i class="mdi mdi-key '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc",attrSpan:`style="`+fsize+`"`,
            })
            +_inpGroupPrepend({
                id:"passwordNew",placeholder:"Password Baru",
                cls:'mt-4',attr:";",type:"password",icon:'<i class="mdi mdi-key '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc",attrSpan:`style="`+fsize+`"`,
            })
            +_inpSejajar({
                attrRow:"margin-left:5px;margin-bottom:10px;",
                attrCol:"margin-left:5px;margin-bottom:10px;",
                attrLabel:"color:black",
                judul:"",
                isi:_btn({
                    judul:"Perbarui Data",
                    attr:"style='float:right;' onclick='_perbaruiAkun()'",
                    class:"btn btn-primary btn-block fzMfc"
                })
            })
}

function _getJudulRincian(a,next){
    var aksiNext=",false";
    if(next){
        aksiNext=",true";
    }


    _.dSdana.forEach(v => {
        v.selected=0;
        if(v.value==_.dtDetailRincian[a].kdSDana){
            v.selected=1;
        }
    });
    return `
    <tr class="text-center bg-gray-200">
        <td class="text-center bg-gray-200">
            `+(a+1)+`
        </td>
        <td>
            <input type="text" class="form-control input-sm text12" id="judul`+a+`" onchange="_setNama(`+a+aksiNext+`)" value="`+_.dtDetailRincian[a].nama+`" style="height: 28px;">
        </td>
        <td colspan="10">
            <div class="input-group input-group">
            <div class="input-group-prepend"><span class="input-group-text">
                Sumber Dana</span>
            </div>
                <select id="kodeSumber" onchange="_setSumberDana(this,`+a+aksiNext+`)" class="form-control fzMfc form-control-sm text15">
                    `+_inpComboBox({
                        data:_.dSdana,
                        bg:"bg-primary",
                        inSelect:"Bagus"
                    })
                +`</select>
            </div>
        </td>
        <td>
            <input type="text" class="v-money form-control text-right input-sm text12" disabled="disabled" style="height: 28px;" value="`+_$(_.dtDetailRincian[a].jumlah)+`">
        </td>
        <td class="text-center align-middle">
            <div class="dropdown">
                <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-pink dropdown-toggle fzMfc"><i class="fa fa-plus mr-1"></i> Uraian
                </button> 
                <div aria-labelledby="dropdownMenuButton" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(13px, 21px, 0px);">
                    <button onclick="_getSHH(`+a+aksiNext+`)" class="dropdown-item py-1 fzMfc">
                        <i class="fa fa-plus mr-1"></i> 
                        Dari SSH
                    </button> 
                    <button  onclick="_setSHH(`+a+aksiNext+`)" class="dropdown-item py-1 fzMfc">
                        <i class="fa fa-plus mr-1"></i>
                        Uraian
                    </button>
                </div>
            </div>
        </td>
    </tr>
`
}
function _getHeadRincian() {
    return `
        <tbody>
            <tr class="text-center bg-gray-200">
                <th rowspan="2">No</th>
                <th rowspan="2" style="min-width:100px">Uraian</th>
                <th rowspan="2" style="width: 55px;">SSH/ HSPK/ ASB</th>
                <th colspan="6">Detail Volume</th>
                <th colspan="3">Rincian Perhitungan</th>
                <th rowspan="2" class="w-tot">Jumlah (Rp)</th>
                <th rowspan="2" width="100">Aksi</th>
            </tr>
            <tr class="text-center bg-gray-200">
                <th class="w-jml">Jml</th>
                <th class="w-sat">Sat</th>
                <th class="w-jml">Jml</th>
                <th class="w-sat">Sat</th>
                <th class="w-jml">Jml</th>
                <th class="w-sat">Sat</th>
                <th class="w-vol">Volume</th>
                <th class="w-vol">Satuan</th>
                <th class="w-hrg">Harga</th>
            </tr>    
    `;
}
function _setBodyRincian(a,b,next){
    var aksiNext="";
    if(next){
        aksiNext=",true";
    }
    var selected="";
{/* <td class="text-center">
                <button type="button" style="max-width:25px; max-height:25px;" title="Edit" class="btn btn-warning btn-sm text-white text12">
                    <i class="fa fa-edit" style="max-width:20px; max-height:20px;"></i>
                </button> 
                <button type="button" title="Detail" style="max-width:25px; max-height:25px;" class="btn btn-success btn-sm text-white text12">
                    <i class="fa fa-list" style="max-width:20px; max-height:20px;"></i>
                </button>
            </td> */}
    var res=`
        <tr class="text-center bg-gray-200">
            <td class="text-center bg-gray-200">
                `+(b+2)+`
            </td>
            <td colspan="2">
                <input type="text" class="form-control input-sm text12"  onchange="_setvaluraian(`+a+`,`+b+aksiNext+`)" id="uraian`+a+``+b+`" `+(_.dtDetailRincian[a].detail[b].idSsh>0?'disabled':'')+` value="`+_.dtDetailRincian[a].detail[b].uraian+`">
            </td>
            
            <td>
                <input type="number" step="1" class="form-control input-sm text-right text12" onchange="_setvaljumlah1(`+a+`,`+b+aksiNext+`)" id="jumlah1`+a+``+b+`"  value="`+_.dtDetailRincian[a].detail[b].jumlah1+`">
            </td>
            <td>
                <input type="text" class="form-control input-sm text-center text12" onchange="_setvalsatuan1(`+a+`,`+b+aksiNext+`)" id="satuan1`+a+``+b+`"  value="`+_.dtDetailRincian[a].detail[b].satuan1+`">
            </td>
            <td>
                <input type="number" step="1" class="form-control input-sm text-right text12" onchange="_setvaljumlah2(`+a+`,`+b+aksiNext+`)" id="jumlah2`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].jumlah2+`">
            </td>
            <td>
                <input type="text" class="form-control input-sm text-center text12" onchange="_setvalsatuan2(`+a+`,`+b+aksiNext+`)"  id="satuan2`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].satuan2+`">
            </td>
            <td>
                <input type="number" step="1" class="form-control input-sm text-right text12" onchange="_setvaljumlah3(`+a+`,`+b+aksiNext+`)"  id="jumlah3`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].jumlah3+`">
            </td>
            <td>
                <input type="text" class="form-control input-sm text-center text12" onchange="_setvalsatuan3(`+a+`,`+b+aksiNext+`)" id="satuan3`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].satuan3+`">
            </td>
            <td>
                <input type="number" step="1" class="form-control text-right input-sm text12" disabled id="valume`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].volume+`">
            </td>
            <td>
                <input type="text" class="form-control input-sm text-center text12" disabled id="satuanVol`+a+``+b+`" value="`+_.dtDetailRincian[a].detail[b].satuanVol+`">
            </td>
            <td>
                <input type="text" class="v-money form-control text-right input-sm text12" onchange="_setvalharga(`+a+`,`+b+aksiNext+`)" id="harga`+a+``+b+`" `+(_.dtDetailRincian[a].detail[b].idSsh>0?'disabled':'')+` value="`+_.dtDetailRincian[a].detail[b].harga+`">
            </td>
            <td>
                <input type="text" class="v-money form-control text-right input-sm text12" disabled id="jumlah`+a+``+b+`" value="`+_$(_.dtDetailRincian[a].detail[b].jumlah)+`">
            </td>
            <td class="text-center">`;
                if(b==0){
                    fstartInd=0;
                }
                if(Number(_.dtDetailRincian[a].detail[b].qdel)){
                    fstartInd=b+1;
                    res+=`<span class="mdi mdi-database-lock text-danger"></span>Terkunci`;
                }else{
                    if(b==fstartInd){
                        selected="disabled";
                    }
                    res+=`<div style="margin:auto">
                            <button type="button" `+selected+` title="Pindah Ke Atas" onclick="_posisiUp(`+a+`,`+b+aksiNext+`)" class="btn btn-sm btn-outline-warning">
                                <i class="fa fa-arrow-up text-dark"></i>
                            </button>`; 
    
                    selected="";
                    if(b==_.dtDetailRincian[a].detail.length-1){
                        selected="disabled";
                    }
                        res+=`<button type="button" `+selected+` title="Pindah Ke Bawah" onclick="_posisiDonw(`+a+`,`+b+aksiNext+`)" class="btn btn-sm btn-outline-warning">
                                <i class="fa fa-arrow-down text-dark"></i>
                            </button>`;
                    res+=`</div>
                    <div style="margin:auto">
                            <button type="button" title="Copy As New" onclick="_copyAsNew(`+a+`,`+b+aksiNext+`)" class="btn btn-sm btn-primary">
                                <i class="fa fa-copy"></i>
                            </button> 
                            <button type="button" title="Hapus" onclick="_delete(`+a+`,`+b+aksiNext+`)" class="btn btn-sm btn-danger ">
                                <small>x</small>
                            </button>
                    </div>`;
                }
        res+=`</td>
        </tr>
    `;
    return res;
}
function _findikatorKinerja() {
    fsize="130px;";
    fcolor='text-warning';
    return _inpGroupPrepend({
        id:"lokasiP",placeholder:"Lokasi Pelaksanaan",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_inpGroupPrepend({
        id:"waktuP",placeholder:"Waktu Pelaksanaan",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home-clock-outline '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_inpGroupPrepend({
        id:"kelompokS",placeholder:"kelompok Sasaran",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-account-group '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_sejajar({
        data:[{
            isi:_inpGroupPrepend({
                id:"keluaran",placeholder:"Keluaran",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        },{
            isi:_inpGroupPrepend({
                id:"keluaranT",placeholder:"Target Keluaran",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        }]
    })
    +_sejajar({
        data:[{
            isi:_inpGroupPrepend({
                id:"hasil",placeholder:"Hasil",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        },{
            isi:_inpGroupPrepend({
                id:"hasilT",placeholder:"Target Hasil",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        }]
    })
    +_checkbok({
        id:"export",
        text:"Export"
    })
}
function _findikatorKinerjaUpd() {
    fsize="130px;";
    fcolor='text-warning';
    return _inpGroupPrepend({
        id:"lokasiP",placeholder:"Lokasi Pelaksanaan",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_inpGroupPrepend({
        id:"waktuP",placeholder:"Waktu Pelaksanaan",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-home-clock-outline '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_inpGroupPrepend({
        id:"kelompokS",placeholder:"kelompok Sasaran",
        cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-account-group '+fcolor+'"></i>',
        bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
    })
    +_sejajar({
        data:[{
            isi:_inpGroupPrepend({
                id:"keluaran",placeholder:"Keluaran",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        },{
            isi:_inpGroupPrepend({
                id:"keluaranT",placeholder:"Target Keluaran",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        }]
    })
    +_sejajar({
        data:[{
            isi:_inpGroupPrepend({
                id:"hasil",placeholder:"Hasil",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        },{
            isi:_inpGroupPrepend({
                id:"hasilT",placeholder:"Target Hasil",
                cls:'mt-4',attr:";",type:"text",icon:'<i class="mdi mdi-file-download-outline '+fcolor+'"></i>',
                bg:'bg-info text-light fzMfc',inpCls:"fzMfc"
            })
        }]
    })
}