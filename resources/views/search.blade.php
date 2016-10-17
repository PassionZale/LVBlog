@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            @if(count($articles))
                @foreach($articles as $article)
                <div class="blog-post">
                    <div class="blog-post-title">
                        <h2><a href="{{url('/article/'.$article->id)}}">{{$article->title}}</a></h2>
                    </div>
                    <p class="blog-post-meta">
                        {{$article->created_at}} By <a href="{{url('/')}}">Lei</a>
                    </p>
                    <p class="blog-post-desc">
                        {{$article->desc}}
                    </p>
                    <div class="blog-post-btn clearfix">
                        <a href="{{url('/article/'.$article->id)}}" class="pull-right">Read More...</a>
                    </div>
                    <hr/>
                </div>
                @endforeach
            @else
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <strong>Whoops! </strong>No result has been found! <a href="/" class="alert-link">Click me to go back.<a>
                </div>
            @endif
        </div>
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
    </div>
</div>
@endsection
