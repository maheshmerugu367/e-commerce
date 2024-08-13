@extends('admin.dashboard')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




<div class="page-header">
    <h4 class=""> Sub Categories</h4>
</div>
<div class="content-wrapper">
    <div class="col-12 grid-margin stretch-card">


        <div class="card badge-light">
            <div class="card-body">

                <div class=" slider">
                    <div class="row">
                        <div class="col-sm-3 mb-1 mt-1">
                            <div class="form-group">
                                <div class="input-group">
                                <form action="{{ route('admin.subcategory.index') }}" method="GET">

                                    <input type="text" class="form-control" name="search" placeholder=" Search Categories">
                                    <div class="input-group-append">

                                    <select name="status" class="form-select form-select-sm">
                                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All</option>
                                                <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
                                 </select>

                                    <button type="submit">Search</button>

                                    </form>


                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- <div class="col-sm-3 mb-1 mt-1">
                            <div class="form-group">
                                <select class="form-control form-select" name="blog_type" id="blog_type">
                                    <option value="0">- Select Unit -</option>
                                    <option value="1">Article</option>
                                    <option value="2">Video</option>
                                    <option value="3">Interview QA</option>
                                </select>
                            </div>

                        </div> -->



                       



                        <div class="col-sm-8  text-end mt-2">
                            <a href="{{route('admin.subcategory.create')}}"> <label class="badge badge-success"><i class="mdi  mdi-plus-circle-outline me-1"></i>Add</label></a>
                            <a href="javascript:void(0);" id="activeSelected"> <label class="badge badge-info "><i class="mdi  mdi-check-circle-outline me-1"></i>Active</label></a>
                            <a href="javascript:void(0);" id="inactiveSelected">  <label class="badge badge-warning"><i class="mdi mdi-close-circle-outline me-1"></i>In Active</label></a>
                            <a href="javascript:void(0);" id="frontactiveSelected"> <label class="badge badge-info "><i class="mdi  mdi-check-circle-outline me-1"></i>front Active</label></a>
                            <a href="javascript:void(0);" id="frontinactiveSelected"> <label class="badge badge-info "><i class="mdi  mdi-check-circle-outline me-1"></i>front In-Active</label></a>

                            <a href="javascript:void(0);" id="deleteSelected"> <label class="badge badge-danger"><i class="mdi   mdi-delete me-1"></i> Delete</label></a>
                            <a href="javascript:void(0);" id="trashSelected"> <label class="badge badge-success"><i class="mdi   mdi-delete me-1"></i> Trash</label></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div></div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card mt-3">

            <div class="table-responsive">
                <div class="table-wrapper">
                    <table class="table table-striped ">
                        <thead class="table-dark">
                            <tr class="badge-secondary">
                                <th><input type="checkbox" id="checkall"></th>
                                <th>S.no</th>


                                <th>Sub Category </th>
                                <th>Category </th>

                                <th>App Icon</th>
                                <th>Web Image</th>
                                <th>Main Image</th>
                                <th>Status</th>
                                <th>Front Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($all_categories as $index =>$category)
                            <tr>
                               
                                <td>
                                        <input type="checkbox" class="CheckBoxClass" name="multiple[]" value="{{ $category->id }}">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$category->title}}</td>
                                <td>{{$category->category->title}}
                                <td>
                                @if($category->app_icon && \Storage::exists('public/' . $category->app_icon))
                                <img src="{{ asset('storage/' . $category->app_icon) }}" alt="App Icon" style="max-width: 100px; max-height: 100px;">
                                @else
                                <p>No Image</p>
                                @endif
                            </td>

                            <td>
                                @if($category->web_icon && \Storage::exists('public/' . $category->web_icon))
                                <img src="{{ asset('storage/' . $category->web_icon) }}" alt="Web Icon" style="max-width: 100px; max-height: 100px;">
                                @else
                                <p>No Image</p>

                                @endif
                            </td>

                            <td>
                                @if($category->main_image && \Storage::exists('public/' . $category->main_image))
                                <img src="{{ asset('storage/' . $category->main_image) }}" alt="Main Image" style="max-width: 100px; max-height: 100px;">
                                @else
                                <p>No Image</p>

                                @endif
                            </td>

                                <td>
                                        @if($category->status == '1')
                                            <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge fw-semibold py-1 w-85 bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                </td>

                                <td>
                                        @if($category->front_status == '1')
                                            <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge fw-semibold py-1 w-85 bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                </td>
        
                                <td class=""> 
                                <a href="{{ route('admin.subcategory.edit', ['id' => $category->id]) }}">
                                <i class=" mdi mdi-pencil-box-outline text-danger me-3 "></i></a>
                                </td>
                            </tr>

                        @endforeach
                           


                        </tbody>



                    </table>

                    <div class="d-flex">
                {!! $all_categories->links() !!}
            </div>

                </div>


            </div>

        </div>



    </div>

    <script>
    document.getElementById('checkall').addEventListener('change', function(e) {
        let checkboxes = document.querySelectorAll('.CheckBoxClass');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

    document.getElementById('deleteSelected').addEventListener('click', function() {
        let selectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            selectedIds.push(checkbox.value);
        });

        if (selectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', selectedIds);


            let userConfirmed = confirm("Are you sure you want to delete the records?");

            if (userConfirmed) {

                axios.post('{{ route("admin.subcategory.deleteSelected") }}', {
                        ids: selectedIds
                    })
                    .then(response => {
                        if (response.data.success) {
                            toastr.success(response.data.success);
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            toastr.error(response.data.error || 'An error occurred.');
                        }
                    })
                    .catch(error => {
                        // handle error
                    });
            }

           
           
        } else {
            alert('Please select at least one record to delete.');
        }
    });


    document.getElementById('trashSelected').addEventListener('click', function() {
        let trashselectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            trashselectedIds.push(checkbox.value);
        });

        if (trashselectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', trashselectedIds);

           
            axios.post('{{ route("admin.subcategory.trashSelected") }}', {
                ids: trashselectedIds
            })
            .then(response => {
                if(response.data.success) {
                    toastr.success(response.data.success);
                    setTimeout(function() {
                    location.reload();
                }, 2000);
                } else {
                    toastr.error(response.data.error || 'An error occurred.');
                }
            })
                .catch(error => {
                    // handle error
                });
        } else {
            alert('Please select at least one record.');
        }
    });


    document.getElementById('activeSelected').addEventListener('click', function() {
        let activeselectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            activeselectedIds.push(checkbox.value);
        });

        if (activeselectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', activeselectedIds);

           
            axios.post('{{ route("admin.subcategory.activeSelected") }}', {
                ids: activeselectedIds
            })
            .then(response => {
                if(response.data.success) {
                    toastr.success(response.data.success);
                    setTimeout(function() {
                    location.reload();
                }, 2000);
                } else {
                    toastr.error(response.data.error || 'An error occurred.');
                }
            })
                .catch(error => {
                    // handle error
                });
        } else {
            alert('Please select at least one record');
        }
    });

    document.getElementById('inactiveSelected').addEventListener('click', function() {
        let  inactiveselectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            inactiveselectedIds.push(checkbox.value);
        });

        if (inactiveselectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', inactiveselectedIds);

           
            axios.post('{{ route("admin.subcategory.inactiveSelected") }}', {
                ids: inactiveselectedIds
            })
            .then(response => {
                if(response.data.success) {
                    toastr.success(response.data.success);
                    setTimeout(function() {
                    location.reload();
                }, 2000);
                } else {
                    toastr.error(response.data.error || 'An error occurred.');
                }
            })
                .catch(error => {
                    // handle error
                });
        } else {
            alert('Please select at least one record');
        }
    });



    document.getElementById('frontactiveSelected').addEventListener('click', function() {
        let frontactiveselectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            frontactiveselectedIds.push(checkbox.value);
        });

        if (frontactiveselectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', frontactiveselectedIds);

           
            axios.post('{{ route("admin.subcategory.frontactiveSelected") }}', {
                ids: frontactiveselectedIds
            })
            .then(response => {
                
                if(response.data.success) {
                    toastr.success(response.data.success);
                    setTimeout(function() {
                    location.reload();
                }, 2000);
                } else {
                    toastr.error(response.data.error || 'An error occurred.');
                }
            })
                .catch(error => {
                    // handle error
                });
        } else {
            alert('Please select at least one record');
        }
    });


    document.getElementById('frontinactiveSelected').addEventListener('click', function() {
        let frontinactiveselectedIds = [];
        document.querySelectorAll('.CheckBoxClass:checked').forEach(checkbox => {
            frontinactiveselectedIds.push(checkbox.value);
        });

        if (frontinactiveselectedIds.length > 0) {
            // Send selectedIds to the server using AJAX or form submission
            console.log('Selected IDs:', frontinactiveselectedIds);

           
            axios.post('{{ route("admin.subcategory.frontinactiveSelected") }}', {
                ids: frontinactiveselectedIds
            })
            .then(response => {
                
                if(response.data.success) {
                    toastr.success(response.data.success);
                    setTimeout(function() {
                    location.reload();
                }, 2000);
                } else {
                    toastr.error(response.data.error || 'An error occurred.');
                }
            })
                .catch(error => {
                    // handle error
                });
        } else {
            alert('Please select at least one record');
        }
    });


</script>





    @endsection