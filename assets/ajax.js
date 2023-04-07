$(document).ready(function(){
    function getTest() {
        (function worker() {
            $.ajax({
                url: '../inc/backend/coucou.php',
                success: function(data) {
                    $('#getTest').html(data);
                },
                complete: function() {
                    setTimeout(worker, 3000);
                }
            });
        })();
    }


    // CHOISIR LES ID DES PC DEMANDÉ
    $('button[name="editExtrasPc"]').click(function() {
        var dateReserv = $('input[name="dateReserv"]').val();
        var maxExtrasPc = $('#inpExtrasPc').attr('max');

        var act = $(this).val();

        if ($('#inpExtrasPc').val() <= maxExtrasPc) {
            if (act == "add") {
                if ($('#inpExtrasPc').val() < maxExtrasPc) {
                    $('#nbExtrasPc').text(parseInt($('#inpExtrasPc').val()) + 1);
                    $('#inpExtrasPc').val(parseInt($('#inpExtrasPc').val()) + 1);
                    // console.log($('#inpExtrasPc').val());
                }
            } else {
                if ($('#inpExtrasPc').val() > 0) {
                    $('#nbExtrasPc').text(parseInt($('#inpExtrasPc').val()) - 1);
                    $('#inpExtrasPc').val(parseInt($('#inpExtrasPc').val()) - 1);
                    // console.log($('#inpExtrasPc').val());
                }
            }

            var inpExtrasPc = $('#inpExtrasPc').val();

            $.ajax({
                url: '../inc/backend/extrasDispo.php',
                type: 'POST',
                data: {
                    act: act,
                    typeRess: 'PC',
                    dateReserv: dateReserv,
                    nbExtras: inpExtrasPc
                },
                success: function(data) {
                    $('#listExtrasPc').html(data);
                },
                error: function(xhr, status, error) {
                    $('#listExtrasPc').html('Une erreur est survenue : ' + error);
                }
            });
            // console.log(act);
        }
    });

    // CHOISIR LES ID DES PLACE DE PARKING DEMANDÉ
    $('button[name="editExtrasPlPark"]').click(function() {
        var dateReserv = $('input[name="dateReserv"]').val();
        var maxExtrasPlPark = $('#inpExtrasPlPark').attr('max');

        var act = $(this).val();

        if ($('#inpExtrasPlPark').val() <= maxExtrasPlPark) {
            if (act == "add") {
                if ($('#inpExtrasPlPark').val() < maxExtrasPlPark) {
                    $('#nbExtrasPlPark').text(parseInt($('#inpExtrasPlPark').val()) + 1);
                    $('#inpExtrasPlPark').val(parseInt($('#inpExtrasPlPark').val()) + 1);
                    // console.log($('#inpExtrasPlPark').val());
                }
            } else {
                if ($('#inpExtrasPlPark').val() > 0) {
                    $('#nbExtrasPlPark').text(parseInt($('#inpExtrasPlPark').val()) - 1);
                    $('#inpExtrasPlPark').val(parseInt($('#inpExtrasPlPark').val()) - 1);
                    // console.log($('#inpExtrasPlPark').val());
                }
            }

            var inpExtrasPlPark = $('#inpExtrasPlPark').val();

            $.ajax({
                url: '../inc/backend/extrasDispo.php',
                type: 'POST',
                data: {
                    act: act,
                    typeRess: 'PK',
                    dateReserv: dateReserv,
                    nbExtras: inpExtrasPlPark
                },
                success: function(data) {
                    $('#listExtrasPlPark').html(data);
                },
                error: function(xhr, status, error) {
                    $('#listExtrasPlPark').html('Une erreur est survenue : ' + error);
                }
            });
            console.log(act);
        } else if ($('#inpExtrasPc').val() == 0 && $('#inpExtrasPlPark').val() == 0) {
            $('#listExtrasPc').html("<i>Aucun extras</i>");
        } else if ($('#inpExtrasPlPark').val() == 0) {
            $('#inpExtrasPlPark').html("");
            // console.log('coucou');
        }
    });
});