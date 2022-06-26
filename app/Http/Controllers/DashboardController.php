<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $processed = [];
        $permissions = Permission::get();
        $data = $permissions->groupBy('group_name')->all();
        foreach ($data as $firstKey => $firstItems) {
            $rows = $firstItems->map(function ($item) {
                $name = explode('.', $item->name);
                $item->child_one = $name[0] ?? null;
                return $item;
            })->groupBy('child_one')->all();

            foreach ($rows as $secondKey => $secondItems) {
                $rows = $secondItems->map(function ($item) {
                    $name = explode('.', $item->name);
                    $item->child_two = $name[1] ?? null;
                    $item->name = ucfirst($name[2] ?? null);
                    return $item;
                })->groupBy('child_two')->all();


                $processed[$firstKey][$secondKey] = $rows;
                foreach ($rows as $k => $i) {
                    $processed[$firstKey][$secondKey][$k] = $i->pluck('name', 'id');
                }


            }
        }

        // return view('dashboard.max_dashboard');
        // return view('dashboard.area-office-dashboard');
        // return view('dashboard.project-dashboard');

        if (session('s_j_project_id')) {
            return view('dashboard.project-dashboard');
        }

        return view('dashboard.dashboard');
    }

}
