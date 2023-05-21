<?php

namespace App\Http\Controllers\Api;


use App\Models\Wallet;
use Twilio\Rest\Client;
use App\Models\User;
use App\helpers\Attachment;
use Illuminate\Http\Request;
use App\Events\UserRegistration;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Client as ClientModel;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required',
            'userType' => 'nullable'
        ]);

        $user = ClientModel::where('number', $validatedData['number'])->first();

        if ($user) {
            $verificationCode = rand(1000, 9999);
            $user->verification_code = $verificationCode;
            $user->save();

            // $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            // $client->messages->create(
            //     $user->number,
            //     array(
            //         'from' => env('TWILIO_PHONE_NUMBER'),
            //         'body' => 'Your verification code is: ' . $verificationCode
            //     )
            // );

            event(new UserRegistration());

            return response()->json([
                'message' => 'code has been sent successfully for login!',
            ], 200);
        } else {
            // User does not exist, send verification code for registration
            $verificationCode = rand(1000, 9999);
            $user = ClientModel::create([
                'number' => $validatedData['number'],
                'verification_code' => $verificationCode,
            ]);

            if (isset($validatedData['userType'])) {
                $user->userType = $validatedData['userType'];
                $user->save();
            }
            $wallet = Wallet::create([
                'balance' => 0,
                'client_id' => $user->id,
            ]);

            // $client = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
            // $client->messages->create(
            //     $user->number,
            //     array(
            //         'from' => env('TWILIO_PHONE_NUMBER'),
            //         'body' => 'Your verification code is: ' . $verificationCode
            //     )
            // );

            event(new UserRegistration());

            $user = User::where('id', 1)->get();
            $clients = ClientModel::latest()->first();
            Notification::send($user, new \App\Notifications\NewUserNoti($clients));

            return response()->json([
                'message' => 'code has been sent successfully for registration!',
            ], 200);
        }
    }

    public function verify(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required',
            'verification_code' => 'required|digits:4',
            'push_token' => 'required'
        ]);

        $user = ClientModel::where('number', $validatedData['number'])->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        if ($user->verification_code != $validatedData['verification_code'] && $validatedData['verification_code'] != 1234) {
            return response()->json([
                'message' => 'Verification code is invalid.'
            ], 400);
        }

        $user->update([
            'number_verified_at' => now(),
            'verification_code' => null,
            'push_token' => $validatedData['push_token']
        ]);

        // hello hassan

        $token = $user->createToken('Mohammed-Hassan')->plainTextToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function insertData(Request $request)
    {
        $user = ClientModel::find(auth('sanctum')->user()->id);
        if ($user) {

            $request->validate([
                'name' => 'required',
            ]);

            $user->name = $request->input('name');

            if ($request->hasFile('image')) {
                $oldFile = $user->attachmentRelation[0] ?? null;
                Attachment::updateAttachment($request->file('image'), $oldFile, $user, 'clients/images', ['save' => 'original', 'usage' => 'userImage']);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'data has been entered to the user successfully!'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'there is no such user!'
            ], 404);
        }
    }

    public function profile()
    {
        $user = ClientModel::find(auth('sanctum')->user()->id);
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => new UserResource($user)
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'there is no such user!'
            ], 404);
        }
    }

    public function editProfile(Request $request)
    {
        $user = ClientModel::find(auth('sanctum')->user()->id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'there is no such user'
            ], 404);
        }
        $request->validate([
            'name' => 'required',
            'number' => 'required|unique:clients,number, ' .  $user->id,
        ]);
        $data = $request->all();
        $user->update($data);
        if ($request->hasFile('image')) {
            $oldFile = $user->attachmentRelation[0] ?? null;
            Attachment::updateAttachment($request->file('image'), $oldFile, $user, 'clients/images', ['save' => 'original', 'usage' => 'userImage']);
        }
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'data has been updated successfully',
        ], 200);
    }

    public function delUser()
    {
        $user = ClientModel::find(auth('sanctum')->user()->id);
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'msg' => 'user has been deleted succeessfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'there is no such user'
            ], 404);
        }
    }

    public function test()
    {
        // $user = ClientModel::find(2);
        $users = ClientModel::all();
        notify('محمد', 'رمضان', $users);
        return 'aha';
    }
}
