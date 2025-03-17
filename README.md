# CoreShop Stripe Payum Connector
This Bundle activates the Stripe Checkout & Stripe JS Payment Gateways in CoreShop.
It requires the [FLUX-SE/PayumStripe](https://github.com/FLUX-SE/PayumStripe) repository which will be installed automatically.

## Installation

#### 1. Composer

```bash
composer req coreshop/payum-stripe-bundle:^2.0
```

#### 2. Activate
Enable the Bundle in Pimcore Extension Manager

#### 3. Setup
Go to Coreshop -> PaymentProvider and add a new Provider. Choose `stripe_checkout`/`stripe_js` from `type` and fill out the required fields.
