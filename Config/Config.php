<?php 
	const BASE_URL = "http://crs.gomezsys.local";

	//Zona horaria
	date_default_timezone_set('America/Santo_Domingo');

	//Datos de conexión a Base de Datos
	const DB_HOST = "localhost";
	const DB_NAME = "db_crs";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "charset=utf8";

	//Para envío de correo
	const ENVIRONMENT = 0; // Local: 0, Produccón: 1;

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "$";
	const CURRENCY = "RD";
	const CURRENCYFORMAT = "PESOS DOMINICANOS";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "COMPLEJO RESIDENCIAL SAMANES";
	const EMAIL_REMITENTE = "no-reply@crs.org";
	const NOMBRE_EMPRESA = "COMPLEJO RESIDENCIAL SAMANES";
	const WEB_EMPRESA = "www.crs.org";

	const DESCRIPCION = "Junta de vecinos";
	const SHAREDHASH = "DesarrolloWeb";

	//Datos Empresa
	const SIGLAS = "CRS";
	const RNC = "430391123";
	const DIRECCION = "Carretera Licey, #51, Santiago, Rep. Dom.";
	const TELEMPRESA = "(809) 736-0941";
	const WHATSAPP = "+8097360941";
	const EMAIL_EMPRESA = "cont.complejoresidelcialsamanes@crs.org";
	const EMAIL_PEDIDOS = "cont.complejoresidelcialsamanes@crs.org"; 
	const EMAIL_SUSCRIPCION = "cont.complejoresidelcialsamanes@crs.org";
	const EMAIL_CONTACTO = "cont.complejoresidelcialsamanes@crs.org";

	//Para pagos a través de depositos o transfererncia
	const NUMERODECUENTA = "842553489";
	const CUENTA = "Corriente";
	const BANCO  = "Popular";
	const MORA = "3%";

	//Datos para Encriptar / Desencriptar
	const KEY = 'ABCD-1234.xyz';
	const METHODENCRIPT = "AES-256-CBC";
	const SECRETKEY = "@@E2011e2012@@";
	const SECRETIV = "10520211";

	//REDES SOCIALES
	const FACEBOOK = "https://www.facebook.com/gomezsys_net";
	const INSTAGRAM = "https://www.instagram.com/gomezsys_net/";

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MFAMILIES = 3;
	const MEMPLOYEES = 4;
	const MVISITS = 5;
	const MVEHICLES = 6;
	const MCONFIGURACION = 7;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PERROR = 8;

	//Roles
	const RSUPADMINISTRADOR = 1;
	const RADMINISTRADOR = 2;
	const RPROPIETARIOS = 3;
	const RCONTABLES = 4;
 ?>