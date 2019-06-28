@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            <search />
        </div>
    </div>

    <hr>

    <h4>Your favorite menus and restaurants</h4>
    <div class="row">
        <div class="col-md-8">
            @foreach($menus as $menu)
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
                <div class="card-header">Favorites</div>

                <div class="card-body">
                    @if($favorites->count())
                        <ul>
                            @foreach($favorites as $favorite)
                                <li><a href="{{ route('restaurants.show', $favorite) }}">{{ $favorite->name }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        You have not favorited any restaurants
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
