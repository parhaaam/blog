@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ثبت پست</div>
                <div class="card-body px-2">
                  @if ($errors->any())
                  @foreach ($errors->all() as $error)
                  <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>خطا</strong> {{ $error }}
                  </div>
                  @endforeach
                  @endif
                  <form class="" action="{{route('storePost')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">عنوان پست</label>
                        <input name="title" type="text" class="form-control" value="{{old('title')}}" placeholder="مثلا: بهترین موبایل‌های ۲۰۲۰" id="title">
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">تصویر</label>
                        <input name="thumbnail" type="file" class="form-control-file border"  value="{{old('thumbnail')}}" placeholder="مثلا: بهترین موبایل‌های ۲۰۲۰" id="thumbnail">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="category">دسته‌بندی
                                  <br>
                                    <small>دسته‌بندی موردنظر خود را انتخاب کنید</small></label>
                                <select class="form-control" name="category" id="category">
                                  @foreach ($categories as $key => $cat)
                                    <option value="{{$cat->id}}" @if( old('category') == $cat->id) selected @endif>{{$cat->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tags">هشتگ‌ <br>
                                  <small>هشتگ‌ها را با , ازهم جدا کنید</small>
                                </label>
                                <input name="tags" type="text" class="form-control" value="{{old('tags')}}" placeholder="مثلا: خبر,فوتبال,ورزش" id="tags">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags">متن</label>
                        <textarea class="form-control d-none" rows="5" ref="message_text" name='text' id="text">{{old('text')}}</textarea>
                        <vue-html5-editor name="text" id="html5-editor" :content='content' v-on:change="EditorChange" default_content="{{old('text')}}"></vue-html5-editor>
                    </div>
                    <button type="submit" class="btn btn-success">ثبت</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
