<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('categories.show');

        $categories = Category::orderByDesc('id')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select(['id', 'name'])->get();
        $category = new Category();

        return view('admin.categories.create', compact('categories', 'category'));
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

        // NEW IM 88.PNG
        // 56464684646465496-new-im-88.png
        $image = $request->file('image');
        $new_img_name = rand().time().'-'.strtolower(str_replace(' ', '-', $image->getClientOriginalName()));
        $image->move(public_path('uploads/images/categories'), $new_img_name);

        // $data = $request->all();
        // $data['image'] = $new_img_name;

        // Category::create($data);
        $name = [
            'en' => $request->name_en,
            'ar' => $request->name_ar
        ];
        Category::create([
            'name' => json_encode($name, JSON_UNESCAPED_UNICODE) ,
            'slug' => Str::slug($request->name_en),
            'image' => $new_img_name,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Created Successfully')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::select(['id', 'name'])->where('id', '<>', $id)->get();
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', compact('categories', 'category'));
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
        $request->validate([
            'name' => 'required|min:3',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category = Category::findOrFail($id);

        // NEW IM 88.PNG
        // 56464684646465496-new-im-88.png
        $new_img_name = $category->image;
        if($request->hasFile('image')) {
            $this->deleteImage($category->image);
            $image = $request->file('image');
            $new_img_name = rand().time().'-'.strtolower(str_replace(' ', '-', $image->getClientOriginalName()));
            $image->move(public_path('uploads/images/categories'), $new_img_name);
        }

        $data = $request->all();
        $data['image'] = $new_img_name;

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('msg', 'Category Updated Successfully')->with('type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $this->deleteImage($category->image);

        Category::where('parent_id', $category->id)->update(['parent_id' => null]);

        $category->delete();

        return redirect()->route('admin.categories.index')->with('msg', 'Category Deleted Successfully')->with('type', 'danger');
    }

    private function deleteImage($src)
    {
        File::delete(public_path('uploads/images/categories/'.$src));
    }

    /**
     * Display a deleted listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $categories = Category::onlyTrashed()->orderByDesc('id')->paginate(10);
        return view('admin.categories.trash', compact('categories'));
    }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function forcedelete($id)
    {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back();
    }


}
