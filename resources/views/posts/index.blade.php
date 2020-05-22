@extends('layouts.app')
@push('scripts')
  <script src="{{asset('js/dashboard.js')}}" charset="utf-8"></script>
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
            <div class="table-striped table-responsive">
                <table class="table">
                  <thead class="">
                    <tr>
                      <th>عنوان</th>
                      <th>نویسنده</th>
                      <th>اخرین تغییر</th>
                      <th>وضعیت</th>
                      <th>عملیات</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($posts as $key => $post)
                      <tr>
                        <td>{{$post->title}}</td>
                        <td>{{$post->user->name}}</td>
                        <td>{{$post->updated_at}}</td>
                        <td>@switch($post->status)
                            @case(1)
                              منتشر شده
                              @break
                            @default
                              در صف بررسی
                              @break
                            @endswitch
                        </td>
                        <td class="table-actions">
                          <a href="{{route('editPost',['post' => $post])}}" class="btn btn-outline-primary"><i class="fas fa-pen"></i> ویرایش</a>
                          <form class="" action="{{route('submitPost',['post' => $post])}}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            @csrf
                            <button type="submit" class="btn btn-outline-success delete">
                              <i class="far fa-paper-plane"></i>انتشار
                            </button>
                          </form>
                          <form class="" action="{{route('deletePost',['post' => $post])}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger delete">
                              <i class="fas fa-trash"></i>حذف
                            </button>
                          </form>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
