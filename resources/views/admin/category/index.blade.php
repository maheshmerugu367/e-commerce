@extends('admin.dashboard')
@section('content')

<div class="page-header">
    <h4 class="">  Categories</h4>
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
                                    <input type="text" class="form-control" placeholder=" Search">
                                    <div class="input-group-append">
                                        <i class="mdi mdi-magnify"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-3 mb-1 mt-1">
                            <div class="form-group">
                                <select class="form-control form-select" name="blog_type" id="blog_type">
                                    <option value="0">- Select Unit -</option>
                                    <option value="1">Article</option>
                                    <option value="2">Video</option>
                                    <option value="3">Interview QA</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-sm-6  text-end mt-2">
                            <a href="add_menu.php"> <label class="badge badge-success"><i class="mdi  mdi-plus-circle-outline me-1"></i>Add</label></a>
                            <label class="badge badge-info "><i class="mdi  mdi-check-circle-outline me-1"></i>Active</label>
                            <label class="badge badge-warning"><i class="mdi mdi-close-circle-outline me-1"></i>In Active</label>
                            <a href=""> <label class="badge badge-danger"><i class="mdi   mdi-delete me-1"></i> Delete</label></a>
                            <a href=""> <label class="badge badge-success"><i class="mdi   mdi-delete me-1"></i> Trash</label></a>


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
                                <th>Category Title</th>
                                <th>App Icon</th>
                                <th>Web Image</th>
                                <th>Main Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($all_categories as $index =>$category)
                            <tr>
                                <td>
                                    <input type="checkbox" class="CheckBoxClass" name="multiple[]" value="1">
                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{$category->title}}</td>
                                <td><img src="{{asset('storage/'.$category->app_icon)}}"></td>
                                <td><img src="{{asset('storage/'.$category->web_icon)}}"></td>
                                <td><img src="{{asset('storage/'.$category->main_image)}}"></td>


                                <td>
                                        @if($category->status == '1')
                                            <span class="badge fw-semibold py-1 w-85 bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge fw-semibold py-1 w-85 bg-danger-subtle text-danger">Inactive</span>
                                        @endif
                                </td>

        
                                <td class=""> 
                                <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}">
                                <i class=" mdi mdi-pencil-box-outline text-danger me-3 "></i></a>
                                </td>
                            </tr>

                        @endforeach
                           


                        </tbody>



                    </table>
                </div>


            </div>

        </div>



    </div>





    @endsection