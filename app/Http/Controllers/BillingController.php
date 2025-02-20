<?php

namespace App\Http\Controllers;

use App\Mail\NewCustomer;
use App\Models\Amount;
use App\Models\CartItem;
use App\Models\CartOrder;
use App\Models\Order;
use App\Models\SelectedIssue;
use App\Models\billing;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Delights\Sage\SageEvolution;
use Cart;
use Illuminate\Support\Facades\Mail;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'addresses' => 'required',
            'zip_codes' => 'required',
            'country' => 'required',
            'citys' => 'required',
            'states' => 'required',
            'payment_method' => 'required',
            'phone_no' => 'required',
            'start_from' => 'required'
        ]);

        $random = Str::random(8);
        $customerCode = "";
        $names = $request->name;
        $email = $request->email;
        $customer = User::whereEmail($email)->first();
        if($customer != null) {
            $customerCode = $customer->customer_code;
            
            $customer->update(['customer_code' => $customerCode, 'name' => $names, 'phone_no' => $request->phone_no, 'country' => $request->country, 'company' => $request->company, 'password' => bcrypt($random)]);
        }
        else {
            $customerCode = $this->getCustomerCode($names);

            $customer = new User;
            $customer->customer_code = $customerCode;
            $customer->name = $names;
            $customer->email = $email;
            $customer->phone_no = $request->phone_no;
            $customer->country = $request->country;
            $customer->company = $request->company;
            $customer->password = bcrypt($random);
            $customer->save();

            $sage = new SageEvolution();
            $customerExists = $sage->getTransaction('CustomerExists?Code='.$customerCode);
            if($customerExists == "true") {
                $customerFind = $sage->getTransaction('CustomerFind?Code='.$customerCode);
                $response = json_decode($customerFind, true);
                if($response["Description"] != $names) {
                    $customerCode = $this->getCustomerCode($names);
                
                    $customer->update(['customer_code' => $customerCode, 'name' => $names, 'phone_no' => $request->phone_no, 'country' => $request->country, 'company' => $request->company, 'password' => bcrypt($random)]);

                    $customerInsert = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => $names, "ChargeTax" => false, "Code" => $customerCode]]);
                }
            }
            else {
                $customerInsert = $sage->postTransaction('CustomerInsert', (object)["client" => ["Active" => true, "Description" => $names, "ChargeTax" => false, "Code" => $customerCode]]);
            }
            //NewCustomer Email
            Mail::to($email)->send(new NewCustomer($customer,$random));
        }
        Session::put('customer_id', $customer->id);

        $address = billing::updateOrCreate([
            'user_id' => $customer->id,
        ], [
            'addresses' => $request->addresses,
            'zip_codes' => $request->zip_codes,
            'apartments' => $request->apartments,
            'citys' => $request->citys,
            'states' => $request->states,
        ]);

        $plan_id = Session::get('plan_id');
        $plan_type = Session::get('plan_type');
        $referenceId = Carbon::now()->timestamp;
        Session::put('referenceId', $referenceId);
        $currency = SubscriptionPlan::findOrFail($plan_id)->currency();
        $quantity =  SubscriptionPlan::findOrFail($plan_id)->quantity;
        $amount = Amount::whereSubscriptionPlanId($plan_id)->value($plan_type);
        Session::put('currency', $currency);
        Session::put('amount', $amount);

        $order = Order::create([
            'user_id' => $customer->id, 'subscription_plan_id' => $plan_id, 'reference' => $referenceId, 'type' => $plan_type
        ]);

        $subscription = Subscription::create([
            'user_id' => $customer->id, 'subscription_plan_id' => $plan_id, 'reference' => $referenceId,
            'type' => $plan_type, 'quantity' => $quantity
        ]);

        $issues = [];
        $a = (int)$request->start_from;
        $issues = [$a, $a + 1, $a + 2, $a + 3];

        foreach ($issues as $issue) {
            SelectedIssue::create([
                'user_id' => $customer->id, 'subscription_id' => $subscription->id, 'issue_no' => $issue, 'order_id' => $order->id
            ]);
        }

        if ($request->payment_method == 'paypal') {
            return redirect('paypal/checkout');
        } elseif ($request->payment_method == 'mtn') {
            return redirect('mtn/checkout');
        } else {
            return redirect('ipay/checkout');
        }
    }

    private function getCustomerCode($names)
    {
        $name_array = explode(' ',trim($names));
        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array)-1];
        $initials = $firstWord[0]."".$lastWord[0];

        $digits = 3;
        $code = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
        return $initials."".$code;
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'addresses' => 'required',
            'zip_codes' => 'required',
            'country' => 'required',
            'citys' => 'required',
            'states' => 'required',
            'payment_method' => 'required',
            'phone_no' => 'required',
        ]);
        $random = Str::random(8);
        $customer = User::updateOrCreate([
            'email' => $request->email,
        ], [
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'country' => $request->country,
            'company' => $request->company,
            'password' => bcrypt($random),
        ]);
        Session::put('customer_id', $customer->id);

        $address = billing::updateOrCreate([
            'user_id' => $customer->id,
        ], [
            'addresses' => $request->addresses,
            'zip_codes' => $request->zip_codes,
            'apartments' => $request->apartments,
            'citys' => $request->citys,
            'states' => $request->states,
        ]);

        $referenceId = Carbon::now()->timestamp;
        $currency = "KSh";
        $amount = Cart::getTotal();
        Session::put('referenceId', $referenceId);
        Session::put('currency', $currency);
        Session::put('amount', $amount);

        $order = CartOrder::create([
            'user_id' => $customer->id, 'reference' => $referenceId
        ]);

        foreach (Cart::getContent() as $cart) {
            CartItem::create([
                'cart_order_id' => $order->id, 'quantity' => $cart->quantity, 'issue_no' => $cart->name
            ]);
        }

        Cart::clear();
        
        if ($request->payment_method == 'paypal') {
            return redirect('paypal/checkout');
        } elseif ($request->payment_method == 'mtn') {
            return redirect('mtn/checkout');
        } else {
            return redirect('ipay/checkout');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(billing $billing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\biliing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(billing $billing)
    {
        //
    }
}
