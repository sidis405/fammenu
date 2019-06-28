@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            @foreach($restaurant->validmenus as $menu)
                <div class="card">
                    <div class="card-header">{{ $menu->name }}
                        <br><small>at {{ $menu->restaurant->name }}</small>
                        <small>from {{ $menu->start_at->format('d/m/Y') }} until {{ $menu->end_at->format('d/m/Y') }}</small>
                        <small>cal {{ $menu->cal }}</small>
                    </div>

                    <div class="card-body">
                            <ul>
                                @foreach($menu->dishes as $dish)
                                    <li>{{ $dish->name }} ({{ $dish->type->name }})</li>
                                @endforeach
                            </ul>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ $restaurant->name }}
                <favorite resturantid="{{ $restaurant->id }}" ison="{{ $restaurant->isFavorited }}"></favorite>
                </div>

                <div class="card-body">
                    {{ $restaurant->address }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
