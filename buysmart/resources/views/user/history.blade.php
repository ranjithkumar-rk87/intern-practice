@extends('layouts.app')

@section('title', 'My History')

@section('content')
<div class="container my-4">

    <h4 class="mb-3">My History</h4>

    @if($histories->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-warning">
                    <tr>
                        <th>S.NO</th>
                        <th>Order ID</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $index => $history)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>#{{ $history->order_id }}</td>
                            <td>
                                <span class="badge 
                                    @if($history->status == 'pending') bg-secondary
                                    @elseif($history->status == 'processing') bg-info
                                    @elseif($history->status == 'delivered') bg-success
                                    @elseif($history->status == 'cancelled') bg-danger
                                    @else bg-dark
                                    @endif
                                ">
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td>
                            <td>{{ ucfirst(str_replace('_',' ', $history->action)) }}</td>
                            <td>₹{{ number_format($history->total_amount, 2) }}</td>
                            <td>{{ ucfirst($history->payment_method ?? 'N/A') }}</td>
                            <td>{{ $history->created_at->format('d M Y, h:i A') }}</td>
                             <td>
                                <a href="{{ route('history.show', $history->order_id) }}" 
                                   class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            No order history found.
        </div>
    @endif

</div>
@endsection
