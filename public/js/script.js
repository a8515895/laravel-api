function addProduct(data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        method : 'POST',
        url: url+'addCart',
        data : data,
        success : function(kq){
            toastr.success("Thêm giỏ hàng thành công","Success! ");
            res = $.parseJSON(kq);
            $("#information-cart").val(`${res.qty} sản phẩm - ${number_format(res.total)} VND`);        
        }
    });
}
function updateProduct(event,id){
    if(checkNumber(event)){
        let qty = event.target.value;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
            method : 'PUT',
            url: url+'updateCart',
            data : {id : id,qty : qty},
            success : function(kq){
                res = $.parseJSON(kq);
                $("#information-cart").val(`${res.qty} sản phẩm - ${number_format(res.total)} VND`);        
            }
        });
    }
}
function removeCart(data){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        method : 'POST',
        url: url+'removeCart',
        data : {id : data},
        success : function(kq){
            if(data == null) {
                window.location.href = window.location.origin;
            }else{
                window.location.href = window.location;
            }
        }
    });
}
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
function clickTab(it,href){
    $(`.tab-item`).removeClass('activeTab');
    $(`.tab-click`).removeClass('activeTab');
    $(it).addClass('activeTab');
    $(`.tab-item[href=${href}]`).addClass('activeTab');
}
function clickForm(idForm,urlAjax,option){
    let method = 'post'
    if(option.method != null && option.method != ''){
        method = option.method;
    }
    var form = $('form#'+idForm);
    var formData = new FormData(form[0]);
    if(formData == null || formData ==""){
        toastr.error("Chưa nhập đầy đủ thông tin","Error!");
    }

    $.ajax({
        method: method,
        type: method,
        url: urlAjax,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        data: formData,
        contentType: false, 
        processData: false,
        success: function (kq) {                 
            if(kq == 0) {
                if(option.url == null ||  option.url == ''){
                    window.location.href = url;
                }
                else{
                    if(option.url != 'none')
                    window.location.href = option.url;                    
                }
            }
            else{                
                res=$.parseJSON(kq);
                toastr.error(res.err,option.title);
            }
        }
    });
}
function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
function checkNumber (event) {   
    if ((event.keyCode > 47 && event.keyCode < 59) || event.keyCode == 8 || (event.keyCode > 95 && event.keyCode < 106) || (event.keyCode > 36 && event.keyCode < 41)){
        return true;
    }else {
        event.preventDefault(); 
        return false;
    }
}