function _onload(data){
    $('#body').html(data.tmBody);
    myCode=data.code;
    console.log(_);
    
    // _.info=data.info;
    
    
    // _.dinas=data.dinas;
    // _.urusan=data.urusan;
    // _.kdUrusan=_.urusan[0].value;
    // _.bidang=data.bidang;
    // _.kdBidang=_.bidang[0].value;
    // _.ind=0;
    // _.tahun=data.tahun;
    
    $('#bodyTM').html(`<div class="p-2"><div id="pdf-container"></div></div>`);
    $('#footer').html(`<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.min.js"></script>`+data.tmFooter+data.footer);
    
    
    // _startTabel("dt");
    $(document).ready(function() { 
        $('#pdf-container').css({
        'display': 'flex',
        'flex-direction': 'column',
        'gap': '20px'
        });

        // Set style untuk semua canvas di dalam #pdf-container
        $('#pdf-container canvas').css({
        'border': '1px solid #ccc',
        'box-shadow': '0 2px 6px rgba(0,0,0,0.1)'
        });

        const url = 'fs_sistem/upload/files/Layla & Majnun-2022-02-22-09-03-51pm.pdf';  
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.5.207/pdf.worker.min.js';
        const loadingTask = pdfjsLib.getDocument(assert+url);
        const container = document.getElementById('pdf-container');


        pdfjsLib.getDocument(assert+url).promise.then(pdf => {
        for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
            pdf.getPage(pageNum).then(page => {
            const scale = 1.2;
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            container.appendChild(canvas);
            page.render({ canvasContext: context, viewport });
            });
        }
        });
    });

    

    
}