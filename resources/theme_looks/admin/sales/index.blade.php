@extends('layouts.admin')
@section('title', 'Admin | sales')

@section('page-headder')
{{-- sales --}}
@endsection

@section('content')
<div class="row my-auto align-items-center bg-white shadow-md border mb-3 py-2">
    <div class="col-md-6">
        <span class="my-auto h6 page-headder">@yield('page-headder')</span>
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}" class="text-primary"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item text-dark"><a href="{{ route('admin.sales.index') }}">All Sells</a></li>
        </ol>
    </div>
    <div class="col-md-6">
        <ol class="float-right button">
            <a href="{{ route('admin.sales.create') }}" class="btn btn-success">New Sales</a>

        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12 p-0">
        <div class="card">
            <div class="card-header justify-content-between py-3">
                <h4 class="card-title float-left pt-2">All Sells</h4>
                <div class="float-right d-flex">
                    <form action="{{ route('admin.sales.index') }}" method="GET" class="float-right d-flex my-auto gap-3">
                        <div class="form-group mb-0 d-flex w-auto">
                            <input type="date" name="from_date" class="form-control mr-2" id="inputGroupFile02" placeholder="from_date" value="{{ request('from_date') }}">
                            <input type="date" name="to_date" class="form-control" id="inputGroupFile02" placeholder="to_date" value="{{ request('to_date') }}">
                        </div>

                        <div class="input-group py-0 my-0">
                            <input type="text" name="search" class="form-control" id="inputGroupFile02" placeholder="Search by name" value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-success input-group-text" for="inputGroupFile02"> <i class="fas fa-search"></i></button>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body card-body table-reHIDnsive p-0">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Sales Code</th>
                            <th>Sales Date</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>TAX</th>
                            <th>Paid Payment</th>
                            <th>Sales by</th>
                            <th>Sales Status</th>
                            <th>Paymet Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>


                    <tbody id="datatable">
                        @if (count($sells) > 0)
                        @foreach ($sells as $key => $sale)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $sale->sale_code }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y h:i A') }}</td>
                            <td>{{ number_format($sale->payable, 2) }}</td>
                            <td>{{ number_format($sale->discount, 2) }}</td>
                            <td>{{ number_format($sale->service_charge, 2) }}</td>

                            <td>
                                @php
                                $badgeClass = $sale->payable == $sale->grand_total ? 'badge badge-success' : 'badge badge-danger';
                                $statusText = $sale->grand_total == $sale->payable ? 'All Paid' : number_format($sale->grand_total, 2);
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                            </td>

                            <td> Admin </td>
                            <td>
                                @php
                                $badgeClass = $sale->sells_status == 1 ? 'badge badge-success' : 'badge badge-warning';
                                $statusText = $sale->sells_status == 1 ? 'Sells' : 'Processing';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                            </td>

                            <td>
                                @php
                                $badgeClass = $sale->payment_status == '1' ? 'badge badge-success' : 'badge badge-danger';
                                @endphp
                                <span class="{{ $badgeClass }}">{{ $sale->payment_status == '1' ? 'Paid' : 'Unpaid' }}</span>
                            </td>


                            <td>

                                <div class="btn-group bg-transparent dropleft" title="View Account">
                                    <a class="btn btn-o dropdown-toggle btn btn-info btn-sm text-light view border-0" data-toggle="dropdown" href="#"> Options <span class="caret"></span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu pull-left px-3 py-2" style="min-width:200px">
                                        <li class="py-1">
                                            <a title="View Invoice" class="dropdown-item" href="{{ route('admin.sales.show', $sale->id) }}">
                                                <i class="fa fa-fw fa-eye text-blue"></i> View Sales
                                            </a>
                                        </li>

                                        <li class="py-1">
                                            <a title="Update Record ?" class="dropdown-item" href="#">
                                                <i class="fa fa-fw fa-file-pdf text-blue"></i> PDF
                                            </a>
                                        </li>
                                        <li class="py-1">
                                            <a style="cursor:pointer" class="dropdown-item" title="Print POS Invoice ?" onclick="print_invoice(41)">
                                                <i class="fa fa-fw fa-file-text text-blue"></i> POS Invoice
                                            </a>
                                        </li>


                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr class="h-50">
                            <td colspan="13">
                                <h4 class="fs-4">No Record Found</h4>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>

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
                                    // Update or add the per_page parameter
                                    searchParams.set('per_page', perPage);
                                    // Redirect to the updated URL
                                    window.location.href = url.pathname + '?' + searchParams.toString();
                                }


                                // Function to fetch data and update the table body
                                function fetchDataAndPopulateTable() {
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const table = document.getElementById('datatable');
                                        const tableRow = table.querySelector('tr');

                                        // Display loading animation
                                        if (tableRow) {
                                            const loadingDiv =
                                                '<div id="loading-animation1" style="display: block; font-size: 50px; height: 100px; padding: 100px;"><i class="fas fa-spinner fa-spin"></i></div>';
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
                                <span id="showing-entries-from">{{ $sells->firstItem() }}</span>
                                to
                                <span id="showing-entries-to">{{ $sells->lastItem() }}</span>
                                of
                                <span id="total-entries">{{ $sells->total() }}</span>
                                entries
                            </div>
                        </div>
                        <!-- ... (remaining content) -->
                        {{ $sells->links('components.pagination.default') }}
                        {{-- {{ $sales->appends(request()->except('page'))->links() }} --}}


                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
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
    });

    document.addEventListener('DOMContentLoaded', function() {
        const showEntriesDropdown = document.getElementById('show-entries');
        const showingEntries = document.querySelectorAll('#showing-entries');
        const totalEntries = document.getElementById('total-entries');

        showEntriesDropdown.addEventListener('change', function() {
            const selectedValue = this.value;
            axios.get(`/admin/sales?show=${selectedValue}`)
                .then(response => {
                    // Update the number of displayed entries
                    showingEntries.forEach(span => {
                        span.textContent = response.data.showing;
                        console.log(response.data);
                    });
                    // Update the total number of entries
                    totalEntries.textContent = response.data.total;
                })
                .catch(error => {
                    console.error(error);

                });
        });
    });

</script>

@endpush
