<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7fb; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding-bottom: 20px; }
        .header { background-color: #0b1a30; padding: 40px 30px; text-align: center; }
        .header h1 { color: #C9A84C; margin: 0; font-size: 32px; letter-spacing: 4px; font-family: 'Times New Roman', Times, serif; }
        .header p { color: #ffffff; margin: 15px 0 0 0; font-size: 18px; font-weight: 300; letter-spacing: 1px; }
        .content { padding: 40px 30px; }
        .greeting { font-size: 22px; font-weight: bold; color: #0b1a30; margin-bottom: 30px; text-align: center; }
        .order-badge-container { text-align: center; margin-bottom: 40px; }
        .order-number { background-color: #fef9e7; border: 1px solid #f4e5b2; color: #b89246; padding: 12px 20px; border-radius: 50px; display: inline-block; font-weight: bold; font-size: 16px; letter-spacing: 1px; }
        .section-title { font-size: 14px; font-weight: bold; color: #0b1a30; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px; margin-bottom: 20px; margin-top: 40px; text-transform: uppercase; letter-spacing: 1.5px; }
        .item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 15px; color: #333333; }
        .totals { margin-top: 25px; border-top: 2px solid #f0f0f0; padding-top: 20px; }
        .total-line { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 15px; color: #555555; }
        .total-final { display: flex; justify-content: space-between; margin-top: 20px; font-size: 20px; font-weight: bold; color: #b89246; }
        .address-box { background-color: #f9fafb; padding: 20px; border-radius: 12px; font-size: 15px; color: #444444; line-height: 1.6; border: 1px solid #f0f0f0; }
        .payment-mode { font-size: 15px; color: #444444; font-weight: 500; }
        .info-text { font-size: 14px; color: #666666; margin-top: 25px; text-align: center; background-color: #f9fafb; padding: 15px; border-radius: 8px; }
        .btn-container { text-align: center; margin-top: 50px; margin-bottom: 30px; }
        .btn { background-color: #C9A84C; color: #0b1a30; text-decoration: none; padding: 16px 35px; border-radius: 50px; font-weight: bold; font-size: 16px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .footer { text-align: center; padding: 30px 20px; font-size: 13px; color: #888888; background-color: #f4f7fb; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        td { padding: 12px 0; border-bottom: 1px solid #f9f9f9; color: #444; font-size: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>MAREA</h1>
            <p>Confirmation de Commande</p>
        </div>
        
        <div class="content">
            <div class="greeting">Merci pour votre commande, {{ $order->customer_first_name }} !</div>
            
            <div class="order-badge-container">
                <div class="order-number">N° {{ $order->order_number }}</div>
            </div>

            <div class="section-title">Récapitulatif de votre commande</div>
            
            <table>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item['name'] }}</strong> <span style="color: #888;">x{{ $item['quantity'] }}</span>
                    </td>
                    <td style="text-align: right; font-weight: 500;">
                        {{ number_format($item['price'] * $item['quantity'], 2) }} MAD
                    </td>
                </tr>
                @endforeach
            </table>

            <div class="totals">
                <table style="width: 100%;">
                    <tr>
                        <td style="border: none; padding: 6px 0; color: #666;">Sous-total</td>
                        <td style="border: none; padding: 6px 0; text-align: right; color: #666;">{{ number_format($order->subtotal, 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 6px 0; color: #666;">Livraison</td>
                        <td style="border: none; padding: 6px 0; text-align: right; color: #666;">
                            {{ $order->type === 'livraison' ? 'Gratuite' : 'À emporter' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 15px 0 0 0; font-size: 20px; font-weight: bold; color: #0b1a30;">Total</td>
                        <td style="border: none; padding: 15px 0 0 0; text-align: right; font-size: 20px; font-weight: bold; color: #C9A84C;">
                            {{ number_format($order->total, 2) }} MAD
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section-title">Informations de {{ $order->type === 'livraison' ? 'livraison' : 'récupération' }}</div>
            <div class="address-box">
                <strong>{{ $order->customer_first_name }} {{ $order->customer_last_name }}</strong><br>
                @if($order->type === 'livraison')
                    {{ $order->customer_address }}<br>
                    {{ $order->customer_city }}, {{ $order->customer_region }}<br>
                    {{ $order->customer_postal_code }} - Maroc<br>
                @endif
                <div style="margin-top: 10px;">
                    Téléphone : {{ $order->customer_phone }}<br>
                    Email : {{ $order->customer_email }}
                </div>
            </div>

            <div class="section-title">Mode de paiement</div>
            <div class="payment-mode">
                @if($order->payment_method === 'carte')
                    💳 Carte Bancaire (En ligne)
                @elseif($order->payment_method === 'paypal')
                    🅿️ PayPal
                @else
                    💵 Paiement à la {{ $order->type === 'livraison' ? 'livraison' : 'réception' }} (Espèces)
                @endif
            </div>
            
            <div class="info-text">
                @if($order->type === 'livraison')
                    ⏱ <strong>Livraison estimée :</strong> 45 - 60 minutes
                @else
                    ⏱ <strong>Préparation estimée :</strong> 20 - 30 minutes
                @endif
            </div>

            <div class="btn-container">
                <a href="{{ env('APP_FRONTEND_URL', 'http://localhost:5173') }}/seguimiento/{{ $order->order_number }}" class="btn">Voir ma commande</a>
            </div>
        </div>
        
        <div class="footer">
            <strong>MAREA Restaurant</strong><br>
            Contact: +212 500 00 00 00 | contact@marearestaurant.ma<br><br>
            &copy; 2026 MAREA Restaurant. Tous droits réservés.
        </div>
    </div>
</body>
</html>
