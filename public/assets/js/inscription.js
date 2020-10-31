$().ready(function () {
    let regionId = $('#adhesion_region').val()
    let fonctionId = $('#adhesion_fonction').val()

    // Gestion du select branche
    $('#divBranche').fadeOut()
    $('#divBranche').children('#adhesion_branche').prop('disabled', 'disabled')
    $('#adhesion_fonction').change(function () {
        let selectedFonction = $('#adhesion_fonction').val()
        if (selectedFonction == 5 || selectedFonction == 6 || selectedFonction== 7){
            $('#divBranche').fadeIn();
            $('#divBranche').children('#adhesion_branche').prop('disabled', false)
            var branche = {
                "":"",
                "LOUVETAU":"LOUVETEAU",
                "ECLAIREUR":"ECLAIREUR",
                "CHEMINOT":"CHEMINOT",
                "ROUTIER":"ROUTIER"
            }
            $.each(branche, function (key, value) {
                $('#adhesion_branche').append($("<option></option>")
                    .attr("value", key)
                    .text(value)
                );
            })
        } else{
            $('#divBranche').fadeOut()
            $('#divBranche').children('#adhesion_branche').prop('disabled','disabled')
            $('#adhesion_branche').children().remove()
        }
    })
    
    // Gestion des district
    $('#adhesion_region').on('change', function () {
        let regionId = $(this).val()
        $.get("../../ajax/requete", {field: "region", value: regionId})
            .done(function (data) {
                if (data){
                    $('#adhesion_district').empty();
                    $('#adhesion_district').append("<option value=''>-</option>")
                    for (let i = 0; i < data.length; i++){
                        const item = data[i]
                        $('#adhesion_district').append(
                            "<option value="+item.id+">"+item.nom+"</option>"
                        )
                    }
                }
            })
    })

    // Gestion des groupes
    $('#adhesion_district').on('change', function () {
        let districtId = $(this).val()
        $.get("../../ajax/requete", {field: "district",value: districtId})
            .done(function (data) {
                if (data){
                    $('#adhesion_groupe').empty();
                    $('#adhesion_groupe').append("<option value=''>-</option>")
                    for (let i = 0; i < data.length; i++){
                        const item = data[i]
                        $('#adhesion_groupe').append(
                            "<option value="+item.id+">"+item.paroisse+"</option>"
                        )
                    }
                }
            })
    })

    // Gestion des fonction
    $('#adhesion_fonction').on('change',function () {
        let fonctionId = $(this).val()
        $.get("../../ajax/requete", {field : "fonction", value: fonctionId})
            .done(function(data) {
                if(data) {
                    $('#montant_adhesion').empty()
                    $('#montant_adhesion').append(data+" FCFA")
                }
            })
    })

    // Soumission
    $("#adhesion").submit(function (event) {
        event.preventDefault();
        var post_url = $(this).attr("action");
        var request_method = $(this).attr("method");
        var form_data = $(this).serialize();
        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data,
            dataType: 'json',
        }).done(function (response) {
            if (response.status === true){
                CinetPay.setConfig({
                    apikey: '18714242495c8ba3f4cf6068.77597603',
                    site_id: 422630,
                    notify_url: 'http://adhesion.scoutascci.org/cinetpay/notify'
                });
                CinetPay.setSignatureData({
                    amount: response.amount,
                    trans_id: response.id,
                    currency: 'CFA',
                    designation: 'Paiement de ' + parseInt(response.amount) + ' FCFA',
                });
                CinetPay.getSignature();
                CinetPay.on('signatureCreated', function (token) {});

                CinetPay.on('paymentPending', function (e) {});
                CinetPay.on('error', function (e) {});
                CinetPay.on('paymentSuccessfull', function (paymentInfo) {
                    if (typeof paymentInfo.lastTime != 'undefined') {
                        if (paymentInfo.cpm_result == '00') {
                            Swal.fire({
                                type: 'success',
                                title: 'Félicitation!',
                                text: 'votre inscription a ete effectuee avec succes. Voulez vous imprimez votre recu ?',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Oui',
                                cancelButtonText: 'Non, prochainement',
                            }).then((result) => {
                                if (result.value) {
                                    window.location = "http://adhesion.scoutascci.org/recherche/carte/";
                                } else {
                                    window.location.reload();
                                }
                            });
                        }else{
                            Swal.fire({
                                type: 'error',
                                title: 'Une erreur sur votre inscription.',
                                text: 'Veuillez contacter les administrateurs en leur transmettant le code ci-dessous.',
                                footer: response.id,
                            })
                        }
                    }
                });
            }else{
                Swal.fire({
                    type: 'error',
                    title: 'Vous êtes déjà inscrit',
                })
            }
        })
    });
});