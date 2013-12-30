<html>
<head>
	<meta content="text/html; charset=UTF-8" http-equiv="content-type">
</head>
<table style="color:#666;font:13px Arial;line-height:1.4em;width:100%;">
	<tbody>

	    <tr>       
                <td cellspacing="0" cellpadding="10" style="color:#4D90FE;font-size:22px; border-bottom: 2px solid #4D90FE;">
                    <a href="http://www.uaca.ac.cr/"><img src="uaca.jpg" width="70" height="80" /></a>
                    <?php echo 'Departamento de Recursos Humanos' ?>
                </td>

            </tr>
		<tr>

                    <td style="color:#777;font-size:16px;padding-top:5px;">
                        <?php if(isset($data['description'])) echo $data['description'];  ?>
                    </td>
		</tr>
		<tr>
            <td>
				<?php echo $content ?>
            </td>
		</tr>
		<tr>
                    <td style="padding:15px 20px;text-align:left;padding-top:5px;border-top:solid 1px #dfdfdf">
			<?php echo 'Gracias por su colaboración.' ?>
                        <br></br>
                        <?php echo 'Si tiene dudas, por favor responda a este correo.' ?>
                    </td>
		</tr>
	</tbody>
</table>
</body>
</html>