# Responsive Stripe subscription sign up page with PHP and Foundation

This project is based on the Stripe subscription tutorial files: https://stripe.com/docs/tutorials/subscriptions. The front end uses the Zurb Foundation framework: http://foundation.zurb.com/

To get started you need a Stripe account, your public and private keys and at least one active Stripe Plan.

This sign up page allows a customer to select their subscription from any available plan in your Stripe account. On submission the customer will be added to Stripe with the chosen plan. The supplied credit card details will be attached to the customer object. If the customer provides a valid voucher the voucher will be attached to the customer.

In the example code I assume a paid trial is being set up so a charge of £1 is made to the card immediately. This is not related to the plan selected by the user. Since a one-off charge is being made the assumption is that the plan has a trial period assigned to it. If you want to charge the subscription cost immediately simply remove the following code from charge.php and ensure that your plans don't have trial periods.

```php
Stripe_Charge::create(array(
  "amount" => 100, # amount in pence
  "currency" => "gbp",
  "customer" => $customer->id)
);
```

What this code doesn't do:
- Nice error handling (in the front end or the back end)
- Handle customer management between Stripe and an external database
- Show you a nice confirmation page (but you can easily deal with that by making some changes to charge.php)
