<!-- Begin Posts -->
<div class="col-sm-12">

    <!-- Standard Post -->
    <div class="post image">
        <span class="date"><?=$QTY?><br><small><?=$perdoor?></small></span>
        <div class="post-title">
            <h2><a href="#"> </a></h2>
            <div class="post-meta">
                <!--h6>Posted by <a href="#">John Doe</a> / <a href="#">Standard</a></h6-->							
            </div>
        </div>		
            
        <div class="post-body">
            <div class="parent">
                <span>
                    <?PHP $msg = str_replace(" ", "</span><span>", $msg); 
                          $msg = str_replace("<span>LBM:", "</div><br><div class='parent'><span>LBM:", $msg);
                          $msg = str_replace("<span>Door:", "</div><br><div class='parent'><span>Door:", $msg);
                          $msg = str_replace("<span>Total:", "</div><br><div class='parent'><span>Total:", $msg) ?>
                          <?=$msg?></span>
            </div>
       
               
        </div>
    </div>
</div><!-- END -->

