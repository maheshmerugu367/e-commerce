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


</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="page-header">
    <h4 class=""> Categories </h4> <a href="categories_menu.php" class=" "> <label class="badge badge-info"><i class="mdi mdi-apps"></i> Manage</label></a>
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

                    <form id="uploadForm" action="{{route('admin.category.store')}}" class="form-sample" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Category Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Category Title" aria-label="Title">

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


                                    <div class="progress mt-2 hidden">
                                        <div class="progress-bar app-icon-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>


                                    </div>

                                    @if ($errors->has('appIcon'))
                                        <div class="error-message">
                                           @foreach ($errors->get('appIcon') as $error)
                                             <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Web Icon </label>
                                    <input type="file" name="webIcon" id="webIconFile">


                                    <div class="progress mt-2 hidden">
                                        <div class="progress-bar web-icon-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>

                                    @if ($errors->has('webIcon'))
                                        <div class="error-message">
                                           @foreach ($errors->get('webIcon') as $error)
                                             <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Main Image </label>
                                    <input type="file" name="mainImage" id="mainImageFile">

                                    <div class="progress mt-2 hidden">
                                        <div class="progress-bar main-image-progress" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                    </div>

                                    @if ($errors->has('mainImage'))
                                        <div class="error-message">
                                           @foreach ($errors->get('mainImage') as $error)
                                             <p>{{ $error }}</p>
                                            @endforeach
                                        </div>
                                    @endif

                                </div>

                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status<span class="text-danger">*</span></label>

                                    <select class="form-control">
                                        <option>--Select --</option>
                                        <option value="0">InActive</option>
                                        <option value="1" selected>Active</option>

                                    </select>


                                </div>
                            </div>


                             <div class="col-md-3">
                                <div class="form-group">
                                <label>Priority<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="priority"  />

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
                           
                            <div class="co-lg-12 text-center mt-4">
                                <button type="submit" id="submitBtn" class="btn btn-gradient-success btn-fw  "><i class="mdi mdi-arrow-right-bold-hexagon-outline "></i>
                                    SUBMIT</button>
                                <button type="button" class="btn btn-info  ">
                                    <i class="mdi mdi-arrow-left-bold-circle"></i> BACK</button>

                            </div>
                    </form>

                </div>


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
                document.querySelector('select'),
                document.querySelector('input[name="appIcon"]'),
                document.querySelector('input[name="webIcon"]'),
                document.querySelector('input[name="mainImage"]'),
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
        // File input change event listeners
        $('#appIconFile').on('change', function(e) {

            handleFileSelect(e, '.app-icon-progress');

            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });
        $('#webIconFile').on('change', function(e) {
            handleFileSelect(e, '.web-icon-progress');
            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });
        $('#mainImageFile').on('change', function(e) {
            handleFileSelect(e, '.main-image-progress');
            var progressBarClass = $(this).closest('.form-group').find('.progress');
            progressBarClass.removeClass('hidden');
        });

        function handleFileSelect(event, progressBarClass) {
            var file = event.target.files[0];
            if (file) {
                var fileSize = file.size;
                var uploaded = 0;
                var chunkSize = fileSize / 100; // Assuming we divide the file into 100 chunks

                // var progressBar = $(progressBarClass);
                // progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');

                var progressBar = $(progressBarClass);
            progressBar.removeClass('hidden'); // Show the progress bar
            progressBar.css('width', '0%').attr('aria-valuenow', 0).text('0%');

                var interval = setInterval(function() {
                    if (uploaded < fileSize) {
                        uploaded += chunkSize;
                        var percentComplete = (uploaded / fileSize) * 100;
                        progressBar.css('width', percentComplete + '%').attr('aria-valuenow', percentComplete).text(Math.floor(percentComplete) + '%');
                    } else {
                        clearInterval(interval);
                    }
                }, 50); // Adjust the interval speed as needed
            }
        }

       
        function clearErrors() {
            $('#titleError').empty();
            $('#appIconError').empty();
            $('#webIconError').empty();
            $('#mainImageError').empty();
        }

        function displayErrors(errors) {
            clearErrors();
            $.each(errors, function(key, value) {
                $('#' + key + 'Error').text(value[0]);
            });
        }
    });
</script>
