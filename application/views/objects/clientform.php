            <form name="client" id="client" method="post" action="/home/email_estimate">
            
                <div class="form-field col-sm-6">
                    <label for="firstName">First Name</label>
                    <span><input type="text" placeholder="" name="firstName" id="firstName" onblur=""/></span>
                </div>
                <div class="form-field col-sm-6">
                    <label for="lastName">Last Name</label>
                    <span><input type="text" placeholder="" name="lastName" id="lastName" onblur=""/></span>
                </div>
                <div class="form-field col-sm-6">
                    <label for="phone">Phone</label>
                    <span><input type="text" placeholder="" name="phone" id="phone" onblur=""/></span>
                </div>
                <div class="form-field col-sm-6">
                    <label for="Width">Company</label>
                    <span><input type="text" placeholder="" name="company" id="company" onblur=""/></span>
                </div>
                <div class="form-field col-sm-12">
                    <label for="address">Address</label>
                    <span><textarea name="address" id="address"></textarea></span>
                </div>

                <div class="form-field col-sm-12">
                    <label for="email">Email</label>
                    <span><input type="text" placeholder="" name="email" id="email" onblur=""/></span>
                    <input type="hidden" name="big_estimate" id="big_estimate">
                    <input type="hidden" name="gt" id="gt">
                    <input hidden id="id_estimate" name="id_estimate" value="<?=$_SESSION['id_estimate']?>">
                <center><span><a class="button gray col-sm-12" onclick="ge('big_estimate').value = ge('addLine').innerHTML;
                                                                        ge('gt').value = ge('grandTotal').innerHTML;
                                                                        ge('client').submit();"
                                                                        id="Next">Send</a></span></center>

      
			</form>