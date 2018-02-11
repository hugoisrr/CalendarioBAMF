<?php

/************************************** /
/*    funcion para saber la extencion*/
/**************************************/
function extension ( $fileName ) { 
	return  substr(strrchr( $fileName,"."),1) ; 
} 
/************************************** /
/*    funcion para saber la edad*/
/**************************************/
function calculaedad($fechanacimiento){ 
list($ano,$mes,$dia) = explode("-",$fechanacimiento); 
$ano_diferencia = date("Y") - $ano; 
$mes_diferencia = date("m") - $mes; 
$dia_diferencia = date("d") - $dia; 
if ($dia_diferencia < 0 || $mes_diferencia < 0) 
	$ano_diferencia--; 
return $ano_diferencia; 
} 
/***************************************/
/*funcion para saber si el directorio  */
/* esta vacio o no      			   */
/***************************************/
function is_dir_empty($dir) {
	if (!is_readable($dir)) return NULL; 
	$handle = opendir($dir);
	while (false !== ($entry = readdir($handle))) {
	if ($entry != "." && $entry != "..") {
	  return FALSE;
	}
	}
	return TRUE;
}
/***************************************/
/*      funcion para enviar correo     */
/***************************************/
function send_mail($messageC,$subject,$email){
	$header = "From:  BAMF <coordinacion@bamf.com.mx>"." \n"; 
	$header .= 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 		
	$message = "<html><head></head><body";
	$message .= "<a href='http://www.bamf.com.mx/' target='_blank'><img src='http://bamf.com.mx/assets/images/190X60.png' alt='lOGO'/></a><br>";
	$message .= $messageC;
	$message .= "<tr>
					<td>
						<h2 style='font-family: 'Montserrat', sans-serif;'><a href='http://www.bamf.com.mx/' target='_blank' style='color: #0193D7;'>BAMF</a></h2>
					</td>
				</tr>
			</table></body></html>";
	return mail($email, $subject,$message, $header); 
}
/***************************************/	
/* funcion para generar una contraseña */
/***************************************/
function generate_password(){
	$password_length = "8"; // asignamos el número de caracteres que va a tener la nueva contraseña 
	$new_password = substr(md5(rand()),0,$password_length);
	return $new_password;
}
/**************************************/
/* funcion para que solo los usuarios */
/* administrador puedan acceder a las */
/*	     paginas de administrador     */
/**************************************/
function administrador(){
	global $user_data;
	if($user_data['idtipoUsuario'] != 1){
		header('Location: protect.php');
		exit();
	}
	
}
/**************************************/
/* funcion para que solo los usuarios */
/* jefe puedan acceder a las 		  */
/*	     paginas de jefe     		  */
/**************************************/
function jefe(){
	global $user_data;
	if($user_data['idtipoUsuario'] != 2){
		header('Location: protect.php');
		exit();
	}
	
}
/**************************************/
/* funcion para que solo los usuarios */
/* diseñador puedan acceder a las     */
/*	     paginas de diseñador  		  */
/**************************************/
function disenador(){
	global $user_data;
	if($user_data['idtipoUsuario'] != 3){
		header('Location: protect.php');
		exit();
	}
	
}
/**************************************/
/* funcion para que solo los usuarios */
/* programador puedan acceder a las   */
/*	     paginas de programador		  */
/**************************************/
function programador(){
	global $user_data;
	if($user_data['idtipoUsuario'] != 5){
		header('Location: protect.php');
		exit();
	}
	
}
/*******************************************/
/*    funcion para mostrar un telefono     */
/*	con formato de número teléfonico	   */
/*******************************************/
function format_telephone($phone_number)
{
    $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
    preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
    return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
}
/*******************************************/
/*    funcion para redireccionar a una     */
/*	pagina a un usuario con sesion activa  */
/*******************************************/
function logged_in_redirect(){
	if(logged_in() === true){
		user_type();
	}
}
/*******************************************/
/*    funcion para que solo los usuarios   */
/* registrados puedan acceder alas paginas */
/*******************************************/
function protect_page(){
	if(logged_in() === false){
		header('Location: protect.php');
		exit();
	}
}
/********************************************/
/*   Función para validar que los correos   */
/*            sean validos                  */
/********************************************/
function trueMail($str){
	if(preg_match("/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/", $str)){
            return true;
        } else {
            return false;
        }
}

