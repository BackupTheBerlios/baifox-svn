<div align="center"></div>
<table width="700" align="center" class="box">
  <tr>
    <td width="100%" align="center" class="boxheader"><b>Menu</b>
  </tr>
  <tr class="boxbody"> 
    <td width="100%" align="left"><div class="fuentecelda"><b>Ordenar por: </b> 
      <?php
if ($_GET['sort'] == 'pid'){
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=pid&mode='.urlencode($_GET['mode']).'">PID</a> ';
}else{
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=pid&mode='.urlencode($_GET['mode']).'">PID</a> ';
}
if ($_GET['sort'] == 'user'){
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=user&mode='.urlencode($_GET['mode']).'">Propietario</a> ';
}else{
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=user&mode='.urlencode($_GET['mode']).'">Propietario</a> ';
}
if ($_GET['sort'] == 'vsz'){
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=vsz&mode='.urlencode($_GET['mode']).'">Mem%</a> ';
}else{
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=vsz&mode='.urlencode($_GET['mode']).'">Mem%</a> ';
}
if ($_GET['sort'] == '%cpu'){
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=%cpu&mode='.urlencode($_GET['mode']).'">CPU%</a> ';
}else{
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=%cpu&mode='.urlencode($_GET['mode']).'">CPU%</a> ';
}
if ($_GET['sort'] == 'command'){
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=command&mode='.urlencode($_GET['mode']).'">Comando</a> ';
}else{
    echo '<a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=command&mode='.urlencode($_GET['mode']).'">Comando</a> ';
}
$_GET['sort'] = strtoupper($_GET['sort']);
?>
</div>
<div class="fuentecelda">
      <b>Modo: </b> <a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=<?php echo urlencode($_GET['sort']); ?>&mode=asc">Ascendente</a> 
      <a class="negro" href="index.php?grupo=sistema&seccion=procesos&pag=index&sort=<?php echo urlencode($_GET['sort']); ?>&mode=desc">Descendente</a> 
</div>
  </tr>
</table>
<?php echo procesos_generarinfo(); ?>