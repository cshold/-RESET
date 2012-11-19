<section class="entry-wrap">
	
	<div id="entry-form">
		
		<h1>Personal Details Headline</h1>
		<p>Bacon ipsum dolor sit amet swine cow ham prosciutto jowl tail. Venison shoulder salami pork loin rump corned beef filet mignon. Rump corned beef short ribs, turkey jerky boudin pork chop strip steak. Sausage ham hock meatball turducken ground round, ball tip tail. Jowl sausage beef ribs salami short ribs. Venison strip steak tenderloin andouille drumstick.</p>
		<p><strong>*Indicates a mandatory field.</strong></p>
	
		<form action="#" method="POST">
		
			<div class="form-container">
				<div>
					<label for="fname">First Name:*</label>
					<input type="text" name="fname" class="required" value="<?=$user['first_name']?>">
					<span class="error-text">First name is required.</span>
				</div>
				<div>
					<label for="lname">Last Name:*</label>
					<input type="text" name="lname" class="required" value="<?=$user['last_name']?>">
					<span class="error-text">Last name is required.</span>
				</div>
				<div>
					<label for="address">Address:*</label>
					<input type="text" name="address" class="required">
					<span class="error-text">Address is required.</span>
				</div>
				<div>
					<label for="city">City:*</label>
					<input type="text" name="city" class="required">
					<span class="error-text">City is required.</span>
				</div>
				<div>
					<label for="prov">Province:*</label>
					<select name="prov">
						<option value="">Select your province</option>
						<option value="AB">Alberta</option>
						<option value="BC">British Columbia</option>
						<option value="MB">Manitoba</option>
						<option value="NB">New Brunswick</option>
						<option value="NL">Newfoundland and Labrador</option>
						<option value="NS">Nova Scotia</option>
						<option value="ON">Ontario</option>
						<option value="PE">Prince Edward Island</option>
						<option value="SK">Saskatchewan</option>
						<option value="NT">Northwest Territories</option>
						<option value="NU">Nunavut</option>
						<option value="YT">Yukon</option>
					</select>
					<span class="error-text">Province is required.</span>
				</div>
				<div>
					<label for="pcode">Postal Code:*</label>
					<input type="text" name="pcode" class="required">
					<span class="error-text">Postal code is required.</span>
				</div>
				<div>
					<label for="phone">Phone Number:*</label>
					<input type="text" name="phone" class="required">
					<span class="error-text">Phone number is required.</span>
				</div>
				<div>
					<label for="email">Email:*</label>
					<input type="text" name="email" class="required" value="<?=$user['email']?>">
					<span class="error-text">Email is required.</span>
				</div>
				<div>
					<label for="email-conf">Confirm Email:*</label>
					<input type="text" name="email-conf" class="required">
					<span class="error-text">Emails must match.</span>
				</div>
				
			</div>
		
			<div id="checkbox-group">
				<div class="checkbox"><input type="checkbox" name="check-age" value="majority" class="required"> *I have reached the age of majority<br>in my province/territory.</div>
				<div class="checkbox"><input type="checkbox" name="check-newsletter" value="check-newsletter"> Newsletter Opt-in</div>
				<div class="checkbox"><input type="checkbox" name="check-rules" value="rules" class="required"> *I agree to the <a href="#" id="form-rules">Rules &amp; Regulations</a>.</div>
			</div>
			
			<a href="#" id="form-submit" class="cta analytics" data-tracking="Submit Form">Submit</a>
		
		
		</form>
		
	</div>
	
</section>