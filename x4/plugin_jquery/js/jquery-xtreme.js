setTimeout(function () {
    $.postJSON = function (url, data, callback) {
        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "json",
            success: callback
        });
    };
}, 1);
