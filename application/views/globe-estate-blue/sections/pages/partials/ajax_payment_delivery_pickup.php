<?php unset($stores['total_count']);
    foreach( $stores as $val ) { ?>
    <div class="accordion-group">
            <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $val['id']; ?>">
                            <?php echo $val['name']; ?> <i class="icon-arrow-down pull-right"></i>
                    </a>
            </div>
        <?php 
             $properties = $store_properties[$val['id']];
                   if(!empty($properties)) { ?>
                             <div id="<?php echo $val['id']; ?>" class="accordion-body collapse" style="height: 0px; ">
                                                <?php foreach($properties as $prop) { ?>
                                    <div class="accordion-inner pick-up-content">
                                            <div class="span4 p-u-c-cal">
                                                    <p><?php echo date("F d, Y", strtotime($prop['date_of_operation'])); ?></p>
                                            </div>
                                            <div class="span4 p-u-c-time">
                                                    <p><?php echo date("h:i:s A", strtotime($prop['time_of_operation_from'])); ?> - <?php echo date("h:i:s A", strtotime($prop['time_of_operation_to'])); ?></p>
                                            </div>
                                            <div class="span4">
                                                    <span class="radio-btn"><input type="radio" name="pickup_store" id="flat-radio-1"/></span>
                                            </div>
                                            <div class="clr"></div><br />
                                    </div>
                                <?php  } ?>
                            </div>
                   <?php } ?>
    </div>
<?php } ?>