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
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      } else {
        element.after(error);
      }
    }
  });
  jQuery.validator.addMethod("phoneUS", function (phone_number, element) {
    return (phone_number.match(/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im)) ? true : false;
  }, "Invalid phone number");
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
        email: true,
      },
      applicantmobile: {
        required: true,
        // phoneUS: true,
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
      comments: {
        required: true,
      },
      report: {
        required: true,
      },
      agency: {
        required: true,
      },
      "inspectiontype[]": {
        required: true,
      },
      'sendinvoice[]': {
        required: true,
      },
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().parent().parent().append(error);
      }
      else if (element.attr("name") == "agency") {
        $(element).parent().append(error);
      }
      else {
        element.after(error);
      }
    }
  });
  $('#employeeaddform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      employeename: {
        required: true,
      },
      employeeemail: {
        email: true,
        required: true,
      },
      employeemobile: {
        required: true,
        phoneUS: true,
      },
      employeeaddress: {
        required: true,
      },
      employeecity: {
        required: true,
      },
      employeestate: {
        required: true,
      },
      employeezipcode: {
        required: true,
      },
      employeepassword: {
        required: true,
        minlength: 8
      },
      password_confirmation: {
        required: true,
        minlength: 8,
        equalTo: '#password',
      }
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      }
      else if (element.attr("name") == "password") {
        $(element).parent().append(error);
      }
      else {
        element.after(error);
      }
    }
  });

  $('#employeeupdateform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      employeename: {
        required: true,
      },
      employeeemail: {
        email: true,
        required: true,
      },
      employeemobile: {
        required: true,
        phoneUS: true,
      },
      employeeaddress: {
        required: true,
      },
      employeecity: {
        required: true,
      },
      employeestate: {
        required: true,
      },
      employeezipcode: {
        required: true,
      },
      employeepassword: {
        required: false,
        minlength: 8
      },
      password_confirmation: {
        required: false,
        minlength: 8,
        equalTo: '#password',
      }
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      } else if (element.attr("name") == "password") {
        $(element).parent().append(error);
      } else {
        element.after(error);
      }
    }
  });
  $('#profile-form').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      name: {
        required: true,
      },
      mobile_number: {
        required: true,
        phoneUS: true,
      },
      email: {
        email: true,
        required: true,
      },
    },
  });
  $('#profile-form-password').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      old_password: {
        required: true,
      },
      password: {
        required: true,
        minlength: 8
      },
      password_confirmation: {
        required: true,
        minlength: 8,
        equalTo: '#password',
      },
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      }
      else if (element.attr("name") == "password") {
        $(element).parent().append(error);
      }
      else {
        element.after(error);
      }
    }
  });

  //
  $('#agencyaddform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      company_name: {
        required: true,
      },
      city: {
        required: true,
      },
      company_address: {
        required: true,
      },
      company_phonenumber: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      name: {
        required: true,
      },
      direct_number: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      zip_code: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 8
      },
      password_confirmation: {
        required: true,
        minlength: 8,
        equalTo: '#password',
      }
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      } else if (element.attr("name") == "password") {
        $(element).parent().append(error);
      } else {
        element.after(error);
      }
    }
  });


  $('#agencyupdateform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      company_name: {
        required: true,
      },
      city: {
        required: true,
      },
      company_address: {
        required: true,
      },
      company_phonenumber: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      name: {
        required: true,
      },
      direct_number: {
        required: true,
        minlength: 10,
        maxlength: 10,
      },
      zip_code: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: false,
        minlength: 8
      },
      password_confirmation: {
        required: false,
        minlength: 8,
        equalTo: '#password',
      }
    },
    errorPlacement: function (error, element) {
      if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().append(error);
      } else if (element.attr("name") == "password") {
        $(element).parent().append(error);
      } else {
        element.after(error);
      }
    }
  });
  $('#websiteconfigurationform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
    },
  });
  $('#emailconfiguration').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    rules: {
      mail_host: {
        required: true,
      },
      mail_port: {
        required: true,
      },
      mail_username: {
        required: true,
      },
      mail_password: {
        required: true,
      },
      mail_address: {
        required: true,
        email: true,
      },
      mail_encryption: {
        required: true,
      },
    },
  });
  $('#reportmailform').validate({
    errorClass: "error fail-alert",
    validClass: "valid success-alert",
    ignore: ':hidden:not(.summernote),.note-editable.card-block',
    rules: {
      "reportmailto[]": {
        required: true,
      },
      subject: {
        required: true,
      },
      message: {
        required: true,
      },
      "attachments[]": {
        required: true,
      },
    },
    errorPlacement: function (error, element) {
      if (element.attr("id") === "reportmailto") {
          $(element).parent().after(error);
      }
      else if (element.hasClass("summernote")) {
        error.insertAfter(element.siblings(".note-editor"));
      }
      else if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
        $(element).parent().parent().parent().parent().append(error);
      }
      else {
        element.after(error);
      }
    }
  });
});

$('#inspectorform').validate({
  errorClass: "error fail-alert",
  validClass: "valid success-alert",
  rules: {
    name: {
      required: true,
    },
    company_name: {
      required: true,
    },
    company_address: {
      required: true,
    },
    number: {
      required: true,
      minlength: 10,
      maxlength: 10,
    },
    license_number: {
      required: true,
    },
    email: {
      required: true,
      email: true,
    },
    area_coverage:{
      required: true,
    },
    color_code:{
      required: true,
    },
    password: {
      required: true,
      minlength: 8
    },

  },
  errorPlacement: function (error, element) {
    if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
      $(element).parent().parent().append(error);
    } else if (element.attr("name") == "password") {
      $(element).parent().append(error);
    } else {
      element.after(error);
    }
  }
});

$('#inspectorupdateform').validate({
  errorClass: "error fail-alert",
  validClass: "valid success-alert",
  rules: {
    name: {
      required: true,
    },
    company_name: {
      required: true,
    },
    company_address: {
      required: true,
    },
    number: {
      required: true,
      minlength: 10,
      maxlength: 10,
    },
    license_number: {
      required: true,
    },
    email: {
      required: true,
      email: true,
    },
    area_coverage:{
      required: true,
    },
    color_code:{
      required: true,
    },
    password: {
      required: true,
      minlength: 8
    },

  },
  errorPlacement: function (error, element) {
    if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
      $(element).parent().parent().append(error);
    } else if (element.attr("name") == "password") {
      $(element).parent().append(error);
    } else {
      element.after(error);
    }
  }
});


$('#register-form').validate({
  errorClass: "error fail-alert",
  validClass: "valid success-alert",
  rules: {
    company_name: {
      required: true,
    },
    city: {
      required: true,
    },
    company_address: {
      required: true,
    },
    company_phonenumber: {
      required: true,
      minlength: 10,
      maxlength: 10,
    },
    name: {
      required: true,
    },
    direct_number: {
      required: true,
      minlength: 10,
      maxlength: 10,
    },
    zip_code: {
      required: true,
    },
    email: {
      required: true,
      email: true,
    },
    password: {
      required: true,
      minlength: 8
    },
    password_confirmation: {
      required: true,
      minlength: 8,
      equalTo: '#password',
    }
  },
  errorPlacement: function (error, element) {
    if (element.attr("type") == "checkbox" || element.attr("type") == "radio") {
      $(element).parent().parent().append(error);
    } else if (element.attr("name") == "password") {
      $(element).parent().append(error);
    } else {
      element.after(error);
    }
  }
});