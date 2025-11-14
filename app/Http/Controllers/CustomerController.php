<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // TODO: implement customer listing (untuk kontraktor)
        abort(501, 'Customer module belum diimplementasikan.');
    }

    public function store(Request $request)
    {
        abort(501, 'Customer module belum diimplementasikan.');
    }

    public function update(Request $request)
    {
        abort(501, 'Customer module belum diimplementasikan.');
    }

    public function destroy()
    {
        abort(501, 'Customer module belum diimplementasikan.');
    }
}
