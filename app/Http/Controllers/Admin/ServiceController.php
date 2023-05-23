<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\helpers\Attachment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attachment as attach;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index',compact('services'));
    }
    public function create(){
        return view('admin.services.create');
    }
public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();
        $service = Service::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        
        if ($request->hasFile('attachment')) {
            Attachment::addAttachment($request->file('attachment'), $service, 'services/images', ['save' => 'original', 'usage' => 'serviceimage']);
        }

        
        $service->save();

     


        return redirect('/services')->with(
            'Add',
            'Product Added Successfully'
        );



    }
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit',compact('service'));
    }

    public function update(UpdateProductRequest $request,$id){
        $validatedData = $request->validated();

        $service = Service::findOrFail($id);


        $service->name = $validatedData['name'];
        $service->description = $validatedData['description'];

       


       
        if ($request->hasFile('attachment')) {
            $oldFile = $service->attachmentRelation[0] ?? null;
            Attachment::updateAttachment($request->file('attachment'), $oldFile, $service, 'services/images', ['save' => 'original', 'usage' => 'serviceimage']);
        }
        $service->save();

      
        

        return redirect('/services')->with(
            'edit',
            'Product Added Successfully'
        );
        }

        public function destroy($id)
        {
            $product = Service::find($id);
            Attachment::deleteAttachment($product,  $relation = 'attachmentRelation' , $type = 'serviceimage');   
            $product->delete();
            return redirect('/services')->with(
                'delete',
                'Product deleted Successfully'
            );
        }
}
