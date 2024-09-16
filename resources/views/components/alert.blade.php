<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if ($errors->any())
@foreach ($errors->all() as $error)
<script>
    swal("oops!", "{!! $error !!}", "error");
</script>
@endforeach
@endif
@if (session('success') || session('status'))
<script>
    swal("Success!", "{!! session('success') !!}", "success");
</script>
@endif
@if (session('error'))
<script>
    swal("oops!", "{!! session('error') !!}", "error");
</script>
@endif
<script>
    document.addEventListener('success', event => {
        swal("Success!", event.detail.status, "success");
    })
</script>
<script>
    document.addEventListener('error', event => {
        swal("Error!", event.detail.status, "error");
    });
</script>