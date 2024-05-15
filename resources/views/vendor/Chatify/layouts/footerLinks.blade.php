<script src="{{ asset('vendor/pusher.min.js') }}"></script>
<script >
  Pusher.logToConsole = true;
  var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
    encrypted: true,
    cluster: "{{ config('chatify.pusher.options.cluster') }}",
    authEndpoint: '{{route("pusher.auth")}}',
    auth: {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }
  });
</script>
<script src="{{ asset('vendor/js/chatify/code.js') }}"></script>
<script>
  messenger = "{{ @$id }}";
</script>
