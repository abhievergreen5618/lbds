// for getting form values

function getFormData($form) {

    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    const array_value = [];
    const posts=[];
    // console.log(unindexed_array);

    $.each(unindexed_array, function (key, value) {
    //   console.log(value);
        name = value.name;

        val = value.value;

        if (val.length) {

            if (name == "sendinvoice[]") {
                posts.push(val);

                // indexed_array[name] = posts;

            }
            if (name == "inspectiontype[]") {

                array_value.push(val);
                indexed_array[name] = array_value;

            } else {

                indexed_array[name] = val;

            }

        }

    });
    indexed_array['sendinvoice[]']=posts;
    return indexed_array;

}

// submit request form

function requestformsubmit() {
    var formdata = getFormData($("#requestform"));
    $.ajax({
        url: "requestsubmit",
        data: formdata,
        type: 'Post',
        dataType: 'json',
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (res) {
            $('.preloader').children().hide();
            $('.preloader').css("height", "0");
            Swal.fire({
                icon: 'success',
                title: 'Good job!',
                text: res.msg,
                showConfirmButton: false,
                timer: 1000,
            }).then((result) => {
                window.location.href = res.newlocation;
            });
        },
        error: function (xhr) {
            $('.preloader').children().hide();
            $('.preloader').css("height", "0");
            if (xhr.status == 422) {
                $('*').removeClass("is-invalid-special");
                $.each(xhr.responseJSON.errors, function (key, value) {
                    if (key == "agency") {
                        $("[name='" + key + "']").next().focus();
                        $("#error-" + key).remove();
                        $("[name='" + key + "']").next().after("<label id='error-" + key + "' class='error fail-alert'>" + value + "</label>");
                    } else if (key == "sendinvoice") {
                        $("[name='sendinvoice[]']:first").focus();
                        $("#error-" + key).remove();
                        $("[name='sendinvoice[]']:first").parent().parent().parent().parent().append("<label id='error-" + key + "' class='error fail-alert'>" + value + "</label>");
                    } else if (key == "inspectiontype") {
                        $("[name='inspectiontype[]']:first").focus();
                        $("#error-" + key).remove();
                        $("[name='inspectiontype[]']:first").parent().parent().parent().parent().append("<label id='error-" + key + "' class='error fail-alert'>" + value + "</label>");
                    } else {
                        $("[name='" + key + "']").focus();
                        $("#error-" + key).remove();
                        $("[name='" + key + "']").after("<label id='error-" + key + "' class='error fail-alert'>" + value + "</label>");
                    }
                });
            }
        },
    });
}

function ucfirst(str, force) {
    str = force ? str.toLowerCase() : str;
    return str.replace(/(\b)([a-zA-Z])/,
        function (firstLetter) {
            return firstLetter.toUpperCase();
        });
}

// function copy(text){
//     var $temp = $("<div>");
//     $("body").append($temp);
//     $temp.attr("contenteditable", true)
//          .html(text).select()
//          .on("focus", function() { document.execCommand('selectAll',false,null); })
//          .focus();
//     document.execCommand("copy");
//     $temp.remove();
// }

function setTooltip(message) {
    $('#copy').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip() {
    setTimeout(function () {
        $('#copy').tooltip('hide');
    }, 1000);
}
