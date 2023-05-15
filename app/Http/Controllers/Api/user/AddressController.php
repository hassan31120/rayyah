<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Client;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $user = Client::find(auth('sanctum')->user()->id);
        if (isset($user)) {
            $addresses = Address::where('user_id', $user->id)->get();
            if (count($addresses) > 0) {
                if (auth('sanctum')->user()->id == $addresses[0]->user_id) {
                    return response()->json([
                        'success' => true,
                        'data' => AddressResource::collection($addresses),
                        'message' => 'Addresses Receieved Successfully!'
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'You don\'t have the right to show this addresses',
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Addresses Receieved Successfully!'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'there is no such user!',
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'number' => 'required|numeric',
            'description' => 'required',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['user_id'] = auth('sanctum')->user()->id;

        $address = Address::create($data);

        return response()->json([
            'success' => true,
            'new_address' => new AddressResource($address)
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $address = Address::find($id);
        if ($address) {
            if ($address->user_id == auth('sanctum')->user()->id) {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'number' => 'required|numeric',
                    'description' => 'required',
                    'lat' => 'required|numeric',
                    'long' => 'required|numeric',
                ]);
                $data = $request->all();
                $address->update($data);
                return response()->json([
                    'success' => true,
                    'address' => new AddressResource($address)
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'this address doesn\'t belong to you '
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'there is no such address!'
            ], 404);
        }
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        if ($address) {
            $address->delete();
            return response()->json([
                'success' => true,
                'message' => 'address has been deleted successfully'
            ], 404);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'there is no such address!'
            ], 404);
        }
    }
}
