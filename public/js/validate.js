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
          email:true,
        },
        applicantmobile: {
          required: true,
          minlength: 10,
          maxlength: 10,
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
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox" || element.attr("type") == "radio")  {
            $(element).parent().parent().append(error);
        } else {
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
          email:true,
          required: true,
        },
        employeemobile: {
          required: true,
          minlength: 10,
          maxlength: 10,
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
        employeepassword : {
          required: true,
          minlength : 8
        },
        password_confirmation : {
          required: true,
          minlength : 8,
          equalTo : '#password',
        }
      },
      errorPlacement: function (error, element) {
        if (element.attr("type") == "checkbox" || element.attr("type") == "radio")  {
            $(element).parent().parent().append(error);
        }
        else if(element.attr("name") == "password")
        {
            $(element).parent().append(error);
        } 
        else {
            element.after(error);
        }
    }
    });
  });