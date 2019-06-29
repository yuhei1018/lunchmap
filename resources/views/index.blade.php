@extends('layout')

@section('content')

    <h1>お店一覧</h1>

    @guest
    <div class="pb-3 w-50 h-100 my-0 mx-auto">
      <form method='POST' action="{{ route('login') }}">
         @csrf
         <input id="email" type="hidden" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="test@test" required autofocus>
         <input id="password" type="hidden" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="testtest" required>
         <button class="btn btn-success">
           <i class="fas fa-check"></i>{{ __(' test user login (ポートフォリオ閲覧用)') }}
         </button>
       </form>
      </div>
      @endguest
  <table class="table table-striped table-hover">
      <tr>
        <th>カテゴリ</th><th>店名</th><th>住所</th><th>投稿者</th><th>写真</th>
      </tr>
    @foreach ($shops as $shop)
      <tr>
        <td>{{ $shop->category->name }}</td>
        <td>
          <a href={{ route('shop.detail', ['id' => $shop->id]) }}>
          {{ $shop->name }}
          </a>
        </td>
        <td>{{ $shop->address }}</td>
        <td>{{ $shop->user->name }}</td>
        <td><img src="{{ str_replace('public/', 'storage/', $shop->image_url) }}" width="200px"></td>
      </tr>
    @endforeach
  </table>
  @auth
    <div>
      <a href={{ route('shop.new') }} class="btn btn-outline-primary">新しいお店</a>
    </div>
  @endauth
@endsection
