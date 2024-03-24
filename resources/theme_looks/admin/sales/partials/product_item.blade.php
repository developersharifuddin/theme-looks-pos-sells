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
