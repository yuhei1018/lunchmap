@extends('layout')

@section('content')
    <h1>{{ $shop->name }}を編集する</h1>
    {{ Form::model($shop, ['route' => ['shop.update', $shop->id], 'method' => 'post', 'files' => true, "enctype"=>"multipart/form-data"]) }}
      <div class="form-group">
        {{ Form::label('name', '店名:') }}
        {{ Form::text('name', $shop->name) }}
      </div>
      <div class="form-group">
        {{ Form::label('address', '住所:') }}
        {{ Form::text('address', $shop->address) }}
      </div>
      <div class="form-group">
        {{ Form::label('category_id', 'カテゴリ:') }}
        {{ Form::select('category_id', $categories) }}
      </div>
      <div class="form-group">
        {{ Form::label('image_url', '写真', ['class' => 'control-label']) }}
        {{ Form::file('image_url') }}
      </div>
      <div class="form-group">
        {{ Form::submit('更新する', ['class' => 'btn btn-primary']) }}
      </div>
      {{ Form::close() }}

      <div>
        <a href={{ route('shop.list') }}>一覧に戻る</a>
      </div>
@endsection
