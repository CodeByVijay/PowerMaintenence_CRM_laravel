<?php

use App\Models\Notification;
use Carbon\Carbon;
if (!function_exists('printData')) {
    function printData($arr)
    {
        echo "<pre>";
        $data = print_r($arr);
        echo "</pre>";
        return $data;
    }
}

if (!function_exists("setFormatDate")) {
    function setFormatDate($inputDate)
    {
        // Parse the input date using Carbon
        $parsedDate = Carbon::createFromFormat('m-d-Y', $inputDate);
        // Format the date to "yyyy-mm-dd" format
        $formattedDate = $parsedDate->format('Y-m-d');
        return $formattedDate;
    }
}

if (!function_exists("getFormatDate")) {
    function getFormatDate($inputDate)
    {
        $formattedDate = date('m-d-Y', $inputDate);
        return $formattedDate;
    }
}

if (!function_exists("sendLeadsNotification")) {
    function sendLeadsNotification($lead_id, $notification_text, $notification_type, $staff_id = null)
    {
        Notification::create([
            'lead_id' => $lead_id,
            'notification' => $notification_text,
            'type' => $notification_type,
            'user_id' => $staff_id,
        ]);
        return true;
    }
}
