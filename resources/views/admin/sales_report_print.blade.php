<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .summary {
            margin-top: 20px;
            font-size: 14px;
        }
        .summary p {
            margin: 5px 0;
        }
        @media print {
            @page { size: A4; margin: 20mm; }
        }
    </style>
</head>
<body onload="window.print()">

    <h2>LAPORAN PENJUALAN</h2>

    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th>Item</th>
                <th>Jumlah Terjual</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPendapatan = 0;
                $totalProduk = 0;
            @endphp
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->period }}</td>
                    <td>{{ $sale->item_name }}</td>
                    <td>{{ $sale->total_quantity_sold }}</td>
                    <td>Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalPendapatan += $sale->total_revenue;
                    $totalProduk += $sale->total_quantity_sold;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th>{{ $totalProduk }}</th>
                <th>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <p><strong>Analisis Sementara:</strong></p>
        <p>
            Total pendapatan: <strong>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong><br>
            Total produk terjual: <strong>{{ $totalProduk }}</strong><br>
            Rata-rata penjualan: <strong>Rp {{ number_format($totalPendapatan / max(count($sales), 1), 0, ',', '.') }}</strong>
        </p>
    </div>

</body>
</html>
