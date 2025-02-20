@extends('layouts.app')

@section('content')
<div class="content-body">
    <!-- Extract to Slot -->
    <section id="description" class="card">
        <div class="card-header">
            <h4 class="card-title text-green-600">Upload Article</h4>
        </div>
        <div class="card-content">
            <div class="card-body">
                <div class="card-text">

                    <div class="tab-content">
                        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-2" :errors="$errors" />

                            <div class="row">
                                <div class="max-w-6xl mx-auto">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form class="form form-vertical" action="{{route('article.upload')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-body">
                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="font-bold text-green-600">Issue Number</label>
                                                                    <div>
                                                                        <select name="issue_no" id="issue_no" required class="rounded-md border-gray-400 form-control">
                                                                            <option value="">-- Select Issue No --</option>
                                                                            @foreach ($magazines as $magazine)
                                                                            <option value="{{$magazine->id}}">{{$magazine->issue_no}}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="media-body mt-75">
                                                                <div class="flex justify-center col-12">
                                                                    <label class="font-bold text-green-600 mt-1">Article</label>
                                                                    <input type="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="btn btn-sm btn-primary ml-50 mb-50 mb-sm-0 cursor-pointer">
                                                                    <p class="text-muted ml-5 mt-50"><small>Allowed Excel.</small></p>
                                                                </div>
                                                            </div>

                                                            <div class="flex justify-end col-12 mt-2">
                                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                                <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- users edit account form ends -->
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </section>
</div>

@endsection