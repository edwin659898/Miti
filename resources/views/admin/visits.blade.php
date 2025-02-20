@extends('layouts.app')

@section('content')

<div class="content-body">
    <!-- account setting page start -->
    <section id="page-account-settings">
        <div class="row">
            <!-- right content section -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="members-gifted-pill" aria-expanded="true">
                                    <div class="media">
                                        <h4 class="card-title text-green-600">Visitors and Access to Miti 50</h4>
                                    </div>
                                    <hr>
                                    <form novalidate>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr class="text-blue-600">
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Device Used</th>
                                                                <th>Platform</th>
                                                                <th>Browser</th>
                                                                <th>Ip</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($visits as $index => $visit)
                                                            @php
                                                                $visitor_info = App\Models\User::findOrFail($visit->visitor_id);
                                                            @endphp
                                                            <tr>
                                                                <td> {{$loop->iteration}}</td>
                                                                <td> {{$visitor_info->name}}</td>
                                                                <td> {{$visitor_info->email}}</td>
                                                                <td>{{$visit->device}}</td>
                                                                <td>{{$visit->platform}}</td>
                                                                <td>{{$visit->browser}}</td>
                                                                <td>{{$visit->ip}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="flex justify-end">
                                                    {{ $visits->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- account setting page end -->
    @endsection