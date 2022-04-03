<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ExpenditureController extends Controller
{
    public function index()
    {
        $expenditures = Expenditure::with('category')->whereMonth('invoice_date', date('m'))->whereYear('invoice_date', date('Y'))->get();
        return view('expenditure.expenditure', compact('expenditures'));
    }
    public function search(Request $request)
    {
        $request->validate([
            'date_start' => 'required',
            'date_finish' => 'required'
        ]);

        if ($request->date_start && $request->date_finish) {
            $expenditures = Expenditure::with('category')->whereBetween('invoice_date', [$request->date_start, $request->date_finish])->get();
        }
        if ($expenditures->all() == null) {
            Alert::error('No Matches Found', 'There are no invoice between these dates.');
        }
        return view('expenditure.expenditure', compact('expenditures'));
    }
    public function expenditureAddShow()
    {
        $categories = Category::where('status', 1)->get();

        if ($categories->all()) {
            return view('expenditure.add', compact('categories'));
        } else {
            toast('You have to add some category first!', 'error');
            return redirect()->route('expenditure.index');
        }
    }
    public function expenditureAdd(Request $request)
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
            $path = 'invoices/expenditure/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        Expenditure::create([
            'description' => $request->description,
            'category_id' => $request->category_id,
            'invoice' => $invoice ? $path . $name : '',
            'price' => $request->price,
            'invoice_date' => $request->invoice_date

        ]);
        toast('New expenditure has been submited!', 'success');
        return redirect()->route('expenditure.index');
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
            $path = 'invoice/expenditure/';
            Storage::putFileAs('public/' . $path, $invoice, $name);
        }
        if ($request->delete_invoice) {
            Expenditure::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => '',
                'price' => $request->price,
                'invoice_date' => $request->invoice_date
            ]);
        } else {
            Expenditure::where('id', $request->id)->update([
                'description' => $request->description,
                'category_id' => $request->category_id,
                'invoice' => $invoice ? $path . $name : $request->old_invoice,
                'price' => $request->price,
                'invoice_date' => $request->invoice_date

            ]);
        }
        toast('Expenditure has been changed!', 'success');
        return redirect()->route('expenditure.index');
    }
}
