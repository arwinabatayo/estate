<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
</head>
<body>
<table width="100%">
    <tr>
        <td>Product</td>
        <td>Item Description</td>
        <td>Qty</td>
        <td>Unit Price</td>
        <td>Discount</td>
        <td>Total</td>
    </tr>
    <?php foreach( $cart_contents as $v ) { ?>
        <tr>
            <td>
				
            </td>
            <td><?php echo $v['name']; ?></td>
            <td><?php echo $v['qty']; ?></td>
            <td><?php echo $v['price']; ?></td>
            <td><?php 
                    if(isset($v['discount'])) {
                        echo $v['discount'];
                    }else {
                        echo '&nbsp;';
                    }
                ?>
            </td>
            <td><?php echo $v['subtotal']; ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="4" align="right">Total : </td>
        <td colspan="2" align="left"><?php echo $this->cart->total(); ?></td>        
    </tr>    
</table>
</body>
</html>
