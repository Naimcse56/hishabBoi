@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-0 mt-2" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-0 mt-2" role="alert">
        {{ session('error') }}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show mb-0 mt-2" role="alert">
        {{ session('warning') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show mb-0 mt-2" role="alert">
        {{ session('info') }}
    </div>
@endif

@if($errors->any())
<div class="alert alert-danger mb-0 mt-2">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- <script>
    // Hide flash messages after 3 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
            alert.style.display = 'none'; // Remove from view
        });
    }, 3000); // Time in milliseconds (3000ms = 3 seconds)
</script> --}}