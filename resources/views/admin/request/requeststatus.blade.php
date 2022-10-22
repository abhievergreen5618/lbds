@push('header_extras')
<link rel="stylesheet" href="{{asset('/css/all.css')}}">
<style>
    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: flex;
        justify-content: space-around;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 20px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    /* .btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
} */

    .btn-circle {
        width: 44px;
        height: 40px;
        text-align: center;
        padding: 10px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
    }

    .requestdetailcard {
        background-color: #007bff;
        color: white;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        color: black !important;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    .section1 {
        background-color: #f5f5f5;
        padding: 2%;
    }

    h4.mb-1.font-weight-bold.text-danger {
        text-align: right;
    }

    .container-fluid.VV {
        background-color: white;
        padding: 28PX;
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
        margin-top: 15px;
    }

    svg.svg-inline--fa.fa-bars.fa-w-14.fa-lg {
        color: black;
        margin-top: 7px;
    }

    .px-4.nav.justify-content-between {
        margin-top: -19%;
    }

    button.accordion-button.collapsed {
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
        padding-top: 19px;
        margin-top: 23px;
        font-weight: 500;
        font-size: 20px;
    }

    .row.btn-danger {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid #f5eeee;
        box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%);
    }

    .col-12.p-4.bg-white.shadow-sm.brequest.rounded-10 {
        margin-top: 24px;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="section1">
    <div class="container-fluid">
        <div class="row jj">
            <div class="col-md-6">
                <div>
                    <h3 class="mb-1 font-weight-bold text-black">Request
                        Information</h3>
                    <h6 class="mb-0 font-95 col-6 px-2 p-1 bg-dark
                        font-weight-600"><span class="text-white">Request #
                            0eaff1</span></h6>
                </div>
            </div>

            <div class="col-md-6">
                <div>
                    <div class="status-label float-end">

                    </div>


                    <h4 class="mb-1 font-weight-bold text-danger">Scheduled</h4>
                    <h6 class="mb-0 font-95 float-end col-6 px-2 p-1 bg-dark
                        font-weight-600 text-white"><span class="font-weight-500">Assigned To:</span> Alexander
                        hernandez Piedra </h6>
                </div>
            </div>

        </div>
    </div>




    <div class="container-fluid VV">

        <div class="col-md-12 mb-3 nav justify-content-between timeline">
            <div class="text-center single-timeline"> <i class="fas
                     fa-check-circle text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Submitted</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95"> Oct
                    20th, 2022</h6>
            </div>
            <div class="text-center single-timeline "> <i class="fas
                     fa-check-circle text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Assigned</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95"> Oct
                    20th, 2022 </h6>
            </div>
            <div class="text-center single-timeline ">
                <i class="fas fa-check-circle text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Scheduled
                </h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95"> Oct
                    21st, 2022 12:30 PM </h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="far fa-clock text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Under Review</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95"> ----
                    ---- ------ </h6>
            </div>
            <div class="text-center single-timeline opacity-50"> <i class="far fa-clock text-success fa-3x"></i>
                <h5 class="font-weight-600 mt-2 text-black">Completed</h5>
                <h6 class="font-weight-500 mt-2 text-secondary font-95"> ----
                    ---- ------ </h6>
            </div>
        </div>




        <div class="row">
            <div class="col-md-12 mb-3 nav ">
                <div class="col-md-6 mb-3">
                    <form name="requestForm" id="requestForm" method="post" action="{{route('requestupdate')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{encrypt($requestdetails->id)}}">
                        <table class="table table-responsive brequest">
                            <tbody>
                                <tr>
                                    <td>Applicant Name</td>
                                    <td><input type="text" class="form-control" id="applicantname" name="applicantname" placeholder="Name" value="{{$requestdetails->applicantname}}" class="form-control">
                                        @error('applicantname')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Email</td>
                                    <td><input type="email" class="form-control" id="applicantemail" name="applicantemail" placeholder="Email" value="{{$requestdetails->applicantemail}}">
                                        @error('applicantemail')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Applicant Phone</td>
                                    <td><input type="number" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="Phone" value="{{$requestdetails->applicantmobile}}">
                                        @error('applicantmobile')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Address" id="address" name="address">{{$requestdetails->address}}</textarea>
                                        @error('address')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td><input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{$requestdetails->city}}">
                                        @error('city')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td><input type="number" class="form-control" id="state" name="state" placeholder="State" value="{{$requestdetails->state}}">
                                        @error('state')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td>Zip Code</td>
                                    <td><input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="ZipCode" value="{{$requestdetails->zipcode}}">
                                        @error('zipcode')
                                        <div>
                                            <label class="error fail-alert  mt-1">{{$message}}<label>
                                        </div>
                                        @enderror
                                    </td>
                                </tr>
                                @if(!empty($invoicedata) && count($invoicedata) != 0)
                                <tr>
                                    <td>Send Invoice(s) To:</td>
                                    <td>
                                        @foreach($invoicedata as $key=>$value)
                                        <div>
                                            <label class="px-2 py-1 mb-1">
                                                <input type="checkbox" value="{{$key}}" name="sendinvoice[]" @if(in_array($key,$requestdetails['sendinvoice'])) {{"checked"}} @endif>
                                                {{$value}}
                                            </label>
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Inspection Fee</td>
                                    <td><input type="text" name="ins_fee" value=""></td>
                                </tr>
                                @if(!empty($data) && count($data) != 0)
                                <tr>
                                    <td>Inspection Type</td>
                                    <td>
                                        <div class="form-group">
                                            <label>Select Inspection Type:</label>
                                            <div class="row type">
                                                @foreach($data as $key=>$value)
                                                <div class="col-md-6">
                                                    <label class="px-2 py-1 border mb-2
                                                border col-md-12">
                                                        <input id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}" @if(in_array($key,$requestdetails['inspectiontype'])) {{"checked"}} @endif>
                                                        {{$value}}
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Comments:</td>
                                    <td><textarea class="form-control" rows="3" placeholder="Enter Comments" name="comments" id="comments">{{$requestdetails->comments}}</textarea></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10"><input type="submit" class="btn btn-primary" value="Update">
                                        <input id="btn-delete" type="button" class="btn btn-danger" value="Delete">
                                        <input id="btn-cancel" type="button" class="btn btn-danger" value="Cancel">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
                <div class="col-md-6 mb-3">
                    <!--                    <h5 class="py-2 bg-white font-weight-600 text-black mb-0">Clinic Details</h5>-->
                    <table class="table brequest">
                        <tbody>
                            <tr>
                                <td>Company Name</td>
                                <td>
                                    {{$companydetails->company_name}}
                                </td>
                            </tr>
                            <tr>
                                <td>Company Address</td>
                                <td>
                                    {{$companydetails->company_address}}
                                </td>
                            </tr>
                            <tr>
                                <td>Company Phone</td>
                                <td>{{$companydetails->company_phonenumber}}</td>
                            </tr>
                            <tr>
                                <td>Agent Name</td>
                                <td>{{$companydetails->name}}</td>
                            </tr>
                            <tr>
                                <td>Agent Direct Number</td>
                                <td>{{$companydetails->direct_number}}</td>
                            </tr>
                            <tr>
                                <td>Agent Email</td>
                                <td>{{$companydetails->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!---xxx--->
                    <div class="mt-3 mb-3 scheduled0eaff1"> <span class="btn
                           btn-danger col-12 shadow-sm font-weight-600 btn-sm
                           pointer"> Schedule Inspection &nbsp; <i class="fas
                              fa-arrow-down fa-sm"></i></span> <br>
                        <div class="input-group">
                            <input type="date" class="border p-2 col-7" name="date" min="2022-10-21" required="">
                            <input type="time" class="border p-2 col-5" name="time" required="">
                        </div>
                        <button class="btn btn-sm col-12 btn-light
                           font-weight-500 btn-schedule border" id="0eaff1">
                            Submit &nbsp; <i class="fas fa-save fa-sm"></i>
                        </button>
                    </div>
                    <div class="status-label mt-2"> <span class="btn btn-sm
                           btn-danger font-weight-500 py-0">Scheduled</span>
                        <div id="reschedule0eaff1" class="collapse">
                            <div class="input-group">
                                <input type="date" class="border p-2 col-7" name="date" min="2022-10-21" required="">
                                <input type="time" class="border p-2 col-5" name="time" required="">
                            </div>
                            <button class="btn btn-sm col-12 btn-light
                              font-weight-500 btn-reschedule border" id="0eaff1">Submit &nbsp;<i class="fas fa-save
                                 fa-sm"></i></button>
                        </div>
                        <span id="btn-calendar" class="btn btn-sm btn-dark
                           font-weight-500 py-0 shadow pointer"> <i class="fas
                              fa-calendar"></i> Add to Calendar </span> <span id="btn-calendar-google" class="btn btn-sm btn-info
                           font-weight-500 py-0 shadow pointer"> <i class="fas
                              fa-calendar"></i> Add to Google WorkSpace </span>
                    </div>
                </div>
            </div>
        </div>




        <div class="accordion accordion-flush" id="accordionFlushConcept">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Completed Reports Uploads
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse
                     collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushConcept">
                    <div class="accordion-body">This is the first item's
                        accordion body content, which is intended to demonstrate
                        the
                        <code>.accordion-flush
                        </code> class.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Agency Uploads
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse
                     collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushConcept">
                    <div class="accordion-body">This is the second item's
                        accordion body content, which is intended to demonstrate
                        the
                        <code>.accordion-flush
                        </code> class.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Send report
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse
                     collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushConcept">
                    <div class="accordion-body">This is the second item's
                        accordion body content, which is intended to demonstrate
                        the
                        <code>.accordion-flush
                        </code> class.
                    </div>
                </div>
            </div>
        </div>






    </div>

    @endsection





    @push('footer_extras')
    <script>
        $(document).ready(function() {
            var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
                allPrevBtn = $('.prevBtn');

            allWells.hide();

            navListItems.click(function(e) {
                e.preventDefault();
                var $target = $($(this).attr('href')),
                    $item = $(this);

                if (!$item.hasClass('disabled')) {
                    navListItems.removeClass('btn-primary').addClass('btn-default');
                    $item.addClass('btn-primary');
                    allWells.hide();
                    $target.show();
                    $target.find('input:eq(0)').focus();
                }
            });

            allNextBtn.click(function() {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url']"),
                    isValid = true;

                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid)
                    nextStepWizard.removeAttr('disabled').trigger('click');
            });

            allPrevBtn.click(function() {
                var curStep = $(this).closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                $(".form-group").removeClass("has-error");
                prevStepWizard.removeAttr('disabled').trigger('click');
            });

            $('div.setup-panel div a.btn-primary').trigger('click');
        });
    </script>
    @endpush