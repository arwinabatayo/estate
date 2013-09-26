<div class="accordion" id="accordion2">
    <?php 
        unset($stores['total_count']);
        foreach( $stores as $val ) { 
    ?>
        <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $val['id']; ?>">
               <?php echo $val['name']; ?>
              </a>
            </div>
            <?php 
                    $properties = $store_properties[$val['id']];
                    if(!empty($properties)) { 
            ?>
                        <div id="<?php echo $val['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                            <?php foreach($properties as $prop) { ?>
                            <div class="accordion-inner">
                                <div class="contentbox">
                                    <span class="fleft"><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?><br />
                                    <?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> to <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?>
                                    </span>
                                    <span class="fright">
                                            <input type="radio" name="<?php echo $prop['store_id']; ?>" value="1" />
                                    </span>
                                    <br class="clear" />
                                </div>
                            </div>
                            <?php  } ?>
                        </div>
            <?php   } 
            ?>
        </div>
    <?php
        } 
    ?>
</div>							            