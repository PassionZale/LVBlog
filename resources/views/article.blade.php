
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="blog-post">
                <div class="blog-post-title page-header">
                    <h2>{{$article->title}}
                        @if($article_category)<small>{{$article_category->name}}</small>@endif
                    </h2>
                </div>
                <p class="blog-post-meta">
                    {{$article->created_at}} By <a href="{{url('/')}}">Lei</a>
                </p>
                @if(count($article_tags))
                <p class="blog-post-label">
                    @foreach($article_tags as $tag)
                        <span class="label label-success">{{$tag->name}}</span>
                    @endforeach
                </p>
                @endif
                <p class="blog-post-desc">
                    {{$article->desc}}
                </p>
                <hr/>
                <input id="rawMarkdown" type="hidden" value="{{$article->content}}">
                <p id="__loading__" class="text-center text-success animated fadeIn">加载中，请稍候...</p>
                <article class="animated fadeIn">
                </article>
                <hr/>
                <p class="clearfix">
                    @if($prev)
                        <a class="pull-left" href="{{url('/article/'.$prev)}}">&laquo;&laquo;上一篇</a>
                    @endif
                    @if($next)
                        <a class="pull-right" href="{{url('/article/'.$next)}}">下一篇&raquo;&raquo;</a>
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(function(){
            var rawMarkdown = $('#rawMarkdown').val();
            if(rawMarkdown == ''){
                $('#__loading__').html('sorry,there is nothing in this article...');
            }else{
                $.post('http://gfm-kyanny.sqale.jp/markdown/raw', rawMarkdown, function(response) {
                    $('#__loading__').hide();
                    if(response == ''){
                        $('article').html(rawMarkdown).show();
                    }else{
                        $('article').html(response).show();
                    }
                });
            }
        });
    </script>
@endsection
