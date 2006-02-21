<?php 
include "webpanel/".$_GET['grupo']."/include_permiso.php"; 
if(count($_SESSION['SEC_USER_DOMINIOS'])>=$_SESSION['SEC_USER_TOTAL_DOMINIOS']){
 	exit();
}
?> 
<form method="POST" name="formulario" action="webpanel/<?php echo $_GET['grupo']."/".$_GET['seccion']; ?>/save.php?id=0">
  <table border="0" cellspacing="0" cellpadding="0" align="center" width="500">
    <tr> 
      <td colspan="3" bgcolor="#F2A500"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="12%" align="center"><img src="images/icn_addcorreo.gif" width="47" height="34"></td>
            <td width="88%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><b><font size="2" color="#FFFFFF">Crear 
              nuevo dominio</font></b></font></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr align="center"> 
      <td colspan="3"> 
        <table width="100%" border="0" cellspacing="2" cellpadding="0">
          <tr align="left" bgcolor="#d6d6d6"> 
            <td height="25" align="right" width="46%" bgcolor="#d6d6d6"><font size="2">Dominio</font></td>
            <td height="25" align="left" width="54%"> 
              <input type="text" name="frmDominio" size="35" onKeyUp="crear_basedatos(this.form); crear_usuario(this.form);" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
            </td>
          </tr>
          <tr align="left" bgcolor="#d6d6d6"> 
            <td height="25" align="right" width="46%" bgcolor="#d6d6d6"><font size="2">Base 
              Datos </font></td>
            <td height="25" align="left" width="54%"> 
              <input type="text" name="frmBase" size="15" maxlength="14" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              <font size="2"> Max 14 car.</font> </td>
          </tr>
          <tr align="left" bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right"><font size="2">Usuario</font></td>
            <td width="54%"> 
              <input type="text" name="frmUsuario" size="15" maxlength="14" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              <font size="2"> Max 14 car.</font> </td>
          </tr>
          <tr align="left" bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right"><font size="2">Password</font></td>
            <td width="54%"> 
              <input type="text" name="frmPassword" size="15" maxlength="14" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              <font size="2"> Max 14 car.</font> </td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right" ><font size="2">Cuentas</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmCuentas" value="-1" size="4" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right" ><font size="2">Redirecciones</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmRedirecciones" value="-1" size="4" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right"><font size="2">Alias</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmAlias" value="-1" size="4" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right" ><font size="2">Autorespondedores</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmAutoRespuesta" value="-1" size="4" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right" ><font size="2">Listas 
              de Correo</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmLista" value="-1" size="4" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              0 = deshabilitado; -1 = ilimitado</font></td>
          </tr>
          <tr bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right"><font size="2">Quota 
              de Correo</font></td>
            <td width="54%"> <font size="2"> 
              <input type="text" name="frmQuotaCORREO" value="NOQUOTA" size="10" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              ejemplo: 10M, 500K, 5MB</font></td>
          </tr>
          <tr align="left" bgcolor="#d6d6d6"> 
            <td width="46%" bgcolor="#d6d6d6" align="right"><font size="2">Quota 
              FTP </font></td>
            <td width="54%"> 
              <input type="text" name="frmQuotaFTP" size="20" value="100" class="boxBlur" onFocus="this.className='boxFocus'"  onBlur="this.className='boxBlur'">
              Mb </td>
          </tr>
          <tr align="center" bgcolor="#d6d6d6"> 
            <td colspan="2" bgcolor="#d6d6d6"><a href="javascript:document.formulario.submit();"><img src="images/icn_grabar.gif" width="25" height="25" border="0"><br>
              [ A&ntilde;adir ] </a></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>

