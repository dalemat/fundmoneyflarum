<?php

namespace CryptoFund\ERC20Money\Provider;

use Flarum\Foundation\AbstractServiceProvider;
use Illuminate\Database\Schema\Builder;

class ERC20ServiceProvider extends AbstractServiceProvider
{
    public function boot()
    {
        $this->createTables();
    }
    
    protected function createTables()
    {
        $schema = $this->container->make(Builder::class);
        
        if (!$schema->hasTable('erc20_transactions')) {
            $schema->create('erc20_transactions', function ($table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->string('transaction_hash');
                $table->string('from_address');
                $table->string('to_address');
                $table->decimal('amount', 20, 8);
                $table->integer('points');
                $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');
                $table->integer('confirmations')->default(0);
                $table->json('metadata')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index('transaction_hash');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
        
        if (!$schema->hasTable('erc20_settings')) {
            $schema->create('erc20_settings', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value');
                $table->timestamps();
            });
        }
    }
}
