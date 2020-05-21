@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ویرایش کاربر</div>
                <div class="card-body px-2">
                  <div class="form-group">
                    <label for="name">نام و نام خانوادگی</label>
                    <input type="name" class="form-control" placeholder="مثلا: علی محمدی" id="name">
                  </div>
                  <div class="form-group">
                    <label for="email">آدرس ایمیل</label>
                    <input type="email" class="form-control" placeholder="Enter email" id="email">
                  </div>
                  <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" placeholder="Enter email" id="email">
                  </div>
                  <div class="form-group">
                    <label for="sel1">نقش</label>
                    <select class="form-control" id="sel1">
                      <option value="3">ادمین</option>
                      <option value="2">سردربیر</option>
                      <option value="1">نویسنده</option>
                      <option value="0">کاربر عادی</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="photo">تصویر پروفایل</label>
                    <input type="file" class="form-control-file border" placeholder="Enter email" id="photo">
                  </div>
                  <div class="form-group">
                    <label for="bio">بیوگرافی</label>
                    <textarea class="form-control" rows="5" id="bio"></textarea>
                  </div>
                    <button type="submit" class="btn btn-success btn-block">ثبت</button>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
