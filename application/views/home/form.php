<!-- Begin Contact Form Block -->
<section class="container content">

<!-- Title -->
<div class="row">
    <div class="center title col-sm-12">
        <h2>Contact us.</h2>
        <p>Want to make your website awesome? Just get in touch, we don't bite.</p>
    </div>
</div><!-- END-->

<!-- Form -->
<form method="post" action="/home/postREST" id="a" name="contactform"  class="row">
    <fieldset>
        <div class="form-field col-sm-6">
            <label for="email">Email</label>
            <span><input type="email" name="email" id="email" /></span>
        </div>
        <div class="form-field col-sm-6">
            <label for="password">Password</label>
            <span><input type="password" name="password" id="name" /></span>
        </div>
        <div class="form-field col-sm-12">
            <label for="message">Message</label>
            <span><textarea id="message"></textarea></span>
        </div>
    </fieldset>
    <div class="form-click center col-sm-12">
        <span><button type="button" onclick="postForm('a','message');"  id="submit" />Send It</span>
    </div>
    <div id="alert" class="col-sm-12"></div>
</form>	

</section>
<!-- End Contact Form Block -->