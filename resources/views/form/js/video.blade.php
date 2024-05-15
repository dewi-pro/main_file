@push('script')
<script>
    $(document).on('click', "#videostream", function() {
        $(".cam-buttons").fadeIn(500);
        $('.cam-buttons').removeClass('d-none');
    });
</script>
<script>
    let log = console.log.bind(console),
        id = val => document.getElementById(val),
        ul = id('ul'),
        gUMbtn = id('gUMbtn'),
        start = id('start'),
        stop = id('stop'),
        stream,
        recorder,
        counter = 1,
        chunks,
        media;

    const webCamContainer = document.getElementById('web-cam-container');

    videostream.onclick = e => {
        let mv = id('mediaVideo'),
            mediaOptions = {
                video: {
                    tag: 'video',
                    type: 'video/webm',
                    ext: '.mp4',
                    gUM: {
                        video: true,
                        audio: true
                    }
                }
            };
        media = mv.checked ? mediaOptions.video : mediaOptions.audio;
        try {
            navigator.mediaDevices.getUserMedia(media.gUM).then(_stream => {
                stream = _stream;
                webCamContainer.srcObject = stream;
                id('btns').style.display = 'inherit';
                start.removeAttribute('disabled');
                recorder = new MediaRecorder(stream);
                recorder.ondataavailable = e => {
                    chunks.push(e.data);
                    if (recorder.state == 'inactive') makeLink();
                };
                $('.web-supported').addClass('d-none');
            }).catch(error => {
                show_toastr('Error!', 'Camera device not found. ', 'danger',
                    '{{ asset('assets/images/notification/high_priority-48.png') }}',
                    4000);
            });
        } catch (err) {
            show_toastr('Error!', 'Camera device not found.', 'danger',
                '{{ asset('assets/images/notification/high_priority-48.png') }}',
                4000);
        }
    }

    start.onclick = e => {
        stop.removeAttribute('disabled');
        chunks = [];
        recorder.start();
        start.disabled = true;

    }

    stop.onclick = e => {
        stop.disabled = true;
        recorder.stop();
        $("#web-cam-container").hide();
    }

    stop.removeAttribute('disabled');

    function makeLink() {
        let blob = new Blob(chunks, {
            type: media.type
        });
        const formData = new FormData();
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        formData.append('media', blob);
        fetch('{{ route('videostore') }}', {
                method: 'POST',
                body: formData
            })
            .then(res =>
                res.json()).then(d => {
                console.log(d);
                if (d.success) {
                    $('input[name="media"]').val(d.filename);
                } else {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toastr-top-right",
                        "preventDuplicates": false,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    show_toastr('Error!', d.message, 'danger',
                        '{{ asset('assets/images/notification/high_priority-48.png') }}',
                        4000);
                }
            });
    }
</script>
<script>
    var hours = 0;
    var mins = 0;
    var seconds = 0;

    $('#start').click(function() {
        startTimer();
    });

    $('#stop').click(function() {
        clearTimeout(timex);
    });

    function startTimer() {
        if (!stream) {
            show_toastr('Error!', 'Camera device not connected. Please check your camera settings.', 'danger',
                '{{ asset('assets/images/notification/high_priority-48.png') }}', 4000);
            return;
        }

        timex = setTimeout(function() {
            seconds++;
            if (seconds > 59) {
                seconds = 0;
                mins++;
                if (mins > 59) {
                    mins = 0;
                    hours++;
                    if (hours < 10) {
                        $("#hours").text('0' + hours + ':')
                    } else {
                        $("#hours").text(hours + ':');
                    }
                }

                if (mins < 10) {
                    $("#mins").text('0' + mins + ':');
                } else {
                    $("#mins").text(mins + ':');
                }
            }

            if (seconds < 10) {
                $("#seconds").text('0' + seconds);
            } else {
                $("#seconds").text(seconds);
            }
            startTimer();
        }, 1000);
    }
</script>
@endpush

