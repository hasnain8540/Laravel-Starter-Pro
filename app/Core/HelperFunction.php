<?php

namespace App\Core;

use App\Models\PartImage;
use App\Models\User;
use Carbon\CarbonInterface;
use Carbon\Carbon;
use App\Models\RefillDetail;

class HelperFunction
{
    /**
     * @return Uid
     */
    public static function _uid()
    {
        return md5(date('Y-m-d') . microtime() . rand());
    }

    // Format Size
    public static function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * Sort Images Data
     */

    public static function _SortData($position, $part)
    {
        $data = PartImage::where(['position' => $position, 'part_id' => $part])->orderBy('default','DESC')->get();

        return $data;
    }

    /**
     * Get User Roles
     */

    public static function getRole($id)
    {
       return User::join('model_has_roles','model_has_roles.model_id','=','users.id')
           ->join('roles','roles.id','=','model_has_roles.role_id')
           ->where('users.id', $id)
           ->select('roles.name as role')->get();
    }

    /**
     * Calculate Display Time
     */
    public static function calculateDisplayTime($start, $end)
    {
        $starts = new Carbon($start);
        $ends = new Carbon($end);

        $options = [
            'join' => ', ',
            'parts' => 2
        ];

        return $starts->diffForHumans($ends, $options);
    }

    /**
     *  Calculate Product Time
     */
    public static function calculationProductTime($start, $end, $part)
    {
        $starts = Carbon::parse($start);
        $ends = Carbon::parse($end);

        $hours = $starts->diff($ends)->format('%H');
        $min = $starts->diff($ends)->format('%I');
        $sec = $starts->diff($ends)->format('%S');

        $hoursToMin = $hours * 60;
        $totalMin = $hoursToMin + $min;
        $minToSec = $totalMin * 60;
        $totalSec = $minToSec + $sec;

        if ($part > 0) {

            $calculatedTime = $totalSec / $part;
        } else {
            $calculatedTime = $totalSec;
        }

        return gmdate("H:i:s", mktime(-4, 0, $calculatedTime));
    }

    /**
     * Check Refill Part
     */
    public static function _checkRefill($part, $refill)
    {
        if (!RefillDetail::where(['part_id' => $part, 'refill_id' => $refill])->exists()) {

            return true;
        } else {

            return false;
        }
    }
}
