@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Dropdown</h1>
        <form action="{{ route('dropdowns.update', $dropdown->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ $dropdown->title }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="icon_dropdown" class="form-label">Icon Dropdown (Gambar)</label>
                <input type="file" name="icon_dropdown" id="icon_dropdown" class="form-control" accept="image/*">
                @if ($dropdown->icon_dropdown)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $dropdown->icon_dropdown) }}" alt="icon"
                            style="max-width:80px;">
                    </div>
                @endif
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" name="link" id="link" class="form-control" value="{{ $dropdown->link }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="icon_id" class="form-label">Icon</label>
                <select name="icon_id" id="icon_id" class="form-control" required>
                    @foreach ($icons as $icon)
                        <option value="{{ $icon->id }}" @if ($dropdown->icon_id == $icon->id) selected @endif>
                            {{ $icon->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
