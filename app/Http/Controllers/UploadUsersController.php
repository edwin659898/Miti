<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadUsersController extends Controller
{
    //
    public function create()
    {
        return view('admin.upload-users');
    }

    public function storeUsers(Request $request)
    {
        Excel::import(new UsersImport, $request->file);

        return redirect()->route('customers.view')->with('success', 'User Imported Successfully');
    }
}
