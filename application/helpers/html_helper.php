<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    // print data for array
    function _log($msg){
        echo "<pre>";
        print_r($msg);
    }
    function _headerLapiran($v){
        $CI =& get_instance();
        $w1="70%;";
        $w2="7%;";
        $w3="23%;";
        return '
            <table cellspacing="0" cellpadding="0" border="0" style="text-align: center; width:100%;" border="2">
                <tr>
                    <td style="width:10%; margin-top:20%;">
                        <img src="'.$v['assert'].'/fs_css/logo/'.$CI->mbgs->app['logo'].'" class="img-circle" width="50">
                    </td>
                    <td style="width:70%; margin-top:20%; font-size:15px;">
                        <br><br><b>RINCIAN BELANJA SUB KEGIATAN<br>
                        SATUAN KERJA PERANGKAT DAERAH</b><br>
                    </td>
                    <td style="width:20%; margin-top:20%;font-size:15px;">
                        <br><br><b>'.$v['nmTahapan'].'</b><br>
                    </td>
                </tr>
                <tr>
                    <td style="width:100%; font-size:13px;" rowspan="3">
                        <b>Pemerintah Kabupaten Sumbawa Barat Tahun Anggaran '.$v['tahun'].'</b><br>
                    </td>
                </tr>
            </table>
        ';
    }
    function _informasiRenstra($v){
        $dt=$v['drenstra'][0];
        $CI =& get_instance();
        $w1="15%;";
        $w2="15%;";
        $w3="70%;";
        return '<br><br>
        <table style="font-size:10px;" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;" width="'.$w1.'">
                        Dinas
                    </td>
                    <td style="text-align:left;" width="'.$w2.'">
                        :
                    </td>
                    <td style="text-align:left;" width="'.$w3.'">
                        '.$dt['nmDinas'].'
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;" width="'.$w1.'">
                        Urusan
                    </td>
                    <td style="text-align:left;" width="'.$w2.'">
                        :'.$dt['kdUrusan'].'
                    </td>
                    <td style="text-align:left;" width="'.$w3.'">
                        '.$dt['nmUrusan'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Bidang
                    </td>
                    <td style="text-align:left;">
                        :'.$dt['kdBidang'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['nmBidang'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Program
                    </td>
                    <td style="text-align:left;">
                        :'.$dt['kdProg'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['nmProg'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Kegiatan
                    </td>
                    <td style="text-align:left;">
                        :'.$dt['kdKeg'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['nmKeg'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Sub Kegiatan
                    </td>
                    <td style="text-align:left;">
                        :'.$dt['kdSub'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['nmSub'].'
                    </td>
                </tr>


                <tr>
                    <td style="text-align:left;">
                        Lokasi Kegiatan
                    </td>
                    <td style="text-align:left;">
                        :
                    </td>
                    <td style="text-align:left;">
                        '.$dt['lokasiP'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Waktu Pelaksanaan
                    </td>
                    <td style="text-align:left;">
                        :
                    </td>
                    <td style="text-align:left;">
                         '.$dt['waktuP'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Kelompok Sasaran
                    </td>
                    <td style="text-align:left;">
                        :
                    </td>
                    <td style="text-align:left;">
                        '.$dt['kelompokS'].'
                    </td>
                </tr>

                <tr>
                    <td style="text-align:left;">
                        Belanja '.$v['tahun'].'
                    </td>
                    <td style="text-align:left;">
                        : Rp. '.$CI->mbgs->_uang($v['totalPagu']).'
                    </td>
                    <td style="text-align:left;">
                         
                    </td>
                </tr>
            </tbody>
        </table>
        ';
    }
    function _informasiIndikator($v){
        $dt=$v['drenstra'][0];
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $textL='style="text-align:left;"';
        
        $w1="10%;";
        $w2="80%;";
        $w3="10%;";
        return '<br><br>
        <table style="font-size:10px;" class="table" border="1">
            <tbody>
                <tr>
                    <td colspan="3" '.$textC.' width="100%">
                        Indikator & Tolok Ukur Kinerja Belanja
                    </td>
                </tr>
                <tr style="bakground-color:gray;">
                    <td  width="'.$w1.'" '.$textL.'>
                        Indikator
                    </td>
                    <td '.$textC.' width="'.$w2.'">
                        Tolok Ukur Kinerja
                    </td>
                    <td '.$textC.' width="'.$w3.'">
                        Target Kinerja
                    </td>
                </tr>
            
                <tr>
                    <td '.$textL.'>
                        Masukan
                    </td>
                    <td style="text-align:left;">
                        Jumlah Dana
                    </td>
                    <td style="text-align:left;">
                        '.$CI->mbgs->_uang($v['totalPagu']).'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Keluaran
                    </td>
                    <td style="text-align:left;">
                        '.$dt['keluaran'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['keluaranT'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Hasil
                    </td>
                    <td style="text-align:left;">
                        '.$dt['hasil'].'
                    </td>
                    <td style="text-align:left;">
                        '.$dt['hasilT'].'
                    </td>
                </tr>
            
                <tr>
                    <td style="text-align:left;">
                        Kelompok<br>
                        Sasaran<br>
                        SubKegiatan
                    </td>
                    <td style="text-align:left;">
                         '.$dt['kelompokS'].'
                    </td>
                    <td style="text-align:left;">
                         
                    </td>
                </tr>
            </tbody>
        </table>
        ';
    }
    function _informasiIPerubahan($v){
        $dt=$v['drenstra'][0];
        $dtO=$v['drenstraOld'][0];
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $textL='style="text-align:left;"';
        
        $fw1="10%;";
        $fw2="80%;";
        $fw3="10%;";
        return '
        <br><br>
            <table style="font-size:10px;" class="table table-striped table-bordered" border="1">
                <tbody>
                    <tr>
                        <td colspan="5" '.$textC.' width="100%">
                            Indikator & Tolok Ukur Kinerja Belanja
                        </td>
                    </tr>
                    <tr style="background-color:none;">
                        <td rowspan="2"  '.$textL.'>
                            Indikator
                        </td>
                        <td '.$textC.' colspan="2">
                            Sebelum Pergeseran
                        </td>
                        <td '.$textC.' colspan="2">
                            Setelah Pergeseran
                        </td>
                    </tr>
                    <tr style="background-color:none;">
                        <td '.$textC.'>
                            Tolok Ukur Kinerja
                        </td>
                        <td '.$textC.'>
                            Target Kinerja
                        </td>
                        <td '.$textC.'>
                            Tolok Ukur Kinerja
                        </td>
                        <td '.$textC.'>
                            Target Kinerja
                        </td>
                    </tr>

                    <tr>
                        <td '.$textL.'>
                            Capaian Program
                        </td>
                        <td style="text-align:left;">
                            Indeks Inovasi Daerah
                        </td>
                        <td style="text-align:left;">
                            Inovatif Kategori
                        </td>
                        <td style="text-align:left;">
                            Indeks Inovasi Daerah
                        </td>
                        <td style="text-align:left;">
                            Inovatif Kategori
                        </td>
                    </tr>
                
                    <tr>
                        <td '.$textL.'>
                            Masukan
                        </td>
                        <td style="text-align:left;">
                            Dana yang dibutuhkan
                        </td>
                        <td style="text-align:left;">
                            '.$CI->mbgs->_uang($v['totalPaguOld']).'
                        </td>
                        <td style="text-align:left;">
                            Dana yang dibutuhkan
                        </td>
                        <td style="text-align:left;">
                            '.$CI->mbgs->_uang($v['totalPaguNow']).'
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:left;">
                            Keluaran
                        </td>
                        <td style="text-align:left;">
                            '.$dtO['keluaran'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dtO['keluaranT'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dt['keluaran'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dt['keluaranT'].'
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:left;">
                            Hasil
                        </td>
                        <td style="text-align:left;">
                            '.$dtO['hasil'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dtO['hasilT'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dt['hasil'].'
                        </td>
                        <td style="text-align:left;">
                            '.$dt['hasilT'].'
                        </td>
                    </tr>

                </tbody>
            </table>
        ';
    }
    function _tabelRincianBelanja($dt,$pdf){
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $html='<br><br>
        <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
            <thead>
                <tr '.$textC.'>
                    <th rowspan="2" width="10%">Kode Rekening</th>
                    <th rowspan="2" width="35%">Uraian</th>
                    <th rowspan="2" width="15%">Detail Volume</th>
                    <th colspan="3" width="30%">Rincian Perhitungan</th>
                    <th rowspan="2" width="10%">Jumlah</th>
                </tr>
                <tr '.$textC.'>
                    <th width="10%">Vol</th>
                    <th width="10%">Sat</th>
                    <th width="10%">Harga Satuan</th>
                </tr>
            </thead>
            <tbody>';
        $kdApbd6="";$judul="";$kdSDana="";$kdApbd1="";$kdApbd2="";$kdApbd3="";$kdApbd4="";$kdApbd5="";
        foreach ($dt['dtDetailRincian'] as $a => $v) {
            if($a==0){ //for sub kegiatan saja
                $html.='
                    <tr class="font-weight-bold">
                        <td width="10%"></td>
                        <td colspan="5" width="80%">'.$v['kdSub']." - ".$v['nmSub'].'</td>
                        <td '.$textC.' width="10%"></td>
                    </tr>
                ';
            }
            if($kdApbd1!=$v['kdApbd1']){
                $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd1'].'</td>
                        <td colspan="5" class="flag1">
                            '.$v['nmApbd1'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd1=$v['kdApbd1'];
            }
            if($kdApbd2!=$v['kdApbd2']){
                $fpagu=_getTotalAnak(1,$v['kdApbd2'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd2'].'</td>
                        <td colspan="5" class="flag1">
                        '.$v['nmApbd2'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd2=$v['kdApbd2'];
            }
            if($kdApbd3!=$v['kdApbd3']){
                $fpagu=_getTotalAnak(2,$v['kdApbd3'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd3'].'</td>
                        <td colspan="5" class="flag1">
                        '.$v['nmApbd3'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd3=$v['kdApbd3'];
            }
            if($kdApbd4!=$v['kdApbd4']){
                $fpagu=_getTotalAnak(3,$v['kdApbd4'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd4'].'</td>
                        <td colspan="5" class="flag1">
                        '.$v['nmApbd4'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd4=$v['kdApbd4'];
            }
            if($kdApbd5!=$v['kdApbd5']){
                $fpagu=_getTotalAnak(4,$v['kdApbd5'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd5'].'</td>
                        <td colspan="5" class="flag1">
                        '.$v['nmApbd5'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd5=$v['kdApbd5'];
            }
    
            
            if($kdApbd6!=$v['kdApbd6']){
                $fpagu=_getTotalAnak(5,$v['kdApbd6'],$dt['dtDetailRincian']);
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd6'].'</td>
                        <td colspan="5" class="flag1">
                        '.$v['nmApbd6'].'
                        </td>               
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $kdApbd6=$v['kdApbd6'];
            } 
            if($kdSDana!=$v['kdSDana']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1"></td>
                        <td colspan="5" class="flag1">
                        '.$v['nmSDana'].'
                        </td>               
                        <td '.$textC.'></td>
                    </tr>
                ';
                $kdSDana=$v['kdSDana'];
            }       
            if($judul!=$v['nama']){
                $fpagu=$v['jumlah'];
                if($pdf){
                    $fpagu=$CI->mbgs->_uang($fpagu);
                }
                $html.='
                    <tr style="background-color: lightblue;">
                        <td class="pl-1"></td>
                        <td colspan="5" class="flag4">
                            '.$v['nama'].'
                        </td>
                        <td '.$textC.'>'.$fpagu.'</td>
                    </tr>
                ';
                $judul=$v['nama'];
            }
            foreach ($v['detail'] as $b => $v1) {
                $fharga=$v1['harga'];
                $fjumlah=$v1['jumlah'];
                if($pdf){
                    $fharga=$CI->mbgs->_uang($fharga);
                    $fjumlah=$CI->mbgs->_uang($fjumlah);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1"></td>
                        <td class="flag4" width="35%">
                        - '. $v1['uraian'].'
                        </td>
                        <td width="15%" '.$textC.'>
                            '._getDetailVolume($v1).'
                        </td>
                        <td width="10%" '.$textC.'>
                            '. $v1['volume'].'
                        </td>
                        <td width="10%" '.$textC.'>
                            '. $v1['satuanVol'].'
                        </td>
                        <td width="10%" '.$textC.'>
                            '.$fharga.'
                        </td>
                        <td '.$textC.'>'.$fjumlah.'</td>
                    </tr>
                ';
            }
        }
        // $CI->mbg->_gdate("d-m-yy");
        $dinas=$dt['dinas'][0];
        $today = getdate();
        
        return $html.'
                <tr class="font-weight-bold">
                    <td colspan="3">Keterangan :</td>
                    <td colspan="4" '.$textC.'>
                        <br><br>
                        Taliwang '.$today['mday'].' '.$CI->mbgs->_getBulan($today['mon']).' '.$today['year'].'<br>
                        '.$dinas['nmDinas'].' <br><br><br> <br><br>
                        '.$dinas['kadis'].'<br>
                        NIP.'.$dinas['nip'].'<br>
                    </td>
                </tr>
            </tbody>
        </table>';
    
    }
    function _tabelRincianBPerubahan($dt,$pdf){
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $textR='style="text-align:right;"';
        $header='
            <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
                <thead style="font-size: small;">
                    <tr '.$textC.'>
                        <th rowspan="3" width="10%">Kode Rekening</th>
                        <th rowspan="3" width="10%">Uraian</th>
                        <th colspan="5" width="34%">Sebelum Pergeseran</th>
                        <th colspan="5" width="34%">Setelah Pergeseran</th>
                        <th rowspan="3" width="12%">+ / (-)</th>
                    </tr>
                    <tr '.$textC.'>
                        <th colspan="4" width="24%">Rincian Perhitungan</th>
                        <th rowspan="2" width="10%">Jumlah</th>
                        <th colspan="4" width="24%">Rincian Perhitungan</th>
                        <th rowspan="2" width="10%">Jumlah</th>
                    </tr>
                    <tr '.$textC.'>
                        <th width="7%">koefisien</th>
                        <th width="7%">Sat</th>
                        <th width="7%">Harga</th>
                        <th width="3%">PPN</th>
                        <th width="7%">koefisien</th>
                        <th width="7%">Sat</th>
                        <th width="7%">Harga</th>
                        <th width="3%">PPN</th>
                    </tr>
                </thead>
                <tbody>
        ';
        $html='<br><br>'.$header;
        $kdApbd6="";$judul="";$kdSDana="";$kdApbd1="";$kdApbd2="";$kdApbd3="";$kdApbd4="";$kdApbd5="";
        
        // 7|18
        $jumlahPage =0;
        foreach ($dt['dtDetailRincian'] as $a => $v) {
            // if($a==0){ //for sub kegiatan saja
            //     $html.='
            //         <tr class="font-weight-bold">
            //             <td width="10%"></td>
            //             <td colspan="5" width="80%">'.$v['kdSub']." - ".$v['nmSub'].'</td>
            //             <td '.$textC.' width="10%"></td>
            //         </tr>
            //     ';
            // }
            if($kdApbd1!=$v['kdApbd1']){
                $ftold=_getTotalAnakOld(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd1'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd1'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                // $html.='
                //     <tr class="font-weight-bold">
                //         <td class="pl-1">'.$v['kdApbd1'].'</td>
                //         <td colspan="5" class="flag1">
                //             '.$v['nmApbd1'].'
                //         </td>               
                //         <td '.$textC.'>'.$fpagu.'</td>
                //     </tr>
                // ';
                $kdApbd1=$v['kdApbd1'];
            }
            if($kdApbd2!=$v['kdApbd2']){
                $ftold=_getTotalAnakOld(1,$v['kdApbd2'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(1,$v['kdApbd2'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd2'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd2'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $kdApbd2=$v['kdApbd2'];
            }
            if($kdApbd3!=$v['kdApbd3']){
                $ftold=_getTotalAnakOld(2,$v['kdApbd3'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(2,$v['kdApbd3'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd3'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd3'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $kdApbd3=$v['kdApbd3'];
            }
            if($kdApbd4!=$v['kdApbd4']){
                $ftold=_getTotalAnakOld(3,$v['kdApbd4'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(3,$v['kdApbd4'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd4'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd4'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $kdApbd4=$v['kdApbd4'];
            }
            if($kdApbd5!=$v['kdApbd5']){
                $ftold=_getTotalAnakOld(4,$v['kdApbd5'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(4,$v['kdApbd5'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd5'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd5'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $kdApbd5=$v['kdApbd5'];
            }
            if($kdApbd6!=$v['kdApbd6']){
                $ftold=_getTotalAnakOld(5,$v['kdApbd6'],$dt['dtDetailRincian']);
                $ftnow=_getTotalAnak(5,$v['kdApbd6'],$dt['dtDetailRincian']);
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1" width="10%">'.$v['kdApbd6'].'</td>
                        <td colspan="5" width="34%">
                            '.$v['nmApbd6'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $kdApbd6=$v['kdApbd6'];
            } 
                // if($kdSDana!=$v['kdSDana']){
                //     $html.='
                //         <tr class="font-weight-bold">
                //             <td class="pl-1"></td>
                //             <td colspan="5" class="flag1">
                //             '.$v['nmSDana'].'
                //             </td>               
                //             <td '.$textC.'></td>
                //         </tr>
                //     ';
                //     $kdSDana=$v['kdSDana'];
                // }       
            if($judul!=$v['nama']){
                $ftold=0;
                if($v['qdel']){
                    $ftold=$v['old'][0]['jumlah'];
                }
                $ftnow=$v['jumlah'];
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                $jumlahPage++;
                // $fpagu=_getTotalAnak(0,$v['kdApbd1'],$dt['dtDetailRincian']);
                if($pdf){
                    $ftold=$CI->mbgs->_uang($ftold);
                    $ftnow=$CI->mbgs->_uang($ftnow);
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                $html.='
                    <tr class="font-weight-bold"  style="background-color: lightblue;">
                        <td class="pl-1" width="10%"></td>
                        <td colspan="5" width="34%">
                            '.$v['nama'].'
                        </td>               
                        <td '.$textR.' width="10%">'.$ftold.'</td>
                        <td colspan="4" class="flag1" width="24%">
                        </td>               
                        <td '.$textR.' width="10%">'.$ftnow.'</td>
                        <td '.$textR.' width="12%">'.($ftotR>=0? $ftot : "(".$ftot.")").'</td>
                    </tr>
                ';
                $judul=$v['nama'];
            }
            foreach ($v['detail'] as $b => $v1) {
                $ftold=0;
                $fdOld='
                    <td width="7%">
                        0 '.$v1['satuanVol'].'
                    </td>
                    <td width="7%">
                        '.$v1['satuanVol'].'
                    </td>
                    <td width="7%" '.$textR.'>
                        '.$v1['harga'].'
                    </td>
                    <td width="3%"></td>
                    <td '.$textR.'>
                        '.$ftold.'
                    </td>
                ';
                if($v1['qdel']){
                    // console.log(_.dtDetailRincian[a].old[0]);
                    $ftold=$v['old'][0]['detail'][$b]['jumlah'];
                    $fdOld='
                        <td width="7%">
                            '._getDetailVolume($v['old'][0]['detail'][$b]).'
                        </td>
                        <td width="7%">
                            '.$v['old'][0]['detail'][$b]['satuanVol'].'
                        </td>
                        <td width="7%" '.$textR.'>
                            '.($pdf? $CI->mbgs->_uang($v['old'][0]['detail'][$b]['harga']):$v['old'][0]['detail'][$b]['harga']).'
                        </td>
                        <td width="3%"></td>
                        <td '.$textR.'>
                            '.($pdf? $CI->mbgs->_uang($ftold):$ftold).'
                        </td>
                    ';
                }
                $ftnow=$v1['jumlah'];
                $ftot=$ftnow-$ftold;
                $ftotR=$ftot;
                if($pdf){
                    $ftot=$CI->mbgs->_uang($ftot);
                }
                
                $fdNow='
                    <td width="7%">
                       '._getDetailVolume($v1).'
                    </td>
                    <td width="7%">
                        '. $v1['volume'].'
                    </td>
                    <td width="7%" '.$textR.'>
                        '.($pdf? $CI->mbgs->_uang($v1['harga']):$v1['harga']).'
                    </td>
                    <td width="3%"></td>
                    <td '.$textR.'>
                        '.($pdf? $CI->mbgs->_uang($ftnow):$ftnow).'
                    </td>
                ';
                $html.='
                    <tr class="font-weight-bold">
                        <td width="10%"></td>
                        <td width="10%">
                            - '.$v1['uraian'].'
                        </td>
                        '.$fdOld.'
                        '.$fdNow.'
                        <td '.$textR.'>'.($ftotR>=0? $ftot:"(".$ftot.")").'</td>
                    </tr>
                ';
                $jumlahPage++;
            }
        }
        // $CI->mbg->_gdate("d-m-yy");
        $dinas=$dt['dinas'][0];
        $today = getdate(); 
        
        
        $countBr=9;
        if($jumlahPage>7){
          $jumlahPage-=7;
        }
        $sisaJP=$jumlahPage%18;
        if($sisaJP>0){
            // if($countBr>$sisaJP){
            //     $countBr-=$sisaJP;
            // }else{
            //     $countBr=0;
            // }
            $countBr=0;
        }
        $br='';
        for($a=1;$a<=$countBr;$a++){
            $br.='<br>';
        }
        if($sisaJP==0){
            $br.=$header;
        }
        
        if($sisaJP==0){
            return $html.'
                    </tbody>
                </table>
                
                <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
                    '.$br.'
                    <tr class="font-weight-bold">
                        <td colspan="7">Keterangan :</td>
                        <td colspan="6"  '.$textC.'>
                            <br><br>
                            Taliwang '.$today['mday'].' '.$CI->mbgs->_getBulan($today['mon']).' '.$today['year'].'<br>
                            '.$dinas['nmDinas'].' <br><br><br> <br><br>
                            '.$dinas['kadis'].'<br>
                            NIP.'.$dinas['nip'].'<br>
                        </td>
                    </tr>
                </table> 
            ';
        }
        return $html.'
                <tr class="font-weight-bold" style="page-break-after: always">
                    <td colspan="7">Keterangan : </td>
                    <td colspan="6" '.$textC.'>
                        <br><br>
                        Taliwang '.$today['mday'].' '.$CI->mbgs->_getBulan($today['mon']).' '.$today['year'].'<br>
                        '.$dinas['nmDinas'].' <br><br><br> <br><br>
                        '.$dinas['kadis'].'<br>
                        NIP.'.$dinas['nip'].'<br>
                    </td>
                </tr>
            </tbody>
        </table>';
    
    }
    function _getDetailVolume($data){
        $CI =& get_instance();
        $res="";
        if($data['jumlah1']>0){
            $res.=$CI->mbgs->_uang($data['jumlah1'])." ".$data['satuan1'];
        }if($data['jumlah2']>0){
            $res.=" x ".$CI->mbgs->_uang($data['jumlah2'])." ".$data['satuan2'];
        }if($data['jumlah3']>0){
            $res.=" x ".$CI->mbgs->_uang($data['jumlah3'])." ".$data['satuan3'];
        }
        return $res;
    }
    function _getTotalAnak($anak,$kode,$data){
        $total=0;
        for($a=0;$a<count($data);$a++){
            switch($anak){
                case 1:
                    if($data[$a]['kdApbd2']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
                case 2:
                    if($data[$a]['kdApbd3']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
                case 3:
                    if($data[$a]['kdApbd4']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
                case 4:
                    // return print_r($data[$a]);
                    if($data[$a]['kdApbd5']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
                case 5:
                    if($data[$a]['kdApbd6']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
                default:
                    if($data[$a]['kdApbd1']==$kode){
                        $total+=$data[$a]['jumlah'];
                    }
                break;
            }
        }
        return $total;
    }
    
    function _getTotalAnakOld($anak,$kode,$data){ 
        $total=0;
        for($a=0;$a<count($data);$a++){
            if($data[$a]['qdel']){
                if (count($data[$a]['qdel'])==0) {
                    return 0;
                }
                switch($anak){
                    case 1:
                        if($data[$a]['kdApbd2']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                    case 2:
                        if($data[$a]['kdApbd3']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                    case 3:
                        if($data[$a]['kdApbd4']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                    case 4:
                        // return print_r($data[$a]);
                        if($data[$a]['kdApbd5']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                    case 5:
                        if($data[$a]['kdApbd6']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                    default:
                        if($data[$a]['kdApbd1']==$kode){
                            $total+=$data[$a]['old'][0]['jumlah'];
                        }
                    break;
                }
            }
        }
        return $total;
    }
    function _lapoBelanjaOpd($data,$kdDinas,$nmDinas){
        $CI =& get_instance();
        $w1="15%;";
        $w3="35%;";
        $html='<br><br>
        <table style="font-size:10px; width:100%;" class="table" >
            <tr>
                <td style="text-align:center">
                    <b>
                        Rekap Kegiatan OPD<br>
                        '.$kdDinas.' - '.$nmDinas.'
                    </b>
                </td>
            </tr>
        </table><br><br>
        <table style="font-size:10px;" class="table" border="2">
            <tbody>
                <tr style="background-color: cadetblue;font-size:13px; text-align:center">
                    <td width="5%">
                        No
                    </td>
                    <td width="'.$w1.'">
                        Kode
                    </td>
                    <td width="'.$w3.'">
                        Nama
                    </td>
                    <td width="'.$w1.'">
                        PRA RENJA
                    </td>
                    <td width="'.$w1.'">
                        RENJA
                    </td>
                    <td width="'.$w1.'">
                        RKA RENJA
                    </td>
                </tr>';
                $tPra=0;
                $tRka=0;
                $tFinal=0;
                foreach ($data as $key => $v) {
                    $tPra+=$v['totalPRARKA'];
                    $tRka+=$v['totalRKA'];
                    $tFinal+=$v['totalRKAFINAL'];
                    $html.='
                        <tr>
                            <td  width="5%">
                                '.($key+1).'
                            </td>
                            <td  width="'.$w1.'">
                                '.($v['kdSub']).'
                            </td>
                            <td  width="'.$w3.'">
                                '.($v['nmSub']).'
                            </td>
                            <td  width="'.$w1.'">
                                '.$CI->mbgs->_uang($v['totalPRARKA']).'
                            </td>
                            <td  width="'.$w1.'">
                                '.$CI->mbgs->_uang($v['totalRKA']).'
                            </td>
                            <td  width="'.$w1.'">
                                '.$CI->mbgs->_uang($v['totalRKAFINAL']).'
                            </td>
                        </tr>
                    ';
                }
        return $html.='
                <tr style="background-color: yellowgreen;font-size:13px; text-align:center">
                    <td colspan="3" width="55%">
                        Total Pagu Dinas
                    </td>
                    <td width="'.$w1.'">
                        '.$CI->mbgs->_uang($tPra).'
                    </td>
                    <td width="'.$w1.'">
                        '.$CI->mbgs->_uang($tRka).'
                    </td>
                    <td width="'.$w1.'">
                        '.$CI->mbgs->_uang($tFinal).'
                    </td>
                </tr>
            </tbody>
        </table>
        ';
    }
    function _lapoRekapBelanjaOpd($data,$kdDinas,$nmDinas){
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $html='<br><br>
        <table style="font-size:10px; width:100%;" class="table" >
            <tr>
                <td style="text-align:center">
                    <b>
                        Rekap Rekening Belanja<br>
                        '.$kdDinas.' - '.$nmDinas.'
                    </b>
                </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
            <thead>
                <tr '.$textC.'>
                    <th  width="15%">Kode Rekening</th>
                    <th  width="70%">Uraian</th>
                    <th  width="15%">Jumlah</th>
                </tr>
            </thead>
            <tbody>';
        $kdApbd6="";$judul="";$kdSDana="";$kdApbd1="";$kdApbd2="";$kdApbd3="";$kdApbd4="";$kdApbd5="";
        foreach ($data as $a => $v) {
            // if($a==0){ //for sub kegiatan saja
            //     $html.='
            //         <tr class="font-weight-bold">
            //             <td width="15%"></td>
            //             <td width="70%">'.$v['kdSub']." - ".$v['nmSub'].'</td>
            //             <td '.$textC.' width="15%"></td>
            //         </tr>
            //     ';
            // }
            if($kdApbd1!=$v['kdApbd1']){
                $html.='
                    <tr class="font-weight-bold">
                        <td width="15%" class="pl-1">'.$v['kdApbd1'].'</td>
                        <td width="70%" class="flag1">
                            '.$v['nmApbd1'].'
                        </td>               
                        <td width="15%" '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(0,$v['kdApbd1'],$data)).'</td>
                    </tr>
                ';
                $kdApbd1=$v['kdApbd1'];
            }
            if($kdApbd2!=$v['kdApbd2']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd2'].'</td>
                        <td class="flag1">
                        '.$v['nmApbd2'].'
                        </td>               
                        <td '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(1,$v['kdApbd2'],$data)).'</td>
                    </tr>
                ';
                $kdApbd2=$v['kdApbd2'];
            }
            if($kdApbd3!=$v['kdApbd3']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd3'].'</td>
                        <td class="flag1">
                        '.$v['nmApbd3'].'
                        </td>               
                        <td '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(2,$v['kdApbd3'],$data)).'</td>
                    </tr>
                ';
                $kdApbd3=$v['kdApbd3'];
            }
            if($kdApbd4!=$v['kdApbd4']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd4'].'</td>
                        <td class="flag1">
                        '.$v['nmApbd4'].'
                        </td>               
                        <td '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(3,$v['kdApbd4'],$data)).'</td>
                    </tr>
                ';
                $kdApbd4=$v['kdApbd4'];
            }
            if($kdApbd5!=$v['kdApbd5']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd5'].'</td>
                        <td class="flag1">
                        '.$v['nmApbd5'].'
                        </td>               
                        <td '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(4,$v['kdApbd5'],$data)).'</td>
                    </tr>
                ';
                $kdApbd5=$v['kdApbd5'];
            }
    
            
            if($kdApbd6!=$v['kdApbd6']){
                $html.='
                    <tr class="font-weight-bold">
                        <td class="pl-1">'.$v['kdApbd6'].'</td>
                        <td class="flag1">
                        '.$v['nmApbd6'].'
                        </td>               
                        <td '.$textC.'>'.$CI->mbgs->_uang(_getTotalAnak(5,$v['kdApbd6'],$data)).'</td>
                    </tr>
                ';
                $kdApbd6=$v['kdApbd6'];
            }
        }
        return $html.='</tbody>
        </table>';
    }
    function _lapoRekapBelanjaAllOpd($data){
        $CI =& get_instance();
        $tpra=0;$trenja=0;$tfinal=0;
        $textC='style="text-align:center;"';
        $html='<br><br>
        <table style="font-size:10px; width:100%;" class="table" >
            <tr>
                <td style="text-align:center">
                    <b>
                        Rekap Rekening Belanja OPD<br>
                    </b>
                </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
            <thead>
                <tr '.$textC.'>
                    <th  width="5%">No</th>
                    <th  width="50%">Dinas</th>
                    <th  width="15%">PRA</th>
                    <th  width="15%">RENJA</th>
                    <th  width="15%">FINAL</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($data as $key => $v) {
                $tpra+=$v['pra'];
                $trenja+=$v['renja'];
                $tfinal+=$v['final'];

                $html.='
                    <tr '.$textC.'>
                        <th  width="5%">'.($key+1).'</th>
                        <th style="text-align:left;" width="50%">'.$v['nmDinas'].'</th>
                        <th  width="15%">'.$CI->mbgs->_uang($v['pra']).'</th>
                        <th  width="15%">'.$CI->mbgs->_uang($v['renja']).'</th>
                        <th  width="15%">'.$CI->mbgs->_uang($v['final']).'</th>
                    </tr>';
            }
            $html.='
                <tr '.$textC.'>
                    <th  width="5%">***</th>
                    <th style="text-align:left;" width="50%">Total Pagu</th>
                    <th  width="15%">'.$CI->mbgs->_uang($tpra).'</th>
                    <th  width="15%">'.$CI->mbgs->_uang($trenja).'</th>
                    <th  width="15%">'.$CI->mbgs->_uang($tfinal).'</th>
                </tr>';
        return $html.='</tbody>
        </table>';
    }
    function _lapoRekapPaguSub($judul,$data){
        $CI =& get_instance();
        $textC='style="text-align:center;"';
        $html='<br><br>
        <table style="font-size:10px; width:100%;" class="table" >
            <tr>
                <td style="text-align:center">
                    <b>
                        '.$judul.'<br>
                    </b>
                </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" cellpadding="1" border="1" style="font-size:10px;">
            <thead>
                <tr '.$textC.'>
                    <th  width="10%">kode</th>
                    <th  width="25%">Program/Kegiatan/Sub</th>
                    <th  width="17%">Indokator</th>
                    <th  width="18%">Target</th>
                    <th  width="10%">PRA</th>
                    <th  width="10%">RENJA</th>
                    <th  width="10%">FINAL</th>
                </tr>
            </thead>
            <tbody>';
            $kd1='';$kd2='';$kd3='';$kd4='';$kd5='';
            foreach ($data as $key => $v) {
                if($kd1!=$v['kd1']){
                    $pg=_getTotalLeval(1,$v['kd1'],$data);
                    $html.='
                        <tr class="font-weight-bold">
                            <td width="10%" class="pl-1">'.$v['kd1'].'</td>
                            <td width="25%" class="flag1">
                                '.$v['nm1'].'
                            </td>              
                            <td width="17%"> </td>
                            <td width="18%"> </td>
                            <td '.$textC.' width="10%">'.$CI->mbgs->_uang($pg['pra']).'</td>
                            <td '.$textC.' width="10%">'.$CI->mbgs->_uang($pg['renja']).'</td>
                            <td '.$textC.' width="10%">'.$CI->mbgs->_uang($pg['final']).'</td>
                        </tr>
                    ';
                    $kd1=$v['kd1'];
                }
                if($kd2!=$v['kd2']){
                    $pg=_getTotalLeval(2,$v['kd2'],$data);
                    $html.='
                        <tr class="font-weight-bold">
                            <td class="pl-1">'.$v['kd2'].'</td>
                            <td  class="flag1">
                            '.$v['nm2'].'
                            </td>               
                            <td> </td>
                            <td> </td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['pra']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['renja']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['final']).'</td>
                        </tr>
                    ';
                    $kd2=$v['kd2'];
                }
                if($kd3!=$v['kd3']){
                    $pg=_getTotalLeval(3,$v['kd3'],$data);
                    $html.='
                        <tr class="font-weight-bold">
                            <td class="pl-1">'.$v['kd3'].'</td>
                            <td  class="flag1">
                            '.$v['nm3'].'
                            </td>               
                            <td> </td>
                            <td> </td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['pra']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['renja']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['final']).'</td>
                        </tr>
                    ';
                    $kd3=$v['kd3'];
                }
                if($kd4!=$v['kd4']){
                    $pg=_getTotalLeval(4,$v['kd4'],$data);
                    $html.='
                        <tr class="font-weight-bold">
                            <td class="pl-1">'.$v['kd4'].'</td>
                            <td  class="flag1">
                            '.$v['nm4'].'
                            </td>               
                            <td> </td>
                            <td> </td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['pra']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['renja']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['final']).'</td>
                        </tr>
                    ';
                    $kd4=$v['kd4'];
                }
                if($kd5!=$v['kd5']){
                    $pg=_getTotalLeval(5,$v['kd5'],$data);
                    $html.='
                        <tr class="font-weight-bold">
                            <td class="pl-1">'.$v['kd5'].'</td>
                            <td  class="flag1">
                            '.$v['nm5'].'
                            </td>               
                            <td>'.$v['keluaran'].' </td>
                            <td>'.$v['keluaranT'].' </td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['pra']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['renja']).'</td>
                            <td '.$textC.'>'.$CI->mbgs->_uang($pg['final']).'</td>
                        </tr>
                    ';
                    $kd5=$v['kd5'];
                }
            }
        return $html.='</tbody>
        </table>';
    }
    function _getTotalLeval($level,$kode,$data){
        $pra=0;$renja=0;$final=0;
        for($a=0;$a<count($data);$a++){
            switch($level){
                case 1:
                    if($data[$a]['kd1']==$kode){
                        $pra+=$data[$a]['pra'];
                        $renja+=$data[$a]['renja'];
                        $final+=$data[$a]['final'];
                    }
                break;
                case 2:
                    if($data[$a]['kd2']==$kode){
                        $pra+=$data[$a]['pra'];
                        $renja+=$data[$a]['renja'];
                        $final+=$data[$a]['final'];
                    }
                break;
                case 3:
                    if($data[$a]['kd3']==$kode){
                        $pra+=$data[$a]['pra'];
                        $renja+=$data[$a]['renja'];
                        $final+=$data[$a]['final'];
                    }
                break;
                case 4:
                    // return print_r($data[$a]);
                    if($data[$a]['kd4']==$kode){
                        $pra+=$data[$a]['pra'];
                        $renja+=$data[$a]['renja'];
                        $final+=$data[$a]['final'];
                    }
                break;
                // case 5:
                //     if($data[$a]['kd5']==$kode){
                //         $pra+=$data[$a]['pra'];
                //         $renja+=$data[$a]['renja'];
                //         $final+=$data[$a]['final'];
                //     }
                // break;
                default:
                    if($data[$a]['kd5']==$kode){
                        $pra+=$data[$a]['pra'];
                        $renja+=$data[$a]['renja'];
                        $final+=$data[$a]['final'];
                    }
                break;
            }
        }
        return ["pra"=>$pra,"renja"=>$renja,"final"=>$final];
    }
?>