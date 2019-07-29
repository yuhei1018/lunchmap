<?php

namespace App\Http\Controllers;

use App\Shop;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

class ShopController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::all();
        return view('index', ['shops' => $shops]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        return view('new', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shop = new Shop;
        $user = \Auth::user();

        $shop->name = request('name');
        $shop->address = request('address');
        $shop->category_id = request('category_id');

        $time = date("Ymdhis");

        $file = $request->file('image_url');
        $path = Storage::disk('s3')->putFile('/', $file, 'public');
        $shop->image_url = Storage::disk('s3')->url($path);

        // $shop->image_url = $request->image_url->storeAs('public/shop_images', $time.'_'.Auth::user()->id . '.jpg');
        $shop->user_id = $user->id;
        $shop->save();
        return redirect()->route('shop.detail', ['id' => $shop->id, 'image_url' => $shop->image_url])->with('my_status', __('新しいお店を追加しました。'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = Shop::find($id);
        $user = \Auth::user();
        if ($user) {
            $login_user_id = $user->id;
        } else {
            $login_user_id = '';
        }
        return view('show', ['shop' => $shop, 'login_user_id' => $login_user_id, 'image_url' => $shop->image_url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop, $id)
    {
        $shop = Shop::find($id);
        $categories = Category::all()->pluck('name', 'id');
        return view('edit', ['shop' => $shop, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop, $id)
    {
      $shop = Shop::find($id);
      $shop->name = request('name');
      $shop->address = request('address');
      $shop->category_id = request('category_id');

      $time = date("Ymdhis");

      $file = $request->file('image_url');
      $path = Storage::disk('s3')->putFile('/', $file, 'public');
      $shop->image_url = Storage::disk('s3')->url($path);

      $shop->save();
      return redirect()->route('shop.detail', ['id' => $shop->id, 'image_url' => $shop->image_url])->with('my_status', __('お店の情報を更新しました。'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        return redirect('/shops')->with('my_status', __('削除しました。'));
    }
}
