@extends('admin.dashboard')
@section('content')

<style>
.hidden {
    display: none;
}
.error-message {
    color: red;
    font-size: 14px;
}
.image-preview {
    max-width: 100px;
    max-height: 100px;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="page-header">
    <h4>Edit Category</h4>
    <a href="categories_menu.php" class="">
        <label class="badge badge-info">
            <i class="mdi mdi-apps"></i> Manage
        </label>
    </a>
</div>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pb-5">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div id="errorContainer" class="alert alert-danger" style="display: none;"></div>

                    <form id="uploadForm" action="{{ route('admin.category.update') }}" class="form-sample" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">

                                <input type="hidden" name="id" class="form-control form-control-lg" value="{{ $category->id }}" placeholder="Enter Category Title" aria-label="Title">

                                    <label>Category Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-lg" value="{{ $category->title }}" placeholder="Enter Category Title" aria-label="Title">
                                    @if ($errors->has('title'))
                                        <div class="error-message">
                                            @foreach ($errors->get('title') as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
    <label>App Icon</label>
    <input type="file" name="appIcon" id="appIconFile">
    @if ($category->app_icon)
        <div class="mt-2">
            <img src="{{ asset('storage/'.$category->app_icon) }}" alt="App Icon Preview" class="image-preview">
        </div>
    @else
        <div class="mt-2 hidden">
            <img class="image-preview hidden">
        </div>
    @endif
    <div class="progress mt-2 hidden">
        <div class="progress-bar app-icon-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</div>
                            </div>
                            <div class="col-md-3">
                              

                            <div class="form-group">
    <label>Web Icon</label>
    <input type="file" name="webIcon" id="webIconFile">
    @if ($category->web_icon)
        <div class="mt-2">
            <img src="{{ asset('storage/'.$category->web_icon) }}" alt="Web Icon Preview" class="image-preview">
        </div>
    @else
        <div class="mt-2 hidden">
            <img class="image-preview hidden">
        </div>
    @endif
    <div class="progress mt-2 hidden">
        <div class="progress-bar web-icon-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</div>

                            </div>
                            <div class="col-md-3">
                            <div class="form-group">
    <label>Main Image</label>
    <input type="file" name="mainImage" id="mainImageFile">
    @if ($category->main_image)
        <div class="mt-2">
            <img src="{{ asset('storage/'.$category->main_image) }}" alt="Main Image Preview" class="image-preview">
        </div>
    @else
        <div class="mt-2 hidden">
            <img class="image-preview hidden">
        </div>
    @endif
    <div class="progress mt-2 hidden">
        <div class="progress-bar main-image-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
</div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>InActive</option>
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Priority<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="priority" value="{{ $category->priority }}" />
                                    @if ($errors->has('priority'))
                                        <div class="error-message">
                                            @foreach ($errors->get('priority') as $error)
                                                <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center mt-4">
                            <button type="submit" id="submitBtn" class="btn btn-gradient-success btn-fw">
                                <i class="mdi mdi-arrow-right-bold-hexagon-outline"></i> UPDATE
                            </button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-info">
                                <i class="mdi mdi-arrow-left-bold-circle"></i> BACK
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');
        const requiredFields = [
            document.querySelector('input[name="title"]'),
            document.querySelector('select[name="status"]'),
           
            document.querySelector('input[name="priority"]')
        ];

        function validateForm() {
            let isValid = true;
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                }
            });
            submitBtn.disabled = !isValid;
        }

        requiredFields.forEach(field => {
            field.addEventListener('input', validateForm);
            field.addEventListener('change', validateForm); // For file inputs
        });

        validateForm(); // Initial check
    });
</script>

<script>
    $(document).ready(function() {
        $('#appIconFile').on('change', function(e) {
            previewImage(e, '#appIconFile');
            handleFileSelect(e, '.app-icon-progress');
            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });

        $('#webIconFile').on('change', function(e) {
            previewImage(e, '#webIconFile');
            handleFileSelect(e, '.web-icon-progress');
            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });

        $('#mainImageFile').on('change', function(e) {
            previewImage(e, '#mainImageFile');
            handleFileSelect(e, '.main-image-progress');
            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });

        function previewImage(event, inputSelector) {
            var input = $(inputSelector)[0];
            var previewContainer = $(inputSelector).siblings('div').find('img');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    if (previewContainer.length) {
                        previewContainer.attr('src', e.target.result).removeClass('hidden');
                    } else {
                        $(inputSelector).siblings('div').append('<img src="' + e.target.result + '" class="image-preview">').removeClass('hidden');
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleFileSelect(event, progressBarClass, duration = 1) {
    var fileInput = event.target;
    var file = fileInput.files[0];
    if (file) {
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();

        // Check if the file extension is either jpeg or png
        if (fileExtension !== 'jpeg' && fileExtension !== 'jpg' && fileExtension !== 'png') {
            alert('Please select a JPEG or PNG image file.');
            fileInput.value = ''; // Reset the input file field
            var progressBar = $(progressBarClass);
            progressBar.addClass('hidden'); // Hide the progress bar
            progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');
            return; // Exit the function if the file type is not supported
        }

        var fileSize = file.size;
        var uploaded = 0;
        var totalChunks = 100; // Total number of progress updates
        var chunkSize = fileSize / totalChunks;
        var intervalTime = (duration * 1000) / totalChunks; // Calculate interval time based on duration and totalChunks

        var progressBar = $(progressBarClass);
        progressBar.removeClass('hidden'); // Show the progress bar
        progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');

        var interval = setInterval(function() {
            if (uploaded < fileSize) {
                uploaded += chunkSize;
                if (uploaded > fileSize) {
                    uploaded = fileSize; // Ensure uploaded does not exceed file size
                }
                var percentComplete = (uploaded / fileSize) * 100;
                progressBar.css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(Math.floor(percentComplete) + '%');
            } else {
                clearInterval(interval);
                progressBar.css('width', '100%').attr('aria-valuenow', 100).text('100%');
            }
        }, intervalTime);
    }
}

    });
</script>


