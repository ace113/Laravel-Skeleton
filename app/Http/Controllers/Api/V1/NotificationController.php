<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Http\Controllers\Api\V1\ApiController;

class NotificationController extends ApiController
{
    protected $notificationService;
    public function __construct(
        NotificationService $notificationService
    )
    {
        $this->notificationService = $notificationService;
    }

    public function getNotificationSettings(Request $request){}


    public function updateNotificationSettings(Request $request){}

    public function getNotificationsList(Request $request){}

    public function getNotificationBadgeCount(Request $request){}

    public function readNotification(Request $request){}

    public function sendNotification(Request $request){}

    public function deleteNotification(Request $request){}

}
