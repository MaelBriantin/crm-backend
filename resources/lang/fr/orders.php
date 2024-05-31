<?php

return [
    'payment_methods' => [
        'cash' => 'Espèces',
        'credit_card' => 'Carte de crédit',
        'check' => 'Chèque',
        'bank_transfer' => 'Virement bancaire',
    ],
    'payment_status' => [
        'paid' => 'Payé',
        'unpaid' => 'Impayé',
        'pending' => 'Différé',
    ],
    'order_creation_error' => 'Une erreur est survenue lors de l\'enregistrement de la commande.',
    'product_quantity_error' => 'La quantité de :product_name commandée est supérieure à la quantité en stock.',
    'deferred_date_invalid' => 'La date de paiement différé doit être supérieure à la date actuelle.',
];
