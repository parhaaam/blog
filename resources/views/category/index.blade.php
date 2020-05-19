@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-striped table-responsive">
                <table class="table">
                  <thead class="">
                    <tr>
                      <th>دسته‌بندی</th>
                      <th>نامک</th>
                      <th>عملیات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>اخبار</td>
                      <td>news</td>
                      <td class="table-actions">
                        <a href="#" class="text-primary"><i class="fas fa-pen"></i></a>
                        <a href="#" class="text-danger"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
