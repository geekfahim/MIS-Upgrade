<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $(document).ready(function () {
        $('input').attr('autocomplete', 'off');
        @if(request()->session()->has('warning'))
        toastr.warning("{{ request()->session()->get('warning') }}", "Warning!");
        @endif
        setTimeout(function () {
            $('.nav-link').each(function (i, obj) {
                if (obj.getAttribute("href") == window.location.href.split('?')[0]) {
                    obj.scrollIntoView({block: "center", inline: "nearest"});
                    return true;
                }
            });
        }, 410);
    });
</script>
