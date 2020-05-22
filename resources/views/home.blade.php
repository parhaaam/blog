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
                    <h5 class="text-secondary"> <small>نوشته شده توسط {{$post->user->name}}</small>  <small>در {{$post->updated_at}}</small></h5>
                    <div class="card-text">{!!$post->text!!}</div>
                  </div>
                  <div class="card-footer text-right">
                    <a href="{{route('single',['post'=>$post])}}" class="btn btn-outline-primary btn-sm">
                      ادامه‌ی مطلب
                    <i class="fas fa-chevron-circle-left"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-sm">
                      پسندیدم
                      <i class="fas fa-heart"></i>
                      <span class="badge badge-danger">{{$post->likes}}</span>
                    </a>
                    <a href="{{route('editPost',['post'=>$post])}}" class="btn btn-outline-dark btn-sm">
                      ویرایش
                      <i class="fas fa-edit"></i>
                    </a>
                  </div>
            </div>
          @endforeach
            {{$posts->links()}}
        </div>
        @component('sidebar')@endcomponent
    </div>
</div>
@endsection
