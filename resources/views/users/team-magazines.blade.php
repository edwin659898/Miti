@extends('layouts.app')

@section('content')
<!-- BEGIN: Content-->
<div class="content-body">

    <!-- Filled Pills Start -->
    <section id="filled-pills">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-green-600">My Team Magazines</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane  active" id="home-fill" aria-labelledby="home-tab-fill" aria-expanded="true">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-deck-wrapper">
                                                <div class="card-deck">

                                                    @forelse($invites as $invite)
                                                    @foreach($invite->subscriptionSize->SubIssues as $issue)
                                                    @if($issuefound = App\Models\Magazine::where([['issue_no',$issue->issue_no],['created_at','!=','']])->first())
                                                    <div class="col-xl-3 col-md-6 col-sm-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="card-body">
                                                                    <img class="card-img-top img-fluid" src="{{asset('files/magazines/cover/'.$issuefound->image)}}" alt="Card image cap">
                                                                    <h5 class="my-1 font-bold text-blue-600">Issue {{$issue->issue_no}}</h5>
                                                                    <div class="card-btns d-flex justify-content-between">
                                                                        <a href="{{ url('user/read/'.$issuefound->slug) }}" class="btn btn-primary btn-sm float-right">Read/Download</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                    @empty
                                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                                        <div class="card border-info text-center bg-transparent">
                                                            <div class="card-content">
                                                                <img src="{{asset('storage/read.jpg')}}" alt="element 04" width="200" class="mt-3 pl-2">
                                                                <div class="card-body">
                                                                    <h4 class="card-title mt-3">You have not been invited to any subscription</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Filled Pills End -->

</div>
<!-- END: Content-->
@endsection