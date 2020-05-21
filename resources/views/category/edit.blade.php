@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ویرایش دسته‌بندی</div>
                <div class="card-body px-2">
                  @if ($errors->any())
                  @foreach ($errors->all() as $error)
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>خطا</strong> {{ $error }}
                  </div>
                  @endforeach
                  @endif
                  <form class="" action="{{route('updateCat',['category'=>$cat])}}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">دسته‌بندی</label>
                                <input type="text" name="name" class="form-control" value="{{old('name',$cat->name)}}" placeholder="مثلا: اخبار" id="name">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="slug">نامک</label>
                                <input type="text" name="slug" class="form-control" value="{{old('slug',$cat->slug)}}" placeholder="مثلا: news" id="slug">
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
