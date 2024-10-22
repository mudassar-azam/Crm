<?php

namespace App\Http\Controllers;

use App\Models\AccountPaymentDetail;
use Illuminate\Http\Request;

class AccountPaymentDetailController extends Controller
{
    public function index()
    {
        $paymentDetails = AccountPaymentDetail::all();

        return response()->json($paymentDetails);
    }
    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'bank_branch_name' => 'required|string',
            'bank_city_name' => 'required|string',
            'country' => 'required|string',
            'account_holder_name' => 'required|string',
        ]);

        $paymentDetail = AccountPaymentDetail::create($request->all());

        return response()->json($paymentDetail, 201);
    }
    public function show($id)
    {
        $paymentDetail = AccountPaymentDetail::find($id);

        if (!$paymentDetail) {
            return response()->json(['message' => 'Payment detail not found'], 404);
        }

        return response()->json($paymentDetail);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'bank_branch_name' => 'required|string',
            'bank_city_name' => 'required|string',
            'country' => 'required|string',
            'account_holder_name' => 'required|string',
        ]);

        $paymentDetail = AccountPaymentDetail::find($id);

        if (!$paymentDetail) {
            return response()->json(['message' => 'Payment detail not found'], 404);
        }

        $paymentDetail->update($request->all());

        return response()->json($paymentDetail);
    }
    public function destroy($id)
    {
        $paymentDetail = AccountPaymentDetail::find($id);

        if (!$paymentDetail) {
            return response()->json(['message' => 'Payment detail not found'], 404);
        }

        $paymentDetail->delete();

        return response()->json(null, 204);
    }
}
