@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ویرایش دسته‌بندی</div>
                <div class="card-body px-2">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">هشتگ</label>
                                <input type="name" class="form-control" placeholder="مثلا: اخبار" id="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="slug">نامک</label>
                                <input type="slug" class="form-control" placeholder="مثلا: news" id="slug">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">ثبت</button>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
