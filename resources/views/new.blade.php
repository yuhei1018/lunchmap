@extends('layout')

@section('content')
    <h1>新しいお店</h1>
    {{ Form::open(['route' => 'shop.store', 'method' => 'post', 'files' => true, "enctype"=>"multipart/form-data"]) }}

    {{ csrf_field() }}

        {{--成功時のメッセージ--}}
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    {{-- エラーメッセージ --}}
    @if ($errors->any())
        <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

      <div class="form-group">
        {{ Form::label('name', '店名:') }}
        {{ Form::text('name', null) }}
      </div>
      <div class="form-group">
        {{ Form::label('address', '住所:') }}
        {{ Form::text('address', null) }}
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
        {{ Form::submit('作成する', ['class' => 'btn btn-primary']) }}
      </div>
      {{ Form::close() }}

      <div>
        <a href={{ route('shop.list') }}>一覧に戻る</a>
      </div>
@endsection
