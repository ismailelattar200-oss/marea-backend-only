<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Votre commande MAREA a été livrée ✓</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #C9A84C;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #12131f;
            margin: 0;
        }
        .order-info {
            background: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th, .items-table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .total-row {
            font-weight: bold;
            font-size: 1.1em;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MAREA</h1>
        </div>
        
        <p>Bonjour {{ $order->customer_name }},</p>
        
        <p>Votre commande <strong>#{{ $order->order_number }}</strong> a été livrée avec succès.</p>
        
        <div class="order-info">
            <h3 style="margin-top: 0;">Détails de la commande :</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Article</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->orderItems && $order->orderItems->count() > 0)
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->menuItem ? $item->menuItem->name : 'Article' }}</td>
                            <td>x{{ $item->quantity }}</td>
                        </tr>
                        @endforeach
                    @elseif($order->items && is_array($order->items))
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item['name'] ?? 'Article' }}</td>
                            <td>x{{ $item['quantity'] ?? 1 }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">Détails non disponibles</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            
            <p class="total-row">Total : {{ number_format($order->total, 2) }} MAD</p>
        </div>
        
        <p>Nous espérons que vous vous régalerez ! N'hésitez pas à nous faire part de vos retours.</p>
        
        <div class="footer">
            <p>Merci de votre confiance — <strong>MAREA Restaurant</strong></p>
        </div>
    </div>
</body>
</html>
