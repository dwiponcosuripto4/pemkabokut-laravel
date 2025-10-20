@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Buat Dropdown Baru</h1>
        <form action="{{ route('dropdowns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="icon_dropdown" class="form-label">Icon Dropdown (Gambar)</label>
                <input type="file" name="icon_dropdown" id="icon_dropdown" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" name="link" id="link" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="icon_id" class="form-label">Icon</label>
                <select name="icon_id" id="icon_id" class="form-control" required>
                    @foreach ($icons as $icon)
                        <option value="{{ $icon->id }}">{{ $icon->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
