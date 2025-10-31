<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function _cbDinas($where){
        return "select kdDInas as value, nmDinas as valueName from dinas ".$where." group by kdDinas";
    }
    function _cbDinasForAG($kdMember,$where){ // admin froup
        return "select a.kdDInas as value, a.nmDinas as valueName 
            from dinas a join admingroup b 
                on  a.kdDinas=b.kdDinas 
            where b.kdMember='".$kdMember."'
        ".$where." group by a.kdDinas";
    }
    function _dinas($where){
        return "select * from dinas ".$where;
    }
    function _dinasForAG($kdMember,$where){
        return "select a.*
        from dinas a join admingroup b 
            on  a.kdDinas=b.kdDinas 
        where b.kdMember='".$kdMember."' 
        ".$where;
    }

    function _cbUrusan($where){
        return "select kdUrusan as value, nmUrusan as valueName from purusan ".$where;
    }
    function _cbBidang($where){
        // kdUrusan untuk membantu filter data depan 
        return "select kdBidang as value, nmBidang as valueName,kdUrusan from pbidang ".$where;
    }
    function _cbBidangDinas($where){
        // kdUrusan untuk membantu filter data depan 
        return "select kdDBidang as value, nmBidang as valueName from dinas_bidang ".$where;
    }
    function _renstraOpd($kodeDinas,$tahun,$where){
        return 'SELECT 
            a.kdSub,a.nmSub,a.qpra,a.qrka,a.qrkaFinal,a.lokasiP,a.waktuP,a.kelompokS,a.keluaran,a.hasil,a.keluaranT,a.hasilT
            ,b.kdKeg,b.nmKeg
            ,c.kdProg,c.nmProg
            ,d.kdBidang,d.nmBidang
            ,e.kdUrusan,e.nmUrusan
            ,f.kdDinas,f.nmDinas
            ,(SELECT SUM(total) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="1" and taJudul=a.taSub) 
            as totalPRARKA
            ,(SELECT SUM(total) FROM ubjudul WHERE kdSub=a.kdSub and kdDinas=a.kdDinas AND tahapan="2" and taJudul=a.taSub) 
            as totalRKA
            ,(SELECT SUM(total) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="3" and taJudul=a.taSub) 
            as totalRKAFINAL
        FROM psub a 
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            Join dinas f
                ON a.kdDinas=f.kdDinas
        WHERE a.kdDinas="'.$kodeDinas.'" and a.taSub="'.$tahun.'" '.$where.'
        GROUP BY a.kdSub,a.kdKeg,b.kdProg,a.kdDinas
        ORDER BY a.kdSub asc
        ';
    }
    function _renstraOpdBidang($kodeDinas,$tahun,$where,$bulan="1"){
        return 'SELECT 
            a.kdSub,a.nmSub,a.qpra,a.qrka,a.qrkaFinal,a.lokasiP,a.waktuP,a.kelompokS,a.keluaran,a.hasil,a.keluaranT,a.hasilT
            ,b.kdKeg,b.nmKeg
            ,c.kdProg,c.nmProg
            ,d.kdBidang,d.nmBidang
            ,e.kdUrusan,e.nmUrusan
            ,f.kdDinas,f.nmDinas
            ,a.kdBidang
            ,(SELECT SUM(pagu) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="1" and taJudul=a.taSub and bulan="'.$bulan.'") 
            as totalPRARKA
            ,(SELECT SUM(total) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="1" and taJudul=a.taSub and bulan="'.$bulan.'") 
            as totalR
            ,a.dhasil
            ,a.dkeluaran
            ,a.prealisasi
        FROM psub a 
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            Join dinas f
                ON a.kdDinas=f.kdDinas
        WHERE a.kdDinas="'.$kodeDinas.'" and a.taSub="'.$tahun.'" '.$where.'
        GROUP BY a.kdSub,a.kdKeg,b.kdProg,a.kdDinas
        ORDER BY a.kdSub asc
        ';
    }
    function _renstraOpdBidangAutoTahun($kodeDinas,$bulan="1"){
        return 'SELECT  
            a.kdBidang
            ,(SELECT SUM(pagu) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="1" and taJudul=a.taSub and bulan="'.$bulan.'") 
            as totalPRARKA
            ,(SELECT SUM(total) FROM ubjudul WHERE kdSub=a.kdSub AND kdDinas=a.kdDinas AND tahapan="1" and taJudul=a.taSub and bulan="'.$bulan.'") 
            as totalR,
            a.taSub
        FROM psub a 
            join tahun g 
                on a.taSub=g.nama
                and g.selected=1
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            Join dinas f
                ON a.kdDinas=f.kdDinas
        WHERE a.kdDinas="'.$kodeDinas.'" 
        GROUP BY a.kdSub,a.kdKeg,b.kdProg,a.kdDinas
        ORDER BY a.kdSub asc
        ';
    }

    function _tsub($kodeDinas,$tahun,$where){
        return '
            select count(kdSub) as total FROM psub WHERE kdDinas="'.$kodeDinas.'" and taSub="'.$tahun.'" '.$where.'
        ';
    }
    function _tsubProses($kodeDinas,$tahun,$where){
        return '
            select a.kdSub
            FROM psub a 
            join ubjudul b
                on a.kdSub=b.kdSub
                and a.kdDinas=b.kdDinas
                and a.taSub=b.taJudul
            WHERE 
                a.kdDinas="'.$kodeDinas.'" and a.taSub="'.$tahun.'"
                '.$where.'
            group by a.kdSub,a.kdDinas
        ';
    }
    function _tpagu($kodeDinas,$ket,$tahun,$where){
        return '
            SELECT 
                SUM(a.total) as total
            FROM ubjudul a 
            join psub b 
                on a.kdSub=b.kdSub
                and a.kdDinas=b.kdDinas
                and a.taJudul=b.taSub
            WHERE a.kdDinas="'.$kodeDinas.'"
                AND a.tahapan="'.$ket.'"
                and a.taJudul="'.$tahun.'"
                '.$where.'
        ';
    }
    function _cbApbd6($where){
        return "
            select kdApbd6 as value, nmApbd6 as valueName from apbd6 ".$where."
        ";
    }
    function _cbApbd($no,$where){
        return "SELECT kdApbd".$no." as value,nmApbd".$no." as valueName FROM  apbd".$no."  ".$where;
    }
    function _cbSDana($where){
        return "
            select kdSDana as value, nmSDana as valueName from sumberdana ".$where."
        ";
    }
    function _keySub($kodeDinas,$tahun,$where){
        return '
            select kdSub,nmSub,kdDinas,kdKeg,taSub,qpra,qrka,qrkaFinal FROM psub 
            WHERE kdDinas="'.$kodeDinas.'" and 
            taSub="'.$tahun.'" 
            '.$where.'
        ';
    }
    function _cbSub($kodeDinas,$tahun,$where){
        return '
            select kdSub as value,nmSub as valueName FROM psub 
            WHERE kdDinas="'.$kodeDinas.'" and 
            taSub="'.$tahun.'" 
            '.$where.'
        ';
    }
    function _renstraOpdGet($kdDinas,$tahun,$where){
        // upd untuk membantu perubahan on /off di getRenstra 
        return '
            select a.kdSub,a.nmSub
                ,b.kdKeg	,b.nmKeg
                ,c.kdProg	,c.nmProg
                ,d.kdBidang    ,d.nmBidang
                ,e.kdUrusan	    ,e.nmUrusan
                ,(
                    SELECT 
                        CASE 
                            WHEN count(kdSub)=1 THEN 1
                            ELSE 0
                        END
                    FROM psub
                    where kdSub=a.kdSub and kdKeg=a.kdKeg and kdDinas="'.$kdDinas.'" and taSub="'.$tahun.'"
                ) as checked
                , 0 as upd
            FROM ptamsub a 
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            where a.taSub="'.$tahun.'" '.$where.'
            GROUP BY a.kdSub,a.kdKeg,c.kdProg
            ORDER BY a.kdSub asc
            -- limit 10
        ';
    }
    function _renstraOpdBidangGet($kdDinas,$kdbidang,$tahun,$where){ 
        return '
            select a.kdSub,a.nmSub
                ,b.kdKeg	,b.nmKeg
                ,c.kdProg	,c.nmProg
                ,d.kdBidang    ,d.nmBidang
                ,e.kdUrusan	    ,e.nmUrusan,
                a.kdBidang
                ,(
                        CASE 
                            WHEN a.kdBidang !=0 THEN 1
                            ELSE 0
                        END
                ) as checked
                , 0 as upd
            FROM psub a 
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            where a.taSub="'.$tahun.'" and a.kdDinas="'.$kdDinas.'" '.$where.' 
            GROUP BY a.kdSub,a.kdKeg,c.kdProg
            ORDER BY a.kdSub asc
            -- limit 10
        ';
    }
    function _dssh($where){
        return "
            SELECT `id`, `nama`, `spesifikasi` as keterangan, `satuan`, `harga`,`kodeRekening` FROM `ssh` ".$where."
            order by nama asc
            -- limit 10
        ";
    }
    function _judulRBelanja($v){
        // ,b.keyForPraRka,b.keyForRKA,b.keyForRkaFinal
        return '
            SELECT 
                a.nama,a.total as jumlah,a.pagu,a.dateUpdate,a.kdJudul,a.kdSDana,a.qdel
                ,b.kdSub	,b.nmSub,0 as keyForPraRka,0 as keyForRKA,0 as keyForRkaFinal
                ,c.kdKeg	,c.nmKeg
                ,d.kdProg	,d.nmProg
                ,f.kdSDana,f.nmSDana
                ,e.kdApbd6 as kdApbd,e.kdApbd6,e.nmApbd6
                ,"sudah" as status
                ,g.kdApbd5,g.nmApbd5
                ,h.kdApbd4,h.nmApbd4
                ,i.kdApbd3,i.nmApbd3
                ,j.kdApbd2,j.nmApbd2
                ,k.kdApbd1,k.nmApbd1
            FROM ubjudul a
                JOIN psub b 
                    ON a.kdSub=b.kdSub
                    and a.taJudul=b.taSub
                    and a.kdDinas=b.kdDinas
                JOIN pkegiatan c 
                    ON b.kdKeg=c.kdKeg
                    and c.taKeg=b.taSub
                JOIN pprogram d 
                    ON c.kdProg=d.kdProg
                    and c.taKeg=d.taProg
                left JOIN sumberdana f 
                    ON a.kdSDana=f.kdSDana
                LEFT JOIN apbd6 e
                    ON a.kdApbd6=e.kdApbd6
                    and a.taJudul=e.taApbd6
                LEFT JOIN apbd5 g 
                    ON e.kdApbd5=g.kdApbd5
                    and g.taApbd5=e.taApbd6
                LEFT JOIN apbd4 h 
                    ON h.kdApbd4=g.kdApbd4
                    and g.taApbd5=h.taApbd4
                LEFT JOIN apbd3 i 
                    ON h.kdApbd3=i.kdApbd3
                    and i.taApbd3=h.taApbd4
                LEFT JOIN apbd2 j 
                    ON j.kdApbd2=i.kdApbd2
                    and i.taApbd3=j.taApbd2
                LEFT JOIN apbd1 k
                    ON j.kdApbd1=k.kdApbd1
                    and k.taApbd1=j.taApbd2
            WHERE b.kdSub="'.$v['kdSub'].'" and a.tahapan="'.$v['tahapan'].'" and a.kdDinas="'.$v['kdDinas'].'" and 
                a.taJudul="'.$v['tahun'].'" and a.status=1
                and a.bulan="'.$v['bulan'].'"
            GROUP BY b.kdSub,c.kdKeg,d.kdProg,a.kdDinas,e.kdApbd6,a.kdJudul
            ORDER BY b.kdSub,c.kdKeg,d.kdProg
        ';
    }
    function _judulRBelanjaOld($v){
        // ,b.keyForPraRka,b.keyForRKA,b.keyForRkaFinal
        return '
            SELECT 
                a.nama,a.total as jumlah,a.dateUpdate,a.kdJudul,a.kdSDana,a.qdel
            FROM ubjudul a
            WHERE a.kdSub="'.$v['kdSub'].'" and a.tahapan="'.$v['tahapan'].'" and a.kdDinas="'.$v['kdDinas'].'" and 
                a.taJudul="'.$v['tahun'].'" and a.status=1 and a.kdJudul="'.$v['kdJudul'].'"
            GROUP BY a.kdSub,a.kdDinas,a.kdApbd6,a.nama 
            ORDER BY a.kdSub
        ';
    }
    function _detailRBelanja($v){
        return 'select  `kdRincian`, `kdJudul`, `uraian`, `total` as jumlah
            , `jumlah1`, `jumlah2`, `jumlah3`, `satuan1`
            , `satuan2`, `satuan3`, `volume`, `satuanVol`
            , `harga` ,"sudah" as status,qdel,idSsh,realisasi
            from ubrincian 
            where kdJudul="'. $v['kdJudul'].'" and taRincian="'. $v['tahun'].'" and tahapan="'.$v['tahapan'].'"
            and kdSub="'. $v['kdSub'].'" and kdDinas="'. $v['kdDinas'].'"
            and status=1
        ';
    }
    function _rekapBelanja($kodeDinas,$tahun,$tahapan,$where){
        $tdinas=' aa.kdDinas="'.$kodeDinas.'" AND ';
        if(strlen($kodeDinas)==0){
            $tdinas='';
        }
        return '
            SELECT 
                sum(total) as jumlah
                ,e.kdApbd6 as kdApbd,e.kdApbd6,e.nmApbd6
                ,g.kdApbd5,g.nmApbd5
                ,h.kdApbd4,h.nmApbd4
                ,i.kdApbd3,i.nmApbd3
                ,j.kdApbd2,j.nmApbd2
                ,k.kdApbd1,k.nmApbd1
            FROM ubjudul aa
                JOIN apbd6 e
                    ON aa.kdApbd6=e.kdApbd6
                    and aa.taJudul=e.taApbd6           
                LEFT JOIN apbd5 g 
                    ON e.kdApbd5=g.kdApbd5
                    and g.taApbd5=e.taApbd6
                LEFT JOIN apbd4 h 
                    ON h.kdApbd4=g.kdApbd4
                    and g.taApbd5=h.taApbd4
                LEFT JOIN apbd3 i 
                    ON h.kdApbd3=i.kdApbd3
                    and i.taApbd3=h.taApbd4
                LEFT JOIN apbd2 j 
                    ON j.kdApbd2=i.kdApbd2
                    and i.taApbd3=j.taApbd2
                LEFT JOIN apbd1 k
                    ON j.kdApbd1=k.kdApbd1
                    and k.taApbd1=j.taApbd2
            WHERE  '.$tdinas.' aa.taJudul="'.$tahun.'" AND aa.tahapan="'.$tahapan.'" '.$where.'
            GROUP BY aa.kdApbd6
            ORDER BY k.kdApbd1,j.kdApbd2,i.kdApbd3,h.kdApbd4,g.kdApbd5,e.kdApbd6
            ';
    }
    function _rekapBelanjaAllOpd($tahun,$where){
        return "
            SELECT a.*,
            (
                SELECT SUM(b.total) 
                FROM `ubjudul` b
                join psub c
                    on c.kdSub=b.kdSub
                    and c.kdDinas=b.kdDinas
                    and b.taJudul=c.taSub
                WHERE b.kdDinas=a.kdDinas AND b.tahapan=1
                and b.taJudul='".$tahun."'
            ) as pra,
            (
                SELECT SUM(total) 
                FROM `ubjudul` b
                join psub c
                    on c.kdSub=b.kdSub
                    and c.kdDinas=b.kdDinas
                    and b.taJudul=c.taSub
                WHERE b.kdDinas=a.kdDinas AND b.tahapan=2
                and b.taJudul='".$tahun."'
            ) as renja,
            (
                SELECT SUM(total) 
                FROM `ubjudul` b
                join psub c
                    on c.kdSub=b.kdSub
                    and c.kdDinas=b.kdDinas
                    and b.taJudul=c.taSub
                WHERE b.kdDinas=a.kdDinas AND b.tahapan=3
                and b.taJudul='".$tahun."'
            ) as final
            FROM dinas a
            where a.taDinas='".$tahun."'
            ".$where."
        ";
    }
    function _rekapBelanjaAllOpdAG($tahun,$kdMember,$where){ 
        //Admin Group
        return "
            SELECT a.*,
            (
                SELECT SUM(total) 
                FROM `ubjudul` 
                WHERE kdDinas=a.kdDinas AND tahapan=1
                and taJudul='".$tahun."'
            ) as pra,
            (
                SELECT SUM(total) 
                FROM `ubjudul` 
                WHERE kdDinas=a.kdDinas AND tahapan=2
                and taJudul='".$tahun."'
            ) as renja,
            (
                SELECT SUM(total) 
                FROM `ubjudul` 
                WHERE kdDinas=a.kdDinas AND tahapan=3
                and taJudul='".$tahun."'
            ) as final
            FROM dinas a 
            JOIN admingroup b 
                on a.kdDinas=b.kdDinas
            WHERE b.kdMember='".$kdMember."' and a.taDinas='".$tahun."'
            ".$where."
        ";
    }
    function _rekapPaguSub($tahun,$join,$where){
        return "
            select a.kdSub as kd5,a.nmSub as nm5,a.keluaran,a.keluaranT
                ,b.kdKeg as kd4	,b.nmKeg as nm4
                ,c.kdProg as kd3	,c.nmProg as nm3
                ,d.kdBidang as kd2   ,d.nmBidang as nm2
                ,e.kdUrusan	as kd1    ,e.nmUrusan as nm1, 
                (
                    SELECT SUM(b1.total) 
                    FROM `ubjudul` b1
                    WHERE b1.kdDinas=a.kdDinas AND b1.tahapan=1 AND b1.kdSUb=a.kdSub
                    and b1.taJudul='".$tahun."'
                ) as pra,
                (
                    SELECT SUM(b1.total) 
                    FROM `ubjudul` b1
                    WHERE b1.kdDinas=a.kdDinas AND b1.tahapan=1 AND b1.kdSUb=a.kdSub
                    and b1.taJudul='".$tahun."'
                ) as renja,
                (
                    SELECT SUM(b1.total) 
                    FROM `ubjudul` b1
                    WHERE b1.kdDinas=a.kdDinas AND b1.tahapan=1 AND b1.kdSUb=a.kdSub
                    and b1.taJudul='".$tahun."'
                ) as final
            FROM psub a 
            JOIN pkegiatan b 
                ON a.kdKeg	=b.kdKeg
                and a.taSub=b.taKeg
            JOIN pprogram c 
                ON b.kdProg 	=c.kdProg
                and c.taProg=b.taKeg
            JOIN pbidang d
                ON c.kdBidang		=d.kdBidang
                and c.taProg=d.taBidang
            JOIN purusan e
                ON d.kdUrusan		=e.kdUrusan
                and e.taUrusan=d.taBidang
            ".$join."
            where a.taSub='".$tahun."' ".$where."
            GROUP BY a.kdSub,a.kdKeg,c.kdProg,a.kdDinas
            ORDER BY a.kdSub asc
        ";
    }
    

    function _agenda($where){
        return '
            SELECT *,
                case  
                    when substring(tglE,1,4)="0000" THEN tglS
                    else concat(tglS," - ",tglE)
                end as tgl,
                poster as img
            FROM agenda
            '.$where.'
        ';
    }

    
    function _tahunForOption($where){
        return 'SELECT nama as judul,perubahan,  
                    case 
                        when perubahan=0 then status
                        else concat(status," ke- ", perubahan)
                    end as keterangan
                FROM tahun order by cast(nama as int) asc ';
    }
    function _getNKA($obj,$all){ //nama key Action crud-???
        $nmKeyTabel=array();
        $no=1;

        $super=[3];
        $admin=[2,3];
        $user=[1,2,3]; //no tingkat jabatan
        $unik="MFC2G18-";
        $nm="sist";     //login sistem
        $nmKeyTabel['l-'.$nm]=array(  
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user,
            'page'=>'Login Sistem'
        );
        
        $no+=1;
        $nm="ssub";     //dashboard sistem
        $nmPage="set sub"; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'page '.$nmPage
        );
        $nmKeyTabel['u-'.$nm]=array( 
            'kd'=>$unik.$no."/2",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user,
            'page'=>'Perbarui Data '.$nmPage
        );

        $no+=1;
        $nm="renj";//inp 
        $nmPage="renja / daftar sub kegiatan terpilih"; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'Page '.$nmPage
        );
        $nmKeyTabel['1-'.$nm]=array( 
            'kd'=>$unik.$no."/2",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user,
            'page'=>'Page PRA '.$nmPage
        );
        $nmKeyTabel['2-'.$nm]=array( 
            'kd'=>$unik.$no."/3",
            'kdJabatan'=>$user,
            'nm'=>($nm."-"),
            'page'=>'Page '.$nmPage
        ); 
        $nmKeyTabel['3-'.$nm]=array(
            'kd'=>$unik.$no."/4",
            'kdJabatan'=>$user,
            'nm'=>($nm."-"),
            'page'=>'Page Final '.$nmPage
        ); 
        $nmKeyTabel['4-'.$nm]=array(
            'kd'=>$unik.$no."/5",
            'kdJabatan'=>$user,
            'nm'=>($nm."-"),
            'page'=>'Page DPA '.$nmPage
        ); 


        $no+=1;
        $nm="ibel";//inp 
        $nmPage="Input Belanja"; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'Page '.$nmPage
        );
        $nmKeyTabel['a-'.$nm]=array( 
            'kd'=>$unik.$no."/2",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user,
            'page'=>'All Action '.$nmPage
        );

        $no+=1;
        $nm="lapo";//inp 
        $nmPage="Laporan "; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'OPD '.$nmPage
        );
        $nmKeyTabel['1-'.$nm]=array( 
            'kd'=>$unik.$no."/2",
            'nm'=>($nm."-"),
            'kdJabatan'=>$admin,
            'page'=>'Rekap Belanja '.$nmPage
        );
        $nmKeyTabel['2-'.$nm]=array( 
            'kd'=>$unik.$no."/3",
            'nm'=>($nm."-"),
            'kdJabatan'=>$admin,
            'page'=>'Rekap Total Belanja '.$nmPage
        );
        $nmKeyTabel['3-'.$nm]=array( 
            'kd'=>$unik.$no."/4",
            'nm'=>($nm."-"),
            'kdJabatan'=>$admin,
            'page'=>'Rekap Berdasarkan '.$nmPage
        );

        $no+=1;
        $nm="peng";//inp 
        $nmPage="Pengaturan"; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'Akun '.$nmPage
        );


        $no+=1;
        $nm="ptah";//inp 
        $nmPage="Pilih Tahun"; 
        $nmKeyTabel['p-'.$nm]=array( 
            'kd'=>$unik.$no."/1",
            'nm'=>($nm."-"),
            'kdJabatan'=>$user, //no tingkat jabatan
            'page'=>'page '.$nmPage
        );

        if($all){
            return $nmKeyTabel;
        }{
            return $nmKeyTabel[$obj]['kd'];
        }
        
    }
?>
