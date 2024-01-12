
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
<section class="center-mobile content container">
<!-- Title -->
<div class="row">
    <div class="center title col-sm-12">
        <h2>Submited Estimates</h2> 
         <p>Below are Estimates that have been submited using the estimation tool</p>
            
    </div>
</div><!-- END-->
<!-- Begin Overview Block -->

		<div class="row">

			<div class="col-sm-12">
                <?PHP
                    foreach ($estimate as $row){
                        ?>
                        <p><a href="/home/delete_estimate/<?=$row->id?>">X</a></p>
                       <h2> 
                            <div class="parent">
                                <span><?=$row->firstName?> <?=$row->lastName?></span> <span> <?=$row->company?></span> <span> <?=$row->phone?></span> <span><?=$row->email?></span>
                            </div>
                        </h2>
                        
                        <p><?=$row->estimate?></p> 
                        <span>Total: <?=$row->total?></span>
                        <?php
                    }
                ?>
               
				
			</div>
           
			
	</section>
	<!-- End Overview Block -->






