@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <h4 class="mb-3">Order #{{ $entry->id }}</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Customer</strong><br>
                    {{ $entry->user->name }}<br>
                    {{ $entry->user->email }}
                </div>

                <div class="col-md-6">
                    <strong>Delivery Address</strong><br>
                    @php($d = $entry->user->detail)
                    @if($d)
                        {{ $d->phone }}<br>
                        {{ $d->address }}<br>
                        {{ $d->city }}, {{ $d->state }} - {{ $d->pincode }}
                    @else
                        -
                    @endif
                </div>
            </div>

            <h5>Order Items</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="80">Product Image</th>
                        <th>Product</th>
                        <th width="100">Qty</th>
                        <th width="120">Price</th>
                        <th width="120">Total</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($entry->items as $item)
                    <tr>
                         <td class="text-center">
                            @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/'.$item->product->image) }}"
                                    class="product-thumb">
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $item->product?->name ?? 'Deleted product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ $item->price }}</td>
                        <td>₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No products</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
