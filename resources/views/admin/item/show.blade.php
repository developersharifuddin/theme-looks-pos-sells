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
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.products.create') }}">Create</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            {{-- <span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span> --}}
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
                <h4 class="card-title float-left pt-2">Create New product</h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body bg-light">
                <form action="{{ route('admin.products.store') }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-9 px-4">
                            <div class="row bg-light">

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->name}}" disabled>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="unit">unit</label>
                                        <input type="number" name="unit" class="form-control @error('unit') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->unit}}" disabled>
                                        @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="unit_value">Unit Value</label>
                                        <input type="number" name="unit_value" class="form-control @error('unit_value') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->unit_value}}" disabled>
                                        @error('unit_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="published_price">Published Price</label>
                                        <input type="number" name="published_price" class="form-control @error('published_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->published_price}}" disabled>
                                        @error('published_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->purchase_price}}" disabled>
                                        @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for="published_price">Discount %<span class="text-danger">*</span></label>
                                    <div class="flex-wrap d-flex">
                                        <div style="flex-basis:45%">
                                            <input name="discount_type" type="text" class="form-control @error('discount_type') is-invalid @enderror" id="discount_type" placeholder="Discount Type.." value="{{ $itemInfo->discount_type }}" disabled>
                                            @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div style="flex-basis:55%">
                                            <input name="discount_amount" type="number" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" placeholder="Discount Amount.." value="{{ $itemInfo->discount_amount }}" disabled>
                                            @error('discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-4 col-lg-3">
                                    <label for="published_price">TAX %<span class="text-danger">*</span></label>
                                    <div class="flex-wrap d-flex">
                                        <div style="flex-basis:45%">
                                            <input name="tax" type="text" class="form-control @error('tax') is-invalid @enderror" id="tax" placeholder="Discount Type.." value="{{ $itemInfo->tax}}" disabled>
                                            @error('tax')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div style="flex-basis:55%">
                                            <input name="tax_amount" type="number" class="form-control @error('tax_amount') is-invalid @enderror" id="tax_amount" placeholder="tax Amount.." value="{{ $itemInfo->tax_amount }}" disabled>
                                            @error('tax_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sell_price">Sales Price</label>
                                        <input type="number" name="sell_price" class="form-control @error('sell_price') is-invalid @enderror" id="Reference No" placeholder="Reference No.." value="{{$itemInfo->sell_price}}" disabled>
                                        @error('sell_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>




                                <div class="mb-3 col-md-4 col-lg-3">
                                    <div class="form-group">
                                        <label for="sku">SKU</label>
                                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" id="sku" placeholder="Reference No.." value="{{ old($itemInfo->sku ?? "") }}" disabled>
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
                                    <label>Cover Image</label> <br>

                                    <img src="{{ asset('uploads/products/'.$itemInfo->thumbnail) }}" alt="{{$itemInfo->thumbnail}}" width="250">

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="my-4 text-right">
                        <a class="btn btn-lg btn-danger" href="{{ route('admin.products.index') }}">Close</a>
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
