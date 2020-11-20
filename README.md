# CoreShop Stripe Checkout Payum Connector
This Bundle activates the Stripe Checkout Payment Gateway in CoreShop.
It requires the [FLUX-SE/PayumStripe](https://github.com/FLUX-SE/PayumStripe) repository which will be installed automatically.

## Installation

#### 1. Composer

```json
    "coreshop/payum-stripe-checkout-bundle": "^1.0"
```

#### 2. Activate
Enable the Bundle in Pimcore Extension Manager

#### 3. Setup
Go to Coreshop -> PaymentProvider and add a new Provider. Choose `stripe_checkout` from `type` and fill out the required fields.
