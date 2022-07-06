<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>English Name</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" placeholder="English Name" value="{{ old('name_en', $product->name_en) }}">
            @error('name_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Arabic Name</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" placeholder="Arabic Name" value="{{ old('name_ar', $product->name_ar) }}">
            @error('name_ar')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    <img width="80" src="{{ asset('uploads/images/products/'.$product->image) }}" alt="">
    @error('image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>English Description</label>
    <textarea name="description_en" class="tinyedit form-control @error('description_en') is-invalid @enderror">{{ old('description_en', $product->description_en) }}</textarea>
    @error('description_en')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Arabic Description</label>
    <textarea name="description_ar" class="tinyedit form-control @error('description_ar') is-invalid @enderror">{{ old('description_ar', $product->description_ar) }}</textarea>
    @error('description_ar')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Price</label>
    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price', $product->price) }}">
    @error('price')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Sale Price</label>
    <input type="number" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" placeholder="Sale Price" value="{{ old('sale_price', $product->sale_price) }}">
    @error('sale_price')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Quantity</label>
    <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="Quantity" value="{{ old('quantity', $product->quantity) }}">
    @error('quantity')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Category</label>
    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
        <option value="">-- Select --</option>
        @foreach ($categories as $item)
            <option {{ $product->category_id == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{ $item->trans_name }}</option>

        @endforeach
    </select>

    @error('category_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
