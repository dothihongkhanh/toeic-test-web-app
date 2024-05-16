<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        $data = $request->all();

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay-callback";

        if (strpos($vnp_Returnurl, '?') === false) {
            $vnp_Returnurl .= "?";
        } else {
            // Nếu có tham số, thêm dấu "&" vào cuối
            $vnp_Returnurl .= "&";
        }
        // Thêm tham số vào sau cùng của URL
        $vnp_Returnurl .= "id_exam={$data['id_exam']}&price={$data['price']}";


        $vnp_TmnCode = "CGXZLS0Z";; //Mã website tại VNPAY 
        $vnp_HashSecret = "XNBCJFAKAZQSGTARRLGCHVZWCIOIGSHN"; //Chuỗi bí mật

        $vnp_TxnRef = Str::uuid();
        $vnp_OrderInfo = 'Thanh toan hoa don';
        $vnp_OrderType = 'bill payment';
        $vnp_Amount = $data['price'] * 100;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo
    }

    public function vnpay_callback(Request $request)
    {
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $price = $request->input('price');
        $idExam = $request->input('id_exam');
        if ($vnp_ResponseCode == '00') {
            DB::beginTransaction();
            try {
                $payment = new Payment();
                $payment->vnp_TxnRef = $vnp_TxnRef; // Sử dụng UUID
                $payment->id_user = Auth::id();
                $payment->id_exam = $idExam;
                $payment->payment_time = now();
                $payment->payment_amount = $price;
                $payment->save();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
            //return redirect()->route('checkout-success', ['vnp_TxnRef' => $vnp_TxnRef]);
            toastr()->success('Thanh toán thành công!');

            return redirect();
        }
    }
}
