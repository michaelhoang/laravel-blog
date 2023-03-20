@extends('layout')
@section('content')

    @foreach ($posts as $post)
        <div class="mt-4 {{ $loop->odd ? 'odd' : 'even' }}">
            <article class="row">
                <div class="feature-image col-4">
                    <img src="https://placehold.jp/300x300.png" alt="{{$post->title}}">
                </div>
                <div class="content col-8">
                    <h2 class="title"><a href="/post/{{ $post->slug }}">{{$post->title}}</a></h2>
                    <p class="description">{{$post->excerpt}}</p>
                </div>
            </article>
        </div>
    @endforeach

@endsection
