<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label>English Name</label>
            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror" placeholder="English Name" value="{{ old('name_en', $category->name_en) }}">
            @error('name_en')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label>Arabic Name</label>
            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror" placeholder="Arabic Name" value="{{ old('name_ar', $category->name_ar) }}">
            @error('name_ar')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="mb-3">
    <label>Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    <img width="80" src="{{ asset('uploads/images/categories/'.$category->image) }}" alt="">
    @error('image')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="mb-3">
    <label>Parent</label>
    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <option value="">-- Select --</option>
        @foreach ($categories as $item)
            {{-- @if ($category->id != $item->id)
                <option {{ $category->parent_id == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{ $item->trans_name }}</option>
            @endif --}}

            <option {{ $category->parent_id == $item->id ? 'selected' : ''  }} value="{{ $item->id }}">{{ $item->trans_name }}</option>

        @endforeach
    </select>

    @error('parent_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
