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
    $('#requestform').validate({
      errorClass: "error fail-alert",
      validClass: "valid success-alert",
      rules: {
        inspectiontype: {
          required: true,
        },
        applicantname: {
          required: true,
        },
        applicantemail: {
          required: true,
        },
        applicantmobile: {
          required: true,
        },
        address: {
          required: true,
        },
        city: {
          required: true,
        },
        state: {
          required: true,
        },
        zipcode: {
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