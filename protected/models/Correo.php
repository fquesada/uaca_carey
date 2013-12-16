<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class Correo extends CFormModel
{
	public $destinatario;
	public $asunto;
	public $mensaje;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// destinatario, asunto and mensaje son requeridos
			array('destinatario, asunto, mensaje', 'required'),
			// email has to be a valid email address
			array('destinatario', 'email'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
                        'destinatario'=>'Destinatario',
                        'asunto'=>'Asunto',
                        'mensaje'=>'Mensaje',
		);
	}       
}