<?php

namespace App\Helpers;

use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DateInterval;
use DateMalformedIntervalStringException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Helper
{
    /**
     * Return the default value if the passed value is not empty
     *
     * @param mixed $value
     * @param mixed $default
     * @return mixed|string
     */
    public static function valueOrDefault(mixed $value, mixed $default=null): mixed
    {
        return $value ?: $default;
    }

    /**
     * Remove multiple slashes from Provided string
     *
     * @param string $url
     * @return string
     */
    public static function cleanURL(string $url): string
    {
        if(!$url){
            return '';
        }

        return str_replace(':/','://', trim(preg_replace('/\/+/', '/', $url), '/'));
    }

    /**
     * return fontawesome icon class as per passed file extension
     *
     * @param string $fileExtension
     * @return string
     */
    public static function getFileIcon(string $fileExtension): string
    {
        return match ($fileExtension) {
            'pdf'           => 'fa-file-pdf',
            'xlsx', 'xls'   => 'fa-file-excel',
            'CSV'           => 'fa-file-csv',
            'docx', 'doc'   => 'fa-file-word',
            'pptx', 'ppt'   => 'fa-file-powerpoint',
            'msg'           => 'fa-at',
            'txt'           => 'fa-file-text',
            'zip'           => 'fa-file-zipper',
            'jpg', 'png',
            'bmp'           => 'fa-file-image',
            default => 'fa-file'
        };
    }

    /**
     * map array into a key value.
     *
     * @param array $options
     * @param string $keyValue
     * @param string $keyLabel
     * @return Collection
     */
    public static function mapStaticOptions(array $options, string $keyValue = 'value', string $keyLabel = 'label'): Collection
    {
        return collect($options)->map(function($option, $key) use ($keyValue, $keyLabel) {
            return [$keyValue => $key, $keyLabel => $option];
        })->values();
    }

    /**
     * return YES / NO
     *
     * @param bool $value
     * @return string
     */
    public static function boolToText(?bool $value = false): string
    {
        return $value == 1 ? __('Ja') : __('Nein');
    }

    /**
     * @deprecated
     * Only required with the old connect portal link.
     *
     * Convert all the url indexes of given array to connect a portal
     * format.
     *
     * @param mixed $actions
     * @param string $cpToken
     * @return mixed
     */
    public static function ConnectPortalURLConversion(mixed $actions, string $cpToken=''): mixed
    {
        // token must be set in the ajax headers. otherwise no need
        // to convert the URLs.
        if(!$cpToken)
        {
            $cpToken = Request::header('CP-TOKEN');
        }

        if(!trim($cpToken) || !$actions){
            return $actions;
        }

        // Extracting token from the header string.
        $token = strtok(rtrim(trim($cpToken), '/'), '/');

        // Token invalid. Connect portal cannot work without a valid token.
        if(!$token){
            return $actions;
        }

        // connect portal base url
        $connectPortalBaseURL = config('app.connect_portal_url');

        // creating url with token.
        $connectPortalURL = $connectPortalBaseURL . '/' . $token;
        $TwapServerURL = config('app.url');

        // converting all provided urls to connection portal
        if(is_array($actions))
        {
            // multiple actions passed
            foreach ($actions as &$action)
            {
                // URL should not be empty.
                if(isset($action['url']) && $action['url']) {
                    //$action['url'] = str_replace($TwapServerURL, $connectPortalURL, $action['url']);
                    $action['url'] = self::generateConnectPortalURL($TwapServerURL, $connectPortalURL, $action['url']);
                }
            }
        } else {
            // single action
            $actions = self::generateConnectPortalURL($TwapServerURL, $connectPortalURL, $actions);
        }

        return $actions;
    }

    /**
     * @deprecated since new connect portal link
     *
     * @param $TwapServerURL
     * @param $connectPortalURL
     * @param $url
     * @return string
     */
    public static function generateConnectPortalURL($TwapServerURL, $connectPortalURL, $url): string
    {
        return str_replace($TwapServerURL, $connectPortalURL, $url);
    }

    /**
     * Convert given date to Carbon Object
     *
     * @param mixed $date
     * @return Carbon|null
     */
    public static function convertToCarbon(mixed $date): ?Carbon
    {
        if($date instanceof Carbon){
            return $date;
        }

        if(!$date){
            return null;
        }

        try {
            return Carbon::parse($date);
        }catch (\Exception $exception){
            return null;
        }
    }

    /**
     * Convert given date frame to start and end date
     *
     * @param string|null $timeFrame
     * @return Collection|null
     */
    public static function convertTimeFrameToDateTime(?string $timeFrame=null): ?Collection
    {
        return match($timeFrame) {
            'all_time', 'all'   => null,
            'today'             =>  new Collection(['start' => now()->startOfDay() , 'end' => now()->endOfDay()]),
            'this_month'        =>  new Collection(['start' => now()->startOfMonth() , 'end' => now()->endOfMonth()]),
            'previous_month'    =>  new Collection(['start' => (new Carbon('first day of last month'))->startOfDay(), 'end' => (new Carbon('last day of last month'))->endOfDay()]),
            'this_week'         =>  new Collection(['start' => now()->startOfWeek() , 'end' => now()->endOfWeek()]),
            'previous_week'     =>  new Collection(['start' => now()->subWeek()->startOfWeek(), 'end' => now()->subWeek()->endOfWeek()]),
            'this_year'         =>  new Collection(['start' => now()->startOfYear() , 'end' => now()->endOfYear()]),
            'previous_year'     =>   new Collection(['start' => (new Carbon('first day of last year'))->startOfYear(), 'end' => (new Carbon('last day of last year'))->endOfYear()]),
            default             => new Collection(['start' => now()->startOfDay() , 'end' => now()->endOfDay()]),
        };
    }

    /**
     * Remove empty values from a collection (including nested arrays).
     *
     * @param array|Collection $data
     * @return Collection
     */
    public static function filterEmptyValues(array|Collection $data): Collection
    {
        if (empty($data)) {
            return $data;
        }

        return collect($data)->map(function ($item) {
            if (is_array($item)) {
                // Recursively filter nested arrays
                return collect($item)->filter()->toArray();
            }
            return $item;
        })->filter();
    }

    public static function getLdapAttribute($attribute): string
    {
        return trim($attribute[0] ?? null);
    }

    public static function getMonthsList(): collection
    {
        return collect(range(1, 12))->map(fn($month) => [
            'name' => Carbon::create(null, $month)->translatedFormat('F'),
            'value' => $month
        ]);
    }

    public static function ttimeNavigateBack()
    {
        $previousRouteExists = in_array(redirect()->back()->getTargetUrl(), [url(route('ttime.expenses.backlog.index')),url(route('ttime.expenses.index'))]);
        $route = 'ttime.expenses.backlog.index';

        if(!Auth::user()->hasRole('Developer') && Auth::user()->hasRole(config('tmhde.t_time.role_technician')) ){
            $route = 'ttime.expenses.index';
        }

        return $previousRouteExists
            ? url()->previous()
            : url(route($route));
    }

    /**
     * Convert ISO 8601 Duration String (P00Y00M01DT16H00M00S) to Carbon Interval
     *
     * @throws DateMalformedIntervalStringException
     */
    public static function convertISODurationToCarbonInterval(string $isoDurationString): CarbonInterval
    {
        //return CarbonInterval::instance(new DateInterval($isoDurationString));

        $isNegative = false;

        // Check for a negative prefix
        if (str_starts_with($isoDurationString, '-')) {
            $isNegative = true;
            $isoDurationString = substr($isoDurationString, 1); // remove leading '-'
        }

        $interval = CarbonInterval::instance(new DateInterval($isoDurationString));

        if ($isNegative) {
            $interval->invert = 1; // mark as negative
        }

        return $interval;

    }

    /**
     * Convert Carbon Interval to ISO 8601 Duration String (P00Y00M01DT16H00M00S)
     *
     */
    public static function convertCarbonIntervalToISODuration(CarbonInterval $interval): string
    {
        $duration = sprintf(
            'P%02dY%02dM%02dDT%02dH%02dM%02dS',
            $interval->y,  // Years
            $interval->m,  // Months
            $interval->d,  // Days
            $interval->h,  // Hours
            $interval->i,  // Minutes
            $interval->s   // Seconds
        );

        // If an interval is negative, prepend a minus sign
        if ($interval->invert === 1) {
            $duration = '-' . $duration;
        }

        return $duration;
    }

    /**
     * Get the number of workdays (Mon–Fri) between two dates.
     *
     * @param string|Carbon $start
     * @param string|Carbon $end
     * @return int  Signed number of days (negative if end < start)
     */
    public static function workdays_between(Carbon|string $start, Carbon|string $end): int
    {
        $start = $start instanceof Carbon ? $start->copy()->startOfDay() : Carbon::parse($start)->startOfDay();
        $end   = $end   instanceof Carbon ? $end->copy()->startOfDay()   : Carbon::parse($end)->startOfDay();

        if ($start->isSameDay($end)) {
            return 0; // same calendar day → 0
        }

        $sign = $start->lessThan($end) ? 1 : -1;

        // Count weekdays in (min, max]  → open start, closed end
        $from = $start->min($end)->copy()->addDay(); // exclude start
        $to   = $start->max($end);                   // include end

        $count = 0;
        foreach (CarbonPeriod::create($from, '1 day', $to) as $day) {
            if ($day->isWeekday()) {
                $count++;
            }
        }

        return $count * $sign;
    }
}
