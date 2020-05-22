@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
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
                  </div>
            </div>
        </div>
        @component('sidebar')@endcomponent
    </div>
</div>
@endsection