/********************************************/
/*   Función para validar que las fechas */
/*            sean validos                  */
/********************************************/
function fecha($str){
	if(preg_match("/^(?:(?:0?[1-9]|1\d|2[0-8])(\/|-)(?:0?[1-9]|1[0-2]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:31(\/|-)(?:0?[13578]|1[02]))|(?:(?:29|30)(\/|-)(?:0?[1,3-9]|1[0-2])))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(29(\/|-)0?2)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/", $str)){
		return true;
        } else {
            return false;
        }
}
/*********************************************************************/
/*funcion para quitar caracteres esespeciales para consultas de mysql*/
/*********************************************************************/
function array_sanitize(&$item){
	$item = mysql_real_escape_string($item);
}
/*********************************************************************/
/*funcion para quitar caracteres esespeciales para consultas de mysql*/
/*********************************************************************/
function sanitize($data) {
	return mysql_real_escape_string($data);
}
/**************************************************/
/* funcion para agrupar los valores de una array  */
/*************************************************/
function output_errors($errors){
	return '<ul><li>' . implode('</li><li>', $errors) . '</li></ul>';
}
/**************************************************/
/* funcion para regresar el mes actual en letra   */
/*************************************************/
function mesActual(){
	$mes = date("m");
	switch ($mes) {
		case '01':
			$mes = "Enero";
			break;
		case '02':
			$mes = "Febrero";
			break;
		case '03':
			$mes = "Marzo";
			break;
		case '04':
			$mes = "Abril";
			break;
		case '05':
			$mes = "Mayo";
			break;
		case '06':
			$mes = "Junio";
			break;
		case '07':
			$mes = "Julio";
			break;
		case '08':
			$mes = "Agosto";
			break;
		case '09':
			$mes = "Septiembre";
			break;
		case '10':
			$mes = "Octubre";
			break;
		case '11':
			$mes = "Noviembre";
			break;
		case '12':
			$mes = "Diciembre";
			break;
		default:
			$mes = "No valido!";
			break;
	}
	return $mes;
}
/**************************************************/
/* función para enviar eventos a Calendario       */
/* Fuente: https://www.exchangecore.com/blog/sending-outlookemail-calendar-events-php/*/
/*Ejem: $from_name = "Coordinacion";        
		$from_address = "coordinacion@bamf.com.mx";        
		$to_name = "Hugo";        
		$to_address = "h.ramirez@bamf.com.mx";        
		$startTime = "03/17/2016 18:00:00";        
		$endTime = "03/17/2016 19:00:00";        
		$subject = "Prueba Calendario";        
		$description = "My Awesome Description, prueba BAMF";        
		$location = "BAMF";
		sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location);*/
/*************************************************/
function sendIcalEvent($from_name, $from_address, $to_name, $to_address, $startTime, $endTime, $subject, $description, $location)
{
    $domain = 'exchangecore.com';

    //Create Email Headers
    $mime_boundary = "----Meeting Booking----".MD5(TIME());

    $headers = "From: ".$from_name." <".$from_address.">\n";
    $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
    $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
    $headers .= "Content-class: urn:content-classes:calendarmessage\n";
    
    //Create Email Body (HTML)
    $message = "--$mime_boundary\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\n";
    $message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message .= "<html>\n";
    $message .= "<body>\n";
    $message .= '<p>Dear '.$to_name.',</p>';
    $message .= '<p>'.$description.'</p>';
    $message .= "</body>\n";
    $message .= "</html>\n";
    $message .= "--$mime_boundary\r\n";

    $ical = 'BEGIN:VCALENDAR' . "\r\n" .
    'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" .
    'VERSION:2.0' . "\r\n" .
    'METHOD:REQUEST' . "\r\n" .
    'BEGIN:VTIMEZONE' . "\r\n" .
    'TZID:Eastern Time' . "\r\n" .
    'BEGIN:STANDARD' . "\r\n" .
    'DTSTART:20091101T020000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" .
    'TZOFFSETFROM:-0400' . "\r\n" .
    'TZOFFSETTO:-0500' . "\r\n" .
    'TZNAME:EST' . "\r\n" .
    'END:STANDARD' . "\r\n" .
    'BEGIN:DAYLIGHT' . "\r\n" .
    'DTSTART:20090301T020000' . "\r\n" .
    'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" .
    'TZOFFSETFROM:-0500' . "\r\n" .
    'TZOFFSETTO:-0400' . "\r\n" .
    'TZNAME:EDST' . "\r\n" .
    'END:DAYLIGHT' . "\r\n" .
    'END:VTIMEZONE' . "\r\n" .	
    'BEGIN:VEVENT' . "\r\n" .
    'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" .
    'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" .
    'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" .
    'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" .
    'DTSTAMP:'.date("Ymd\TGis"). "\r\n" .
    'DTSTART;TZID="Eastern Time":'.date("Ymd\THis", strtotime($startTime)). "\r\n" .
    'DTEND;TZID="Eastern Time":'.date("Ymd\THis", strtotime($endTime)). "\r\n" .
    'TRANSP:OPAQUE'. "\r\n" .
    'SEQUENCE:1'. "\r\n" .
    'SUMMARY:' . $subject . "\r\n" .
    'LOCATION:' . $location . "\r\n" .
    'CLASS:PUBLIC'. "\r\n" .
    'PRIORITY:5'. "\r\n" .
    'BEGIN:VALARM' . "\r\n" .
    'TRIGGER:-PT15M' . "\r\n" .
    'ACTION:DISPLAY' . "\r\n" .
    'DESCRIPTION:Reminder' . "\r\n" .
    'END:VALARM' . "\r\n" .
    'END:VEVENT'. "\r\n" .
    'END:VCALENDAR'. "\r\n";
    $message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n";
    $message .= "Content-Transfer-Encoding: 8bit\n\n";
    $message .= $ical;

    $mailsent = mail($to_address, $subject, $message, $headers);

    return ($mailsent)?(true):(false);
}
?>