<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #6f42c1;">
    <div class="container-fluid">
        <a class="navbar-brand text-white ms-3" href="{{route('dashboard')}}">PIMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex justify-content-center flex-grow-1">
                <a class="navbar-brand text-white text-center" href="#">Admin Dashboard</a>
            </div>
            <div class="d-flex flex-shrink-0 align-items-center">
                <button id="logout" type="submit" class="btn btn-danger">Logout</button>
            </div>
        </div>
    </div>
</nav>













<script>
    $(document).ready(function () {
        const token = localStorage.getItem('auth_token');

    

        $('#logout').click(function () {
            $.ajax({
                url: '{{ route('logout') }}',
                type: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    localStorage.removeItem('auth_token');
                    alert(response.message);
                    window.location.href = "{{ route('login-page') }}";
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Logout failed!');
                },
            });
        });
    });
</script>