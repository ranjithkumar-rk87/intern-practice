<!DOCTYPE html>
<html>
<head>
    <title>User Index</title>
</head>
<body>
    <h1>Welcome to User Index Page</h1>{{-- This is a Blade comment --}}
    <a href="{{ route('users.create') }}">Create User</a>

    @php
        $total = 100;
    @endphp

    <h2>Total: {{ $total }}</h2>

    @php
        $age = 16;
    @endphp

    <h2>Age: {{ $age }}</h2>

    @if($age >= 18)
        <p>Adult</p>
    @elseif($age >= 13)
        <p>Teen</p>
    @else
        <p>Child</p>
    @endif


    @php
         $numbers = [10, 20, 30, 40, 50];
    @endphp


    @foreach($numbers as $number)
        <p>{{ $number }}</p>
    @endforeach

    @for($i = 1; $i <= 5; $i++)
        <p>{{ $i }}</p>
    @endfor

    @php
        $count = 0;
    @endphp


    @while($count < 3)
        <p>{{ $count }}</p>
        @php $count++; @endphp
    @endwhile

</body>
</html>
