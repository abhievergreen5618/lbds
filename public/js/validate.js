$(document).ready(function () {
    $('#inspection-type-form').validate({
      errorClass: "error fail-alert",
      validClass: "valid success-alert",
      rules: {
        name: {
          required: true,
        },
        description: {
          required: true,
        },
        status: {
          required: true,
        },
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox" || element.attr("type") == "radio")  {
            $(element).parent().parent().append(error);
        } else {
            element.after( error );
        }
    }
    });
  });