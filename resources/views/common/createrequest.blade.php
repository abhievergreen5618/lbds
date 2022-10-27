@push('header_extras')
<style>
    .others {
        margin-left: 10px !important;
    }
</style>
@endpush

@extends('layouts.app')
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ __('Submit New Request') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form id="requestform">
            <!-- {{$id}} -->
            @if(!empty($id))
            <input type='hidden' value='{{encrypt($id)}}' name='id'>
            @endif
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    @role('admin')
                    <div class="col-md-12 my-2">
                        <label for="report">{{ __('Agencies') }}</label>
                        <select class="form-control" name="agency" id="agency">
                            <option value="">Select Agency</option>
                            @if(!empty($companydetails) && count($companydetails) != 0)
                            @foreach($companydetails as $key=>$value)
                            <option value="{{encrypt($key)}}">{{__($value)}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    @endrole
                    @role('company')
                    <input type="hidden" name="agency" value="{{encrypt(auth()->user()->id)}}">
                    @endrole
                    @if(!empty($data) && count($data) != 0)
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Select Inspection Type') }}</label>
                            </div>
                            @foreach($data as $key=>$value)
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype[]" value="{{$key}}">
                                    <label class="form-check-label" for="inspection-type-{{$key}}">{{__($value)}}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
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
                    @if(!empty($invoicedata) && count($invoicedata) != 0)
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Send Invoice(s) To:') }}</label>
                            </div>
                            @foreach($invoicedata as $key=>$value)
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="send-invoice-{{$key}}" type="checkbox" name="sendinvoice[]" value="{{$key}}">
                                    <label class="form-check-label" for="send-invoice-{{$key}}">{{__($value)}}</label>
                                </div>
                            </div>
                            @endforeach
                            <!-- <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <div class="input-group mb-3">
                                        <div class="input-group-text align-items-center">
                                            <label class="form-check-label">{{__('Others')}}</label>
                                            <input class="form-check-input mt-0 others" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 my-2">
                        <label for="comments">{{ __('Comments') }}</label>
                        <textarea class="form-control" rows="3" placeholder="Enter Comments" name="comments" id="comments"></textarea>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="relatedfiles">{{ __('Agency Related Files') }}</label>
                        <div class="dropzone" id="agencyfiles"></div>
                    </div>
                    <div class="col-md-6 my-2">
                        <label for="relatedfiles">{{ __('Reports Related Files') }}</label>
                        <div class="dropzone" id="reportfiles"></div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footer_extras')
<script>
    $(document).ready(function() {
        var myselect = $('#agency').select2({
            placeholder: "Select",
        });
    });

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
            success: function(result) {
                $('.preloader').children().hide();
                $('.preloader').css("height", "0");
                Swal.fire({
                    icon: 'success',
                    title: 'Good job!',
                    text: 'Details saved successfully',
                    showConfirmButton: false,
                    timer: 1000,
                }).then((result) => {
                    var newloc = "{{ route('admin.request.list') }}";
                    window.location.href = newloc;
                });
            },
            error: function(xhr) {
                $('.preloader').children().hide();
                $('.preloader').css("height", "0");
                if (xhr.status == 422) {
                    $('*').removeClass("is-invalid-special");
                    $.each(xhr.responseJSON.errors, function(key, value) {
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

    function getFormData($form) {

        var unindexed_array = $form.serializeArray();

        var indexed_array = {};

        const posts = [];

        $.each(unindexed_array, function(key, value) {

            name = value.name;

            val = value.value;

            if (val.length) {

                if (name == "sendinvoice[]") {

                    posts.push(val);

                    indexed_array["sendinvoice[]"] = posts;

                }
                if (name == "inspectiontype[]") {

                    posts.push(val);

                    indexed_array["inspectiontype[]"] = posts;

                } else {

                    indexed_array[name] = val;

                }

            }

        });

        return indexed_array;

    }
    var firstcount = false;
    var secondcount = false;
    function checkcount(count, id) {
        if (count == 0 && id == "agencyfiles") {
            firstcount = true;
            return false;
        } else if (count > 0 && id == "reportfiles") {
            return false;
        } else if (firstcount != false && count == 0 && id == "reportfiles") {
            secondcount = true;
            return true;
        }
        else
        {
            return false;
        }
    }



    var uploaded = false;
    Dropzone.autoDiscover = false;
    const myDropzone = new $(".dropzone").dropzone({
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        url: "fileuploadrequest",
        headers: {
            'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
        },
        maxFilesize: 500,
        acceptedFiles: ".jpeg,.jpg,.png,.pdf",
        init: function() {
            var myDropzone = this;
            const $button = document.getElementById('submit-btn');
            $button.addEventListener("click", function(e) {
                if ($('#requestform').valid()) {
                    $('.preloader').children().show();
                    $('.preloader').css("height", "100vh");
                    var count = myDropzone.getAcceptedFiles().length;
                    var element = $(myDropzone).get(0).element;
                    count = checkcount(count, $(element).attr("id"));
                    debugger;
                    if (typeof(count) != "undefined" && count == true) {
                        e.preventDefault();
                        requestformsubmit();
                    } 
                    else {
                        if (uploaded === false) {
                            myDropzone.on('sending', function(file, xhr, formData) {
                                formData.append('type', $(element).attr("id"));
                            });
                            myDropzone.processQueue();
                        } else {
                            e.preventDefault();
                            requestformsubmit();
                        }
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }
            });
            this.on("queuecomplete", function() {
                var element = $(myDropzone).get(0).element;
                var id = $(element).attr("id");
                if ($('#requestform').valid()) {
                    uploaded = true;
                    if (id == "reportfiles") {
                        requestformsubmit();
                    }
                    else if(firstcount == false && secondcount != true)
                    {
                        requestformsubmit();
                    }
                    $('.dz-remove').remove();
                }
            });
            // this.on("error", function(file, message) {
            //     alert(message);
            //     this.removeFile(file);
            // });
        },
        removedfile: function(file) {
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode
                .removeChild(
                    file.previewElement) : void 0;
        },
    });
</script>
@endpush