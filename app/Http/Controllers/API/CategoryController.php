<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|min:3',
            'name_ar' => 'required|min:3',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $image = $request->file('image');
        $new_img_name = rand().time().'-'.strtolower(str_replace(' ', '-', $image->getClientOriginalName()));
        $image->move(public_path('uploads/images/categories'), $new_img_name);

        // Category::create($data);
        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ];
        return Category::create([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE) ,
            'slug' => Str::slug($request->name_en),
            'image' => $new_img_name,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'name_en' => 'required|min:3',
        //     'name_ar' => 'required|min:3',
        //     'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        //     'parent_id' => 'nullable|exists:categories,id'
        // ]);

        // return $request->all();

        $category = Category::findOrFail($id);

        $new_img_name = $category->image;
        if($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $image = $request->file('image');
            $new_img_name = rand().time().'-'.strtolower(str_replace(' ', '-', $image->getClientOriginalName()));
            $image->move(public_path('uploads/images/categories'), $new_img_name);
        }

        $old_name = json_decode( $category->name, true );

        if($request->has('name_en')) {
            $name = [
                'en' => $request->name_en,
                'ar' => $old_name['ar']
            ];
        }

        if($request->has('name_ar')) {
            $name = [
                'en' => $old_name['en'],
                'ar' => $request->name_ar
            ];
        }


        $data = $request->all();
        $data['image'] = $new_img_name;
        unset($data['name_en']);
        unset($data['name_ar']);
        $data['name'] = json_encode($name, JSON_UNESCAPED_UNICODE);

        return $category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Category::destroy($id);
    }
}
