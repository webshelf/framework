
@if(popups()->exist())

    {{--<script>--}}
        {{--toastr.options = {--}}
            {{--"positionClass": "toast-bottom-left",--}}
            {{--"timeOut": "3000",--}}
            {{--"progressBar": true,--}}
            {{--"closeButton": true,--}}
            {{--"extendedTimeOut": "1000",--}}
            {{--"preventDuplicates": true--}}
        {{--};--}}
    {{--</script>--}}

    @foreach(popups()->all() as $popup)

        @if($popup->get('status') == 'success')
            <script>
                toastr.success('{{ $popup->get('message') }}', '{{ $popup->get('title') }}');
            </script>
        @endif

        @if($popup->get('status') == 'warning')
            <script>
                toastr.options.closeButton = true;
                toastr.warning('{{ $popup->get('message') }}', '{{ $popup->get('title') }}');
            </script>
        @endif

        @if($popup->get('status') == 'info')
            <script>
                toastr.options.closeButton = true;
                toastr.info('{{ $popup->get('message') }}', '{{ $popup->get('title') }}');
            </script>
        @endif

        @if($popup->get('status') == 'error')
            <script>
                toastr.options.closeButton = true;
                toastr.error('{{ $popup->get('message') }}', '{{ $popup->get('title') }}');
            </script>
        @endif

    @endforeach

@endif
