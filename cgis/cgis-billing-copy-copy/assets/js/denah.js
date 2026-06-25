function getActDtl1(id){
	var arrid = id.split("/");
	var gudang = arrid[0];
	var iddata = arrid[1];

	var arridData = iddata.split("-");
	var x = arridData[0];
	var y = arridData[1];
	var nm_blok = arridData[2];
	var idEnd = gudang+"/"+x+"-"+y;

	var n = x.toString().length;
	var n2 = y.toString().length;
	
	if(n == 1){
		var nol = "0";
		//console.log("sini j1 = "+ j);
	}else{
		nol = "";
	}
	
	if(n2 == 1){
		var nol2 = "0";
	}else {
		nol2 = "";
	}
	
	textContent = gudang + ''+ nol2 + x + '' + nol + y;

	$('input[name="LOK_AKHIR"]').val(nm_blok);
	$('input[name="KODE_GDG"]').val(gudang);
	$('input[name="blok_gdg"]').val(idEnd);
	$('input[name="X"]').val(x);
	$('input[name="Y"]').val(y);
	document.getElementById('PENUMPUKAN').value = '';

	$.ajax({
		type: 'post',
		url: site_url+'/setting/getTier',
		data: { blok:idEnd },
		success:function(data){
			document.getElementById("selectOpt").innerHTML = data;
			//var obj = $.parseJSON(data);
			//var TIER = obj['TIER'];
			//$('input[name="callTier"]').val(TIER);
			//document.getElementById('callTier2').innerHTML = TIER;
			//console.log(TIER);
			//var getTier = document.getElementById('callTier').value;//
            $('.ModalDetail').modal();
		}
	});
	

	$("#addContPlan").click(function(){
		
		var NO_SPK = document.getElementById('NO_SPK').value;
		var KODE_GDG = document.getElementById('KODE_GDG').value;
		var ID_JOB = document.getElementById('id_job').value;
		var BLOK = document.getElementById('blok_gdg').value;
		var LOK_AKHIR = document.getElementById('LOK_AKHIR').value;
		var NO_CONT = document.getElementById('NO_CONT').value;
		var PENUMPUKAN = document.getElementById('PENUMPUKAN').value;
		var no_dok = document.getElementById('no_dok').value;
		var jns_kegiatan = document.getElementById('jns_kegiatan').value;
		var lokasi_awal = document.getElementById('lok_awal').value;
		var X = document.getElementById('X').value;
		var Y = document.getElementById('Y').value;
		$.ajax({
			type: 'post',
			url: site_url+'/setting/insertGudang',
			data: { KODE_GDG:KODE_GDG, BLOK:BLOK, LOK_AKHIR:LOK_AKHIR, NO_CONT:NO_CONT, PENUMPUKAN:PENUMPUKAN, X:X, Y:Y, NO_SPK:NO_SPK, no_dok:no_dok, jns_kegiatan:jns_kegiatan, lokasi_awal:lokasi_awal },
			success:function(data){
				var obj = $.parseJSON(data);
				var BLOK = obj[0]['LEVEL_4'];
				console.log(BLOK);
			}
		});
		
		$('.ModalDetail').modal('hide');
		setTimeout(function () {
			window.location.href = '<?php echo site_url();?>/planning/placement';
		}, 100);
	});
	
	$("#addContPlanRelocation").click(function(){
		//console.log("sini");
		var NO_SPK = document.getElementById('NO_SPK').value;
		var KODE_GDG = document.getElementById('KODE_GDG').value;
		var ID_JOB = document.getElementById('id_job').value;
		var BLOK = document.getElementById('blok_gdg').value;
		var LOK_AKHIR = document.getElementById('LOK_AKHIR').value;
		var LOK_AKHIR_LOCATION = document.getElementById('LOK_AKHIR_LOCATION').value;
		var TIER_AKHIR_LOCATION = document.getElementById('TIER_AKHIR_LOCATION').value;
		var NO_CONT = document.getElementById('NO_CONT').value;
		var PENUMPUKAN = document.getElementById('PENUMPUKAN').value;
		var X = document.getElementById('X').value;
		var Y = document.getElementById('Y').value;
		$.ajax({
			type: 'post',
			url: site_url+'/setting/updateGudangRelocation',
			data: { ID_JOB:ID_JOB, KODE_GDG:KODE_GDG, BLOK:BLOK, LOK_AKHIR_LOCATION:LOK_AKHIR_LOCATION,LOK_AKHIR:LOK_AKHIR, NO_CONT:NO_CONT, TIER_AKHIR_LOCATION:TIER_AKHIR_LOCATION,PENUMPUKAN:PENUMPUKAN, X:X, Y:Y, NO_SPK:NO_SPK },
			success:function(data){
				var obj = $.parseJSON(data);
				var BLOK = obj[0]['LEVEL_4'];
				console.log(obj);
			}
		});
		//return false;
		$('.ModalDetail').modal('hide');
		//window.location.reload(true);
		var setUrl = 'http://103.29.187.33/tpk_ipc/cgis/application.php/planning/placement';
		setTimeout(function () {
			window.location.href = setUrl;
		}, 100);
		//window.location.href = site_url+'/planning/placement';
	});
}

function alertMsg(){
    //return confirm ("BLOK SUDAH PENUH!");
    swalert('error','Maaf, Blok Sudah Penuh');
	return false;
}