@extends('layouts.main')
@section('content')
<section id="shop-checkout" class="mx-auto mt-12 mb-16 flex sm:max-w-6xl p-4 w-full border-2 rounded-lg shadow-lg">
    <div class="container">
        <div class="shop-cart">
            <form action="{{route('make.payment')}}" class="sep-top-md" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 no-padding">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="upper text-green-500 font-bold">Shipping Address</h4>
                            </div>
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2 px-4" :errors="$errors" />
                            <div class="col-lg-12 form-group">
                                <label class="sr-only">Country</label>
                                <select name="country" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm">
                                    <option value="">-- Select your country --</option>
                                    @foreach($countries as $country)
                                    @if (old('country') == $country->id)
                                    <option value="{{$country->id}}" selected>{{$country->country}}</option>
                                    @else
                                    <option value="{{$country->id}}">{{$country->country}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="sr-only">First Name</label>
                                <input type="text" name="name" value="{{ old('name') ?? auth()->user()->name ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="Name*">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="sr-only">Company Name</label>
                                <input type="text" name="company" value="{{ old('company') ?? auth()->user()->company ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="Company (optional)">
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="sr-only">Address</label>
                                <input type="text" name="address" value="{{ old('address') ?? auth()->user()->shippingInfo->address ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="Address*">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">Apartment, suite, unit etc.</label>
                                <input type="text" name="apartment" value="{{ old('apartment') ?? auth()->user()->shippingInfo->apartment ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="Apartment, suite, etc. (optional)">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">Town / City</label>
                                <input type="text" name="city" value="{{ old('city') ?? auth()->user()->shippingInfo->city ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="City*">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">State / County</label>
                                <input type="text" name="state" value="{{ old('state') ?? auth()->user()->shippingInfo->state ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="State*">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">Postcode / Zip</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') ?? auth()->user()->shippingInfo->zip_code ?? '' }}" class="form-control rounded-md border-gray-300" placeholder="Zipcode*">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">Email</label>
                                <input type="text" name="email" value="{{ old('email') ?? auth()->user()->email ?? ''}}" class="form-control rounded-md border-gray-300" placeholder="E-mail">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="sr-only">Phone</label>
                                <input type="tel" name="phone_no" value="{{ old('phone_no') ?? auth()->user()->phone_no ?? '' }}" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="Phone Number (No code)" class="form-control rounded-md border-gray-300">
                            </div>
                        </div>
                      
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <h4 class="text-green-500 font-bold">Details of Selected Plan</h4>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="cart-product-name">
                                                    <strong>Country</strong>
                                                </td>
                                                <td class="cart-product-name text-right">
                                                    <span class="amount">{{$currency->location}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cart-product-name">
                                                    <strong>Type</strong>
                                                </td>
                                                <td class="cart-product-name text-right">
                                                    <span class="amount">
                                                        @if($plan_type == 'combined')
                                                        Printed and Digital
                                                        @else
                                                        Digital only
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cart-product-name">
                                                    <strong>Quantity you will receive per Issue</strong>
                                                </td>
                                                <td class="cart-product-name  text-right">
                                                    <span class="amount">{{$currency->quantity}}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cart-product-name">
                                                    <strong>Amount to be Charged</strong>
                                                </td>
                                                <td class="cart-product-name text-right">
                                                    <span class="amount color lead"><strong>{{$currency->currency()}}{{$amount}}</strong></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4 class="text-green-500 font-bold">Select Issue you wish to Start your Subscription</h4>
                                @foreach($recentmagazines as $recent)
                                <div class="list-group">
                                    <input type="radio" name="start_from" value="{{$recent->issue_no}}" id="{{$recent->id}}" onchange="setSelectedIssue('{{$recent->issue_no}}')"/>
                                    <label class="list-group-item bg-blue-400 rounded-md py-1 text-black" for="{{$recent->id}}">Issue {{$recent->issue_no}}</label>
                                </div>
                                @endforeach
                            </div>
                            <div class="col-lg-12 mt-2">
                                <h4 class="text-green-500 font-bold">Choose Payment Methodes</h4>
                                <div class="list-group">
                                   <!-- Mpesa, Airtel Money -->
                                    <input type="radio" name="payment_method" value="ipay" id="Radio1" onchange="setPaymentMethod('ipay')" />
                                    <label class="list-group-item text-yellow-700 bg-gray-100 hover:bg-yellow-200 p-2 rounded" for="Radio1">
                                        <img width="90" alt="card" src="/storage/mpesa.png">
                                        Mpesa, Airtel Money
                                    </label> 
                                    {{-- <button type="submit" class="btn"><a href="{{$currency->currency()}}{{$amount}}" class="btn btn-danger">M-Pesa/MTN</a></button> --}}
                                    <input type="radio" name="payment_method" value="card" id="Radio4"  onchange="setPaymentMethod('visa')"/>
                                    <label class="list-group-item text-yellow-700" for="Radio4"><img width="90" alt="visa" src="/storage/mtn.jpg">VISA</label>
                                    {{-- <input type="radio" name="payment_method" value="mtn" id="Radio2" /> --}}
                                    {{-- <label class="list-group-item" for="Radio2"><img width="90" alt="mtn" src="/storage/mtn.jpg"> MTN</label> --}}
                                    <input type="radio" name="payment_method" value="paypal" id="Radio3"  onchange="setPaymentMethod('paypal')"/>
                                    <label class="list-group-item" for="Radio3"><img width="90" alt="paypal" src="/storage/paypal.png"></label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="flex justify-between items-center pt-4">
                                    <a href="{{route('choose.plan')}}" class="h-12 w-24 text-blue-500 text-sm font-medium">Change Plan</a>
                                    <x-button type="submit" class="bg-green-800 hover:bg-blue-700 text-white">Subscribe</x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <input type="hidden" name="selected_payment_method" id="selected_payment_method" />
                <input type="hidden" name="selected_start_from" id="selected_start_from" /> -->

            </form>
            <div class="seperator"><i class="fa fa-credit-card"></i>
            </div>
        </div>
    </div>
</section>
<!-- <script>
    // This function sets the selected payment method before submitting the form
    function setPaymentMethod(method) {
        document.getElementById('selected_payment_method').value = method;
    }

    function setSelectedIssue(issue){
        document.getElementById('selected_start_from').value = issue;

    }


</script> -->
@endsection

