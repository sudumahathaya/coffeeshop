<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Services\PaymentGateways\SimulationPaymentGateway;
use App\Services\PaymentGateways\StripePaymentGateway;
use InvalidArgumentException;

class PaymentGatewayFactory
{
    private static array $gateways = [
        'simulation' => SimulationPaymentGateway::class,
        'stripe' => StripePaymentGateway::class,
    ];

    /**
     * Create payment gateway instance
     */
    public static function create(string $gateway, array $config = []): PaymentGatewayInterface
    {
        if (!isset(self::$gateways[$gateway])) {
            throw new InvalidArgumentException("Unsupported payment gateway: {$gateway}");
        }

        $gatewayClass = self::$gateways[$gateway];
        
        if (!class_exists($gatewayClass)) {
            throw new InvalidArgumentException("Payment gateway class not found: {$gatewayClass}");
        }

        return new $gatewayClass($config);
    }

    /**
     * Get available gateways
     */
    public static function getAvailableGateways(): array
    {
        return array_keys(self::$gateways);
    }

    /**
     * Register new gateway
     */
    public static function register(string $name, string $class): void
    {
        if (!is_subclass_of($class, PaymentGatewayInterface::class)) {
            throw new InvalidArgumentException("Gateway class must implement PaymentGatewayInterface");
        }

        self::$gateways[$name] = $class;
    }
}