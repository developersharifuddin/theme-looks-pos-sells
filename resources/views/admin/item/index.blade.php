@extends('layouts.admin')
@section('title', 'Admin | product')

@section('page-headder')
{{-- products --}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
<li class="breadcrumb-item text-dark"><a href="{{route('admin.products.index')}}">Product</a></li>
@endsection


@section('content')
<style>
    .form-switch {
        padding-left: 0em;
    }

    .form-check {
        /* display: block; */
        /* min-height: 1.5rem; */
        padding-left: 0em;
        /* margin-bottom: 0.125rem; */
    }

    .float-left {
        /* float: left!important; */
    }

</style>
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{route('admin.dashboard')}}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{route('admin.products.index')}}">Products</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            {{-- <span class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal"> Add New</span> --}}
            <a href="{{route('admin.products.create')}}" class="btn btn-success" rel="tooltip" id="add" title="add">
                Add New
            </a>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">All product</h4>

                <div class="float-right d-flex my-auto gap-3">

                    <form class="mb-0 pb-0" id="sort_products" action="" method="GET">
                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search">
                            <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body p-0 table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th class="image text-start">Image</th>
                            <th style="text-align: left !important; ">Product Name</th>
                            <th>Product SKU</th>
                            <th>Published Price(TK.)</th>
                            <th>Purchase Price(TK.)</th>
                            <th>Sells Price(TK.)</th>
                            <th>Sells Discount(TK.)</th>
                            <th>TAX%</th>
                            <th>Stock Qty.</th>
                            <th>Stock Status</th>
                            <th>Approved Status</th>
                            <th>Active Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="datatable">
                        @if(count($products) > 0)
                        @foreach($products as $key =>$item)
                        <tr>
                            <td>{{$key +1}}</td>
                            <td>
                                <img src="{{ asset('uploads/products/'.$item->thumbnail) }}" alt="{{$item->thumbnail}}" width="70">
                            </td>
                            <td class="product-name text-start" style="line-height:1.5; min-width:150px">
                                <p>{{$item->name}}</p>
                            </td>
                            <td>{{$item->sku}}
                            <td>{{$item->published_price}}</td>
                            <td>{{$item->purchase_price}}</td>
                            <td>{{$item->sell_price}}</td>
                            <td>{{$item->discount_amount}}</td>
                            <td>{{$item->tax}} </td>
                            <td>{{$item->current_stock}}</td>
                            <td>
                                @php
                                $badgeClass = ( $item->current_stock > 0) ? 'badge badge-success' : 'badge badge-danger';
                                $statusText = ( $item->current_stock > 0) ? 'In-Stock' : 'Out-Of-Stock';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                            </td>

                            <td>
                                @php
                                $badgeClass = ($item->approved_status == '1') ? 'badge badge-success' : 'badge badge-danger';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ ($item->approved_status == '1') ? 'Approved' : 'Un-Approved'}}</span>
                            </td>
                            <td>
                                @php
                                $badgeClass = ($item->status == '1') ? 'badge badge-success' : 'badge badge-danger';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ ($item->status == '1') ? 'Active' : 'In-Active'}}</span>
                            </td>

                            <td style="min-width:130px" class="d-flex my-4">


                                <a href="{{route('admin.products.edit', $item->id )}}" class="btn btn-primary btn-sm edit text-light border-0 edit" rel="tooltip" id="edit" title="Edit" data-id="4">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="{{route('admin.products.show', $item->id )}}" class="btn btn-info btn-sm text-light view border-0 view" id="view" rel="tooltip" title="view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="h-50">
                            <td colspan="17">
                                <h4 class="fs-4">No data found</h4>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

                <div class="pt-4 pb-2 px-4">
                    <div class="pagination d-flex justify-content-between">
                        <!-- ... (previous content) -->
                        <div class="d-flex">
                            <!-- Your Blade file -->

                            {{-- <form method="GET" action="{{ route('admin.products.index') }}">
                            <label for="per_page">Entries per Page:</label>
                            <select name="per_page" id="per_page" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="30" {{ request('per_page') == 30 ? 'selected' : '' }}>30</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                            </form> --}}

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
                                    // Update or add the per_page parameter
                                    searchParams.set('per_page', perPage);
                                    // Redirect to the updated URL
                                    window.location.href = url.pathname + '?' + searchParams.toString();
                                }


                                // Show loading animation
                                //  document.getElementById('loading-animation').style.display = 'block';

                                // Simulate a delay of 2 seconds
                                // setTimeout(function() {
                                // Hide loading animation
                                //    document.getElementById('loading-animation').style.display = 'none';

                                // Show category table
                                //    document.getElementById('category-table').style.display = 'table';
                                //}, 2000);





                                // Function to fetch data and update the table body
                                function fetchDataAndPopulateTable() {
                                    // Simulate a delay of 2 seconds
                                    //// document.addEventListener('DOMContentLoaded', function() {
                                    // const tableRow = document.getElementById('datatable').querySelector('tr');
                                    // Display loading animation
                                    //if (tableRow) {
                                    //  tableRow.innerHTML = '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                    // }
                                    //});

                                    document.addEventListener('DOMContentLoaded', function() {
                                        const table = document.getElementById('datatable');
                                        const tableRow = table.querySelector('tr');

                                        // Display loading animation
                                        if (tableRow) {
                                            const loadingDiv = '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
                                            tableRow.appendChild(loadingDiv);
                                            setTimeout(function() {

                                            }, 2000); // Adjust the time according to your needs
                                        }
                                    });


                                }

                                // Call the function when the page loads
                                fetchDataAndPopulateTable();

                            </script>

                            <!-- Information about displayed entries -->
                            <div class="dataTables_info pl-2">
                                Showing
                                <span id="showing-entries-from">{{ $products->firstItem() }}</span>
                                to
                                <span id="showing-entries-to">{{ $products->lastItem() }}</span>
                                of
                                <span id="total-entries">{{ $products->total() }}</span>
                                entries
                            </div>
                        </div>
                        <!-- ... (remaining content) -->
                        {{ $products->links('components.pagination.default') }}
                        {{-- {{ $products->appends(request()->except('page'))->links() }} --}}


                    </div>
                </div>
            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->



        {{-- add modal --}}
        <div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Add New product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>product Name</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="product Name English..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="Name Bangla..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Bin Number</label>
                                <input class="form-control" type="number" name="bin" placeholder="Bin Number..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Email</label>
                                <label>Email</label>
                                <input class="form-control" type="email" name="bin" placeholder="email..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Image</label>
                                <input class="form-control" type="file" name="Image" placeholder="Bin Number..." value="">
                            </div>


                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Address</label>
                                <textarea class="form-control" placeholder="Leave a  Address here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a  Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- edit modal --}}
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">Edit product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>product Name</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="product Name English..." value="madina group of industries Dhaka">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="Name Bangla..." value="madina group of industries Dhaka">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Bin Number</label>
                                <input class="form-control" type="number" name="bin" placeholder="Bin Number..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Email</label>
                                <input class="form-control" type="email" name="bin" placeholder="email..." value="">
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Image</label>
                                <input class="form-control" type="file" name="Image" placeholder="Bin Number..." value="">
                            </div>


                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Address</label>
                                <textarea class="form-control" placeholder="Leave a  Address here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a  Descriptions here.." id="floatingTextareadesc"></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-warning">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- view modal --}}
        <div class="modal fade" id="viewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addModalLabel">View product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-md-4">
                        <div class="row">
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>product Name</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="product Name English..." value="madina group of industries Dhaka" disabled>
                            </div>
                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Name Bangla</label>
                                <input class="form-control" type="text" name="HID-date" placeholder="Name Bangla..." value="madina group of industries Dhaka" disabled>
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Bin Number</label>
                                <input class="form-control" type="number" name="bin" placeholder="Bin Number..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Email</label>
                                <input class="form-control" type="email" name="bin" placeholder="email..." value="">
                            </div>

                            <div class="mb-3 col-md-4 col-lg-3">
                                <label>Image</label>
                                <input class="form-control" type="file" name="Image" placeholder="Bin Number..." value="">
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Address</label>
                                <textarea class="form-control" placeholder="Leave a  Address here.." id="floatingTextareadesc"></textarea>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="floatingTextareadesc"> Descriptions</label>
                                <textarea class="form-control" placeholder="Leave a  Descriptions here.." id="floatingTextareadesc" disabled></textarea>
                            </div>

                        </div>
                        <div class="mb-3 text-right">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.col -->

</div>
<!-- /.content -->
@endsection
@push('.js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        //$('#datepicker').datepicker();
        // $('#datepicker').datepicker({
        //    format: 'yyyy-mm-dd'
        //    , language: 'en'
        //    , autoclose: true
        //});
    });

</script>



{{-- <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/dataTables.reHIDnsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-reHIDnsive/js/reHIDnsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $("#example1").DataTable({
                "reHIDnsive": true
                , "lengthChange": false
                , "autoWidth": false
                , "searching": true
                , "ordering": true
                , "paging": true
                , "info": true
                , "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    });

</script> --}}
@endpush
