$(function () {
    $("#addSerialNumber").validate({
        rules: {
            serial_number: {
                required: true
            }
        },
        messages: {
            serial_number: {
                required: "请输入汇款流水号"
            }
        }
    })

})
