@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
@endsection
@section('content')

<link rel="stylesheet" href=link rel="stylesheet" href="{{asset('backend/dist/css/bootstrap-multiselect.css')}}">


<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Update</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ route('admin.products.index') }}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Products
            </a>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">Update product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.products.update', $itemInfo->id) }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-9 px-4">
                            <div class="row bg-light">

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('name', $itemInfo->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="unit">Unit</label>
                                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('unit', $itemInfo->unit) }}">
                                        @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="unit_value">Unit Value</label>
                                        <input type="text" name="unit_value" class="form-control @error('unit_value') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('unit_value', $itemInfo->unit_value) }}">
                                        @error('unit_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>



                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="published_price">Published Price</label>
                                        <input type="number" name="published_price" class="form-control @error('published_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('published_price', $itemInfo->published_price) }}">
                                        @error('published_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('purchase_price', $itemInfo->purchase_price) }}">
                                        @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="discount_type">Discount %<span class="text-danger">*</span></label>
                                        <input name="discount_type" type="number" min="0" max="100" step="1" class="form-control @error('') is-invalid @enderror" id="discount_type" placeholder="discount %.." value="{{ old('discount_type', $itemInfo->discount_type) }}">
                                        @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="tax">TAX %<span class="text-danger">*</span></label>
                                        <input name="tax" type="number" min="0" max="100" step="1" class="form-control @error('') is-invalid @enderror" id="tax" placeholder="tax.." value="{{ old('tax', $itemInfo->tax) }}">
                                        @error('tax')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sell_price">Sales Price</label>
                                        <input type="number" name="sell_price" class="form-control @error('sell_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{ old('sell_price', $itemInfo->sell_price) }}">
                                        @error('sell_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sku">SKU</label>
                                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" id="sku" placeholder="Reference No.." value="{{ old('sku', $itemInfo->sku) }}">
                                        @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>





                            </div>
                        </div>

                        <div class="col-md-3 px-4">
                            <div class="row bg-white">

                                <div class="mb-3 col-md-12">
                                    <label>Cover Image</label>
                                    <input class="form-control" type="file" name="thumbnail" placeholder="Cover Number..." value="">
                                    <img class="mt-2" src="{{ asset('uploads/products/'.$itemInfo->thumbnail) }}" alt="{{$itemInfo->thumbnail}}" width="100">

                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="my-4 text-right">
                        <a type="button" class="btn btn-danger" href="{{ route('admin.products.index') }}">Cancel</a>
                        <button type="submit" class="btn home-details-btn btn-success">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->


    </div>
    <!-- /.col -->

</div>
<!-- /.content -->
@endsection
