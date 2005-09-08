<?php 
  $numpage_registros=$numpage_total;
  $numpage_paginas=round($numpage_total/$numpage_regpage);
  if($numpage_paginas*$numpage_regpage<$numpage_registros){ $numpage_paginas=$numpage_paginas+1; }
  $num_ultimapag=($numpage_paginas*$numpage_regpage)-$numpage_regpage;
?>
<table cellspacing=0 cellpadding=0 width=90% border=0 align="center">
  <tbody> 
  <tr> 
    <td class=cell4></td>
  </tr>
  <tr> 
    <td class=cell4></td>
  </tr>
  <tr> 
    <td class=cell4 align=left> 
        <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Mostrando <?php echo $from+1; ?>-<?php if ($from+$numpage_regpage>$numpage_registros){ echo $numpage_registros; }else{ echo $from+$numpage_regpage; } ?> de <?php echo $numpage_registros; ?></font> 
    </td>
    <td class=cell4 align=right>Ver 
      <select onChange="location.href='<?php echo $numpage_urlweb; ?>&numpage_regpage=<?php echo $numpage_regpage; ?>&from='+this.options[this.selectedIndex].value" name=frmNumPagina>
<?php if($numpage_paginas>1){
	$sumapag=0;
	for($i=1;$i<=$numpage_paginas;$i++)
	{		
?>
	<a href="<?php echo "$sumapag"; ?>"><option value=<?php echo "$sumapag";?> <?php if($from==$sumapag){ echo "selected"; } ?>>Pág: <?php echo "$i"; ?></option></a>
<?php
	$sumapag=$sumapag+$numpage_regpage;
	}
 }
?>
      </select>
      con 
      <select onChange="location.href='<?php echo $numpage_urlweb; ?>&from=<?php echo $from; ?>&numpage_regpage='+this.options[this.selectedIndex].value" name=frmNumRegPage>
        <option value=5    <?php if($numpage_regpage==5){ echo "selected"; } ?>>5 reg</option>
        <option value=10   <?php if($numpage_regpage==10){ echo "selected"; } ?>>10 reg</option>
        <option value=15   <?php if($numpage_regpage==15){ echo "selected"; } ?>>15 reg</option>
        <option value=20   <?php if($numpage_regpage==20){ echo "selected"; } ?>>20 reg</option>
        <option value=25   <?php if($numpage_regpage==25){ echo "selected"; } ?>>25 reg</option>
        <option value=30   <?php if($numpage_regpage==30){ echo "selected"; } ?>>30 reg</option>
        <option value=40   <?php if($numpage_regpage==40){ echo "selected"; } ?>>40 reg</option>
        <option value=50   <?php if($numpage_regpage==50){ echo "selected"; } ?>>50 reg</option>
        <option value=100  <?php if($numpage_regpage==100){ echo "selected"; } ?>>100 reg</option>
        <option value=200  <?php if($numpage_regpage==200){ echo "selected"; } ?>>200 reg</option>
        <option value=300  <?php if($numpage_regpage==300){ echo "selected"; } ?>>300 reg</option>
        <option value=400  <?php if($numpage_regpage==400){ echo "selected"; } ?>>400 reg</option>
        <option value=500  <?php if($numpage_regpage==500){ echo "selected"; } ?>>500 reg</option>
        <option value=9999 <?php if($numpage_regpage==9999){ echo "selected"; } ?>>Todos</option>
      </select>
      <?php if($from>0){ ?>
<a href="<?php echo $numpage_urlweb; ?>&from=0"><img height=20 src="images/flip_first.gif" width=20 align=absMiddle border=0></a>
<?php } else {?>
<img height=20 src="images/flip_first_gray.gif" width=20 align=absMiddle border=0>
<?php }?>

<?php if($from-$numpage_regpage>=0){
	if($from-$numpage_regpage<=0){
		$numpag_anterior=0;
	}else{
		$numpag_anterior=$from-$numpage_regpage;
	}?>
<a href="<?php echo $numpage_urlweb; ?>&from=<?php echo $numpag_anterior;?>"><img height=20 src="images/flip_prev.gif" width=20 align=absMiddle border=0></a>
<?php } else {?>
<img height=20 src="images/flip_prev_gray.gif" width=20 align=absMiddle border=0>
<?php }?>

<?php if($registros+$numpage_regpage<$numpage_registros){
	$numpage_siguiente=$registros+$numpage_regpage; ?>
	<a href="<?php echo $numpage_urlweb; ?>&from=<?php echo $numpage_siguiente;?>"><img height=20 src="images/flip_next.gif" width=20 align=absMiddle border=0></a>
<?php } else {?>
<img height=20 src="images/flip_next_gray.gif" width=20 align=absMiddle border=0>
<?php }?>

<?php if($numpage_registros-$from<$numpage_regpage){ ?>
<img height=20 src="images/flip_last_gray.gif" width=20 align=absMiddle border=0>
<?php }else {?>
<a href="<?php echo $numpage_urlweb; ?>&from=<?php echo $num_ultimapag; ?>"><img height=20 src="images/flip_last.gif" width=20 align=absMiddle border=0></a>
<?php }?>     

 </td>
  </tr>
  </tbody>
</table>
