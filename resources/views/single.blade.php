@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
          @if ($errors->has('messages'))
          @foreach ($errors->get('messages', ':message') as $error)
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{$error}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          @endforeach
          @endif
            <div class="card mb-2">
                <img class="card-img-top img-fluid" src="{{$post->thumbnail ==null ? asset('no image.jpg') : Storage::url($post->thumbnail)}}" alt="Card image">
                <div class="card-body text-right">
                    <h3 class="card-title">{{$post->title}}</h3>
                    <h5 class="text-secondary"> <small>نوشته شده توسط {{$post->user->name}} در {{$post->updated_at}} در موضوع <a href="{{route('postByCat',['slug' => $post->category->slug])}}">{{$post->category->name}}</a></small></h5>
                    <div class="card-text">{!!$post->text!!}</div>
                    <div class="tags">
                      @foreach ($post->tags()->get() as $tagKey => $tag)
                        <a href="{{route('tagPosts',['slug'=> $tag->slug])}}">#{{$tag->name}}</a>
                      @endforeach
                    </div>
                </div>
                <div class="card-footer text-right d-flex">
                  <form class="" action="{{route('storeLike',['post'=>$post])}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        پسندیدم
                        <span class="badge badge-pill badge-danger">{{$post->likesCount}}</span>
                    </button>
                  </form>
                  @can('update',$post)
                    <a href="{{route('editPost',['post'=>$post])}}" class="btn btn-outline-dark btn-sm mx-2">
                        ویرایش
                    </a>
                  @endcan
                </div>
            </div>
            @foreach ($comments as $key => $comment)
              <div class="card mb-2">
                  <div class="card-body text-right">
                      <h5 class="text-secondary">{{$comment->user_name}} در {{$comment->updated_at}} گفت</h5>
                      <div class="card-text">{{$comment->text}}</div>
                  </div>
              </div>
            @endforeach
            <div id="commentSection" class="card mb-2">
                <form class="" action="{{route('storeComment',['post'=>$post])}}" method="post">
                  @csrf
                    <div class="card-body text-right">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="name">نام و نام خانوادگی:</label>
                                    <input type="text" class="form-control" name="user_name" value="{{old('user_name',Auth::user() ? Auth::user()->name : '')}}" id="name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="user_email">ایمیل:</label>
                                    <input type="email" class="form-control" name="user_email" value="{{old('user_email',Auth::user() ? Auth::user()->email : '')}}" id="user_email" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="website">وبسایت</label>
                                    <input type="url" class="form-control" name="website" value="{{old('website')}}" id="website">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="text">نظر</label>
                            <textarea class="form-control" rows="5" name="text" id="text">{{old('text')}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-outline-success">ثبت نظر</button>
                    </div>
                </form>
            </div>
        </div>
        @component('sidebar')@endcomponent
    </div>
</div>
@endsection
