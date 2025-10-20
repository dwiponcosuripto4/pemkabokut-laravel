@extends('admin.layouts.navigation')

@section('content')
    <div class="container" style="height: auto;">
        <h1>Create Portal with Dropdowns</h1>
        <form action="{{ route('icon.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Icon Image</label>
                <input type="file" name="image" class="form-control" id="image" required>
            </div>

            {{-- Dynamic Dropdowns Section --}}
            <div class="dropdown-section">
                <h5>Add Dropdowns</h5>
                <div class="dropdown-entry">
                    <div class="mb-3">
                        <label for="dropdown_title" class="form-label">Dropdown Title</label>
                        <input type="text" name="dropdowns[0][title]" class="form-control"
                            placeholder="Enter dropdown title">
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_link" class="form-label">Dropdown Link</label>
                        <input type="url" name="dropdowns[0][link]" class="form-control"
                            placeholder="Enter dropdown link">
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_icon_dropdown" class="form-label">Dropdown Icon (Image)</label>
                        <input type="file" name="dropdowns[0][icon_dropdown]" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" id="add-dropdown">Add Dropdown</button>

            <button type="submit" class="btn btn-primary mt-3">Create Icon and Dropdowns</button>
        </form>
    </div>

    <link rel="stylesheet" href="{{ asset('css/portal.css') }}">

    <script>
        let dropdownIndex = 1;
        document.getElementById('add-dropdown').addEventListener('click', function() {
            const dropdownSection = document.querySelector('.dropdown-section');
            const newDropdown = `
                <div class="dropdown-entry mt-4">
                    <div class="mb-3">
                        <label for="dropdown_title" class="form-label">Dropdown Title</label>
                        <input type="text" name="dropdowns[${dropdownIndex}][title]" class="form-control" placeholder="Enter dropdown title" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_link" class="form-label">Dropdown Link</label>
                        <input type="url" name="dropdowns[${dropdownIndex}][link]" class="form-control" placeholder="Enter dropdown link" required>
                    </div>
                    <div class="mb-3">
                        <label for="dropdown_icon_dropdown" class="form-label">Dropdown Icon (Image)</label>
                        <input type="file" name="dropdowns[${dropdownIndex}][icon_dropdown]" class="form-control" accept="image/*">
                    </div>
                </div>
            `;
            dropdownSection.insertAdjacentHTML('beforeend', newDropdown);
            dropdownIndex++;
        });
    </script>
@endsection
