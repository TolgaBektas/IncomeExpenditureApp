<?php

namespace App\Http\Controllers;

use App\Models\Expenditure;
use App\Models\Income;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /* dd(date('m')); */
        $total_month_income = 0;
        $total_month_expenditure = 0;
        $year_incomes = [];
        $year_expenditures = [];
        $incomes = Income::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', 1)->get('price');
        foreach ($incomes as $income) {
            $total_month_income += $income->price;
        }
        $expenditures = Expenditure::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status', 1)->get('price');
        foreach ($expenditures as $expenditure) {
            $total_month_expenditure += $expenditure->price;
        }

        $total_year_income = 0;
        $total_year_expenditure = 0;

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
        $incomes = Income::whereYear('created_at', date('Y'))->where('status', 1)->orderBy('created_at')->get();
        foreach ($incomes as $income) {
            $total_year_income += $income->price;
            switch (\Carbon\Carbon::parse($income->created_at)->format('F')) {
                case 'January':
                    $january += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $january;
                    break;
                case 'February':
                    $february += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $february;
                    break;
                case 'March':
                    $march += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $march;
                    break;
                case 'April':
                    $april += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $april;
                    break;
                case 'May':
                    $may += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $may;
                    break;
                case 'June':
                    $june += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $june;
                    break;
                case 'July':
                    $july += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $july;
                    break;
                case 'August':
                    $august += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $august;
                    break;
                case 'September':
                    $september += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $september;
                    break;
                case 'October':
                    $october += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $october;
                    break;
                case 'November':
                    $november += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $november;
                    break;
                case 'December':
                    $december += $income->price;
                    $year_incomes[\Carbon\Carbon::parse($income->created_at)->format('F')] = $december;
                    break;
            }
        }


        $expenditures = Expenditure::whereYear('created_at', date('Y'))->where('status', 1)->orderBy('created_at')->get();
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
        foreach ($expenditures as $expenditure) {
            $total_year_expenditure += $expenditure->price;
            switch (\Carbon\Carbon::parse($expenditure->created_at)->format('F')) {
                case 'January':
                    $january += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $january;
                    break;
                case 'February':
                    $february += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $february;
                    break;
                case 'March':
                    $march += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $march;
                    break;
                case 'April':
                    $april += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $april;
                    break;
                case 'May':
                    $may += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $may;
                    break;
                case 'June':
                    $june += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $june;
                    break;
                case 'July':
                    $july += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $july;
                    break;
                case 'August':
                    $august += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $august;
                    break;
                case 'September':
                    $september += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $september;
                    break;
                case 'October':
                    $october += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $october;
                    break;
                case 'November':
                    $november += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $november;
                    break;
                case 'December':
                    $december += $expenditure->price;
                    $year_expenditures[\Carbon\Carbon::parse($expenditure->created_at)->format('F')] = $december;
                    break;
            }
        }

        return view('index', compact('total_month_income', 'total_month_expenditure', 'total_year_income', 'total_year_expenditure', 'year_incomes', 'year_expenditures'));
    }
}
