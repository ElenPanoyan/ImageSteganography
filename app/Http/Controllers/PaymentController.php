<?php
/** Payment for one time services
 */
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Payment;
use App\Services\PaymentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function createServiceOrder($id)
    {
        $configs = config('app.payment');

        $service = Service::where('id', $id)->first();
        $orderInfo = [
            'status'=>Order::PENDING_STATUS,
            'user_id'=> $user['id'],
            'price'=>$service['price'],
            'service_id'=> $service['id'],
            'session_id'=>session()->getId()
        ];

        /************Create Order************/
        $Order =  Order::create($orderInfo);
        /**********Data For Payment*******************/
        $paymentInfo =  [];
        $paymentInfo['total_amount'] = $orderInfo['price'];
        $paymentInfo['lang'] = $lang;
        $paymentInfo['user_id'] = $user['id'];
        $paymentInfo['order_id'] = $Order['id'];


            $data = [
                'order_id' => $paymentInfo['order_id'],
                'type' => $paymentInfo['type'],
                'status' => 'pending',
                'session_id' => session()->getId(),
            ];
            $pay = Payment::create($data);

        $last_order = Order::orderBy('created_at', 'desc')->first();
        if(!$last_order){
            $last_order_id = 1;
        }else{
            $last_order_id = $last_order['id']+1;
        }
        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => $last_order_id,
            "BackURL" => env('APP_URL') . 'payment/checkPayment',
            "Description" => 'LC-CITADEL'
        ];
        $response = Http::post('ardshini_register', $query);
        $response = $response->json();

        if ($response['errorCode'] == 0) {

                Payment::where('id', '=', $pay['id'])->update([
                    'ameria_payment_id' => $response['PaymentID']
                ]);

            $redirect_url =$response['formUrl'];
            return redirect($redirect_url);
        }

    }

    private function createPayment(array $paymentInfo)
    {
        /********Create Payment*************/
        $payment = config('app.payment');
        try {
            $data = [
                'order_id' => $paymentInfo['order_id'],
                'type' => $paymentInfo['type'],
                'status' => 'pending',
                'session_id' => session()->getId(),
            ];
            $pay = Payment::create($data);
        } catch (Exception $e) {
            $this->paymentService->error_log('Create Payment', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $last_order = Order::orderBy('created_at', 'desc')->first();
        if(!$last_order){
            $last_order_id = 1;
        }else{
            $last_order_id = $last_order['id']+1;
        }
        $query = [
            "ClientID" => $payment['AmeriaClientID'],
            "Username" => $payment['AmeriaUsername'],
            "Password" => $payment['AmeriaPassword'],
            "Currency" => "AMD",
            "Amount" => (int)$paymentInfo['total_amount'],
            "OrderID" => $last_order_id,
            "BackURL" => env('APP_URL') . 'payment/checkPayment',
            "Description" => 'LC-CITADEL'
        ];
        /********Action Log For Request*************/
        $this->paymentService->action_log('Ameria Create Payment Request', $paymentInfo, $paymentInfo['type']);
        $response = Http::post($payment['AmeriaRegisterUrl'], $query);
        /********Action Log For Response*************/
        $this->paymentService->action_log('Ameria  Payment Response', $response->json(), $paymentInfo['type']);
        return ['response' => $response->json(), 'pay' => $pay];
    }

    public function checkPayment(Request $request)
    {
        $lang = 'am';
        $payment_info = config('app.payment');
        $payment = Payment::where('ameria_payment_id', '=', $request['paymentID'])->first();
        $Order = Order::where('session_id', '=', $payment['session_id'])->orderBy('created_at', 'desc')->first();
        $product = $Order['product_id'];
        $user = $Order['user_id'];
        try {
            Order::where('id', '=', $Order['id'])->update([
                'status' => 'paid'
            ]);
        } catch (Exception $e) {
            $paymentInfo = [];
            $paymentInfo['total_amount'] = $Order['total_amount'];
            $paymentInfo['lang'] = $lang;
            $paymentInfo['user_id'] = $Order['user_id'];
            $paymentInfo['order_id'] = $Order['id'];
            $paymentInfo['type'] = 'one_time_service';
            $this->paymentService->error_log('Update Order Status', $paymentInfo, 'one_time_service', $e->getMessage());
            return response($e->getMessage(), 500);
        }
        $query = [
            "Username" => $payment_info['AmeriaUsername'],
            "Password" => $payment_info['AmeriaPassword'],
            "PaymentID" => $request['paymentID']
        ];
        /********Action Log For Check Request*************/
        $this->paymentService->action_log('Ameria Check Payment Request', $payment, $payment['type']);
        $response = Http::post($payment_info['AmeriaPaymentDetails'], $query);
        $response = $response->json();
        /********Action Log For Check Response*************/
        $this->paymentService->action_log('Ameria Check Payment Response', $response, $payment['type']);
        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '00') {
            Payment::where('id', $payment->id)->update([
                'status' => 'approved'
            ]);
            Order::where('id', $Order['id'])->update([
                'status' => Order::COMPLETED_STATUS
            ]);
            DB::table('service_user')->insert([
                'user_id' => $user,
                'service_id' => $product,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            if ($response) {
                return redirect("/$lang/payment-success");
            }
        }
        return $response['Description'] ?? [];
    }

    public function payment_success()
    {
        return view('payment.payment_success');
    }

    public function createServiceOrderget($id){
        return $this->createServiceOrder($id);
    }
}
