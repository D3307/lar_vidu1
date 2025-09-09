<h2>Báo cáo thống kê (Biểu đồ)</h2>
@foreach($charts as $chart)
    <div style="margin-bottom:20px;">
        <img src="{{ $chart }}" style="width:100%; max-width:600px;">
    </div>
@endforeach
