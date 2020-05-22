@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
          @foreach ($posts as $key => $post)
            <div class="card mb-2">
                <a href="{{route('single',['post'=>$post])}}">
                  <img class="card-img-top img-fluid" src="{{Storage::url($post->thumbnail)}}" alt="Card image">
                </a>
                  <div class="card-body text-right">
                    <h3 class="card-title"><a href="{{route('single',['post'=>$post])}}" class="text-dark">{{$post->title}}</a></h3>
                    <h5 class="text-secondary"> <small>نوشته شده توسط {{$post->user->name}} در {{$post->updated_at}} در موضوع <a href="{{route('postByCat',['slug' => $post->category->slug])}}">{{$post->category->name}}</a></small></h5>
                    <div class="card-text">{!!$post->text!!}</div>
                    <div class="tags">
                      @foreach ($post->tags()->get() as $tagKey => $tag)
                        <a href="{{route('tagPosts',['slug'=> $tag->slug])}}">#{{$tag->name}}</a>
                      @endforeach
                    </div>
                  </div>
                  <div class="card-footer text-right d-flex">
                    <a href="{{route('single',['post'=>$post])}}" class="btn btn-outline-primary btn-sm mx-2">
                      ادامه‌ی مطلب
                    </a>
                    <form class="" action="{{route('storeLike',['post'=>$post])}}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                          پسندیدم
                          <span class="badge badge-pill badge-danger">{{$post->likesCount}}</span>
                      </button>
                    </form>
                    <a href="{{route('single',['post'=>$post])}}#commentSection" class="btn btn-outline-info btn-sm mx-2">
                      ثبت نظر
                    <span class="badge badge-pill badge-info text-white">{{$post->commentsCount}}</span>
                    </a>
                    @can('update',$post)
                      <a href="{{route('editPost',['post'=>$post])}}" class="btn btn-outline-dark btn-sm mx-2">
                          ویرایش
                      </a>
                    @endcan
                  </div>
            </div>
          @endforeach
            {{$posts->links()}}
        </div>
        @component('sidebar')@endcomponent
    </div>
</div>
@endsection
