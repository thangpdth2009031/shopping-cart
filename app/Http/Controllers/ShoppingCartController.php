<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        Session::flash('message', 'Thêm sản phẩm vào giỏ hàng thành công!');
        return redirect('/shopping/cart')->with('message', $message);
    }

    public function show() {
        if (!Session::has('shoppingCart')) {
            Session::put('shoppingCart', []);
        }
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

    public function save(Request $request){
        //shoppingCart(cartItem1, cartItem2)
        //Kiểm tra thông tin giỏ hàng, nếu không có sản phẩm trả về trang products
        if (!Session::has('shoppingCart') || count(Session::get('shoppingCart')) == 0) {
            Session::flash('error-msg', 'Hiện tại không có sản phẩm nào trong giỏ hàng!');
            return redirect('/shopping/list');
        }
        //Chuyển đổi từ shopping cart sang oder, từng cartItem sẽ chuyển thành order
        $shoppingCart = Session::get('shoppingCart');
        $order = new Order();
        $order->totalPrice = 0;
        $order->customerId = 1;//Sau này phải lấy thông tin người dùng đang đăng nhập hiện tại.
        $order->shipName = $request->get('shipName');
        $order->shipPhone = $request->get('shipPhone');
        $order->shipAddress = $request->get('shipAddress');
        $order->note = $request->get('note');
        $order->isCheckOut = false;//default là đang thanh toán.
        $order->created_at = Carbon::now();//Thời gian tạo đơn hàng.
        $order->updated_at = Carbon::now();//Thời gian tạo đơn hàng.
        $order->status = 0; //default là chờ confirm.
        //Tạo ra mảng orderDetail để lưu thông tin của các item.
        $orderDetails = [];
        $messageError = '';
        foreach ($shoppingCart as $cartItem) {
            $product = Products::find($cartItem->id);
            if ($product == null) {
                $messageError = 'Có lỗi xảy ra, sản phẩm với id'. $cartItem->id . 'không tồn tại hoặc đã bị xoá';
                break;
            }
            $orderDetail = new OrderDetail();
            $orderDetail->productId = $cartItem->id;
            $orderDetail->unitPrice = $cartItem->price;
            $orderDetail->quantity = $cartItem->quantity;
            $order->totalPrice += $orderDetail->quantity * $orderDetail->unitPrice;
            array_push($orderDetails, $orderDetail);
        }
        if (count($orderDetails)== 0) {
            Session::flash('error-msg', $messageError);
            return 1;
            //return redirect('/shopping/list');
        }
        try {
            DB::beginTransaction();
            //database queries here
            $order->save();//order sau dòng code này có id.
            $orderDetailArray = [];
            foreach ($orderDetails as $orderDetail) {
                $orderDetail->orderId = $order->id;
                array_push($orderDetailArray, $orderDetail->toArray());
            }
            OrderDetail::insert($orderDetailArray);
            DB::commit();//finish transaction, tất cả được update database.
            Session::forget('shoppingCart');
            Session::flash('success-msg', 'Lưu đơn hàng thành công!');
        } catch (\Exception $exception) {
            DB::rollBack();//rollback, không có gì thay đổi trong database cả.
            Session::flash('error-msg', 'Lưu đơn hàng thất bại!');
            return $exception;

        }
        return redirect('/shopping/list');
    }
}
