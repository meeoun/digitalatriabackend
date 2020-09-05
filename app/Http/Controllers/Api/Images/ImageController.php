<?php

namespace App\Http\Controllers\Api\Images;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\DestroyImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Image;
use App\Traits\ImagePath;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends ApiController
{
    use ImagePath;
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->showAll(Image::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreImageRequest $request)
    {
     if($request->has('image'))
     {
         $path = $request->image->store($this->getDatePath(),'images');
         $image = new Image($request->only(['description']));
         $image->name = $this->nameNoExtension($request->image->getClientOriginalName());
         $image->file_path = $path;
         $image->url = "$this->imageFolder/$path";
         $image->extension = $request->image->getClientOriginalExtension();
         $strArray = explode('/',$path);
         $image->hash_name = end($strArray);
         $image->save();
         return $this->showOne($image);
     }

     return $this->error("Image Not Found", "404");

    }

    /**
     * Display the specified resource.
     *
     * @param Image $image
     * @return JsonResponse
     */
    public function show(Image $image)
    {
        return $this->showOne($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateImageRequest $request
     * @param Image $image
     * @return JsonResponse
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->fill($request->only(['name', 'description']));
        $image->save();
        return $this->showOne($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyImageRequest $request
     * @return JsonResponse
     */
    public function destroy(DestroyImageRequest $request)
    {
        $id = ($request->url());
        $id =explode('/',$id);
        $id = end($id);
        $image = Image::findOrFail($id);
        Storage::disk('images')->delete($image->file_path);
        $image->delete();
        return $this->successMessage("Image Destroyed");
    }
}
