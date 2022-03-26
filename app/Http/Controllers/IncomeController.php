<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('category')->whereMonth('invoice_date', date('m'))->whereYear('invoice_date', date('Y'))->get();
        $categories = Category::where('status', 1)->get();

        return view('income.income', compact('incomes', 'categories'));
    }
    public function search(Request $request)
    {
        $request->validate([
            'date_start' => 'required',
            'date_finish' => 'required'
        ]);

        if ($request->date_start && $request->date_finish) {
            $incomes = Income::whereBetween('invoice_date', [$request->date_start, $request->date_finish])->get();
        }
        if ($incomes->all() == null) {
            Alert::error('No Matches Found', 'There are no invoice between these dates.');
        }
        $categories = Category::where('status', 1)->get();
        return view('income.income', compact('incomes', 'categories'));
    }
    public function incomeAddShow()
    {
        $categories = Category::where('status', 1)->get();

        if ($categories->all()) {
            return view('income.add', compact('categories'));
        } else {
            toast('You have to add some category first!', 'error');
            return redirect()->route('income.index');
        }
    }
    public function incomeAdd(Request $request)
    {
        $request->validate([
            'invoice' => 'file|mimes:jpeg,png,jpg,gif,pdf',
            'invoice_date' => 'required',
            'description' => 'required|max:255',
            'price' => 'required',
            'category_id' => 'required'

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
            'invoice_date' => $request->invoice_date

        ]);
        toast('New income has been submited!', 'success');
        return redirect()->route('income.index');
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
            'invoice' => 'file|mimes:jpeg,png,jpg,gif,pdf',
            'invoice_date' => 'required',
            'description' => 'required|max:255',
            'price' => 'required'

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
                'invoice_date' => $request->invoice_date

            ]);
        } else {
            Income::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => $invoice ? $path . $name : $request->old_invoice,
                'price' => $request->price,
                'invoice_date' => $request->invoice_date

            ]);
        }
        toast('Income has been changed!', 'success');
        return redirect()->route('income.index');
    }
}
