@push('header_extras')
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
    .requestdetailcard
    {
        background-color: #007bff;
        color: white;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: black !important;
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Request Details</h3>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body pt-2">
            <div class="container">
                <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button" class="btn btn-primary btn-circle"><i class="fa fa-check"></i></a>
                            <p>Submitted</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                            <p>Assigned</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                            <p>Scheduled</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                            <p>Under Review</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-check"></i></a>
                            <p>Completed</p>
                        </div>
                    </div>
                </div>
                <div class="card text-center">
                    <div class="card-header requestdetailcard">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active text-light" aria-current="true" href="#" data-childid="companydetails">Company Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  text-light" href="#" data-childid="editdetails">Edit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  text-light" href="#" data-childid="reportupload">Completed Reports Uploads</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link  text-light" href="#" data-childid="agencyupload">Agency Uploads</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body card-div" id="companydetails">
                        <div class="row">
                            <div class="col-lg-6">
                                <h2>Company Name</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->company_name}}</p>
                            </div>
                            <div class="col-lg-6">
                                <h2>Company Address</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->company_address}}</p>
                            </div>
                            <div class="col-lg-6">
                                <h2>Company Phone</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->company_phonenumber}}</p>
                            </div>
                            <div class="col-lg-6">
                                <h2>Agent Name</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->name}}</p>
                            </div>
                            <div class="col-lg-6">
                                <h2>Agent Direct Number</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->direct_number}}</p>
                            </div>
                            <div class="col-lg-6">
                                <h2>Agent Email</h2>
                            </div>
                            <div class="col-lg-6">
                                <p>{{$companydetails->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-div" id="editdetails" style="display: none;">
                    <div class="row g-3 align-items-end">
                            <div class="col-md-12 my-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="">{{ __('Insured / Applicant Information') }}</label>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="applicantname">{{ __('Name') }}</label>
                                        <input type="text" class="form-control" id="applicantname" name="applicantname" placeholder="Name">
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="applicantemail">{{ __('Email address') }}</label>
                                        <input type="email" class="form-control" id="applicantemail" name="applicantemail" placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="applicantmobile">{{ __('Phone') }}</label>
                                        <input type="number" class="form-control" id="applicantmobile" name="applicantmobile" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 my-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="">{{ __('Subject Property Information') }}</label>
                                    </div>
                                    <div class="col-lg-12 my-2">
                                        <label for="address">{{ __('Address') }}</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter Address" id="address" name="address"></textarea>
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="city">{{ __('City') }}</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="state">{{ __('State') }}</label>
                                        <input type="number" class="form-control" id="state" name="state" placeholder="State">
                                    </div>
                                    <div class="col-lg-4 my-2">
                                        <label for="zipcode">{{ __('ZipCode') }}</label>
                                        <input type="number" class="form-control" id="zipcode" name="zipcode" placeholder="ZipCode">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-div" id="reportupload" style="display: none;">
                        <div class="row">
                            @foreach($agencyfiles as $key=>$value)
                            <div class="col-lg-3">
                                <div class="card text-bg-dark">
                                    <img src="{{asset('/taskfiles/').'/'.$value}}" class="card-img" alt="...">
                                    <!-- <div class="card-img-overlay">
                                    </div> -->
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-body card-div" id="agencyupload" style="display: none;">
                        <div class="row">
                            @foreach($reportfiles as $key=>$value)
                            <div class="col-lg-3">
                                <div class="card text-bg-dark">
                                    <img src="{{asset('/taskfiles/').'/'.$value}}" class="card-img" alt="...">
                                    <!-- <div class="card-img-overlay">
                                    </div> -->
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
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