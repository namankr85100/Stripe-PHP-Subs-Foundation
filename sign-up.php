<?php
ini_set('display_errors', 'On');
// Get Stripe library
require_once('stripe/lib/Stripe.php');
// Set Stripe secret key
Stripe::setApiKey("your_secret_key");

$allPlans = Stripe_plan::all(); // Get plans from Stripe
?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Stripe Foundation Subscription sign up</title>
    <link rel="stylesheet" href="css/foundation.css" />
	<!-- <link rel="stylesheet" href="foundation-icons/foundation-icons.css" /> -->
  	<script src="js/vendor/modernizr.js"></script>
	  <!-- The required Stripe lib -->
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	<!-- jQuery is used only for this example; it isn't required to use Stripe -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

	<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('Your-publishable-key');

    var stripeResponseHandler = function(status, response) {
      var $form = $('#payment-form');

      if (response.error) {
        // Show the errors on the form
		//$('.error').toggle();
        $form.find('.error').text(response.error.message);
        $form.find('button').prop('disabled', false);
      } else {
        // token contains id, last4, and card type
        var token = response.id;
        // Insert the token into the form so it gets submitted to the server
        $form.append($('<input type="hidden" name="stripeToken" />').val(token));
        // and re-submit
        $form.get(0).submit();
      }
    };

    jQuery(function($) {
      $('#payment-form').submit(function(e) {
        var $form = $(this);

        // Disable the submit button to prevent repeated clicks
        $form.find('button').prop('disabled', true);

        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
      });
    });
  </script>
  </head>
  <body>
  <nav class="top-bar" data-topbar>
  <ul class="title-area">
    <li class="name">
      <h1><a href="#">Your site</a></h1>
    </li>
      <li class="toggle-topbar menu-icon"><a href="#"></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
      <li class="active"><a href="#">An active link</a></li>
      <li><a href="#">A link</a></li>
    </ul>

 </section>
</nav>
  <div class="row">
      <div class="small-12 columns">
        <h2>Sign up to a subscription</h2>
      </div>
    </div>

<!-- Main content -->
<div class="row">
   <div class="large-6 medium-8 small-12 columns">
     <!--Post the form to your charge.php file-->
	<form action="charge.php" method="POST" id="payment-form">


		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
			<h5>Your subscription</h5>
			</div>
		</div>


			<div class="row">

					<div class="large-10 medium-10 small-12 columns">

				     <select name="sub">
					 <?php // Get all plans from Stripe
						foreach($allPlans['data'] as $key=>$val){
					?>
						<option value="<?php echo $val['id'] ?>"><?php echo $val['name']?></option>
					<?php
						}
					?>
		</select>
		</div>
		</div>

		<!-- start address and details section -->
		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<h5>Your details<h5>
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>Name</label>
				<input type="text" placeholder="Joe Bloggs" data-stripe="name">
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>Email</label>
				<input type="email" placeholder="your@email.com" name="email">
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>Address line 1</label>
				<input type="text" data-stripe="address_line1">
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>City</label>
				<input type="text" data-stripe="address_city">
			</div>
		</div>

		<div class="row">
			<div class="large-3 medium-4 small-6 columns">
				<label>Postcode</label>
				<input type="text" data-stripe="address_zip">
			</div>
		</div>

		<!-- credit card details section -->
		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<h5>Card details<h5>
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>Card number | <a href="https://stripe.com/docs/testing" target="_blank">Test card details</a></label>
				<input type="text" placeholder="The long number across the card" data-stripe="number"/>
			</div>
		</div>

		<div class="row">
			<div class="small-4 large-2 medium-2 columns">
				<label>CVC</label>
				<input type="text" placeholder="123" data-stripe="cvc"/>
			</div>
		</div>
		<div class="row">
			<div class="small-4 large-2 medium-3 columns">
				<label>Expiry MM</label>
				<input type="text" placeholder="MM" data-stripe="exp-month"/>
			</div>
			<div class="small-4 large-2 medium-3 columns left bottom">
			<label>Expiry YYYY</label>
				<input type="text" placeholder="YYYY" data-stripe="exp-year"/>
			</div>
		</div>



		<!-- start voucher section -->
		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<h5>Voucher<h5>
			</div>
		</div>

		<div class="row">
			<div class="large-10 medium-10 small-12 columns">
				<label>Got a voucher code?</label>
				<input type="text" placeholder="Add it here" name="coupon">
			</div>
		</div>

		<!-- submit button and error -->
		<div class="row">
			<div class="small-12 large-6 medium-4 columns">
				<p><span class="error" style="display:none;"></span></p>
			</div>
		</div>

		<div class="row">
		    <div class="small-8 large-6 medium-4 columns">
		      <button type="submit" class="success radius button">Pay securely</button>
		    </div>
		</div>
	 </form>
 </div>
    <div class=" large-6 medium-4 small-12 columns">

			<div class="panel">
        	<h5>Need help?</h5>
			<ul>
			<li><a href="https://stripe.com/docs/api/php" target="_blank">Full API documentation</a></li>
			<li><a href="https://stripe.com/docs" target="_blank">Main Stripe documentation</a></li>
			<li><a href="https://support.stripe.com/" target="_blank">Support site</a></li>
			</ul>
        	<a href="mailto:support@stripe.com" target="_blank" class="small button">Or email Stripe</a>

      </div>
 </div>
</div>
<!-- Foundation JS includes -->
  <script src="js/vendor/fastclick.js"></script>
  <script src="js/foundation.min.js"></script>
  <script>
	$(document).foundation();
  </script>
  </body>
  </html>
