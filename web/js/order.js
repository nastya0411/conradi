$(() => {

    const loadPayType = (url, type) => 
        $.ajax({
            url:  `${url}?type=${type}`,
            method: "POST",
            success(data) {
                if (data.status) {
                    $("#order-pay_type_id option").remove();
                    $("#order-pay_type_id")
                        .append(`<option value="">Выберете тип оплаты:</option>`)
                    Object
                        .entries(data.options)
                        .forEach((el) => {
                            $("#order-pay_type_id")
                                .append(`<option value="${el[0]}">${el[1]}</option>`)
                        })
                }
            }
        })

    $('#order-pay_receipt').on('change', function() {        
        if ($(this).prop('checked')) {        
            loadPayType($(this).data('url'), $(this).data('on-filter'))
        } else {            
            loadPayType($(this).data('url'), $(this).data('off-filter'))
        }
    })
})