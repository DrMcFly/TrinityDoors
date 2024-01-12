
<script src="/js/estimate.js" type="text/javascript" charset="utf-8"></script>


<!-- Begin Contact Form Block -->
<section class="container content">

<!-- Title -->
<div class="row">
    <div class="center title col-sm-12">
        <h2>Create an Estimate</h2> 
         <p>Type in your measurements, choose type of wood and door, click calculate to see your price and if everything is right click add.<br>
       The wood we have in stock is in the dropdown boxes. We can get anything you like, you may have to contact us. 501-402-0812<br>
       If you bring your own wood (BYOW) there is a $2.50 / sqft charge. We do not grantee the doors will not warp. 
            </p>
    </div>
</div><!-- END-->




<!-- Form -->
<form method="post" action="/home/add_item" id="a" name="a"  class="row">
    
        <div class="form-field col-sm-6">
            <label for="Width">Width Inches</label>
            <span><input type="text" placeholder="12 1/4" name="width" id="width" onblur="o_Width=this.value; this.value=frac(this.value);"/></span>
        </div>
        <div class="form-field col-sm-6">
            <label for="Height">Height Inches</label>
            <span><input type="text" placeholder="30 11/16" name="height" id="height" onblur="o_Height=this.value; this.value=frac(this.value);"/></span>
        </div>
        <div class="form-field col-sm-6">
            <label for="trim">Trim Wood</label>
            <span>
                <select name="trim" id="trim" onblur="Trim=this.value;">
                    <option> -- Select -- </option>
                    <option value="0.00">None</option>
                    <option value="2.50">BYOW</option>
                    <?php
                    foreach($inv as $row){
                        if ($row->type == 2){
                            ?>
                            <option value="<?=$row->price1?>"><?=str_replace(" ","&nbsp;",$row->description)?></option>
                            <?PHP
                        }
                    }
                    ?>
                </select>
            </span>
        </div>
        </div>
        <div class="form-field col-sm-6">
            <label for="center">Center Wood / Slab</label>
            <span>
                <select name="center" id="center"; onblur="Center=this.value;">
                    <option> -- Select -- </option>
                    <!--<option value="0.00">None</option>-->
                    <option value="2.50">BYOW</option>
                    <?php
                    foreach($inv as $row){
                        if ($row->type == 2){
                            ?>
                            <option value="<?=$row->price1?>"><?=str_replace(" ","&nbsp;",$row->description)?></option>
                            <?PHP
                        }
                    }
                    ?>
                </select>
            </span>
            <br>
        </div>
        <div class="form-field col-sm-12">
            <label for="qty">QTY</label>
            <span><input type="number" name="qty" id="qty" onblur="Qty=this.value;"/></span>
        </div>
        <div class="form-field col-sm-12">
            <label for="message">Estimate</label>
            <span><textarea id="message"></textarea></span>
        </div>
    
    <br><br>
    <div class="form-click center col-sm-12">
        <span><a class="button gray" onclick="Calculate(cnt); "  id="Calculate" />Calculate</a></span>
        <span><a class="button gray" onclick="add(cnt);"  id="Add_Item" style="visibility: hidden;"/>Add</a></span>
    </div>
    <div id="alert" class="col-sm-12"></div>
    <input hidden id="QTY" name="QTY">
    <input hidden id="ppHeight" name="pHeight">
    <input hidden id="ppWidth" name="pWidth">
    <input hidden id="ppsqft" name="ppsqft">
    <input hidden id="LBM" name="LBM">
    <input hidden id="total" name="total">
    <input hidden id="msg" name="msg">
    <input hidden id="perdoor" name="perdoor">
    <?php $id_estimate = rand(1000,9999);
        $_SESSION['id_estimate'] = $id_estimate;
    ?>
    <input hidden id="id_estimate" name="id_estimate" value="<?=$id_estimate?>">


</form>	



</section>

<!-- Begin Blog Block -->
<section class="content container">
<style>
    .parent {
        display: flex;
        justify-content: space-between;
    }

    span.circle {
    height: 20px;
    width: 20px;
    border-radius: 100%;
    border: 1px solid #eee;
    background:#ddd;   
    cursor: pointer;
    transition: all 0.4s ease-in-out;
    }
</style>
	<div class="row" id="addLine">
        <div id="line_item_0"></div>
    </div>
    <p>Total: <span id="grandTotal">0.00</span> </p>

    <div class="form-click center col-sm-12" id="fin" style="display:none">
    <label for="Finish">Want to send us the estimate? Click Next to become a customer or continue adding to the estimate. </label><br>
        <span><a class="button gray" onclick="getPage('home','client','ov2'); sign(true); ge(ov1).style.height=window.innerHeight; "  id="Next">Next</a></span> <!--or 
        <span><a class="button gray" onclick="getPage('home','sign_in','ov2'); sign(true); ge(ov1).style.height=200;" id="Signin">Sign in</a></span-->
    </div>
</section>

<!--light box -->
<style>
		#ov2 {
			height: 710px;
			width: 500px;
            overflow-y: scroll
		}
		
		#ov3 {
			height: 320px;
		}
		
		@media only screen and (max-width: 500px) {
			#ov2 {
				height: 120%;
				width: 320px;
			}
			
        }
		@media only screen and (max-width: 600px) {
			#ov3 {
				height: 120%;
			}
        }
			
			
</style>

		<div id="ov1" class="sign-off" style="background: rgba(0,0,0,0.5);
			position: absolute;
			z-index: 999;
			width: 100%;
			height: 270%;
			left: 0;
			top: 0;
            padding: 0;
            margin: 0;
			
			">
		</div>
			<center><div  id="ov3" class="sign-off" style="
			left: 0;
			margin: auto;
			position: absolute;
			top: 20px;
			right: 0;
			width: 100%;
            height: 100%;
			z-index: 1000;" onclick="zoom(false);">
			</div></center>
		
  		<div  id="ov2" class="sign-off" style="background: #fff;
			left: 0;
			margin: auto;
			position: absolute;
			top: 20px;
			right: 0;
			z-index: 1000;
			padding: 20px;
			border: 1px solid #999;
			border-radius: 10px;">
			

			
			
			
		</div>
<!-- end lightbox -->


