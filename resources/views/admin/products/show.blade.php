@extends('admin.layout')

@section('title', $product->name ?? 'Sản phẩm (Admin)')

@section('content')
    <h2 style="color:#7a2f3b">{{ $product->name }}</h2>

    @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="" style="max-width:320px;border-radius:8px;margin-bottom:12px">
    @endif

    <p class="muted">{{ number_format($product->price ?? 0) }}₫</p>
    <p class="muted">Danh mục: {{ $product->category->name ?? '-' }}</p>

    <div style="margin-top:8px">
        <strong>Size:</strong>
        @if($product->size)
            @php $sizes = preg_split('/[,;|\s]+/', $product->size); @endphp
            @foreach($sizes as $s)
                @if(trim($s) !== '')
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:34px;height:34px;border-radius:50%;background:#fff;border:1px solid #eee;color:#7a2f3b;font-weight:600;margin-right:6px">{{ trim($s) }}</span>
                @endif
            @endforeach
        @else
            -
        @endif
    </div>

    <div style="margin-top:8px">
        <strong>Chất liệu:</strong> {{ $product->material ?? '-' }}
    </div>

    <div style="margin-top:8px">
        <strong>Màu sắc:</strong>
        @if($product->color)
            @php $colors = preg_split('/[,;|]+/', $product->color); @endphp
            @foreach($colors as $c)
                @php $ctrim = trim($c);
                      $map = ['đỏ'=>'#c0392b','đen'=>'#000','trắng'=>'#fff','hồng'=>'#eec6d6','be'=>'#f5e6da','nâu'=>'#8b5e3c','xanh'=>'#2c8fbd','xanh lá'=>'#2e8b57','vàng'=>'#f1c40f','ghi'=>'#7f8c8d'];
                      $code = $map[mb_strtolower($ctrim,'UTF-8')] ?? $ctrim;
                @endphp
                <span title="{{ $ctrim }}" style="display:inline-block;width:20px;height:20px;border-radius:50%;background:{{ $code }};border:1px solid rgba(0,0,0,0.08);margin-right:6px;vertical-align:middle"></span>
            @endforeach
        @else
            -
        @endif
    </div>

    <div style="margin-top:12px">
        <a class="btn" href="{{ route('admin.products.index') }}">Quay lại</a>
        <a class="btn" href="{{ route('admin.products.edit', $product->id) }}" style="background:#fff;color:#7a2f3b;border:1px solid #eee;margin-left:8px">Sửa</a>
    </div>
@endsection
