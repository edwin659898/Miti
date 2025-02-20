<?php


namespace Delights\Ipay\Controller;

class Cashier
{
    const CHANNEL_MPESA = 'mpesa';
    const CHANNEL_BONGA = 'bonga';
    const CHANNEL_AIRTEL = 'airtel';
    const CHANNEL_EQUITY = 'equity';
    const CHANNEL_MOBILE_BANKING = 'mobile_banking';
    const CHANNEL_DEBIT_CARD = 'debit_card';
    const CHANNEL_CREDIT_CARD = 'credit_card';
    const CHANNEL_MKOPO_RAHISI = 'mkopo_rahisi';
    const CHANNEL_SAIDA = 'saida';
    const CHANNEL_ELIPA = 'elipa';
    const CHANNEL_UNIONPAY = 'unionpay';
    const CHANNEL_MVISA = 'mvisa';
    const CHANNEL_VOOMA = 'vooma';
    const CHANNEL_PESAPAL = 'pesapal';

    // Other methods and properties
    public function processPayment()
    {
        // Payment logic here
    }
}
