<?php
ini_set('display_errors', 'On');
require_once('stripe/lib/Stripe.php'); // Point to your Stripe library
// Set your secret key: remember to change this to your live secret key in production
// See your keys here https://dashboard.stripe.com/account
Stripe::setApiKey("your-api-key");

// Get the card and plan and customer details submitted by the form
$token = $_POST['stripeToken'];
$selectedSub = $_POST['sub'];
$customerEmail = $_POST['email'];

// Create a Customer
$customer = Stripe_Customer::create(array(
  "card" => $token,
  "email" => $customerEmail,
  "plan" => $selectedSub,
  )
);

// If coupon is supplied update the customer
if (isset($_POST["coupon"]) && !empty($_POST["coupon"])) {
    $appliedCoupon = $_POST['coupon'];
	$customer->coupon = $appliedCoupon;
}

// Charge the Customer instead of the card
Stripe_Charge::create(array(
  "amount" => 100, # amount in pence
  "currency" => "gbp",
  "customer" => $customer->id)
);

echo '<h3>New customer created</h3>';
echo '<a href="https://dashboard.stripe.com">View Stripe dashboard</a>';
echo '<p>You might want to make this page a bit more attractive</p>'
?>
