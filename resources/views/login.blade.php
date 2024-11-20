<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            color: #6f42c1; 
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: bold;
            color: #6f42c1; 
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .btn-custom {
            background-color: #6f42c1; 
            color: white;
            border-radius: 5px;
            width: 100%;
            padding: 10px;
            font-size: 1.1rem;
        }

        .btn-custom:hover {
            background-color: #5a32a3; 
        }

        .result {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2rem;
            color: #ff0000;
        }

        @media (max-width: 767px) {
            .login-container {
                margin: 20px;
                padding: 20px;
            }

            .login-container h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center bg-light">

    <div class="login-container">
        <h1>Login</h1>
        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn-custom">Login</button>
        </form>
        <div id="result" class="result"></div>
    </div>

    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#loginForm').submit(function (e) {
                e.preventDefault();

                const email = $('#email').val();
                const password = $('#password').val();

                $.ajax({
                    url: '{{ route('api.login') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: { email, password },
                    success: function (response) {
                        $('#result').text('Login successful!');
                        localStorage.setItem('auth_token', response.token);
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    error: function (xhr) {
                        $('#result').text(xhr.responseJSON.message || 'Login failed!');
                    },
                });
            });
        });
    </script>
</body>
</html>
