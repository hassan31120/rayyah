<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\helpers\Attachment;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Attachment as attach;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }
    public function create(){
        $categories = Category::all();
        return view('admin.products.create',compact('categories'));
    }
public function store(CreateProductRequest $request)
    {
        $validatedData = $request->validated();
        $category = Category::findOrFail($validatedData['category_id']);
        $product = $category->products()->create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'latitude'=>$validatedData['latitude'],
            'longitude'=>$validatedData['longitude'],
            'rate' => $validatedData['rate'],
        ]);

        if ($request->hasFile('logo')) {
            Attachment::addAttachment($request->file('logo'), $product, 'products/logo', ['save' => 'original', 'usage' => 'logoImage']);
        }
        $product->save();

        if ($request->hasFile('image')) {
            $uploadpath = 'uploads/products/'.$product->id . '/';
            $i = 1;
            foreach ($request->file('image') as $imageFile) {
                $extension = $imageFile->getClientOriginalExtension();
                $fileName = time() . $i++ . '.' . $extension;
                $imageFile->move($uploadpath, $fileName);
                $finalImagePathName = $uploadpath . $fileName;

                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName,
                ]);

            }
        }


        return redirect('/products')->with(
            'success',
            'Product Added Successfully'
        );



    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit',compact('product','categories'));#
    }

    public function update(UpdateProductRequest $request,$id){
        $validatedData = $request->validated();

        $product = Product::findOrFail($id);


        $product->name = $validatedData['name'];
        $product->description = $validatedData['description'];
        $product->category_id = $validatedData['category_id'];
        $product->rate = $validatedData['rate'];

        if($request->longitude){

            $product->latitude = $validatedData['latitude'];
            $product->longitude = $validatedData['longitude'];
        }



        if ($request->logo) {
            $getoldFile1 = attach::where([
                ['attachmentable_id', $product->id],
                ['usage','logoImage'],
                ['attachmentable_type', 'App\Models\Product'],
               
            ])->first() ?? null;
            $oldFile2 =  $product->attachmentRelation[0];

            Attachment::updateAttachment($request->file('logo'), $oldFile2, $product, 'products/logo', ['save' => 'original', 'usage' => 'logoImage']);
        }
        $product->save();

        if ($request->hasFile('image')) {
            $uploadpath = 'uploads/products/'.$product->id . '/';
            $i = 1;
            

            foreach ($request->file('image') as $imageFile) {
             
                $extension = $imageFile->getClientOriginalExtension();
                $fileName = time() . $i++ . '.' . $extension;
                $imageFile->move($uploadpath, $fileName);
                $finalImagePathName = $uploadpath . $fileName;
               
                $product->productImages()->update([
                    'image' => $finalImagePathName,
                ]);
               

            }
        }

        return redirect('/products')->with(
            'edit',
            'Product Added Successfully'
        );
        }

        public function destroy($id)
        {
            $product = Product::find($id);
            
            $product->delete();
            return redirect('/products')->with(
                'delete',
                'Product deleted Successfully'
            );
        }
}
