INSERT INTO `apbd2`(`kdApbd2`, `kdApbd1`, `nmApbd2`, `deskripsi`, `taApbd2`)  (
	SELECT `kdApbd2`, `kdApbd1`, `nmApbd2`, `deskripsi`, "2026" from apbd2 WHERE taApbd2='2025'
);


INSERT INTO `apbd3`(`kdApbd3`, `kdApbd2`, `nmApbd3`, `deskripsi`, `taApbd3`)  (
	SELECT `kdApbd3`, `kdApbd1`, `nmApbd3`, `deskripsi`, "2026" from apbd3 WHERE taApbd3='2025'
);

INSERT INTO `apbd4`(`kdApbd4`, `kdApbd3`, `nmApbd4`, `deskripsi`, `taApbd4`)  (
	SELECT `kdApbd4`, `kdApbd3`, `nmApbd4`, `deskripsi`, "2026" from apbd4 WHERE taApbd4='2025'
);

INSERT INTO `apbd5`(`kdApbd5`, `kdApbd4`, `nmApbd5`, `deskripsi`, `taApbd5`)  (
	SELECT `kdApbd5`, `kdApbd4`, `nmApbd5`, `deskripsi`, "2026" from apbd5 WHERE taApbd5='2025'
);

INSERT INTO `apbd6`(`kdApbd6`, `kdApbd5`, `nmApbd6`, `deskripsi`, `taApbd6`)  (
	SELECT `kdApbd6`, `kdApbd5`, `nmApbd6`, `deskripsi`, "2026" from apbd6 WHERE taApbd6='2025'
);

INSERT INTO `purusan`(`kdUrusan`, `nmUrusan`, `taUrusan`) (
	SELECT `kdUrusan`, `nmUrusan`, '2026' FROM `purusan` where taUrusan ='2025'
)

INSERT INTO `pbidang`(`kdbidang`, `nmbidang`, `tabidang`) (
	SELECT `kdbidang`, `nmbidang`, '2026' FROM `pbidang` where tabidang ='2025'
)

INSERT IGNORE INTO `pprogram`(`kdprog`, `nmprog`, `taprog`) 
SELECT `kdprog`, `nmprog`, '2026' FROM `pprogram` where taprog ='2025';

INSERT IGNORE INTO pkegiatan (kdkeg, nmkeg, takeg)
SELECT kdkeg, nmkeg, '2026'
FROM pkegiatan
WHERE takeg = '2025';
