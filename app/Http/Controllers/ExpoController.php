<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use App\Channels\CustomExpoChannel as ExpoChannel;
use App\Customer;
use App\User;

class ExpoController extends Controller
{
    public function __construct(ExpoChannel $expoChannel)
    {
        $this->expoChannel = $expoChannel;
    }

    public function subscribe(Request $request)
    {
        $random = Customer::whereEmail('lihar@mtp.id')->first();

        $interest = $this->expoChannel->interestName($random);
        
        $token = 'ExponentPushToken[PmLoqZL02keoDiLiqrSrp2]';
        
        try {
            $this->expoChannel->expo->subscribe($interest, $token);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 'failed',
                'error'     =>  [
                    'message' => $e->getMessage(),
                ],
            ], 500);
        }

        return response()->json([
            'status' => 'succeed',
            'model' => $random,
            'expo_token' => $token
        ]);
    }
}
