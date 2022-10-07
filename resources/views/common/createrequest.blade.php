@push('header_extras')
<style>
    .others{
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
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    @if(!empty($data) && count($data) != 0)
                    <div class="col-md-12 my-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="">{{ __('Select Inspection Type') }}</label>
                            </div>
                            @foreach($data as $key=>$value)
                            <div class="col-lg-4 my-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="inspection-type-{{$key}}" type="checkbox" name="inspectiontype" value="{{$key}}">
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
                                <textarea class="form-control" rows="3" placeholder="Enter ..." id="address" name="address"></textarea>
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="city">{{ __('City') }}</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" id="city" name="city" placeholder="Password">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="zipcode">{{ __('State') }}</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" id="state" name="state" placeholder="Password">
                            </div>
                            <div class="col-lg-4 my-2">
                                <label for="zipcode">{{ __('ZipCode') }}</label>
                                <input type="number" class="form-control" id="exampleInputPassword1" id="zipcode" name="zipcode" placeholder="Password">
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
                                    <input class="form-check-input" id="send-invoice-{{$key}}" type="checkbox" name="sendinvoice" value="{{$key}}">
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
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="comments" id="comments"></textarea>
                    </div>
                    <div class="col-md-12 my-2">
                        <label for="report">{{ __('Reports') }}</label>
                        <select class="form-control" name="report">
                            <option>Select Reports</option>
                            <option>Agency Uploads</option>
                        </select>
                    </div>
                    <div class="col-md-12 my-2">
                        <label for="relatedfiles">{{ __('Related Files') }}</label>
                        <div class="dropzone" id="kt_dropzonejs_example_1"></div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('footer_extras')
<script>
            Dropzone.autoDiscover = false;
        const myDropzone = new $(".dropzone").dropzone({
            autoProcessQueue: false,
            addRemoveLinks: true,
            url: "fileupload",
            headers: {
                'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
            },
            maxFilesize: 10,
            acceptedFiles: ".jpeg,.jpg,.png,.pdf",
            init: function() {
                var myDropzone = this;
                const $button = document.getElementById('submit-btn')
                $button.addEventListener("click", function(e) {
                    if ($('#task-form').valid()) {
                        $('#preloader').show();
                        var count = myDropzone.getAcceptedFiles().length;
                        if (count == 0) {
                            e.preventDefault();
                            taskformsubmit();
                        } else {
                            if (uploaded === false) {
                                const acceptedFiles = myDropzone.getAcceptedFiles();
                                for (let i = 0; i < acceptedFiles.length; i++) {
                                    setTimeout(function() {
                                        myDropzone.processFile(acceptedFiles[i])
                                    }, i * 500)
                                }
                            } else {
                                e.preventDefault();
                                taskformsubmit();
                            }
                            e.preventDefault();
                            e.stopPropagation();
                        }
                    }
                });
                this.on("queuecomplete", function() {
                    if ($('#task-form').valid()) {
                        uploaded = true;
                        taskformsubmit();
                        $('.dz-remove').remove();
                    }
                });
            },
            success: function(file, response) {
                if (response.hasOwnProperty('id')) {
                    var msg = "<input type='hidden' value='" + response.id + "' name='id'>";
                    $('#task-form').prepend(msg);
                }
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