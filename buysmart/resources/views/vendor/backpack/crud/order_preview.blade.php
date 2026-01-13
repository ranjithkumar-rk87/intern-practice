@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">

   <div class="d-flex justify-content-between mb-3">
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-link">
        <i class="la la-angle-left"></i> Back
    </a>

    <button class="btn btn-sm btn-success" onclick="window.print()">
        <i class="la la-print"></i> Print Invoice
    </button>
</div>


    <div class="card">
        <div class="card-body">

            <h4 class="mb-3">Order #{{ $entry->id }}</h4>

            <div class="row mb-4">
                <div class="col-md-6">
                    <strong>Customer</strong><br>
                    {{ $entry->user->name ?? '-' }}<br>
                    {{ $entry->user->email ?? '-' }}<br>
                    {{ $entry->user->phone ?? '-' }}
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
                                    <span>—</span>
                                @endif
                            </td>
                            <td>{{ $item->product?->name ?? 'Deleted product' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No products</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                <h5>Order Summary</h5>
                <p><strong>Total Amount:</strong> ₹{{ number_format($entry->total_amount, 2) }}</p>
                <p><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($entry->status) }}</span></p>
                <p><strong>Payment Method:</strong> {{ ucfirst($entry->payment_method) }}</p>
                <p><strong>Order Date:</strong> {{ $entry->created_at->format('d M Y, H:i') }}</p>
            </div>

        </div>
    </div>
</div>
@endsection
