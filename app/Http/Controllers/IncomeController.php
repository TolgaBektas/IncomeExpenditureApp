<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::whereMonth('created_at', date('m'))->get();
        $categories = Category::where('status', 1)->get();
        return view('income.income', compact('incomes', 'categories'));
    }
    public function incomeAddShow()
    {
        $categories = Category::where('status', 1)->get();
        return view('income.add', compact('categories'));
    }
    public function incomeAdd(Request $request)
    {
        $request->validate([
            'invoice' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
        $invoice = $request->file('invoice');

        if ($invoice) {
            $name = $invoice->getClientOriginalName();
            $extension = $invoice->getClientOriginalExtension();
            $explode = explode('.', $name);
            $name = $explode[0] . '_' . date("Y-m-d_H-m_s") . uniqid() . '.' . $extension;
            $path = 'invoices/income/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        Income::create([
            'description' => $request->description,
            'category_id' => $request->category_id,
            'invoice' => $invoice ? $path . $name : '',
            'price' => $request->price,
            'status' => $request->status ? 1 : 0

        ]);
        toast('New income has been submited!', 'success');
        return redirect()->route('income.index');
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $income = Income::find($id);
        $status = $income->status;
        $income->status = $status ? 0 : 1;
        $income->save();
        return response()->json(['message' => 'success', 'status' =>  $income->status], 200);
    }
    public function delete(Request $request)
    {
        Income::destroy($request->id);
        return response()->json(['message' => 'success'], 200);
    }
    public function updateShow(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $income = Income::find($request->id);
        if ($income) {
            return view('income.update', compact('income', 'categories'));
        } else {
            return redirect()->route('income.index');
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            'invoice' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2097152',
        ]);
        $invoice = $request->file('invoice');
        if ($invoice) {
            Storage::disk('public')->delete($request->old_invoice);
            $name = $invoice->getClientOriginalName();
            $extension = $invoice->getClientOriginalExtension();
            $explode = explode('.', $name);
            $name = $explode[0] . '_' . date("Y-m-d_H-m_s") . uniqid() . '.' . $extension;
            $path = 'invoice/income/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        if ($request->delete_invoice) {
            Income::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => '',
                'price' => $request->price,
                'status' => $request->status ? 1 : 0

            ]);
        } else {
            Income::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => $invoice ? $path . $name : $request->old_invoice,
                'price' => $request->price,
                'status' => $request->status ? 1 : 0

            ]);
        }
        toast('Income has been changed!', 'success');
        return redirect()->route('income.index');
    }
}
