 <div id="productContainer" class="row card-body px-2">
     @if (count($items) > 0)


     @foreach ($items as $item)
     <div class="col-4 col-xl-3 borde p-0" title="{{ $item->name }}">
         <div class="product-list-wrapper text-center m-1 border p-2" @if ($item->current_stock < 1) style="border:1px solid #f9bcbc !important; background: #f7efef" @endif>

                 @if ($item->current_stock < 1) <div class="ribbon-wrapper">
                     <div class="ribbon">
                         <span>Out of Stock</span>
                     </div>
         </div>
         @endif
         <a href="{{route('admin.products.show', $item->id )}}" title="{{ $item->name }}" target="_blank">
             <div class="product-img">
                 <img src="{{ asset('uploads/products/'.$item->thumbnail) }}" alt="{{$item->thumbnail}}" width="80">
             </div>
             <div class="product-text-area mt-2">
                 <p class="product-title myClass fw-semibold mb-0" style="white-space: normal">
                     {{ $item->name }}
                 </p>
                 <p class="product-price  my-2 py-0">
                     <span><strike class="original-price pl-2 text-danger">{{ $item->published_price}}
                             TK.</strike></span>
                     <span class="fs-6 fw-bold">{{ $item->sell_price }} TK.</span>
                 </p>
             </div>
         </a>
         <div class="home-details-btn-wrapper loadingCart">
             @if ($item->current_stock < 1) <span class="btn home-details-btn btn-success btn-block disabled" aria-disabled="true">
                 Add to Cart
                 </span>
                 @else
                 <!-- Add onclick attribute to call addToCart function with product ID -->
                 <a class="addToCartBtn btn home-details-btn btn-success btn-block" data-current-stock="{{ $item->current_stock }}" onclick="addToCart(event, '{{ $item->id }}', '{{ $item->code }}')" href="javascript:void(0)">
                     Add to Cart
                 </a>
                 @endif

         </div>
     </div>
 </div>
 @endforeach
 @else
 <tr class="h-50 text-center">
     <td colspan="5">
         <h4 class="fs-4">No Record Found</h4>
     </td>
 </tr>
 @endif
 </div>


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

             <!-- Information about displayed entries -->
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
         <div id="pagination-links">
             {{ $items->links('components.pagination.default') }}
         </div>
     </div>
 </div>
