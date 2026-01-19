@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4 align-items-start">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                ← Back to Home
            </a>
        </div>

    <div class="col-12 col-md-6">
        <div class="card border rounded shadow-sm product_image" >
            <img src="{{ asset('storage/'.$product->image) }}" class="w-100 h-100">
        </div>
    </div>

    <div class="col-12 col-md-6 mt-4 mt-md-0">
        <div class="card shadow-sm p-4">

            <div class="d-flex justify-content-between align-items-start">
                <h2 class="fw-bold">{{ $product->name }}</h2>

                @auth
                    @php
                        $exists = auth()->user()
                            ->wishlist()
                            ->where('product_id', $product->id)
                            ->exists();
                    @endphp

                    @if(!$exists)
                        <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">
                                ❤️ Wishlist
                            </button>
                        </form>
                    @else
                        <span class="badge bg-danger px-3 py-2">
                            ❤️ Wishlisted
                        </span>
                    @endif
                @endauth
                </div>

                @if($product->stock > 0)
                    <h4 class="text-success mb-2">
                        ₹{{ number_format($product->price, 2) }}
                    </h4>
                @endif


                <div class="my-2">
                    @if($product->stock > 10)
                        <span class="badge bg-success">In Stock</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning text-dark">
                            Only {{ $product->stock }} left
                        </span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>

                <p class="text-muted mt-3">
                    {{ $product->description }}
                </p>

                @auth
                <form method="GET" class="mt-4">
                    <label class="form-label fw-semibold">Quantity</label>
                    <div class="input-group mb-3" style="max-width:180px;">
                        <button formaction="{{ route('quantity.update', $product->id) }}"
                                name="action" value="decrease"
                                class="btn btn-outline-secondary">−</button>

                        <input type="number"
                               name="quantity"
                               value="{{ old('quantity', 1) }}"
                               class="form-control text-center"
                               readonly>

                        <button formaction="{{ route('quantity.update', $product->id) }}"
                                name="action" value="increase"
                                class="btn btn-outline-secondary">+</button>
                    </div>

                    
                   <div class="d-flex gap-2 mt-3">
                         <button formaction="{{ route('cart.add', $product->id) }}"
                                class="btn btn-primary px-5 flex-fill"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                            Add to Cart
                        </button>

                        <!-- <button formaction="{{ route('buy.now', $product->id) }}"
                                class="btn btn-success px-5 flex-fill"
                                {{ $product->stock == 0 ? 'disabled' : '' }}>
                            Buy Now
                        </button> -->
                    </div>

                </form>
                <form action="{{ route('delivery.check', $product->id) }}"method="POST"class="mt-4">
                @csrf

                <label class="form-label fw-semibold">
                    Check Delivery Availability
                </label>

                <div class="input-group">
                    <input type="text"
                           name="pincode"
                           class="form-control"
                           placeholder="Enter 6-digit Pincode"
                           maxlength="6"
                           required>

                    <button class="btn btn-dark">
                        Check
                    </button>
                </div>
            </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mt-3">
                        Login to Continue
                    </a>
                @endguest

            </div>
        </div>
    </div>


@php
    $specs = json_decode($product->specifications, true);
@endphp

@if(is_array($specs) && count($specs))
    <h4 class="mt-4">Specifications</h4>

