@extends('website::frame')

@section('content')

    <div class="container">
        <div class="alert alert-primary" role="alert">
            Articles Loaded: {{ resolve('articles')->count() }}
        </div>

        <div class="row my-2 d-flex flex-column">
            @foreach (resolve('articles') as $article)
            <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                    <p class="card-text">{!! $article->content !!}</p>
                    <a href="{{ $article->path() }}" class="card-link">View Article</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>    

@endsection