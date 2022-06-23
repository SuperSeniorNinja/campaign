<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*$tutorials = \App\Tutorial::where('flag', 1)
                        ->orderBy('id')                        
                        ->paginate(20);

        $scripts = Auth::user()->scripts();

        if ($request->has('searchFor')) {
            $scripts = $scripts->search($request->input('searchFor'));
        }

        if ($request->has('orderBy')) {
            if ($request->input('orderBy') == 'category') {
                $scripts = $scripts
                    ->join('templates', 'templates.id', '=', 'scripts.template_id')
                    ->join('categories', 'categories.id', '=', 'templates.categ_id')
                    ->orderBy('categories.name')
                    ->select('scripts.*');
            } else
            if ($request->input('orderBy') == 'alphabetically') {
                $scripts = $scripts->orderBy('name');
            }
        }*/
        if(Auth::check())
        {
            Session::put('active_menu', "formpage");
            return view('formpage');
        }
        else
            return redirect()->route('home');
    }
}
