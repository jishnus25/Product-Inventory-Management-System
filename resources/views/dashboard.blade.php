<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIMS</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex flex-column min-vh-100">

    @include('layout/top')
   

    <div class="d-flex flex-grow-1">
        @include('layout/nav')

       

        <div class="flex-grow-1 p-4 bg-light text-dark">
            <div class="container mt-5">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Products</h5>
                                <p class="card-text">{{ $totalProducts }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Stock Value</h5>
                                <p class="card-text">${{ number_format($totalStockValue, 2) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-dark h-100">
                            <div class="card-body">
                                <h5 class="card-title">Low Stock Products</h5>
                                <p class="card-text">{{ $lowStockProducts->count() }} products</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

        
                <div class="mt-5">
                

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="d-flex justify-content-between mb-3">
                        <h3>Product List</h3>
                        <a href="{{ route('products.export') }}" class="btn btn-success">Export to CSV</a>
                    </div>
                    

                    <table class="table table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr @if ($product->quantity < 5) class="table-warning" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        {{ $product->quantity }}
                                        @if ($product->quantity < 5)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->category ? $product->category->name : 'No Category' }}</td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-link btn-sm">Edit</a>
                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                
                <div class="d-flex justify-content-center mt-3">
                    <div class="pagination-container">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layout/footer')




   







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            const token = localStorage.getItem('auth_token');



            $('#logout').click(function() {
                $.ajax({
                    url: '{{ route('logout') }}',
                    type: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        localStorage.removeItem('auth_token');
                        alert(response.message);
                        window.location.href = "{{ route('login-page') }}";
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message || 'Logout failed!');
                    },
                });
            });
        });
    </script>
</body>

</html>
