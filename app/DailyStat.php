<?php

namespace App;

use App\Http\Requests\GetDataRequest;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;

class DailyStat extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    /*public function scopePlotData($query, $start, $end, $column) {
        return $query
            ->select('date', $column)
            ->where('date', '>=', $start)
            ->where('date', '<=', $end)
            ->get();
    }*/
    
    public function scopeStart($query, $date) {
        return $query
            ->where('date', '>=', $date);
    }

    public function scopeEnd($query, $date) {
        return $query
            ->where('date', '<=', $date);
    }

    public function scopeSummary($query) {
        return $query->select(\DB::raw('
            SUM(earnings) as earnings,
            SUM(subscribers) as subscribers,
            SUM(views) as views,
            SUM(videos) as videos'));
    }
}