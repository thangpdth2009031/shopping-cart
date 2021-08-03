<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerId');//Ai mua?
            $table->double('totalPrice');//Mua tất cả bao nhiêu tiền?
            $table->string('shipName');//Ship cho ai?
            $table->string('shipPhone');//Số phone gọi khi cần là gi?
            $table->string('shipAddress');//Ship đến địa chỉ nào?
            $table->string('note');
            $table->boolean('isCheckOut');//Thanh toán hay chưa
            $table->timestamps();
            //-1 Delete xoa
            //-2 Cancel huy
            //0 waiting.   Chờ phản hồi
            //1 Confirmed  Đã xác nhận đơn hàng
            //2 shipping   Đang được vận chuyển
            //3 done       Đã sử lí xong.
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
