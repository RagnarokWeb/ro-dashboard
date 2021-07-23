<?php
include __DIR__.'/../app/index.php';
use Illuminate\Database\Capsule\Manager as DB;
use Models\AccountLogin;
use Carbon\Carbon;
validateLogin(true, false);//check account login
header('Content-Type: application/json');
$fromDate = Carbon::now()->startOfMonth();
$toDate = Carbon::now()->endOfMonth();
$paymentLogs = AccountLogin::query();

if($fromDate && $toDate) {
    $paymentLogs->whereBetween('logindate', [$fromDate, $toDate]);
}

$column = [
    DB::raw('count(accid) as agg'),
    DB::raw('day(logindate) as day')
];

$paymentLogs->groupByRaw('day(logindate)');
$paymentLogs->distinct('accid');

echo(json_encode($paymentLogs->get($column)->keyBy('day')));
?>