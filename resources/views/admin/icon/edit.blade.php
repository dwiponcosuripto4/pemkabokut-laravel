@extends('admin.layouts.navigation')

@section('content')
    <div class="container" style="height: auto;">
        <h1>Edit Icon and Dropdowns</h1>

        <form action="{{ route('icon.update', $icon->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div class="mb-3">
                <label for="title" class="form-label">Icon Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $icon->title }}" required>
            </div>

            <!-- Icon Image Input with Card Display -->
            <div class="mb-3">
                <label for="image" class="form-label">Icon Image</label>

                <div class="table-icon-section d-flex flex-column gap-2 justify-content-center align-items-center">
                    <div class="card bg-opacity-60 text-center">
                        <div class="card-body">
                            @php
                                // Cek apakah gambar merupakan URL eksternal
                                $isExternalImage = Str::startsWith($icon->image, ['http://', 'https://']);
                            @endphp

                            <!-- Jika gambar merupakan URL eksternal -->
                            @if ($isExternalImage)
                                <img src="{{ $icon->image }}" alt="{{ $icon->title }}" class="img-fluid"
                                    style="width: 100px; height: 100px; object-fit: contain;">
                            @else
                                <img src="{{ asset('storage/' . $icon->image) }}" alt="{{ $icon->title }}"
                                    class="img-fluid" style="width: 100px; height: 100px; object-fit: contain;">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Upload New Image -->
                <input type="file" name="image" class="form-control mt-2" id="image">
                <small class="form-text text-muted">Leave empty if you don't want to change the image.</small>
            </div>

            {{-- Dynamic Dropdowns Section --}}
            <div class="dropdown-section">
                <h5>Edit Dropdowns</h5>

                @foreach ($icon->dropdowns as $index => $dropdown)
                    <div class="dropdown-entry">
                        <div class="mb-3">
                            <label for="dropdown_title_{{ $index }}" class="form-label">Dropdown Title</label>
                            <input type="text" name="dropdowns[{{ $dropdown->id }}][title]" class="form-control"
                                value="{{ $dropdown->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown_link_{{ $index }}" class="form-label">Dropdown Link</label>
                            <input type="url" name="dropdowns[{{ $dropdown->id }}][link]" class="form-control"
                                value="{{ $dropdown->link }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="dropdown_icon_dropdown_{{ $index }}" class="form-label">Dropdown Icon
                                (Image)</label>
                            <input type="file" name="dropdowns[{{ $dropdown->id }}][icon_dropdown]" class="form-control"
                                accept="image/*">
                            @if ($dropdown->icon_dropdown)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $dropdown->icon_dropdown) }}" alt="icon"
                                        style="max-width:40px;">
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-dropdown"
                            data-dropdown-id="{{ $dropdown->id }}">Delete Dropdown</button>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" id="add-dropdown">Add New Dropdown</button>

            <button type="submit" class="btn btn-primary mt-3">Update Icon and Dropdowns</button>
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">

    <script>
        let dropdownIndex = {{ $icon->dropdowns->count() }};

        // Add new dropdown input fields
        document.getElementById('add-dropdown').addEventListener('click', function() {
            const dropdownSection = document.querySelector('.dropdown-section');
            const newDropdown = `
                <div class="dropdown-entry mt-4">
                    <div class="mb-3">
                        <label for="dropdown_title_${dropdownIndex}" class="form-label">Dropdown Title</label>
                        <input type="text" name="dropdowns[new_${dropdownIndex}][title]" class="form-control" placeholder="Enter dropdown title" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_link_${dropdownIndex}" class="form-label">Dropdown Link</label>
                        <input type="url" name="dropdowns[new_${dropdownIndex}][link]" class="form-control" placeholder="Enter dropdown link" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_icon_dropdown_${dropdownIndex}" class="form-label">Dropdown Icon (Image)</label>
                        <input type="file" name="dropdowns[new_${dropdownIndex}][icon_dropdown]" class="form-control" accept="image/*">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-dropdown">Delete Dropdown</button>
                </div>
            `;
            dropdownSection.insertAdjacentHTML('beforeend', newDropdown);
            dropdownIndex++;
        });

        // Remove dropdown entry
        document.addEventListener('click', function(event) {
            if (event.target && event.target.matches('.remove-dropdown')) {
                const entry = event.target.closest('.dropdown-entry');
                entry.remove();
            }
        });
    </script>
@endsection
