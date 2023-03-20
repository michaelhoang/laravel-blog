@extends('layout')
@section('content')

    <div class="col-12">
        <article class="row">
            <div class="feature-image col-4">
                <img src="https://placehold.jp/300x300.png" alt="{{$post->title}}">
            </div>
            <div class="content col-8">
                <h2 class="title">{{$post->title}}</h2>
                <p class="description">{{$post->content}}</p>
            </div>
        </article>
    </div>

@endsection
