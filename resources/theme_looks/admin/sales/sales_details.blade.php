@extends('layouts.admin')
@section('title', 'Admin | sales')

@section('page-headder')
{{-- sales --}}
@endsection

@section('content')
<style>
    .invoice-info {
        font-size: 13px;
    }

</style>
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sales.index') }}">sales</a></li>
        </ol>
    </div>
    <div class="col-md-6">

    </div>
</div>




<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable text-center" style="display: none;">
                        <a href="javascript:void()" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <strong>Success!! Record Saved Successfully! SMS Has been Sent!</strong>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="invoice p-4">
                <!-- Title row -->
                <div class="printableArea">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4 class="page-header fw-bold mb-4">
                                <img src="{{ asset('backend/dist/img/software-development.png') }}" class="img" alt="User Image" style="height: 44px; width:auto;">
                                </i> Service Sales Invoice
                            </h4>
                        </div>
                    </div>

                    <!-- Info row -->
                    <div class="row invoice-info">

                        <!-- Invoice Details -->
                        <div class="col-sm-5 invoice-info" style="line-height:1">
                            <p><b>Invoice:</b> #{{$sell->sale_code}}</p>
                            <p> <b>Date:</b> {{ $sell->created_at->format('M d, Y h:i:s A') }}</p>

                            <p><b>Sales Status:</b> {{$sell->sells_status == 1 ? 'Sells' : 'Processing';}} </p>
                            <p><b>Reference No.:</b> {{$sell->ref_no}}</p>
                        </div>


                        <!-- Customer Details -->
                        <div class="col-sm-7 invoice-col text-right">

                            <h5>Customer Details</h5>
                            <address style="line-height:1.5">
                                <strong>Customer Name: {{$sell->customername}}</strong><br>
                                Mobile: {{$sell->customerphone}}<br>
                                Email: {{ $sell->customeremail ? $sell->customeremail : 'No email available' }}

                                <br>Address: {{$sell->customeraddress}}
                            </address>
                        </div>

                    </div>
                    <!-- /.row -->

                    <div class="row mt-4 mb-0">
                        <div class="table-responsive">
                            <table class="table table-striped records_table table-bordered pb-0 mb-0">
                                <thead class="bg-gray-active">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th class="text-start">Item Name</th>
                                        <th>Quantity</th>
                                        <th>Published Price (BDT)</th>
                                        <th>Discount Amount (BDT)</th>
                                        <th>Sell Price (BDT)</th>
                                        <th>Total Amount (BDT)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sellItem as $key => $item)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td> <img src="{{ asset('uploads/products/'.$item->itemthumbnail) }}" alt="{{$item->itemthumbnail}}" width="70"></td>

                                        <td class="product-name text-start" style="line-height:1.5; min-width:150px">
                                            <p>{{$item->itemname}}</p>
                                        </td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->published_price}} TK.</td>
                                        <td>{{$item->discount_amount}} TK.</td>
                                        <td>{{$item->sell_price}} TK.</td>
                                        <td>{{$item->sub_total}} TK.</td>
                                    </tr>
                                    @endforeach
                                <tfoot class="col-md-12 tfoot table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">Subtotal</td>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">
                                                <h6><b id="subtotal_amt" name="subtotal_amt">{{$sell->grand_total}} TK.</b></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;"> </td>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">
                                                <h6><b id="otder_charges_amt" name="otder_charges_amt">{{$sell->service_charge}} TK.</b></h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">Payable Amount</td>
                                            <td colspan="7" class="text-right" style="font-size: 13px;">
                                                <h6><b id="total_amt" name="total_amt">{{$sell->payable}} TK.</b></h6>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                            </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="row no-print py-3">
                        <div class="col-xs-12">


                        </div>
                    </div>
            </section>
            <!-- /.content -->
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- /.content -->
@endsection
