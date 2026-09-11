@if(count($products) > 0)
<div class="search-result-list" style="background:#fff; border:1px solid #ddd; border-radius:4px; max-height:320px; overflow-y:auto; padding:8px 0;">
    @foreach($products as $product)
    <a href="{{ url('product/detail/'.$product->id.'/'.$product->product_slug) }}" style="display:flex; align-items:center; padding:6px 12px; text-decoration:none; color:#333; border-bottom:1px solid #f0f0f0;">
        <img src="{{ asset($product->product_thambnail) }}" alt="{{ $product->product_name }}" style="width:42px; height:42px; object-fit:cover; margin-right:10px; border-radius:3px;">
        <div>
            <div style="font-size:13px; font-weight:500;">{{ $product->product_name }}</div>
            <div style="font-size:12px; color:#e44;">{{ number_format($product->selling_price, 0, ',', '.') }} đ</div>
        </div>
    </a>
    @endforeach
</div>
@else
<div style="background:#fff; border:1px solid #ddd; padding:10px 14px; font-size:13px; color:#888; border-radius:4px;">Không tìm thấy sản phẩm nào.</div>
@endif
