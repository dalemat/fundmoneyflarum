<?php

use Flarum\Extend;
use CryptoFund\ERC20Money\Api\Controllers;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/less/forum.less'),
    
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/less/admin.less'),
    
    (new Extend\Routes('api'))
        ->post('/erc20-fund', 'erc20.fund', Controllers\FundAccountController::class)
        ->get('/erc20-transactions', 'erc20.transactions', Controllers\TransactionListController::class)
        ->get('/erc20-settings', 'erc20.settings', Controllers\SettingsController::class)
        ->post('/erc20-settings', 'erc20.settings.save', Controllers\SettingsController::class)
        ->post('/erc20-test-connection', 'erc20.test', Controllers\TestConnectionController::class)
        ->post('/erc20-check-transactions', 'erc20.check', Controllers\CheckTransactionsController::class),
    
    (new Extend\Locales(__DIR__ . '/locale')),
    
    (new Extend\Console())
        ->command(\CryptoFund\ERC20Money\Commands\CheckTransactionsCommand::class),
    
    // Manual service provider registration for older Flarum versions
    (new Extend\ServiceProvider())
        ->register(\CryptoFund\ERC20Money\Provider\ERC20ServiceProvider::class),
];
