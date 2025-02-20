<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Models\Order;
use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\Magazine;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Libraries\IpayService;
use App\Models\MpesaPayment;

use Stripe;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();
        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $currency = SubscriptionPlan::findOrFail($plan_id);
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
        $recentmagazines = Magazine::whereNotNull('created_at')->latest()->limit(4)->get();
        return view('selected-plan', compact('amount', 'currency', 'countries', 'plan_type', 'recentmagazines'));
    }

    // mpesa

//Let ipay do all the work

// public function mpesa()
// {
//     $plan_id = Session::get('plan_id');
//     $plan_type = Session::get('plan_type');


//     $amount = Amount::where('subscription_plan_id', $plan_id)->value($plan_type);

//     dd($amount * 130, $plan_type);

//     return view('home.mpesa', compact('amount', 'currency', 'countries', 'plan_type', 'recentmagazines'));

// }
    // public function mpesaPost(Request $request,$amount)
    // {
    //     dd($amount);
        
    //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
    //     Stripe\Charge::create ([
    //             "amount" =>$amount * 100,
    //             "currency" => "KSHs",
    //             "source" => $request->stripeToken,
    //             "description" => "Thank you for your Payment to Sales-Page Application(powered by BGF)." 
    //     ]);
    //      Session::flash('success', 'Payment successful!');
              
    //     return back();
    // }


  
    public function checkout()
    {
        $ip = request()->ip();
        $data = \Location::get($ip);
        $Mycountry = $data->countryName ?? '';
        $currency = null;
        switch ($Mycountry) {
            case 'Kenya':
                $currency = 'KSH';
                $rate = 1; 
                break;
            case 'Uganda':
                $currency = 'UGX';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('UGX');
                break;
            case 'Tanzania':
                $currency = 'TSH';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('TSH');
                break;
            default:
                $currency = '$';
                $rate = ExchangeRate::where('currency', '=', 'KSH')->value('KSHS_USD');
                break;
        }
        $countries = Country::all();
        return view('checkout', compact('countries', 'currency', 'rate', 'amount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Session::put('plan_id', $request->plan_id);
        Session::put('plan_type', $request->plan_type);
        return redirect('subscribe/plan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }



// Bgf@123
// info@betterglobeforestry.com
// tickets@better-globe-forestry-lp2fxh.p.tawk.email (ticketing email)

    ///leave everything to ipay
    public function initiatePayment(Request $request)
    {
        $profile=Auth()->user();
        $amount = $amount;

        // return response()->json([
        //     "success"=>true,
        //     "data"=> $request->all()
        // ], 200);


        if (!$profile) {
            return response()->json(['error' => "user not logged in"], 401);
        }
        //validate and sanitize the phone number to work
        try {
            $this->validate($request, [
                'phone' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }


        // $orderId = Session::get('referenceId');
        $orderId=11;
        $amount = $amount;
        $email = $profile->email; 
        $phone =$request->phone;
            $data = IpayService::generateData([
                'total' => $amount,
                'oid' => $orderId,
                'phone' => $phone,
                'email' => $email,
                'currency' => 'KES',
                'url' => \Illuminate\Support\Facades\URL::to('ipay_payment'), // Use fully qualified namespace
            ]);
    
            // Redirect to iPay
            $ipayUrl = 'https://payments.ipayafrica.com/v3/ke?' . http_build_query($data);
        
            return redirect()->away($ipayUrl);
      
    }


    public function handlePaymentCallback(Request $request)
    {

        $profile=Auth()->user();


        if (!$profile) {
            return response()->json(['error' => "user not logged in"], 401);
        }
        // Retrieve and process callback data from iPay
        $status = $request->get('status');
        $transactionId = $request->get('txncd');
        $orderId = $request->get('id');
        $amount = $request->get('mc');
        $name = $request->get('msisdn_id');
        $email=$profile->email;
        $phone=$request->get('msisdn_idnum');
    
        if ($status === 'aei7p7yrx4ae34') {
            // Handle successful payment
             $this->updateOrdersOnSuccess($orderId, $transactionId, $amount, $name, $email, $phone, $profile);
            // return response()->json(['message' => 'Payment successful!', 'transaction_id' => $transactionId, 'data' => $request->all()]);
        } else {
            // Handle failed payment
            return response()->json(['message' => 'Payment failed!', 'status' => $status]);
        }
    }
    
    protected function updateOrdersOnSuccess($orderId, $transactionId, $amount, $name, $email, $phone, $user)
    {
         $adminEmail="accounts@betterglobeforestry.com";
         $order = Order::find($orderId);

            if (!$order) {
                return response()->json([
                    "success" => false,
                    "error" => "Order not found",
                ], 404);
            }

    
        $order->payment_status = "paid";
        $order->payment_method = "mpesa";
        $order->save();
    
        // Save mpesa transaction

        // http://127.0.0.1:8000/ipay_payment?status=aei7p7yrx4ae34&txncd=TAR9OJOGMJ&msisdn_id=SAPPHIRA+SAPPHIRA&msisdn_idnum=254740274151&p1=&p2=&p3=&p4=&uyt=744573166&agt=35428837&qwh=1792841707&ifd=1451952052&afd=631999497&poi=97754184&id=12345&ivm=12345&mc=1&channel=MPESA&vat=0.0024&commission=0.015
     
        $mpesaPayment = new MpesaPayment();
        $mpesaPayment->order_id =$orderId;
        $mpesaPayment->receipt = $transactionId;
        $mpesaPayment->amount = $amount;
        $mpesaPayment->name = $name;
        $mpesaPayment->email = $email;
        $mpesaPayment->phone = $phone;

        $mpesaPayment->save();




        
        try {
            // Attempt to send the email to the customer
            Mail::to($email)->send(new OrderMail($order, $user));

            //send email to admin
            
            Mail::to($adminEmail)->send(new AdminOrder($order, $user));
        
          
        } catch (\Exception $e) {
            \Log::error('Error sending email: ' . $e->getMessage());
        
            // Error response
        
        }
        
        header('Location: /');
        exit;
    }
}
