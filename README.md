# CoreShop Stripe Checkout Payum Connector
This Bundle activates the Stripe Checkout PaymentGateway in CoreShop.
It requires the [Prometee/PayumStripe](https://github.com/Prometee/PayumStripe) repository which will be installed automatically.

## Installation

#### 1. Composer

```json
    "coreshop/payum-stripe-checkout-bundle": "dev-master"
```

#### 2. Activate
Enable the Bundle in Pimcore Extension Manager

#### 3. Setup
Go to Coreshop -> PaymentProvider and add a new Provider. Choose `stripe_checkout` from `type` and fill out the required fields.