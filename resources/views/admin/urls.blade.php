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
                                        <h4 class="card-title text-green-600">Articles Urls</h4>
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
                                                                <th>Main Route</th>
                                                                <th>Generated Secure URL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($urls as $url)
                                                            <tr>
                                                                <td> {{$loop->iteration}}</td>
                                                                <td> {{$url->destination_url}}</td>
                                                                <td> {{$url->default_short_url}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="flex justify-end">
                                                    
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