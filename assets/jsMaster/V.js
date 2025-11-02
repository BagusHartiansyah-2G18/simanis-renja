var param={},judul={},slider=Array(),informasi=Array(),infoSupport=Array(),infoSupport1=Array(),infoSupport2=Array(),viewWebsite=""
  ,chart=Array(),form={},dropdonw={},navBar={},menuSupport=[],header={},list=[],navList=[],_={},
  color=Array(),icon=Array(),pjudulRincian=Array(),duplikat=Array();

var img={
  size :15000000 //2 MB
  ,data:Array()
  ,fileName:["jpg","jpeg","png","bmp"]
  ,maxUpload:2
  ,idView:"images"
},
_file={
  size :15000000 //2 MB
  ,data:Array()
  ,fileName:["application/pdf","pdf"]
  ,maxUpload:2
  ,idView:"files"
},
_pageLength=25,
_notif=false,
_vmaxTabel=3,
// _urlMaster='https://bappedaksb.com/master/'
_urlMaster='http://localhost/bappedax/master/'
;
var uang = new Intl.NumberFormat('en-US',
    { style: 'currency', currency: 'USD',
      minimumFractionDigits: 3 });
var date            = new Date();
var _tamp1="",_tamp2="";
var _judulExpJS="Laporan_";


function triwulanViewer() {
  let dtx = localStorage.getItem("triulan");
  if(dtx.length>10){
    dtx = JSON.parse(dtx); 
    if(dtx.length>0){ 
      const formInfo =  $(".dropdown-menu.extended.notification");
      formInfo.addClass("show minWidth-300"); 
      formInfo.html(`
          <li>
              <p class="yellow">Warning</p>
          </li>
          ${hitungTriulan(dtx).map((v,i)=>`
              <li class="col align-items-center" style="width: 100%;">
                <div>
                  <label class="col-1">${i+1}</label>
                  <span class="subject">
                      <span class="from">${v.nmBidang}</span>
                    </span>
                </div>
                <div class="col">
                  
                  <span class="message row " style="justify-content:space-evenly">
                    ${v.satu>0 ? `<label class="text-danger">0-25% (${v.satu})</label>`:''}
                    ${v.dua>0 ? `<label class="text-warning">26-50% (${v.dua})</label>`:''}
                    ${v.tiga>0 ? `<label class="text-primary">51-75% (${v.tiga})</label>`:''}
                    ${v.empat>0 ? `<label class="text-success">76-100% (${v.empat})</label>`:''}
                  </span>
                </div>
              </li>
            `).join(' ')}
          <li class="bg-secondary btn-block">
              <button type="button" class="btn btn-sm btn-success btn-block p-4" onclick="_mengertiNotif()" title="Preview Document">
                      <i class="mdi mdi-comment-check-outline"></i>
                      Saya Mengerti
              </button>
          </li>
        `)
    } 
  }
}

$(document).ready(function() { 
  triwulanViewer();
})

function _mengertiNotif() {
  $(".dropdown-menu.extended.notification").removeClass("show");
  localStorage.removeItem("triulan");
}

function hitungTriulan(dataBidang) { 
    

    const resp =[];

    dataBidang.forEach(bidang => {
        let count25 = 0;
        let count50 = 0;
        let count75 = 0;
        let count100 = 0;
        bidang.triulan.forEach(v => {
            const persen = parseFloat(v.persen);
            if (persen <= 25) count25++;
            else if (persen >26 && persen<=50) count50++;
            else if (persen >51 && persen<=75) count75++;
            else if (persen >76 && persen<=100) count100++;
        });
        resp.push({
          ...bidang,
        "satu": count25,
        "dua": count50,
        "tiga": count75,
        "empat": count100
      })
    });

    return resp; 
}