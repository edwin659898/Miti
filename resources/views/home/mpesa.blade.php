<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipa na M-Pesa / AIRTEL Money</title>
    <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="" rel="stylesheet" />
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" ">
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"
    ></script>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap");

      body {
        background-color: #2b3346;
        font-family: "Rubik", sans-serif;
      }

      .card {
        width: 400px;
        border: none;
        border-radius: 15px;
      }
      a {
        /* width: 330px;
        border: none;  */
        background: #f3f4f6;
        /* border-radius: 15px; */
      }
     

      .justify-content-around div {
        border: none;
        border-radius: 30px;
        background: #f3f4f6;
        padding: 5px 20px 5px;
        color: #8d9297;
      }

      .justify-content-around span {
        font-size: 12px;
      }

      .justify-content-around div:hover {
        background: #545ebd;
        color: #fff;
        cursor: pointer;
      }

      .justify-content-around div:nth-child(1) {
        background: #545ebd;
        color: #fff;
      }

      span.mt-0 {
        color: #8d9297;
        font-size: 12px;
      }

      h6 {
        font-size: 15px;
      }
      .mpesa {
        background-color: green !important;
      }
      .strip {
        background-color: rgb(11, 124, 230) !important;
      }
      .cards {
        background-color: rgb(208, 230, 11) !important;
      }.card {
        background-color: rgba(0, 128, 0, 0.185) !important;
      }

      img {
        border-radius: 15px;
      }
    </style>
  </head>
  <body oncontextmenu="return false" class="snippet-body">
    <div class="container d-flex justify-content-center">
      <div class="card mt-5 px-3 py-4">
        <div class="d-flex flex-row justify-content-around">
          <span>
            {{-- Mpesa  --}}
            {{-- <a href="{{ url('mpesa',$total_amount)}}" class="btn btn-danger">MPesa</a>
        </span>
          
            <span>
            <a href="{{ url('paypal',$total_amount)}}" class="btn btn-danger">Pay Pal</a>
            </span> 
       
         <span>
            <a href="{{ url('stripe',$total_amount)}}" class="btn btn-danger">Credit Card </a>
         </span> 
         <span>
          <a href="{{ url('cash_oder',$total_amount) }}" class="btn btn-danger">Cash  </a>
       </span>  --}}

        </div>
        <div class="media mt-4 pl-2">
            <img src="{{ asset('/storage/mpesa.png') }}" alt="
            " class="mr-3" height="75" />
          <div class="media-body">
            <h6 class="mt-1">PAY USING MPESA <br>   AIRTEL Money</h6>

          </div>
        </div>
        <div class="media mt-3 pl-2">
                          <!--bs5 input-->
                          @php
                          dd('This is the correct file');
                      @endphp
                      
                          {{-- <pre>
                            Amount: {{ isset($amount) ? $amount : 'Not Set' }}
                            Currency: {{ isset($currency) ? json_encode($currency) : 'Not Set' }}
                            Countries: {{ isset($countries) ? json_encode($countries) : 'Not Set' }}
                            Plan Type: {{ isset($plan_type) ? $plan_type : 'Not Set' }}
                            Recent Magazines: {{ isset($recentmagazines) ? json_encode($recentmagazines) : 'Not Set' }}
                        </pre> --}}

            <form class="row g-3"  method="POST" action="{{route('post.ipay')}}">
       {{-- <form class="row g-3" method="POST" action="{{route('post.ipay')}}"> --}}

            @csrf

                <div class="col-12">
                  {{-- <label for="inputAddress"  class="btn btn-success">Pay Now ${{ $total_amount }}</label> --}}
            {{-- <p class="btn btn-primary btn-lg btn-block" type="submit">Pay Now {{ $total_amount }}</p> --}}
                  <input type="text" style="display:none;" class="form-control" name="amount" placeholder="Enter Amount" value="">
                  {{-- <input type="hidden" name="oid" value="{{ $order->id }}"> --}}
 
                  {{-- {{ $amount }} --}}

                  <p style="color: #fff">Enter your M-Pesa / AIRTEL Money <span style="color: #d81a1a">PHONE NUMBER</span> below then click Pay.<br> It will propt you to Enter your <span style="color: #d81a1a">PIN</span>.<br> Please confirm the amount before Sending </p>
                </div>

                <div class="col-12">
                  <label for="tel" class="form-label" >Enter Phone Number</label>
                  <input type="text" class="form-control" name="phone"  placeholder="Enter Phone Number">
                </div>
             
                <div class="col-12">
                  <button type="submit" class="btn btn-success" name="submit" value="submit">
                    Pay {{ isset($currency->currency) ? $currency->currency : 'KES' }} {{ isset($amount) ? $amount : 0 }}
                </button>
                
                  {{--  {{$currency ?? 'KES'}} {{ $amount }}  --}}
                  {{-- {{$currency->currency()}}{{$amount}} --}}
                </div>
              </form>
              <!--bs5 input-->
          </div>
        </div>
      </div>
    </div>
    <script
      type="text/javascript"
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
    ></script>
    <script type="text/javascript" src=""></script>
    <script type="text/javascript" src=""></script>
    <script type="text/Javascript"></script>
  </body>
</html>