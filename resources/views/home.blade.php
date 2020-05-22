@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
          @foreach ($posts as $key => $post)
            <div class="card mb-2">
                <img class="card-img-top img-fluid" src="{{$post->thumbnail}}" alt="Card image">
                  <div class="card-body text-right">
                    <h3 class="card-title">{{$post->title}}</h3>
                    <h5 class="text-secondary"> <small>نوشته شده توسط {{$post->user->name}}</small>  <small>در {{$post->updated_at}}</small></h5>
                    <div class="card-text">{!!$post->text!!}</div>
                  </div>
                  <div class="card-footer text-right">
                    <a href="#" class="btn btn-outline-danger btn-sm">
                      پسندیدم
                      <i class="fas fa-heart"></i>
                      <span class="badge badge-danger">{{$post->likes}}</span>
                    </a>
                    <a href="{{route('single',['post'=>$post])}}" class="btn btn-outline-primary btn-sm">
                      ادامه‌ی مطلب
                    <i class="fas fa-chevron-circle-left"></i>
                    </a>
                  </div>
            </div>
          @endforeach
            <div class="card">
                <img class="card-img-top img-fluid" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="Card image">
                  <div class="card-body text-right">
                    <h3 class="card-title">عنوان مطلب</h3>
                    <h5 class="text-secondary"> <small>نوشته شده توسط پرهام پرنیان</small>  <small>در ۱۲/۱۲/۱۳۹۸</small></h5>
                    <div class="card-text">Some example text.</div>
                  </div>
                  <div class="card-footer text-right">
                    <a href="#" class="btn btn-outline-danger btn-sm">
                      پسندیدم
                      <i class="fas fa-heart"></i>
                      <span class="badge badge-danger">10</span>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-sm">
                      ادامه‌ی مطلب
                    <i class="fas fa-chevron-circle-left"></i>
                    </a>
                  </div>
            </div>
            {{$posts->links()}}
        </div>
        @component('sidebar')@endcomponent
    </div>
</div>
@endsection
