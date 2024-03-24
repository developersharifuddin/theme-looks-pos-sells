@extends('layouts.admin')
@section('title', 'Admin | sells')

@section('page-headder')
{{-- Categories --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-sm-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sales.index') }}"> Sales</a></li>

        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ route('admin.sales.index') }}" class="btn btn-success">Sales</a>

        </ol>
    </div>
</div>

@include('admin.sales.partials.style')


<div class="row">
    <div class="col-md-7 p-0">
        <div class="card">
            <div class="card-header bg-light ">
                <h6 class="text-dark">Our Products</h6>
                <form id="searchForm" action="{{ route('admin.sales.create') }}" method="GET">
                    @csrf
                    @method('GET')
                    <div class="d-flex justify-content-start">

                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="search" name="search" value="" placeholder="Search by name or SKU..." class="form-control" id="inlineFormInputGroup">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-search"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="productContainer" class="row card-body px-4">
                <div id="item-list" class="row card-body px-3">
                    @include('admin.sales.partials.product_item')
                    <div class="pt-4 pb-2 px-4">
                        <div class="pagination d-flex justify-content-between">
                            <!-- ... (previous content) -->
                            <div class="d-flex">

                                <label for="per_page">Entries per Page:</label>
                                <select name="per_page" id="per_page" onchange="updateQueryString()">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>

                                <script>
                                    function updateQueryString() {
                                        var perPage = document.getElementById('per_page').value;
                                        var currentUrl = window.location.href;
                                        var url = new URL(currentUrl);
                                        var searchParams = new URLSearchParams(url.search);
                                        searchParams.set('per_page', perPage);
                                        window.location.href = url.pathname + '?' + searchParams.toString();
                                    }


                                    function fetchDataAndPopulateTable() {

                                        document.addEventListener('DOMContentLoaded', function() {
                                            const table = document.getElementById('datatable');
                                            const tableRow = table.querySelector('tr');

                                            if (tableRow) {
                                                const loadingDiv =
                                                    '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                                tableRow.appendChild(loadingDiv);
                                                setTimeout(function() {

                                                }, 2000);
                                            }
                                        });


                                    }

                                    fetchDataAndPopulateTable();

                                </script>

                                <div class="dataTables_info pl-2">
                                    Showing
                                    <span id="showing-entries-from">{{ $items->firstItem() }}</span>
                                    to
                                    <span id="showing-entries-to">{{ $items->lastItem() }}</span>
                                    of
                                    <span id="total-entries">{{ $items->total() }}</span>
                                    entries
                                </div>
                            </div>
                            <!-- Pagination Links -->
                            <div id="pagination-links">
                                {{ $items->links('components.pagination.default') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 p-0">
        <form action="{{ route('admin.sales.store') }}" class="form-horizontal" id="sales-form" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
            @csrf
            @method('POST')
            <div class="card ml-3 bg-ifo">
                <div class="card-header justify-content-between py-3">
                    <h6 class="card-title float-left">POS Sells</h6>


                </div>
                <!-- /.card-header -->
                <div class="card-body p-2">
                    <div class="row mt-2">
                        <div class="col-md-12 mb-3">

                            <section id="cart_container" class="cart-content">
                                <div class="card-body p-0">
                                    <table class="table table-hover shadow-none" id="itemTable">
                                        <span id="nfp"></span>

                                        <div class="d-flex justify-content-center">
                                            <style>
                                                .viewer {
                                                    position: absolut;
                                                    z-index: 5;
                                                }

                                                svg {
                                                    overflow: hidden;
                                                    vertical-align: middle;
                                                    width: 80px;
                                                    height: 80px;
                                                }

                                            </style>
                                            <div class="text-info mb-3 mt-0 pb-5 pt-0" role="status" id="loader">
                                                <div class="viewer" style=" width:30px; height:30px">
                                                    <div class="inner" style="width: 90px; height: 90px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                                                            <circle cx="27.5" cy="57.5" r="5" fill="#fe718d">
                                                                <animate attributeName="cy" calcMode="spline" keySplines="0 0.5 0.5 1;0.5 0 1 0.5;0.5 0.5 0.5 0.5" repeatCount="indefinite" values="57.5;42.5;57.5;57.5" keyTimes="0;0.3;0.6;1" dur="0.7194244604316546s" begin="-0.43165467625899273s"></animate>
                                                            </circle>
                                                            <circle cx="42.5" cy="57.5" r="5" fill="#f47e60">
                                                                <animate attributeName="cy" calcMode="spline" keySplines="0 0.5 0.5 1;0.5 0 1 0.5;0.5 0.5 0.5 0.5" repeatCount="indefinite" values="57.5;42.5;57.5;57.5" keyTimes="0;0.3;0.6;1" dur="0.7194244604316546s" begin="-0.32374100719424453s"></animate>
                                                            </circle>
                                                            <circle cx="57.5" cy="57.5" r="5" fill="#f8b26a">
                                                                <animate attributeName="cy" calcMode="spline" keySplines="0 0.5 0.5 1;0.5 0 1 0.5;0.5 0.5 0.5 0.5" repeatCount="indefinite" values="57.5;42.5;57.5;57.5" keyTimes="0;0.3;0.6;1" dur="0.7194244604316546s" begin="-0.21582733812949637s"></animate>
                                                            </circle>
                                                            <circle cx="72.5" cy="57.5" r="5" fill="#abbd81">
                                                                <animate attributeName="cy" calcMode="spline" keySplines="0 0.5 0.5 1;0.5 0 1 0.5;0.5 0.5 0.5 0.5" repeatCount="indefinite" values="57.5;42.5;57.5;57.5" keyTimes="0;0.3;0.6;1" dur="0.7194244604316546s" begin="-0.10791366906474818s"></animate>
                                                            </circle>
                                                        </svg></div>
                                                </div>
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>

                                        <thead>
                                            <tr>
                                                <th>S/L</th>
                                                <th class="text-start">Item Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody id="itemTableBody">
                                            <tr class="bg-primary">
                                                <td colspan="9" id="default" class="py-3">
                                                    <h6 class="text-info mb-0 pb-0"><i class="fa fa-cart-shopping"></i> Your Cart is Empty</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </section>

                            <input type="hidden" name="country_id" id="country_id_form">
                            <input id="cart_id" type="hidden" multiple="" name="cart_id" value="">
                            <input type="hidden" value="" name="gift_wrap" id="has_gift">
                        </div>

                        <div class="col-md-12">
                            <div class="bg-white p-1">
                                <section id="checkout-sidebar" class="check-sidebar">
                                    <div class="checkout-sidebar__header">
                                        <h5>Checkout Summary</h5>
                                    </div>

                                    <div class="checkout-sidebar__content">
                                        <table class="col-md-12 mb-3">
                                            <tbody>
                                                <tr>
                                                    <th class="text-right" style="font-size: 12px;">Total Product
                                                        Quantity: </th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="total_product_qty" class="total_product_qty" name="total_product_qty">0.00 TK</b>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th class="text-right" style="font-size: 12px;">Subtotal:</th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="subtotal_amt" name="subtotal_amt" class="subtotal_amt">0.00 TK</b>
                                                    </th>
                                                </tr>
                                                <tr class="d-none">
                                                    <th class="text-right" style="font-size: 12px;">Others Charge/Service Charge:
                                                    </th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="other_charges_amt" name="other_charges_amt">0.00 TK</b>
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th class="text-right" style="font-size: 12px;">Product Discount:
                                                    </th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="product_discount" name="product_discount">0.00 TK</b>
                                                    </th>
                                                </tr>

                                                <tr>
                                                    <th class="text-right" style="font-size: 12px;">TAX:
                                                    </th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="tax" name="tax">0.00 TK</b>
                                                    </th>
                                                </tr>


                                                <tr>
                                                    <th class="text-right" style="font-size: 12px;">Grand Total:
                                                    </th>
                                                    <th class="text-right" style="padding-left:10%;font-size: 12px;">
                                                        <b id="grand_total" name="total_amt">0.00 TK</b>
                                                    </th>
                                                </tr>

                                            </tbody>
                                        </table>
                                        <div class="row d-none">
                                            <div class="form-group col-12 col-md-12 col-lg-6">
                                                <label for="amount">Total Payable
                                                    Amount</label>
                                                <div class="input-group">
                                                    <input type="number" name="total_payable_amount" placeholder="total_payable_amount" class="form-control @error('total_payable_amount') is-invalid @enderror" id="total_payable_amount" readonly>
                                                </div>
                                                @error('total_payable_amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="service_charge">Service Charge(BDT)</label>
                                                    <div class="input-group">
                                                        <input type="number" name="service_charge" onchange="updateServiceCharge()" placeholder="service charge.." min="0" class="form-control @error('service_charge') is-invalid @enderror" id="service_charge">
                                                    </div>
                                                    @error('service_charge')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 text-right">
                        <button type="submit" class="btn home-details-btn btn-success btn-block">Save</button>
                        <a type="button" class="btn btn-primary btn-block" href="{{ route('admin.sales.index') }}">Cancel</a>
                    </div>
                </div>
        </form>

    </div>
    <!-- /.content -->

    @endsection

    @push('.js')

    @include('admin.sales.partials.script')

    @endpush
