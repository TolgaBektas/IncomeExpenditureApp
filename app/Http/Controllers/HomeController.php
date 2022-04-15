<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $years = [];
        $income_years = Income::get('invoice_date');
        foreach ($income_years as $year) {
            array_push($years, Carbon::createFromFormat('Y-m-d', $year->invoice_date)->format('Y'));
        }
        $expenditure_years = Expenditure::get('invoice_date');
        foreach ($expenditure_years as $year) {
            array_push($years, Carbon::createFromFormat('Y-m-d', $year->invoice_date)->format('Y'));
        }
        asort($years);
        $years = array_unique($years);
        $incomes_month = Income::whereMonth('invoice_date', date('m'))->whereYear('invoice_date', date('Y'))->get();
        $expenditures_month = Expenditure::whereMonth('invoice_date', date('m'))->whereYear('invoice_date', date('Y'))->get();

        if ($request->all()) {
            $incomes_years = Income::whereYear('invoice_date', $request->all()['q'])->orderBy('invoice_date')->get();
            $expenditures_years = Expenditure::whereYear('invoice_date', $request->all()['q'])->orderBy('invoice_date')->get();
        } else {
            $incomes_years = Income::whereYear('invoice_date', date('Y'))->orderBy('invoice_date')->get();
            $expenditures_years = Expenditure::whereYear('invoice_date', date('Y'))->orderBy('invoice_date')->get();
        }
        $total_month_income = 0;
        $total_month_expenditure = 0;
        $year_incomes = [];
        $year_expenditures = [];
        $total_year_income = 0;
        $total_year_expenditure = 0;
        foreach ($incomes_month as $income) {
            $total_month_income += $income->price;
        }
        foreach ($expenditures_month as $expenditure) {
            $total_month_expenditure += $expenditure->price;
        }
        $january = 0;
        $february = 0;
        $march = 0;
        $april = 0;
        $may = 0;
        $june = 0;
        $july = 0;
        $august = 0;
        $september = 0;
        $october = 0;
        $november = 0;
        $december = 0;
        $year_incomes['January'] = $january;
        $year_incomes['February'] = $february;
        $year_incomes['March'] = $march;
        $year_incomes['April'] = $april;
        $year_incomes['May'] = $may;
        $year_incomes['June'] = $june;
        $year_incomes['July'] = $july;
        $year_incomes['August'] = $august;
        $year_incomes['September'] = $september;
        $year_incomes['October'] = $october;
        $year_incomes['November'] = $november;
        $year_incomes['December'] = $december;
        foreach ($incomes_years as $income) {
            $total_year_income += $income->price;
            switch (\Carbon\Carbon::parse($income->invoice_date)->format('F')) {
                case 'January':
                    $january += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $january;
                    break;
                case 'February':
                    $february += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $february;
                    break;
                case 'March':
                    $march += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $march;
                    break;
                case 'April':
                    $april += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $april;
                    break;
                case 'May':
                    $may += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $may;
                    break;
                case 'June':
                    $june += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $june;
                    break;
                case 'July':
                    $july += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $july;
                    break;
                case 'August':
                    $august += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $august;
                    break;
                case 'September':
                    $september += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $september;
                    break;
                case 'October':
                    $october += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $october;
                    break;
                case 'November':
                    $november += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $november;
                    break;
                case 'December':
                    $december += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->invoice_date)->format('F')] = $december;
                    break;
            }
        }


        $january = 0;
        $february = 0;
        $march = 0;
        $april = 0;
        $may = 0;
        $june = 0;
        $july = 0;
        $august = 0;
        $september = 0;
        $october = 0;
        $november = 0;
        $december = 0;
        $year_expenditures['January'] = $january;
        $year_expenditures['February'] = $february;
        $year_expenditures['March'] = $march;
        $year_expenditures['April'] = $april;
        $year_expenditures['May'] = $may;
        $year_expenditures['June'] = $june;
        $year_expenditures['July'] = $july;
        $year_expenditures['August'] = $august;
        $year_expenditures['September'] = $september;
        $year_expenditures['October'] = $october;
        $year_expenditures['November'] = $november;
        $year_expenditures['December'] = $december;
        foreach ($expenditures_years as $expenditure) {
            $total_year_expenditure += $expenditure->price;
            switch (\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')) {
                case 'January':
                    $january += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $january;
                    break;
                case 'February':
                    $february += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $february;
                    break;
                case 'March':
                    $march += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $march;
                    break;
                case 'April':
                    $april += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $april;
                    break;
                case 'May':
                    $may += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $may;
                    break;
                case 'June':
                    $june += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $june;
                    break;
                case 'July':
                    $july += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $july;
                    break;
                case 'August':
                    $august += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $august;
                    break;
                case 'September':
                    $september += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $september;
                    break;
                case 'October':
                    $october += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $october;
                    break;
                case 'November':
                    $november += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $november;
                    break;
                case 'December':
                    $december += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->invoice_date)->format('F')] = $december;
                    break;
            }
        }
        return view('index', compact('total_month_income', 'total_month_expenditure', 'total_year_income', 'total_year_expenditure', 'year_incomes', 'year_expenditures', 'years'));
    }
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }
}
