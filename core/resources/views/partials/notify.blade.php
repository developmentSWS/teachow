<link rel="stylesheet" href="{{ asset('assets/global/css/iziToast.min.css') }}">
<script src="{{ asset('assets/global/js/iziToast.min.js') }}"></script>
@if (session()->has('notify'))
    @foreach (session('notify') as $msg)
        <script>
            "use strict";
            iziToast.{{ $msg[0] }}({
                message: "{{ __($msg[1]) }}",
                position: "topRight"
            });
        </script>
    @endforeach
@endif

@if ($errors->any())
    @php
        $collection = collect($errors->all());
        $errors = $collection->unique();
    @endphp

    <script>
        "use strict";
        @foreach ($errors as $error)
            iziToast.error({
            message: '{{ __($error) }}',
            position: "topRight"
            });
        @endforeach
    </script>

@endif
<script>
    "use strict";

    function notify(status, message) {
        iziToast[status]({
            message: message,
            position: "topRight"
        });
    }



    function rating(rating) {
        var star = '';
        for (var i = 0; i < 5; i++) {
            if (!(rating <= i)) {
                star += '<i class=" las la-star fa-lg"></i>';
            } else {
                star += '<i class="lar la-star fa-lg"></i>';
            }
        }
        return star;
    }
</script>
