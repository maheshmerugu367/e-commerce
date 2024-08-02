@extends('admin.dashboard')


@section('content')

    <div class="page-header">
        <h4 class=""> Categories </h4> <a href="categories_menu.php" class=" "> <label class="badge badge-info"><i class="mdi mdi-apps"></i> Manage</label></a>
    </div>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-5">
                        <form class="form-sample">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" placeholder="Enter Menu Title" aria-label="Title">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>App Icon</label>
                                        <input type="file" name="file" id="file" class="input-file">
                                        <label for="file" class="btn btn-tertiary js-labelFile">
                                            <i class="i mdi mdi-arrow-up-bold-circle "></i>
                                            <span class="js-fileName">Choose a file</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>web Icon </label>
                                        <input type="file" name="file" id="file" class="input-file">
                                        <label for="file" class="btn btn-tertiary js-labelFile">
                                            <i class="i mdi mdi-arrow-up-bold-circle "></i>
                                            <span class="js-fileName">Choose a file</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Main Image </label>
                                        <input type="file" name="file" id="file" class="input-file">
                                        <label for="file" class="btn btn-tertiary js-labelFile">
                                            <i class="i mdi mdi-arrow-up-bold-circle "></i>
                                            <span class="js-fileName">Choose a file</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="co-lg-12 text-center mt-4">
                                    <button type="button" class="btn btn-gradient-success btn-fw  "><i class="mdi mdi-arrow-right-bold-hexagon-outline "></i>
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