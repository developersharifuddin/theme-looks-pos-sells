<!-- resources/views/emails/order/shipped.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Your Order Has Been Shipped</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            padding: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Order Has Been Shipped</h1>
        </div>
        <div class="content">
            <p>Dear Sir, Your Account ID {{ $order->customer_id }}</p>
            <p>We are pleased to inform you that your order has been shipped!</p>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Email</th>
                        <th>Order Status</th>
                        <th>Payable</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->order_status }}</td>
                        <td>{{ $order->payale }}</td>
                    </tr>
                    <!-- Add more rows for additional products if applicable -->
                </tbody>
            </table>
            <p>If you have any questions, feel free to contact us.</p>
            <p>Thank you for your order!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} YourCompany. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
