<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Role;
use App\Models\User;
use App\Models\Store;
use App\Models\storeUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\UploadedFile;
use App\Http\Requests\StoreRequest;
use App\Services\UploadFileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function addstore(StoreRequest $request)
    {
        $discount = MyHelper::calDiscount(400);
        return $discount;

    $filename = resolve(UploadFileService::class)->uploadFileStoreLogo($request);
        
        $addStore= new Store();
        $addStore-> name = $request ->name;
        $addStore->email_contact = $request ->email_contact;
        $addStore->phone_number = $request ->phone_number;
        $addStore->address = $request ->address;
        $addStore->logo = '$filename';
        $addStore->save();

        $addUser = new User();
        $addUser->name = $request->name;
        $addUser->email = $request->email;
        $addUser->password = $request->password;
        $addUser->save();

        $profilename = (new UploadFileService())->uploadFileUserProfile($request);



        $addStoreUser = new storeUsers();
        $addStoreUser->store_id = $addStore->id;
        $addStoreUser->user_id = $addUser->id;
        $addStoreUser->profile = $profilename;
        $addStoreUser->save();

        $getRoleStoreAdmin = Role::where('name', 'admin')->first();
        $addUser->attachRole($getRoleStoreAdmin);
        
    }
    public function liststores(Request $request)
    {
        $listStores = Store::paginate($request->per_page);

        $listStores->transform(function($item) {
            $item['store_user'] = StoreUser::select(
                'user.id',
                'user.name'
            )->join(
                'users as user', 
                'user.id', 
                'store_users.user_id'
            )->where('store_id', $item['id'])->get();
            
            return $item->format();
        });

        return response()->json([
            'stores' => $listStores
        ]);

    }
    public function editStore(StoreRequest $request)
    {
        $editStore = Store::find($request->id);
        $editStore->name = $request->name;
        $editStore->email_contact = $request->email_contact;
        $editStore->phone_number = $request->phone_number;
        $editStore->address = $request->address;

        /** Save Image */
        if (isset($request['logo'])) {
            (new UploadFileService())->editUploadFileStoreLogo($request,$editStore);
        }

        $editStore->save();

        return response()->json([
            'message' => 'ອັບເດດສຳເລັດ.'
        ]);
    }
    public function deleteStore(StoreRequest $request)
    {
        $deleteStore = Store::find($request->id);
        $deleteStore->delete();
    }
}
