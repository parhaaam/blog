@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ویرایش کاربر</div>
                <div class="card-body px-2">
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>خطا</strong> {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    <form action="{{route('updateUser',['user'=>$user])}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                        @csrf
                        <div class="form-group">
                            <label for="name">نام و نام خانوادگی</label>
                            <input type="name" name="name" class="form-control" placeholder="مثلا: علی محمدی" id="name" value="{{ old('name',$user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="role">نقش</label>
                            <select class="form-control" name="role" id="role">
                                <option value="3" @if (old('role',$user->role)==3) selected @endif>ادمین</option>
                                <option value="2" @if (old('role',$user->role)==2) selected @endif>سردبیر</option>
                                <option value="1" @if (old('role',$user->role)==1) selected @endif>نویسنده</option>
                                <option value="0" @if (old('role',$user->role)==0) selected @endif>کاربر عادی</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">تصویر پروفایل</label>
                            <input type="file" class="form-control-file border" name="photo" value="{{ old('photo',$user->photo) }}" id="photo">
                        </div>
                        <div class="form-group">
                            <label for="password">رمزعبور</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">تکرار رمزعبور</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="bio">بیوگرافی</label>
                            <textarea class="form-control" rows="5" name="bio" id="bio">{{ old('bio',$user->bio) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">ثبت</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
