<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Expenditure::whereMonth('created_at', date('m'))->get();
        $categories = Category::where('status', 1)->get();
        return view('expenditure.expenditure', compact('expenditures', 'categories'));
    }
    public function expenditureAddShow()
    {
        $categories = Category::where('status', 1)->get();
        return view('expenditure.add', compact('categories'));
    }
    public function expenditureAdd(Request $request)
    {
        $request->validate([
            'invoice' => 'file|mimes:jpeg,png,jpg,gif,pdf',
        ]);
        $invoice = $request->file('invoice');

        if ($invoice) {
            $name = $invoice->getClientOriginalName();
            $extension = $invoice->getClientOriginalExtension();
            $explode = explode('.', $name);
            $name = $explode[0] . '_' . date("Y-m-d_H-m_s") . uniqid() . '.' . $extension;
            $path = 'invoices/expenditure/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        Expenditure::create([
            'description' => $request->description,
            'category_id' => $request->category_id,
            'invoice' => $invoice ? $path . $name : '',
            'price' => $request->price,
            'status' => $request->status ? 1 : 0

        ]);
        toast('New expenditure has been submited!', 'success');
        return redirect()->route('expenditure.index');
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $expenditure = Expenditure::find($id);
        $status = $expenditure->status;
        $expenditure->status = $status ? 0 : 1;
        $expenditure->save();
        return response()->json(['message' => 'success', 'status' =>  $expenditure->status], 200);
    }
    public function delete(Request $request)
    {
        Expenditure::destroy($request->id);
        return response()->json(['message' => 'success'], 200);
    }
    public function updateShow(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $expenditure = Expenditure::find($request->id);
        if ($expenditure) {
            return view('expenditure.update', compact('expenditure', 'categories'));
        } else {
            return redirect()->route('expenditure.index');
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'invoice' => 'file|mimes:jpeg,png,jpg,gif,pdf',
        ]);
        $invoice = $request->file('invoice');
        if ($invoice) {
            Storage::disk('public')->delete($request->old_invoice);
            $name = $invoice->getClientOriginalName();
            $extension = $invoice->getClientOriginalExtension();
            $explode = explode('.', $name);
            $name = $explode[0] . '_' . date("Y-m-d_H-m_s") . uniqid() . '.' . $extension;
            $path = 'invoice/expenditure/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        if ($request->delete_invoice) {
            Expenditure::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => '',
                'price' => $request->price,
                'status' => $request->status ? 1 : 0

            ]);
        } else {
            Expenditure::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => $invoice ? $path . $name : $request->old_invoice,
                'price' => $request->price,
                'status' => $request->status ? 1 : 0

            ]);
        }
        toast('Expenditure has been changed!', 'success');
        return redirect()->route('expenditure.index');
    }
}
