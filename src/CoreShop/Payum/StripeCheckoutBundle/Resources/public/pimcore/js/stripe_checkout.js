pimcore.registerNS('coreshop.provider.gateways.stripe_checkout');
coreshop.provider.gateways.stripe_checkout = Class.create(coreshop.provider.gateways.abstract, {

    getLayout: function (config) {
        return [
            {
                xtype: 'textfield',
                fieldLabel: t('stripe_checkout_publishable_key'),
                name: 'gatewayConfig.config.publishable_key',
                length: 255,
                value: config.publishable_key ? config.publishable_key : ""
            },
            {
                xtype: 'textfield',
                fieldLabel: t('stripe_checkout_secret_key'),
                name: 'gatewayConfig.config.secret_key',
                length: 255,
                value: config.secret_key ? config.secret_key : ""
            },
            {
                // TODO: render `webhook_secret_keys` field as dynamic (Add/Remove)
                xtype: 'textfield',
                fieldLabel: t('stripe_checkout_webhook_secret_keys'),
                name: 'gatewayConfig.config.webhook_secret_keys',
                tooltip: t('stripe_checkout_webhook_secret_keys_tooltip'),
                length: 255,
                value: config.webhook_secret_keys ? config.webhook_secret_keys : "",
                listeners: {
                    render : function(field) {
                        new Ext.ToolTip({
                            target : field.getEl(),
                            html: field.tooltip
                        });
                    }
                }
            },
        ];
    }

});