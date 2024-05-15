@extends('layouts.main')
@section('title', __('Appoinment Time Wise'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Appoinment Time Wise') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), ['']) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('bookings.index'), __('Booking'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Appoinment Time Wise') }}</li>
        </ul>
    </div>
@endsection
@push('style')
    <link href="{{ asset('assets/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="section-body">
            <div class="m-auto col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5> {{ __('Appoinment Time Wise') }}</h5>
                    </div>
                    <form action="{{ route('booking.fill.store', $booking->id) }}" method="POST"
                        enctype="multipart/form-data" id="fill-form">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div id="booking-step1" class="row booking-step">
                                @include('bookings.appoinment.time')
                            </div>
                            <div id="booking-step2" class="row booking-step d-none">
                                <div class="col-lg-12">
                                    @include('bookings.multi-form')
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="mb-3 btn-flt float-start">
                                <button id="prevButton" type="button" class="btn btn-secondary d-none"><i
                                        class="ti ti-chevron-left me-2"></i>{{ __('Previous') }}</button>
                            </div>
                            <div class="mb-3 btn-flt float-end">
                                <button id="nextButton" type="button" class="btn btn-primary">{{ __('Next') }}<i
                                        class="ti ti-chevron-right ms-2"></i></button>
                                <button class="btn btn-primary d-none" id="submitButton" onclick="nextPrev(1);"
                                    type="button">{{ __('Submit') }}</button>
                            </div>
                        </div>
                        <div class="extra_style">
                            @foreach ($array as $keys => $rows)
                                <span class="step"></span>
                            @endforeach
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
    <script src="{{ asset('vendor/js/jquery.payment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ Utility::getsettings('PAYPAL_SANDBOX_CLIENT_ID') }}&currency={{ $booking->currency_name }}">
    </script>
    @if (Utility::getsettings('PAYTM_ENVIRONMENT') == 'production')
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw.paytm.in\merchantpgpui\checkoutjs\merchants\{{ Utility::getsettings('PAYTM_MERCHANT_ID') }}.js" ></script>
    @else
        <script type="application/javascript" crossorigin="anonymous" src="https:\\securegw-stage.paytm.in\merchantpgpui\checkoutjs\merchants\{{ Utility::getsettings('PAYTM_MERCHANT_ID') }}.js" ></script>
    @endif
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        $(document).ready(function() {
            var currentStep = 1;

            function showStep(stepNumber) {
                $('.booking-step').addClass('d-none');
                $('#booking-step' + stepNumber).removeClass('d-none');
                if (currentStep === 2) {
                    $('#nextButton').addClass('d-none');
                    $('#submitButton').removeClass('d-none');
                    $('#prevButton').removeClass('d-none');
                } else {
                    $('#nextButton').removeClass('d-none');
                    $('#submitButton').addClass('d-none');
                    $('#prevButton').addClass('d-none');
                }
            }
            // Function to go to the next booking-step
            function nextStep() {
                if (currentStep < 3) {
                    currentStep++;
                    showStep(currentStep);
                }
            }
            // Function to go back to the previous booking-step
            function prevStep() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            }
            // Attach event handlers for navigation buttons
            $('#nextButton').click(nextStep);
            $('#prevButton').click(prevStep);


        });

        var booking_value_id = $('#booking_value_id').val();
        var SITEURL = '{{ URL::to('') }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        ('restrictNumeric');
        $('.cc-number').payment('formatCardNumber');
        $('.cc-exp').payment('formatCardExpiry');
        $('.cc-cvc').payment('formatCardCVC');
        $.fn.toggleInputError = function(erred) {
            this.parent('.form-group').toggleClass('has-error', erred);
            return this;
        };

        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'Select Option',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });

        var flatpickrInstance;
        document.addEventListener('DOMContentLoaded', function() {
            var datepickerEl = document.querySelector('#pc-datepicker');
            var bookingStartDate = new Date("{{ $bookingStartDate }}");
            var bookingEndDate = new Date("{{ $bookingEndDate }}");
            bookingStartDate.setHours('{{ $currdate->format('h') }}',
                '{{ $currdate->format('i') }}', 0, 0);
            bookingEndDate.setHours('{{ $currdate->format('h') }}',
                '{{ $currdate->format('i') }}', 0, 0);
            var selectedDays = '{!! json_encode($selectedDays) !!}';
            flatpickrInstance = flatpickr(datepickerEl, {
                inline: true,
                disableMobile: true,
                enable: [
                    function(date) {
                        var pickerDate = new Date(date);
                        pickerDate.setHours('{{ $currdate->format('h') }}',
                            '{{ $currdate->format('i') }}', 0, 0);
                        var currentDate = new Date();
                        currentDate.setHours('{{ $currdate->format('h') }}',
                            '{{ $currdate->format('i') }}', 0, 0);
                        var dayOfWeek = date.getDay();
                        var isNotSelected = selectedDays.includes(dayOfWeek);
                        var enable = pickerDate >= bookingStartDate &&
                            pickerDate <= bookingEndDate &&
                            pickerDate >= currentDate &&
                            isNotSelected;
                        return (enable);
                    }
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    getappointmentSlot(dateStr);
                }
            });
            getappointmentSlot();
        });

        function getappointmentSlot(selectedDate = '{{ $currdate->format('Y-m-d') }}') {
            var url = '{{ route('booking.slots.appoinment.get', $booking->id) }}';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    date: selectedDate,
                },
                success: function(response) {
                    $('.appointmentSlot').empty().html(response.html);
                    $('input[name="booking_date"]').val(selectedDate);
                    var limitSlots = parseInt({{ $timeWiseBooking->maximum_limit }});
                    var SelectedSlots = $('input[name="slot[]"]:checked');
                    if (SelectedSlots.length >= limitSlots) {
                        $('input[name="slot[]"]:not(:checked)').attr('disabled', true);
                    } else {
                        $('input[name="slot[]"]').attr('disabled', false);
                        $('input[name="slot[]"].disabled').attr('disabled', true);
                    }
                },
                error: function(error) {}
            });
        }

        $(document).on('click', 'input[name="slot[]"]', function() {
            var limitSlots = parseInt({{ $timeWiseBooking->maximum_limit }});
            var SelectedSlots = $('input[name="slot[]"]:checked');
            if (SelectedSlots.length >= limitSlots) {
                $('input[name="slot[]"]:not(:checked)').attr('disabled', true);
            } else {
                $('input[name="slot[]"]').attr('disabled', false);
                $('input[name="slot[]"].disabled').attr('disabled', true);
            }
        });

        function nextPrev(n) {
            if (n == 1 && !validateForm()) return false;
            var formData = new FormData($('#fill-form')[0]);
            var $this = $("#submitButton");
            var loadingText = '<i class="fa fa-spinner fa-spin"></i> Submiting form';
            if ($("#submitButton").html() !== loadingText) {
                $this.data('original-text', $("#submitButton").html());
                $this.html(loadingText);
            }
            @if ($booking->payment_type == 'paypal')
                if ($('#payment_id').val() == '') {
                    var errorElement = document.getElementById('paypal-errors');
                    iziToast.error({
                        title: 'Error!',
                        message: "{{ 'Please make payment' }}",
                        position: 'topRight'
                    });
                    $('#submitButton').removeAttr('disabled');
                    $('#submitButton').html('Submit')
                    showTab(n);
                    return false;
                }
            @endif
            make_payment();
        }

        function validateForm() {
            var currentTab = 0;
            var check = [];
            $('.step-' + currentTab).find('.required').each(function() {
                var name = $(this).attr('name');
                if ($(this).val() == "") {
                    $(this).addClass('is-invalid');
                    check.push(false);
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                    check.push(true);
                }
                if ($(this).attr('type') == 'hidden') {
                    if ($(this).parents('.signature-pad-body').length) {
                        if ($(this).val() == "") {
                            $(this).parents('.signature-pad-body').find('.signaturePad').addClass('is-invalid');
                            $(this).parents('.signature-pad-body').find('.signaturePad').removeClass('is-valid');
                            show_toastr('Error!', '{{ __('Please save your signature.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            $(this).parents('.signature-pad-body').find('.signaturePad').addClass('is-valid');
                            $(this).parents('.signature-pad-body').find('.signaturePad').removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                    if ($(this).parents('.cam-buttons').length) {
                        var videoContainer = $(this).parents('.cam-buttons');
                        var videoCam = videoContainer.find('.video_cam');
                        if (videoContainer.find('input[name="media"]').val() == "") {
                            videoCam.addClass('is-invalid');
                            videoCam.removeClass('is-valid');
                            show_toastr('Error!', '{{ __('Video recording field is required.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            videoCam.addClass('is-valid');
                            videoCam.removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                    if ($(this).parents('.selfie_screen').length) {
                        var videoContainer = $(this).parents('.selfie_screen');
                        var videoCam = videoContainer.find('.selfie_photo');
                        if (videoContainer.find('input[name="image"]').val() == "") {
                            videoCam.addClass('is-invalid');
                            videoCam.removeClass('is-valid');
                            show_toastr('Error!', '{{ __('This selfie field is required.') }}', 'danger',
                                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
                            check.push(false);
                        } else {
                            videoCam.addClass('is-valid');
                            videoCam.removeClass('is-invalid');
                            check.push(true);
                        }
                    }
                }
                if ($(this).attr('type') == 'email') {
                    var emailStr = $(this).val();
                    var regex = /^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i;
                    if (regex.test(emailStr)) {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        check.push(true);
                    } else {
                        $(this).addClass('is-invalid');
                        check.push(false);
                    }
                }
                if ($(this).attr('type') == 'tel') {
                    var tel = $(this).val();
                    var filter = /^\d*(?:\.\d{1,2})?$/;
                    if (filter.test(tel)) {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        check.push(true);
                    } else {
                        $(this).addClass('invalid');
                        check.push(false);
                    }
                }
                if ($(this).attr('type') == 'radio') {
                    if ($('input[name="' + name + '"]:checked').length <= 0) {
                        $(this).addClass('is-invalid');
                        $('.required-radio').html('Select any one');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $('.required-radio').html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'checkbox') {
                    if ($('input[name="' + name + '"]:checked').length <= 0) {
                        $(this).addClass('is-invalid');
                        $('.required-checkbox').html('Select any one');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $('.required-checkbox').html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'number') {
                    var numval = parseInt($(this).val());
                    var min = parseInt($(this).attr('min'));
                    var max = parseInt($(this).attr('max'));
                    if ($(this).val() == "") {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        $(this).removeClass('is-valid');
                        check.push(false);
                    } else {
                        if (isNaN(min) == false && isNaN(max) == true && min > numval) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Sorry minimum number is ' + min + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else if (isNaN(min) == true && isNaN(max) == false && max < numval) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Sorry maximum number is ' + max + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else if (isNaN(min) == false && isNaN(max) == false && (min > numval || numval > max)) {
                            $(this).addClass('is-invalid')
                            $(this).parent().find('.required-number').html('Select between minimum number ' + min +
                                ' and maximum number ' + max + '.');
                            $(this).removeClass('is-valid');
                            check.push(false);
                        } else {
                            $(this).removeClass('is-invalid');
                            $(this).addClass('is-valid');
                            $(this).parent().find('.required-number').html('');
                            check.push(true);
                        }
                    }
                }
                if ($(this).attr('type') == 'file') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please select file in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'date') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please select date in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this)[0].localName == 'textarea') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
                if ($(this).attr('type') == 'text') {
                    var inp = $(this).val();
                    if (inp.length == 0) {
                        $(this).addClass('is-invalid');
                        $(this).next().html('Please fill in this field.');
                        check.push(false);
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).addClass('is-valid');
                        $(this).next().html('');
                        check.push(true);
                    }
                }
            });
            var valid = true;
            check.forEach(function(val) {
                if (val == false) {
                    valid = false;
                    return false;
                }
            });
            if (valid) {
                $('.step-' + currentTab).addClass('finish');
            }
            return valid; // return the valid status
        }

        function make_payment() {
            var formData = new FormData($('#fill-form')[0]);
            if (booking_value_id == '') {
                @if ($booking->payment_status == 1)
                    @if ($booking->payment_type == 'stripe')
                        stripe.createToken(card).then(function(result) {
                            if (result.error) {
                                // Inform the user if there was an error
                                var errorElement = document.getElementById('card-errors');
                                errorElement.textContent = result.error.message;
                            } else {
                                formData.append('stripeToken', result.token.id);
                            }
                        }).then(function() {
                            submitForm(formData);
                        });
                    @elseif ($booking->payment_type == 'paytm')
                        var amount = '{{ $booking->amount }}';
                        var name = '{{ $booking->business_name }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var email = '{{ $booking->business_email }}';
                        var succes_msg = '{{ $booking->success_msg }}';
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('paymentpaytm.payment') }}",
                            data: {
                                '_token': '{{ csrf_token() }}',
                                'amount': amount,
                                'name': name,
                                'email': email,
                                'mobile': '123456789',
                                'succes_msg': succes_msg,
                                'form_id': form_id,
                            },
                            success: function(data) {
                                $('.paytm-pg-loader').show();
                                $('.paytm-overlay').show();

                                if (data.txnToken == "") {
                                    show_toastr('Failed!', data.message, 'danger',
                                        '{{ asset('assets/images/notification/high_priority-48.png') }}',
                                        4000);
                                    $('.paytm-pg-loader').hide();
                                    $('.paytm-overlay').hide();
                                    return false;
                                }
                                invokeBlinkCheckoutPopup(data.orderId, data.txnToken, data.amount)
                            }
                        });

                        function invokeBlinkCheckoutPopup(orderId, txnToken, amount) {
                            window.Paytm.CheckoutJS.init({
                                "root": "",
                                "flow": "DEFAULT",
                                "data": {
                                    "orderId": orderId,
                                    "token": txnToken,
                                    "tokenType": "TXN_TOKEN",
                                    "amount": amount,
                                },
                                handler: {
                                    transactionStatus: function(data) {},
                                    notifyMerchant: function notifyMerchant(eventName, data) {
                                        if (eventName == "APP_CLOSED") {
                                            $('.paytm-pg-loader').hide();
                                            $('.paytm-overlay').hide();
                                        }
                                    }
                                }
                            }).then(function() {
                                window.Paytm.CheckoutJS.invoke();
                                formData.append('payment_id', orderId);
                                submitForm(formData);
                            });
                        }
                    @elseif ($booking->payment_type == 'flutterwave')
                        var amount = '{{ $booking->amount }}';
                        var name = '{{ $booking->business_name }}';
                        var email = '{{ $booking->business_email }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var plan_name = '{{ $booking->business_name  }}';
                        const modal = FlutterwaveCheckout({
                            public_key: "{{ Utility::getsettings('FLW_PUBLIC_KEY') }}",
                            tx_ref: "titanic-48981487343MDI0NzMx",
                            amount: amount,
                            currency: currency,
                            payment_options: "card, banktransfer, ussd",
                            callback: function(payment) {
                                // Send AJAX verification request to backend
                                formData.append('payment_id', payment.transaction_id);
                                modal.close();
                                submitForm(formData);
                            },
                            onclose: function(incomplete) {
                                modal.close();
                                show_toastr('Failed!', 'Transaction was not completed, window closed.',
                                    'danger');
                            },
                            meta: {
                                consumer_id: form_id,
                                consumer_mac: "92a3-912ba-1192a",
                            },
                            customer: {
                                email: email,
                                phone_number: "08102909304",
                                name: name,
                            },
                            customizations: {
                                title: plan_name,
                                description: "Payment for an awesome cruise",
                                logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
                            },
                        });
                    @elseif ($booking->payment_type == 'paystack')
                        var amount = '{{ $booking->amount }}';
                        var name = '{{ $booking->business_name }}';
                        var email = '{{ $booking->business_email }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var handler = PaystackPop.setup({
                            key: "{{ Utility::getsettings('PAYSTACK_PUBLIC_KEY') }}", // Replace with your public key
                            email: email,
                            amount: (amount *
                                100
                            ), // the amount value is multiplied by 100 to convert to the lowest currency unit
                            currency: currency, // Use GHS for Ghana Cedis or USD for US Dollars
                            ref: '{{ Str::random(10) }}', // Replace with a reference you generated
                            callback: function(response) {
                                //this happens after the payment is completed successfully
                                formData.append('payment_id', response.transaction);
                                var reference = response.reference;
                                show_toastr('Done!', 'Payment complete! Reference: ' + reference, 'success',
                                    '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
                                submitForm(formData);
                            },
                            onClose: function() {
                                show_toastr('Failed!', 'Transaction was not completed, window closed.',
                                    'danger');
                            },
                        });
                        handler.openIframe();
                    @elseif ($booking->payment_type == 'payumoney')
                        var amount = '{{ $booking->amount }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var created_by = '{{ $booking->created_by }}';
                        $('#payumoney_currency').val(currency);
                        $('#payumoney_amount').val(amount);
                        $('#payumoney_form_id').val(form_id);
                        $('#payumoney_created_by').val(created_by);
                        $('#payumoney_payment_frms').submit();
                        submitForm(formData);
                    @elseif ($booking->payment_type == 'coingate')
                        var amount = '{{ $booking->amount }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var created_by = '{{ $booking->created_by }}';
                        $('#cg_currency').val(currency);
                        $('#cg_amount').val(amount);
                        $('#cg_form_id').val(form_id);
                        $('#cg_created_by').val(created_by);
                        $('#coingate_payment_frms').submit();
                        submitForm(formData);
                    @elseif ($booking->payment_type == 'mercado')
                        var amount = '{{ $booking->amount }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var created_by = '{{ $booking->created_by }}';
                        $('#mercado_currency').val(currency);
                        $('#mercado_amount').val(amount);
                        $('#mercado_form_id').val(form_id);
                        $('#mercado_created_by').val(created_by);
                        $('#mercado_payment_frms').submit();
                        submitForm(formData);
                    @elseif ($booking->payment_type == 'razorpay')
                        var amount = '{{ $booking->amount }}';
                        var name = '{{ $booking->business_name }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        var data = {
                            "_token": "{{ csrf_token() }}",
                            'price': amount,
                            'name': name,
                            'currency': currency,
                            'form_id': form_id,
                        }
                        var options = {
                            "key": "{{ Utility::getsettings('RAZORPAY_KEY') }}",
                            "amount": (amount * 100),
                            "name": name,
                            'currency': currency,
                            "description": "",
                            "image": '',
                            "handler": function(response) {
                                formData.append('payment_id', response.razorpay_payment_id);
                                submitForm(formData);
                                '{{ Crypt::encrypt(['payment_id' => ',response.razorpay_payment_id,', 'plan_id' => 'plan_id', 'request_user_id' => 'user_id', 'order_id' => 'order_id', 'type' => 'razorpay']) }}';
                                // window.location.href = SITEURL + '/' + 'pre-payment-success/' + data;
                            },
                            "theme": {
                                "color": "#528FF0"
                            }
                        };
                        // setLoading(true);
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                        // e.preventDefault();
                    @else
                        submitForm(formData);
                    @endif
                @else
                    submitForm(formData);
                @endif
            } else {
                submitForm(formData);
            }
        }

        function submitForm(formData) {
            var url = $('#fill-form').attr('action');
            formData.append('ajax', true);
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.is_success) {
                        $('.card-body').html(
                            '<div class="text-center gallery" id="success_loader"><img src="{{ asset('assets/images/success.gif') }}" /><br><br><h2 class="w-100 ">Your booking is successfully ' +
                            'completed!</h2></div>');
                        $('#success_loader').after(
                            '<div class="text-center">Click to view your booking details: <a target="_blank" href="' +
                            response.redirect + '">Click Here</a></div>');
                        $('.card-footer').addClass('d-none');
                        $('#submitButton').removeAttr('disabled');
                        $('#submitButton').html('Submit');
                    } else {
                        show_toastr('Error!', response.message, 'danger');
                        $('#submitButton').removeAttr('disabled');
                        $('#submitButton').html('Submit');
                    }
                },
                error: function(error) {}
            });
        }
    </script>
    <script>
        $(document).on("click", "input[type='checkbox']", function() {
            var name = $(this).attr('name');
            checkCheckbox(name);
        });
        $("body input[type='checkbox']").each(function(i, item) {
            var name = $(item).attr('name');
            checkCheckbox(name);
        });

        function checkCheckbox(name) {
            if ($("input[name='" + name + "']:checked").length) {
                $("input[name='" + name + "']").removeAttr('required');
            } else {
                $("input[name='" + name + "']").attr('required', 'required');
            }
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
        $(document).ready(function() {
            setTimeout(function() {
                $("#setData").trigger('click');
            }, 30);
        });
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'Select Option',
                    searchPlaceholderValue: 'Select Option',
                });
            }
        });
        $(document).ready(function() {
            $(".custom_select").select2();
        })
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var num_of_star = $(this).attr('data-num_of_star');
                $(this).rateYo({
                    rating: val,
                    halfStar: true,
                    numStars: num_of_star,
                    precision: 2,
                    onSet: function(rating, rateYoInstance) {
                        num_of_star = $(rateYoInstance.node).attr('data-num_of_star');
                        var input = ($(rateYoInstance.node).attr('id'));
                        if (num_of_star == 10) {
                            rating = rating * 2;
                        }
                        $('input[name="' + input + '"]').val(rating);
                    }
                })
            });
        }
        if ($(".ck_editor").length) {
            CKEDITOR.replace($('.ck_editor').attr('name'), {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        }
    </script>
    @if ($booking->payment_status == 1)
        <script>
            var stripe, card;
            $(document).ready(function() {
                @if ($booking->payment_status == 1)
                    @if ($booking->payment_type == 'stripe')
                        stripe = Stripe('{{ Utility::getsettings('STRIPE_KEY') }}');
                        var elements = stripe.elements();
                        var style = {
                            base: {
                                color: '#32325d',
                                lineHeight: '24px',
                                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                                fontSmoothing: 'antialiased',
                                fontSize: '18px',
                                '::placeholder': {
                                    color: '#aab7c4'
                                }
                            },
                            invalid: {
                                color: '#fa755a',
                                iconColor: '#fa755a'
                            }
                        };
                        // Create an instance of the card Element
                        card = elements.create('card', {
                            style: style
                        });
                        // Add an instance of the card Element into the `card-element` <div>
                        card.mount('#card-element');
                        // Handle real-time validation errors from the card Element.
                        card.addEventListener('change', function(event) {
                            var displayError = document.getElementById('card-errors');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                        });
                    @endif
                    @if ($booking->payment_type == 'paypal')
                        var amount = '{{ $booking->amount }}';
                        var name = '{{ $booking->title }}';
                        var currency = '{{ $booking->currency_name }}';
                        var form_id = '{{ $booking->id }}';
                        paypal.Buttons({
                            // Set up the transaction
                            createOrder: function(data, actions) {
                                return actions.order.create({
                                    purchase_units: [{
                                        amount: {
                                            value: amount
                                        }
                                    }]
                                });
                            },
                            // Finalize the transaction
                            onApprove: function(data, actions) {
                                return actions.order.capture().then(function(orderData) {
                                    // Successful capture! For demo purposes:
                                    console.log('Capture result', orderData, JSON.stringify(
                                        orderData, null, 2));
                                    var transaction = orderData.purchase_units[0].payments.captures[
                                        0];
                                    $('#payment_id').val(transaction.id);
                                    var errorElement = document.getElementById('paypal-errors');
                                    errorElement.textContent = '';
                                    $('#paypal-button-container').html('')
                                });
                            }
                        }).render('#paypal-button-container');
                    @endif
                @endif
            })
        </script>
    @endif
@endpush
