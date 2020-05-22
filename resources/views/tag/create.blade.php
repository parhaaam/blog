@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ایجاد هشتگ</div>
                <div class="card-body px-2">
                  @if ($errors->any())
                  @foreach ($errors->all() as $error)
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>خطا</strong> {{ $error }}
                  </div>
                  @endforeach
                  @endif
                  <form class="" action="{{route('storeTag')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">هشتگ</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="مثلا: اخبار" id="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="slug">نامک</label>
                                <input type="text" name="slug" class="form-control" value="{{old('slug')}}" placeholder="مثلا: news" id="slug">
                            </div>
                        </div>
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
