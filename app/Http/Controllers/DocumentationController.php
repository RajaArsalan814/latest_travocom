<?php

namespace App\Http\Controllers;

use App\document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function add_documentation(Request $request)
    {

        $request->validate([
            "given_name" => "required",
            "sur_name" => "required",
            "passport_no" => "required",
            "is_head" => "required",
            "validity" => "required",
            "expiry" => "required",
            "gender" => "required",
        ]);
        // dd($request);
        foreach ($request->person as $key => $value) {
            $all_entries[] = [
                'person' => $value,
                'given_name' => $request->given_name[$key],
                'sur_name' => $request->sur_name[$key],
                'passport_no' => $request->passport_no[$key],
                'validity' => $request->validity[$key],
                'expiry' => $request->expiry[$key],
                'gender' => $request->gender[$key],
                'cnic' => $request->cnic[$key],
                'is_head' => isset($request->is_head[$key]) ? 1 : null,
            ];
        }
        $update = document::where('inquiry_id', $request->inq_id)->where('customer_id', $request->customer_id)->first();
        // dd($update);
        if ($update) {
            $update->inquiry_id = $request->inq_id;
            $update->customer_id = $request->customer_id;
            $update->type = "passport";
            $update->entries = json_encode($all_entries);
            $update->save();

            session()->flash('success', "Documents Updated Successfully");
            return redirect()->back();
        } else {
            $store = new document();
            $store->inquiry_id = $request->inq_id;
            $store->customer_id = $request->customer_id;
            $store->type = "passport";
            $store->entries = json_encode($all_entries);
            $store->save();
            session()->flash('success', "Documents Saved Successfully");
            return redirect()->back();
        }

        // $store->given_name = $request->;
    }
}
