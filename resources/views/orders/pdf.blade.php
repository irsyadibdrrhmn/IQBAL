<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders PDF</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Order List</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Order ID</th>
                <th>Products</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($orders as $order)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $order->id }}</td>
                <td>
                    <ul>
                        @foreach ($order->orderItems as $item)
                        <li>{{ $item->product->name }} - {{ $item->quantity }} x {{ $item->price }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>${{ $order->total }}</td>
                <td>Pending</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
