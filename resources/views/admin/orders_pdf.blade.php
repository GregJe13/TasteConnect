<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; font-size: 12px;}
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Customer Orders Report</h1>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Order Date</th>
                <th>Address</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->customer->name }}</td>
                    <td>{{ $order->customer->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->orderDate)->format('Y-m-d H:i') }}</td>
                    <td>{{ $order->address }}</td>
                    <td>Rp{{ number_format($order->totalAmount, 0, ',', '.') }}</td>
                    <td>
                        @switch($order->status)
                            @case(0) Processing @break
                            @case(1) Delivery @break
                            @case(2)
                            @case(4) Completed @break
                            @case(3) Cancelled @break
                            @default Unknown
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>