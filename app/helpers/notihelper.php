<?php

use App\Models\PushNotification;

if (!function_exists('capitalize')) {
    function capitalize($string)
    {
        return ucfirst($string);
    }
}

if (!function_exists('notify')) {
    function notify($title, $body, $users = [], $noti_image = null)
    {
        $SERVER_API_KEY = 'AAAAcYLIAGM:APA91bHuL2kulcQqbI7euyywVjybhS4BCLf6he23QWqNNiUBHiz5Iw23YVDvn4NdTxMxtPpP_yom8bROnuVDFaUm9gRTEhMUyC-aLe8fptlyKWU8bJKnvGc7XEB__w9K5AjK6tCJUwaQ';
        $tokens = [];
        foreach ($users as $user) {
            array_push($tokens, $user->push_token);
        }
        $data = [
            "registration_ids" =>
            $tokens,
            "notification" => [
                "title" => $title,
                "body" => $body,
                "sound" => "default", // required for sound on ios
                "image" => asset($noti_image)
            ],
            "data" => [
                "click_action" => "FLUTTER_NOTIFICATION_CLICK"
            ],
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        // storing the notification in the DB
        $image = isset($noti_image) ? $noti_image : null;
        foreach ($users as $user) {
            PushNotification::create([
                'title' => $title,
                'body' => $body,
                'image' => $image,
                'client_id' => $user->id
            ]);
        }
    }
}
