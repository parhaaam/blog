@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">ویرایش پست</div>
                <div class="card-body px-2">
                    <div class="form-group">
                        <label for="title">عنوان پست</label>
                        <input type="title" class="form-control" placeholder="مثلا: بهترین موبایل‌های ۲۰۲۰" id="title">
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">تصویر</label>
                        <input type="file" class="form-control-file border" placeholder="مثلا: بهترین موبایل‌های ۲۰۲۰" id="thumbnail">
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="category">دسته‌بندی</label>
                                <select class="form-control" id="category">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="tags">هشتگ‌</label>
                                <select class="form-control" id="tags">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags">متن</label>
                        <vue-html5-editor id="html5-editor" :content='content' v-on:change="EditorChange"></vue-html5-editor>
                    </div>
                    <button type="submit" class="btn btn-warning">ثبت</button>
                    <button type="submit" class="btn btn-success">انتشار</button>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
