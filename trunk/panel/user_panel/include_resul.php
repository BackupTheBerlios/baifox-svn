<table width=70% align=center class=main>
  <tr bgcolor="#FFCC66"> 
    <td width=50% valign=top align=left height="10" style="BORDER-RIGHT: #000000 1px solid; BORDER-TOP: #000000 1px solid; BORDER-LEFT: #000000 1px solid; BORDER-BOTTOM: #000000 1px solid" bgcolor="#FFCB0D"> 
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000"></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        <?php switch ($_GET['resulid']){
    Case 1:
        echo "Su mensaje ha sido enviado correctamente";
        break;
    Case 99:
        echo $_SESSION['strTemp'];
        break;
}?>
        </font></p>
    </td>
  </tr>
</table>
