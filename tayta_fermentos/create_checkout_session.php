<?php

require_once 'libs/stripe-php/init.php'; 

\Stripe\Stripe::setApiKey('sk_test_51PvTtwApp0UZS128VndM5RQne35jpDaAXez8fRS3rfqp2QoOCG3Cq6rOXbnfFnUGcA88DoRawZQSN3PsUOa2YEuf004tdDwUZ8');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$total = $input['total'];

try {

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'pen',
                'product_data' => [
                    'name' => 'Compra en Tayta Fermentos',
                ],
                'unit_amount' => $total * 100, 
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'https://tayta_fermentos.com/confirm.php', 
        'cancel_url' => 'https://tayta_fermentos.com/checkout.php', 
    ]);

    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
