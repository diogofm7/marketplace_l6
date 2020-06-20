function processPayment(token, buttonTarget) {
    let data = {
        card_token: token,
        hash: PagSeguroDirectPayment.getSenderHash(),
        installment: document.querySelector('select.select_installments').value,
        card_name: document.querySelector('input[name=card_name]').value,
        _token: csrf
    };

    $.ajax({
        type: 'POST',
        url: urlProcess,
        data: data,
        dataType: 'json',
        error: function () {
            $("#pagando").html("<h5 class='text-danger font-weight-bolder'>Tivemos um problema com seu pagamento!!!</h5>");
            $("#loader").hide();
            buttonTarget.disabled = false;
        },
        success: function (res) {
            toastr.success(res.data.message, 'Sucesso');
            $("#loader").hide();
            $("#pagando").html("");
            setTimeout(function(){
                window.location.href = `${urlThanks}?order=${res.data.order}`;
            },2000);
        }
    });
}


function getInstallments(amount, brand) {
    PagSeguroDirectPayment.getInstallments({
        amount: amount,
        brand: brand,
        maxInstallmentNoInterest: 0,
        success: function (res) {
            let selectInstallments = drawSelectInstallments(res.installments[brand]);
            document.querySelector('div.installments').innerHTML = selectInstallments;
        },
        error: function (err) {
            console.log(err);
        }
    })
}

function drawSelectInstallments(installments) {
    let select = '<label>Opções de Parcelamento:</label>';

    select += '<select class="form-control select_installments">';

    for(let l of installments) {
        select += `<option value="${l.quantity}|${l.installmentAmount}">${l.quantity}x de ${l.installmentAmount.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})} - Total fica ${l.totalAmount.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})}</option>`;
    }

    select += '</select>';

    return select;
}
