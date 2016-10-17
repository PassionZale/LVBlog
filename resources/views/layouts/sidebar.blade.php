
<div class="list-group">
    <div class="list-group-item">
        <form role="form" method="post" action="{{url('/search')}}">
            <div class="form-group" style="margin-bottom:0;">
                <div class="input-group">
                    <input value="{{ $keyword or ''}}" id="keyword" name="keyword" class="form-control" type="text" placeholder="Search for article title..." required>
                    {{csrf_field()}}
                    <div class="input-group-addon" style="cursor: pointer;">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @foreach($categories_sidebar['categories'] as $category)
    <a href="{{url('/category/'.$category->id)}}" class="list-group-item">
        {{$category->name}}
    </a>
    @endforeach
    @if($categories_sidebar['categories_count'] > 8)
    <a href="#" class="list-group-item active">
        More&nbsp;&raquo;&raquo;&raquo;
    </a>
    @endif
</div>

@section('sidebar_script')
<script>
    $('.input-group-addon').on('click',function(){
        $('form').submit();
    });
    $('#keyword').on('keyup',function(e){
        if(e.keyCode == 13){
            $('form').submit();
        }
    });
</script>
@endsection
