@extends('layout')

@section('content')
    <h1>{{ $shop->name }}</h1>
      <p>
        {{ $shop->category->name }}
      </p>
      <p>{{ $shop->address }}</p>
      <div>
        <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyCRpOmQGBDF0r3_NwWadl3lR8qMi95EDV0&amp;q={{ $shop->address }}'
    width='100%'
    height='320'
    frameborder='0'>
    </iframe>

        <a href={{ route('shop.list') }}>一覧に戻る</a>

        @auth
          @if ($shop->user_id === $login_user_id)
                  <a href={{ route('shop.edit', ['id' => $shop->id]) }}>編集</a>
              {{ Form::open(['method' => 'delete', 'route' => ['shop.destroy', $shop->id]]) }}
                  {{ Form::submit('削除', ['class' => 'btn btn-outline-danger']) }}
              {{ Form::close() }}
          @endif
        @endauth
      </div>
@endsection
