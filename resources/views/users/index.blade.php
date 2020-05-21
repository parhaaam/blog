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
                      <th>نام</th>
                      <th>ایمیل</th>
                      <th>نقش</th>
                      <th>عملیات</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $key => $user)
                      <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                          @switch($user->role)
                            @case(3)
                              مدیر
                              @break
                            @case(2)
                              سردبیر
                              @break
                            @case(1)
                              نویسنده
                              @break
                            @default
                              کاربر
                              @break
                            @endswitch
                        </td>
                        <td class="table-actions">
                          <a href="{{route('editUser',['user' => $user])}}" class="btn btn-outline-primary"><i class="fas fa-pen"></i> ویرایش</a>
                          <form class="" action="{{route('deleteUser',['user' => $user])}}" method="post">
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
