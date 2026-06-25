$( document ).ready(function() {
    let err = 0;
    $('.sendingnpct1').each(function(i, obj) {
        err++;
    });
    if (err > 0) {
        $('#str').prop('disabled',true);
    }
});

$(document).on('click','a#send',function () {
    let cont = $(this).data('cont');
    let nomerspk = $(this).data('nomerspk');
    let plat = $('#kond'+cont).find(":selected").text();
    console.log(cont);
    // let response = 'test';
    // console.log(response);
    if (plat != 'NONE') {
        $('a#nosuc.'+cont).remove();
        $.ajax({
            type: "POST",
            ContentType: "application/json",
            url: '/tpk_ipc/cgis/handheld.php/operation/kirimnpct1_new',
            data: {container:cont,no_plat:plat},
            dataType: "json",
            success : function(response){
                console.log(response);
                if (response.status == 'success') {
                    $('.'+cont).replaceWith(`<a class='btn btn-success ${cont}' style='display: inherit;'>S</a><a class='btn btn-primary pik${cont}' data-cont='${cont}' data-nomerspk='${nomerspk}' id="pickupajax" style='display: inherit;'>Pickup</a>`);
                    swal("Info", "Terkirim", "success")
                }else{
                    $('.'+cont).replaceWith(`<a class='btn btn-warning ${cont}' style='display: inherit;' id='nosuc'>E</a><a class='btn btn-primary sendingnpct1 ${cont}' data-cont='${cont}' id="send" style='display: inherit;'>Send</a>`);
                    swal("Info", "Tidak Terkirim", "error")
                }
                
            }
            // success: function(response) {
            //     console.log('SUCCESS BLOCK');
            //     console.log(response.status);
            // },
            // error: function(response) {
            //     console.log('ERROR BLOCK');
            //     console.log(response);
            // }
        });
        let err2 = 0;
        $('.sendingnpct1').each(function(i, obj) {
            err2++;
        });
        console.log(err2);
        if (err2 == 1) {
            $('#str').removeAttr('disabled');
        }
       
    } else {
        swal("Info", "Mohon Isi Truck Terlebih dahulu", "error")
    }
});


$(document).on('click','a#pickupajax',function () {
    let cont = $(this).data('cont');
    let nomerspk = $(this).data('nomerspk');
    $.ajax({
        type: "POST",
        url: '/tpk_ipc/cgis/handheld.php/operation/pickuppercontainer',
        data: {nocont:cont,nomerspk:nomerspk},
        dataType: 'json',
        success: function(response){
            console.log(response);
            if (response.status == 'success') {
                $(`.pik${cont}`).replaceWith(`<a class='btn btn-success ${cont}' style='display: inherit;'>P</a>`);
            }else{
                swal("Info", "Pickup Error", "error")
            }
            
        }
   });
   let err2 = 0;
    $('.sendingnpct1').each(function(i, obj) {
        err2++;
    });
    console.log(err2);
    if (err2 == 1) {
        $('#str').removeAttr('disabled');
    }
});

$(document).ajaxStart(function() {
    $('#loader').show();
 });
 $(document).ajaxStop(function() {
    $('#loader').hide();
 });
