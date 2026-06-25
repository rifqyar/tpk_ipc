
--sdfsfsdgf
SELECT no_respon,tg_respon FROM t_ppk_hdr WHERE left(no_respon,4) = '2021' AND RIGHT(no_respon,6) = '001608';
SELECT no_dok,tgl_dok,kd_req from t_request  WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';
SELECT no_dok,tgl_dok FROM t_gatepass WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';
SELECT no_dok,tgl_dok FROM t_spk WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';
SELECT no_dok FROM t_job_slip  WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';
SELECT no_dok FROM t_operation WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';
SELECT no_dok FROM t_op_inspection  WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608';


update t_gatepass set no_dok = '2021.2.0300.0.K02.I.001608' WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608 ';
update t_spk set no_dok = '2021.2.0300.0.K02.I.001608' WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608 ';
update t_job_slip set no_dok = '2021.2.0300.0.K02.I.001608'  WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608 ';
update t_operation set no_dok = '2021.2.0300.0.K02.I.001608' WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608 ';
update t_op_inspection set no_dok = '2021.2.0300.0.K02.I.001608'  WHERE left(no_dok,4) = '2021' AND RIGHT(no_dok,6) = '001608 ';
--

--dweling time
SELECT distinct bb.NO_SPK,aa.NO_DOK,aa.TGL_DOK,aa.NO_CONT,ff.KD_CONT_TIPE,ff.WK_IN,nn.W_BEHANDLE,dd.WK_GATEOUT ,DATEDIFF(dd.WK_GATEOUT,nn.W_BEHANDLE) AS 'DWELING CA' FROM (
	SELECT a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.TIPE_CONT,b.KD_STATUS,b.DISCHARGE,b.CALL_SIGN,b.VESSEL,b.VOY_IN FROM t_request a JOIN t_request_cont b ON a.ID = b.ID AND b.KD_STATUS = 'INQUIRY') aa
JOIN (
	SELECT c.NO_SPK,c.NO_DOK,c.TGL_DOK,c.WK_REQ,d.NO_CONT from t_spk c JOIN t_spk_cont d ON c.ID = d.ID) bb
ON aa.NO_DOK = bb.NO_DOK AND aa.TGL_DOK = bb.TGL_DOK AND aa.no_cont = bb.no_cont
JOIN t_op_delivery dd ON dd.NO_SPK = bb.no_spk AND dd.NO_CONT = bb.no_cont
JOIN (
	SELECT f.CALL_SIGN,f.NM_ANGKUT,f.NO_VOY_FLIGHT,g.NO_CONT,g.KD_CONT_TIPE,g.WK_IN FROM t_cocostshdr f JOIN t_cocostscont g ON f.ID = g.ID) ff
ON ff.CALL_SIGN = aa.CALL_SIGN and ff.NM_ANGKUT = aa.VESSEL and ff.NO_VOY_FLIGHT = aa.VOY_IN AND  ff.NO_CONT =  aa.NO_CONT
LEFT JOIN t_op_behandlein nn ON bb.NO_SPK = nn.NO_SPK AND bb.NO_CONT = nn.NO_CONT
WHERE YEAR(bb.WK_REQ) = 2020 AND MONTH(bb.WK_REQ) = 4 AND ff.KD_CONT_TIPE = 'DRY'



--join
SELECT distinct A.NO_CONT 'NO KONTAINER',A.LNSW_NOAJU,A.LNSW_TGLAJU,A.NO_RESPON,A.TG_RESPON,A.NO_DAFTAR_PABEAN,A.TGL_DAFTAR_PABEAN,case when D.STATUS_CONT = 900 then 'DELIVERY' ELSE 'BEHANDLE CA' END,E.NM_KAPAL,E.NO_VOY,E.NAMA_CUST,G.START_INSP, F.FINISH_INSP
FROM v_ppk_permit_join A
JOIN (
SELECT b.NO_DOK, b.TGL_DOK, c.NO_CONT, c.STATUS_CONT, b.NM_KAPAL, b.NO_VOY, b.NPWP, b.CONSIGNEE
FROM t_spk b
JOIN t_spk_cont c ON b.id = c.id) D ON A.NO_RESPON = D.NO_DOK AND A.TG_RESPON = D.TGL_DOK AND A.NO_CONT = D.NO_CONT
LEFT JOIN t_gatepass E ON A.NO_RESPON = E.NO_DOK AND A.TG_RESPON = E.TGL_DOK AND A.NO_CONT = E.NO_CONT
LEFT JOIN t_op_inspection F ON F.NO_DOK = A.NO_DAFTAR_PABEAN AND YEAR(F.TGL_DOK) = YEAR(A.TGL_DAFTAR_PABEAN) AND F.NO_CONT = A.NO_CONT
LEFT JOIN t_op_inspection G ON G.NO_DOK = A.NO_RESPON AND YEAR(G.TGL_DOK) = YEAR(A.TG_RESPON) AND G.NO_CONT = A.NO_CONT
ORDER BY A.TGL_DAFTAR_PABEAN DESC,D.STATUS_CONT asc


-- reefer dari delivery
SELECT no_cont,plug_start_date,plug_end_date FROM req_delivery_dtl
WHERE no_cont in ('EMCU5288406','MNBU0085948','MNBU0266360','MNBU3226090','MNBU3260793','MNBU3319588','MNBU3865341','MNBU3934376','MNBU9047888','MNBU9151418','MSWU0010026','MSWU0012008','MSWU0013262','MWCU6831352','MWMU6406754','SZLU9695494')
and tarif_id = '172'
ORDER BY no_cont asc


----reefer
SELECT aa.id,aa.NO_DOK,aa.TGL_DOK,aa.NO_CONT,aa.TIPE_CONT,aa.KD_STATUS,aa.DISCHARGE,aa.PLUG_TERMINAL,aa.UNPLUG_TERMINAL FROM (
	SELECT b.id,a.NO_DOK,a.TGL_DOK,b.NO_CONT,b.TIPE_CONT,b.KD_STATUS,b.DISCHARGE,b.CALL_SIGN,b.VESSEL,b.VOY_IN,b.PLUG_TERMINAL,b.UNPLUG_TERMINAL FROM t_request a JOIN t_request_cont b ON a.ID = b.ID AND b.KD_STATUS = 'INQUIRY') aa
JOIN (
	SELECT c.NO_SPK,c.NO_DOK,c.TGL_DOK,c.WK_REQ,d.NO_CONT from t_spk c JOIN t_spk_cont d ON c.ID = d.ID) bb
ON aa.NO_DOK = bb.NO_DOK AND aa.TGL_DOK = bb.TGL_DOK AND aa.no_cont = bb.no_cont
WHERE bb.no_cont IN ('EMCU5288406','MNBU0085948','MNBU0266360','MNBU3226090','MNBU3260793','MNBU3319588','MNBU3865341','MNBU3934376','MNBU9047888','MNBU9151418','MSWU0010026','MSWU0012008','MSWU0013262','MWCU6831352','MWMU6406754','SZLU9695494')
AND date(aa.tgl_dok) > DATE('2020-12-01') 
ORDER BY aa.NO_CONT asc