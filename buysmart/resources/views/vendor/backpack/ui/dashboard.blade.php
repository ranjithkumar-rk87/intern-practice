@extends(backpack_view('blank'))


@section('content')
 <div class="row">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h3 class="card-title text-center">{{ \App\Models\User::count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Orders</div>
                <div class="card-body">
                    <h3 class="card-title text-center">{{ \App\Models\Order::count() }}</h3>
                </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Products</div>
                <div class="card-body">
                    <h3 class="card-title text-center">{{ \App\Models\Product::count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Revenue (Delivered Orders)</div>
                <div class="card-body">
                    <h3 class="card-title text-center">
                        ₹{{ \App\Models\Order::where('status', 'delivered')->sum('total_amount') }}
                    </h3>
                </div>
            </div>
        </div>



    <!-- Pending Orders Card -->
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Pending Orders</div>
            <div class="card-body">
                <h3 class="card-title text-center">{{ \App\Models\Order::where('status', 'pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Confirmed Orders</div>
            <div class="card-body">
                <h3 class="card-title text-center">{{ \App\Models\Order::where('status', 'confirmed')->count() }}</h3>
            </div>
        </div>
    </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-header">Delivered Orders</div>
            <div class="card-body">
                <h3 class="card-title text-center">{{ \App\Models\Order::where('status', 'delivered')->count() }}</h3>
            </div>
        </div>
    </div>
@endsection
