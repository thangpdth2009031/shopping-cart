<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoppingCartController extends Controller
{
    public function add(Request $request) {
        $productId = $request->get('productId');//Lấy ra thông tin sản phẩm từ request.
        $productQuantity = $request->get('productQuantity');//Lấy ra số lượng sản phẩm cần thêm.
        $action = $request->get('cartAction');//Lấy ra số lượng sản phẩm cần thêm.
        //Kiểm tra sự tồn tại của sản phẩm trong database
        $product = Products::find($productId);
        if ($product == null) {
            //Trong trường hợp sản phẩm không còn tồn tại thì show trang 404.
            return view('404');
        }
        //Kiểm tra số lượng sản phẩm thêm vào đơn hàng, đảm bảo lớn hơn 0. $productQuantity
        //Kiểm tra số lượng hàng còn trong kho (tạm thời coi như luôn có)
        //Kiểm tra trong session có shopping cart chưa
        $shoppingCart = null;
        if (Session::has('shoppingCart')) {
            //Có rồi thì lấy thông tin cũ ra
            $shoppingCart = Session::get('shoppingCart');
        } else {
            //Chưa có thì tạo mới.
            $shoppingCart = [];
        }
        //Kiểm tra trong shoppingcart có sản phẩm này chưa.
        $cartItem = null;
        $message = 'Thêm sản phẩm vào giỏ hàng thành công!';
        if (!array_key_exists($productId, $shoppingCart)) {
            //Trường hợp chưa có sản phẩm, tạo ra cartItem mới, lấy thông tin từ chính sản phẩm đó.
            $cartItem = new \stdClass();
            $cartItem->id = $product->id;
            $cartItem->name = $product->name;
            $cartItem->thumbnail = $product->thumbnail;
            $cartItem->price = $product->price;
            $cartItem->quantity = intval($productQuantity);
        } else {
            //Trường hợp có sản phẩm rồi thì lấy ra và tăng số lượng.
            $cartItem = $shoppingCart[$productId];
            if ($action != null && $action == 'update') {
                $cartItem->quantity = $productQuantity;
                $message = 'Update sản phẩm thành công!';
            } else {
                $cartItem->quantity += $productQuantity;
                $message = 'Thêm mới sản phẩm vào giỏ hàng thành công!';
            }
        }
        //Sau đó cho lại vào shopping cart
        $shoppingCart[$productId] = $cartItem;
        //Lưu shoppingcart vào lại trong session
        Session::put('shoppingCart', $shoppingCart);
        Session::flash('success-msg', 'Thêm sản phẩm vào giỏ hàng thành công!');
        return redirect('/shopping/cart')->with('message', $message);
    }

    public function show() {
        $shoppingCart = Session::get('shoppingCart');
        return view('cart', [
            'shoppingCart'=>$shoppingCart
        ]);
    }

    public function remove(Request $request) {
        $productId = $request->get('productId');
        $shoppingCart = null;
        if (Session::has('shoppingCart')) {
            $shoppingCart = Session::get('shoppingCart');
            unset($shoppingCart[$productId]);
            Session::put('shoppingCart', $shoppingCart);
            return redirect('/shopping/cart')->with('remove', 'Xoá sản phẩm khỏi giỏ hàng thành công!');
        }
    }
}