<div class="accordion" id="productSpecsAccordion">

    @foreach($specs as $section => $items)
        @php
            $headingId = 'heading_' . $loop->index;
            $collapseId = 'collapse_' . $loop->index;
        @endphp

        <div class="accordion-item">
            <h2 class="accordion-header" id="{{ $headingId }}">
                <button class="accordion-button {{ !$loop->first ? 'collapsed' : '' }}"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#{{ $collapseId }}"
                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                        aria-controls="{{ $collapseId }}">
                    {{ ucfirst(str_replace('_', ' ', $section)) }}
                </button>
            </h2>

            <div id="{{ $collapseId }}"
                 class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                 aria-labelledby="{{ $headingId }}"
                 data-bs-parent="#productSpecsAccordion">

                <div class="accordion-body">
                    <div class="row g-3">
                        @if(is_array($items))
                            @foreach($items as $key => $value)
                                <div class="col-md-6">
                                    <strong>{{ str_replace('_', ' ', $key) }}:</strong>
                                    {{ is_array($value) ? implode(', ', $value) : $value }}
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                {{ $items }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    @endforeach
</div>
@endif


    <div class="row mt-5">
        <div class="col-12">
            <h3>Product Reviews</h3>

            <div class="mb-3">
                <strong>Average Rating:</strong>
                @php $avg = $product->averageRating(); @endphp
                @for($i=1; $i<=5; $i++)
                    @if($i <= round($avg))
                        <span class="text-warning">★</span>
                    @else
                        <span class="text-muted">★</span>
                    @endif
                @endfor
                ({{ number_format($avg, 1) }})
            </div>

            <div class="mb-4">
                @forelse($product->reviews as $review)
                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ $review->user->name }}</strong>
                        <span class="text-warning">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating) ★ @else ☆ @endif
                            @endfor
                        </span>
                        <p>{{ $review->review }}</p>
                    </div>
                @empty
                    <p>No reviews yet. Be the first to review!</p>
                @endforelse
            </div>

            @auth
            <form action="{{ route('product.review.store', $product->id) }}" method="POST">
                @csrf
                <label class="form-label fw-semibold">Your Rating</label>
                <select name="rating" class="form-select mb-2" required>
                    <option value="">Select rating</option>
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>

                <label class="form-label fw-semibold">Your Review</label>
                <textarea name="review" class="form-control mb-2" placeholder="Write your review"></textarea>

                <button class="btn btn-outline-primary w-100">Submit Review</button>
            </form>
            @endauth

            @guest
            <p><a href="{{ route('login') }}">Login</a> to submit a review.</p>
            @endguest

        </div>
    </div>


    <div class="row mt-5">
        <div class="col-12">
            <h3>Product Q&A</h3>
            <div class="mb-4">
                @forelse($product->questions ?? [] as $q)
                    <div class="mb-3 border-bottom pb-2">
                        <strong>{{ $q->user->name }} asks:</strong>
                        <p>{{ $q->question }}</p>

                        @if($q->answered && $q->answer)
                            <div class="text-success ps-3">
                                <strong>Answer:</strong> {{ $q->answer }}
                            </div>
                        @else
                            <div class="text-muted ps-3"><em>Not answered yet</em></div>
                        @endif
                    </div>
                @empty
                    <p>No questions yet. Be the first to ask!</p>
                @endforelse
            </div>

            @auth
            <form action="{{ route('product.question.store', $product->id) }}" method="POST">
                @csrf
                <textarea name="question" class="form-control mb-2" placeholder="Ask a question about this product" required></textarea>
                <button class="btn btn-outline-primary w-100">Submit Question</button>
            </form>
            @endauth

            @guest
            <p><a href="{{ route('login') }}">Login</a> to ask a question.</p>
            @endguest
        </div>
    </div>
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3>Related Products</h3>
        </div>

        @foreach($relatedProducts as $related)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card  border rounded h-100 shadow-sm">
                <a href="{{ route('products.show', $related->id) }}">
                    <img src="{{ asset('storage/'.$related->image) }}"
                        class="card-img-top"
                        alt="{{ $related->name }}">
                </a>

                <div class="card-body text-center">
                    <h6>{{ $related->name }}</h6>

                    @if($related->stock > 0)
                        <p class="text-success mb-1">
                            ₹{{ number_format($related->price, 2) }}
                        </p>
                        <span class="badge bg-success">In Stock</span>
                    @else
                        <span class="badge bg-danger">Out of Stock</span>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif



</div>
@endsection
