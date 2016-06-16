<?php

namespace App\Http\Controllers;

use App\DailyStat;
use App\Http\Requests;
use App\Http\Requests\GetDataRequest;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $error = ['views'=>'N/A','subscribers'=>'N/A','videos'=>'N/A','earnings'=>'N/A'];
        $errorMsg = NULL;
        try
        {
            $data = auth()->user()->totalStats()->first();
        }
        catch(\QueryException $qe)
        {
            $data = $error;
            $errorMsg = "Could not retrieve overall statistics";
        }
        catch(\PDOException $qe)
        {
            $data = $error;
            $errorMsg = "Could not retrieve overall statistics";
        }
        catch(\ErrorException $ee)
        {
            $data = $error;
            $errorMsg = "Could not retrieve overall statistics";
        }

        return view('dashboard', $data )->withErrors($errorMsg);
    }

    public function getData() {

        $data = auth()->user()
            ->dailyStats()
            ->select(['date',
                'views',
                'subscribers',
                'videos',
                'earnings',
                'total_views',
                'total_subscribers',
                'total_videos',
                'total_earnings'
            ])
            ->get();

        return response()->json([
            'data' => $data,
        ]);

        // ajax request
        /*if($request->ajax()) {

            $data = auth()
                ->user()
                ->dailyStats()
                ->select(['date',$request->get('chartselector')])
                ->start($request->get('start'))
                ->end($request->get('end'))
                ->get();

            return response()->json([
                'data' => $data,
                'chart' => $request->get('chartselector'),
            ]);
        }*/
    }
}