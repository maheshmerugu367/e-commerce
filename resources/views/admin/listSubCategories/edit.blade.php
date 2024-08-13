@extends('admin.dashboard')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
    <h4>Edit List Sub Category</h4>
    <a href="{{route('admin.list.subcategories.index')}}" class="">
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

                    <form id="uploadForm" action="{{ route('admin.list.subcategories.update') }}" class="form-sample" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">



                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>Category Title<span class="text-danger">*</span></label>

                                    <select class="form-select" name="category_id">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)

                                        <option value="{{ $category->id }}" {{ old('category_id', $list_sub_category->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->title }}
                                        </option>


                                        @endforeach

                                    </select>


                                    @if ($errors->has('category_id'))
                                    <div class="error-message">
                                        @foreach ($errors->get('category_id') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Sub Category Title<span class="text-danger">*</span></label>
                                    <select class="form-select" name="sub_category_id">
                                        <option value="">Select</option>
                                        @foreach($sub_categories as $sub_category)
                                
                                        <option value="{{ $sub_category->id }}" {{ old('sub_category_id', $list_sub_category->sub_category_id) == $sub_category->id ? 'selected' : '' }}>
                                            {{ $sub_category->title }}
                                        </option>

                                        @endforeach

                                    </select>


                                    @if ($errors->has('sub_category_id'))
                                    <div class="error-message">
                                        @foreach ($errors->get('sub_category_id') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">

                                    <input type="hidden" name="id" class="form-control form-control-lg" value="{{ $list_sub_category->id }}" placeholder="Enter list_sub_category Title" aria-label="Title">

                                    <label>list Sub Category Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $list_sub_category->title) }}"  placeholder="Enter  list Sub Category Title " aria-label="Title">
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
                                    <label>App Icon (100x100)</label>
                                    <label for="appIconFile" class="btn btn-primary btn-sm">Choose Image</label>

                                    <input type="file" name="appIcon" id="appIconFile" style="display: none;">
                                    @if ($list_sub_category->app_icon)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$list_sub_category->app_icon) }}" alt="App Icon Preview" style="width:80px;height:80px;" class="image-preview">

                                        <button type="button"
                                            class="btn btn-danger"
                                            onclick="confirmDeleteAppIcon('{{ route('admin.list.subcategory.delete.app.icon', ['id' => $list_sub_category->id]) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
                                    <label>Web Icon (100x100)</label>
                                    <label for="webIconFile" class="btn btn-primary btn-sm">Choose Image</label>

                                    <input type="file" name="webIcon" id="webIconFile" style="display :none;">
                                    @if ($list_sub_category->web_icon)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$list_sub_category->web_icon) }}" alt="Web Icon Preview" class="image-preview" style="width:80px;height:80px;">



                                        <button type="button"
                                            class="btn btn-danger"
                                            onclick="confirmDeleteWebIcon('{{ route('admin.list.subcategory.delete.web.icon', ['id' => $list_sub_category->id]) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                        </a>
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
                                    <label>Main Image (100x100)</label>
                                    <label for="mainImageFile" class="btn btn-primary btn-sm">Choose Image</label>

                                    <input type="file" name="mainImage" id="mainImageFile" style="display:none;">
                                    @if ($list_sub_category->main_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/'.$list_sub_category->main_image) }}" alt="Main Image Preview" class="image-preview" style="width:80px;height:80px;">


                                        <button type="button"
                                            class="btn btn-danger"
                                            onclick="confirmDeleteMainIcon('{{ route('admin.list.subcategory.delete.main.icon', ['id' => $list_sub_category->id]) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>

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






                        </div>




                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select class="form-control" name="status">
                                        <option value="0" {{ $list_sub_category->status == 0 ? 'selected' : '' }}>InActive</option>
                                        <option value="1" {{ $list_sub_category->status == 1 ? 'selected' : '' }}>Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Priority<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="priority" value="{{ old('priority', $list_sub_category->priority) }}"   />
                                    @if ($errors->has('priority'))
                                    <div class="error-message">
                                        @foreach ($errors->get('priority') as $error)
                                        <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="seoTitle">SEO Title</label>
                                    <input type="text" class="form-control" id="seoTitle" name="seo_title" value="{{$list_sub_category->seo_title}}" placeholder="Enter SEO Title">
                                </div>
                            </div>



                        </div>

                        <div class="row">







                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="seoDescription">SEO Description</label>
                                    <textarea class="form-control" id="seoDescription" name="seo_description" placeholder="Enter SEO Description">{{$list_sub_category->seo_description}}</textarea>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="seoKeywords">SEO Keywords</label>
                                    <textarea class="form-control" id="seoDescription" name="seo_keywords" placeholder="Enter SEO Description">{{$list_sub_category->seo_keywords}}</textarea>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 text-center mt-4">
                            <button type="submit" id="submitBtn" class="btn btn-gradient-success btn-fw">
                                <i class="mdi mdi-arrow-right-bold-hexagon-outline"></i> UPDATE
                            </button>
                            <a href="{{ route('admin.subcategory.index') }}" class="btn btn-info">
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


    <script>
        document.getElementById('appIconFile').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagePreview');
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                    } else {
                        var imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.alt = 'App Icon Preview';
                        imgElement.className = 'image-preview';
                        document.querySelector('.form-group').appendChild(imgElement);
                    }
                };

                reader.readAsDataURL(file);
            }
        });

        // Initially hide "No file chosen" text if a file is already uploaded
        document.getElementById('fileName').textContent = "{{ $list_sub_category->app_icon ? '' : 'No file chosen' }}";
    </script>


    <script>
        document.getElementById('webIconFile').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagePreview');
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                    } else {
                        var imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.alt = 'Web Icon Preview';
                        imgElement.className = 'image-preview';
                        document.querySelector('.form-group').appendChild(imgElement);
                    }
                };

                reader.readAsDataURL(file);
            }
        });

        // Initially hide "No file chosen" text if a file is already uploaded
        document.getElementById('fileName').textContent = "{{ $list_sub_category->app_icon ? '' : 'No file chosen' }}";
    </script>


    <script>
        document.getElementById('mainImageFile').addEventListener('change', function() {
            alert()
            var file = this.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imagePreview = document.getElementById('imagePreview');
                    if (imagePreview) {
                        imagePreview.src = e.target.result;
                    } else {
                        var imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.alt = 'Main Icon Preview';
                        imgElement.className = 'image-preview';
                        document.querySelector('.form-group').appendChild(imgElement);
                    }
                };

                reader.readAsDataURL(file);
            }
        });

        // Initially hide "No file chosen" text if a file is already uploaded
        document.getElementById('fileName').textContent = "{{ $list_sub_category->app_icon ? '' : 'No file chosen' }}";
    </script>


    <script>
        function confirmDeleteAppIcon(url) {
            // Display confirmation dialog
            let userConfirmed = confirm("Are you sure you want to delete this app icon?");

            if (userConfirmed) {
                // Redirect to the delete URL
                window.location.href = url;
            }
        }


        function confirmDeleteWebIcon(url) {
            // Display confirmation dialog
            let userConfirmed = confirm("Are you sure you want to delete this Web icon?");

            if (userConfirmed) {
                // Redirect to the delete URL
                window.location.href = url;
            }
        }



        function confirmDeleteMainIcon(url) {
            // Display confirmation dialog
            let userConfirmed = confirm("Are you sure you want to delete this Main icon?");

            if (userConfirmed) {
                // Redirect to the delete URL
                window.location.href = url;
            }
        }
    </script>