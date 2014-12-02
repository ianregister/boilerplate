
<form>
     <fieldset>
          <input type="text" name="name" placeholder="Name" data-h5-errorid="invalid-name" required/>
          <div id="invalid-name" class="error message name" style="display:none">Please enter your name</div>

          <input type="text" class="h5-email" name="email" value="" placeholder="Email" data-h5-errorid="invalid-email-address" required/>
          <div id="invalid-email" class="error message email" style="display:none">Please enter your email</div>
          <div id="invalid-email-address" class="error message email invalid" style="display:none">Please enter a valid email address</div>

          <input type="text" class="h5-number" name="number" value="" placeholder="Contact Number" data-h5-errorid="invalid-number" required/>
          <div id="invalid-number" class="error message number" style="display:none">Please enter your contact number</div>


          <textarea name="text" placeholder="Details of your query"></textarea>
          <input type="submit" name="" value="Submit" class="float right"/>
     </fieldset>
</form> 

<div id="beer-contact-form-thanks" >Thank you <span id="beer-contact-form-response"></span>, we will be in touch within 2 business days.</div>
<div id="beer-contact-form-error" >Something went wrong, please try again.</div> 