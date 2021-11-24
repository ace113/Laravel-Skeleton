<?php

namespace App\Services;

class NotificationService
{
    public function __construct()
    {

    }

    // curl send firebase notification
    protected function sendCurlRequest($fields)
    {
        try {
            $url = 'https://fcm.googleapis.com/fcm/send';

            $key=config('app.fcm_service_key');
          

            $headers = array(
                'Authorization: Key=' . $key,
                'Content-Type: application/json'
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);        

            return $result;

        } catch (Exception $e) {
            return true;
        }
        return true;
    }

    public function saveNotificationData($userId, $notificationType="TEST", $notificationTitle="Hello", $data =[])
    {
        if(is_null($userId)){
            return true;
        }
        
        $this->notificationType = $notificationType;
        $this->notificationTitle = $notificationTitle;
        $deviceIds = $this->userRepository->getUserDeviceToken($userId);
        $this->notificationBody = self::getNotificationBody($this->notificationType, $data);

        $notification = Notification::create([
            'id' => Str::uuid(),
            'user_id' => $userId,
            'notifiable_type' => $this->notificationType,
            'data' => json_encode($data)
        ]);

        $badgeCount = Notification::where(['user_id' => $userId, 'read_at' => null])->count();

        $fields = array(
            'registration_ids' => $deviceIds,
            'notification' => array(
                'body' => $this->notificationBody,
                'title' => $this->notificationTitle,
                'sound' => 'default',
                'badge' => 1
            ),
            'priority' => 'high',
            'data' => array(
                'notification_id' => $notification->id,
                'notification_type' => $notificationType,
                'status'        => isset($data['status']) ? $data['status'] : null,
                'reason'        => isset($data['reason']) ? $data['reason'] : null,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                'created_at' => gmdate("Y-m-d H:i:s"),
            ),            
        );
      
        return self::sendCurlRequest($fields);
    }

    public function getNotificationBody($type, $data=[]){
        switch($type){           
            case 'CUSTOM': 
                return $data['body'];
                break;
            default: 
                return 'Test Notification.';
                break;
        }   
    }
}