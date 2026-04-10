<?php 

	class Usuarios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(MUSUARIOS);
		}

		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "USUARIOS | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Usuarios <small>".NOMBRE_EMPRESA."</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "fnts_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){
				if(empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtPhone']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUsuario']);
					$intLocationId = intval($_POST['intLocationid']);
					$intnomenclature = intval($_POST['nomenclaturaid']);
					$strIdentification = preg_replace('/[^0-9]/', '',strClean($_POST['txtIdentificacion']));
					$strPassport = strtoupper(strClean($_POST['txtPassport']));
					$strName = strtoupper(strClean($_POST['txtNombres']));
					$strLastname = strtoupper(strClean($_POST['txtApellidos']));
					$intStreetId = intval($_POST['street_id']);
					$intHomeNumber = intval($_POST['homeNumber']);
					$intCell = preg_replace('/[^0-9]/', '',strClean($_POST['txtCel']));
					$intTel = preg_replace('/[^0-9]/', '',strClean($_POST['txtPhone']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));

					$request_user = "";
					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
						$strPassword = empty($_POST['txtPassword']) 
						? passGenerator() 
						: $_POST['txtPassword'];

					$passwordHash = password_hash($strPassword, PASSWORD_DEFAULT);
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertUsuario($strIdentification,
																		$strPassport,
																		$strName,
																		$strLastname, 
																		$intTel, 
																		$intCell,
																		$strEmail,
																		$passwordHash,
																		$intLocationId,
																		$intStreetId,
																		$intHomeNumber,
																		$intTipoId, 
																		$intStatus);
						}
					}else{
						$option = 2;
						$passwordHash = empty($_POST['txtPassword']) ? "" : password_hash($_POST['txtPassword'], PASSWORD_DEFAULT);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateUsuario($idUsuario, 
																		$strIdentification,
																		$strPassport,
																		$strName,
																		$strLastname, 
																		$intTel, 
																		$intCell,
																		$strEmail,
																		$passwordHash,
																		$intLocationId,
																		$intStreetId,
																		$intHomeNumber,
																		$intTipoId, 
																		$intStatus);
						}

					}

					if($request_user > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_user == 'emailExist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe.');		
					}else if($request_user == 'identificacionExist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! la identificación ya existe.');		
					}else if($request_user == 'passportExist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el passaporte ya existe.');	
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuarios()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectUsuarios();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					// Formatear teléfono directamente aquí
            		$arrData[$i]['telefono'] = formatPhone($arrData[$i]['telefono']);


					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['idusuario'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) ){
							$btnEdit = '<button class="btn btn-warning  btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['idusuario'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) ||
							($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and
							($_SESSION['userData']['idusuario'] != $arrData[$i]['idusuario'] )
							 ){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idusuario'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
						}else{
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuario($idusuario){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idusuario);
				if($idusuario > 0)
				{
					$arrData = $this->model->selectUsuario($idusuario);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "PERFIL DE USUARIO";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "fnts_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}

		/*public function putPerfil(){
			if($_POST){
				if ($_FILES["image"]["size"] != 0) {
				  $idUsuario = $_SESSION['idUser'];
				  // rename the image before saving to database
				  $original_name = $_FILES["image"]["name"];
			      $new_image_name = uniqid() . time() . "." . pathinfo($original_name, PATHINFO_EXTENSION);
			      move_uploaded_file($_FILES["image"]["tmp_name"], "Assets/img/uploads/" . $new_image_name);
				  $request_user_image = $this->model->updateImage($idUsuario,$new_image_name);	
				    if($request_user_image)
					{
						sessionUser($_SESSION['idUser']);
						if (!empty($_POST["image_old"]) && $_POST["image_old"] != "default_profile.jpg") {
							// remove the old image from uploads directory
			      			unlink("Assets/img/uploads/" . $_POST["image_old"]);
						}
						$arrResponse = array('status' => true, 'msg' => 'Imagen Actualizada correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar la imagen.');
					}
				}else if(empty($_POST['txtNombre']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNombre = strClean($_POST['txtNombre']);
					$strEmail = strClean($_POST['txtEmail']);
					$intTelefono = preg_replace('/[^0-9]/', '',strClean($_POST['txtTelefono']));
					$strPassword = "";
					$strDireccion = strClean($_POST['txtDireccion']);
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updatePerfil($idUsuario,
																$strNombre, 
																$intTelefono,
																$strEmail,
																$strPassword,
																$strDireccion);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}*/
		public function putPerfil()
		{
			if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
				echo json_encode([
					'status' => false,
					'msg' => 'Método no permitido.'
				], JSON_UNESCAPED_UNICODE);
				die();
			}

			if (empty($_SESSION['idUser'])) {
				echo json_encode([
					'status' => false,
					'msg' => 'Sesión no válida.'
				], JSON_UNESCAPED_UNICODE);
				die();
			}

			$idUsuario = (int) $_SESSION['idUser'];

			try {
				// =========================
				// 1) Validar campos base
				// =========================
				$strNombre    = isset($_POST['txtNombre']) ? strClean(trim($_POST['txtNombre'])) : '';
				$strLastname  = isset($_POST['txtApellidos']) ? strClean(trim($_POST['txtApellidos'])) : '';
				$strTelefono  = isset($_POST['txtTelefono']) ? preg_replace('/[^0-9]/', '', strClean($_POST['txtTelefono'])) : '';
				$strEmail     = isset($_POST['txtEmail']) ? strClean(trim($_POST['txtEmail'])) : '';
				$strPassword  = isset($_POST['txtPassword']) ? trim($_POST['txtPassword']) : '';
				$imageOld     = isset($_POST['image_old']) ? basename($_POST['image_old']) : '';

				if ($strNombre === '' || $strTelefono === '' || $strEmail === '') {
					echo json_encode([
						'status' => false,
						'msg' => 'Los campos nombre, teléfono y correo son obligatorios.'
					], JSON_UNESCAPED_UNICODE);
					die();
				}

				if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
					echo json_encode([
						'status' => false,
						'msg' => 'El correo electrónico no es válido.'
					], JSON_UNESCAPED_UNICODE);
					die();
				}

				// =========================
				// 2) Preparar password
				// =========================
				$passwordHash = '';
				if ($strPassword !== '') {
					// Recomendado en vez de SHA256 directo
					$passwordHash = password_hash($strPassword, PASSWORD_DEFAULT);
				}

				// =========================
				// 3) Actualizar datos perfil
				// =========================
				$request_user = $this->model->updatePerfil(
					$idUsuario,
					$strNombre,
					$strLastname,
					$strTelefono,
					$strEmail,
					$passwordHash
				);

				if ($request_user === "emailExist") {
					echo json_encode([
						'status' => false,
						'msg' => 'El correo electrónico ya está registrado por otro usuario.'
					], JSON_UNESCAPED_UNICODE);
					die();
				}

				if (!$request_user) {
					echo json_encode([
						'status' => false,
						'msg' => 'No fue posible actualizar los datos del perfil.'
					], JSON_UNESCAPED_UNICODE);
					die();
				}

				// =========================
				// 4) Procesar imagen SOLO si fue enviada
				// =========================
				if (
					isset($_FILES['image']) &&
					isset($_FILES['image']['error']) &&
					$_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE
				) {
					$file = $_FILES['image'];

					if ($file['error'] !== UPLOAD_ERR_OK) {
						echo json_encode([
							'status' => false,
							'msg' => 'Los datos fueron actualizados, pero hubo un error al subir la imagen.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					$maxSize = 2 * 1024 * 1024; // 2MB
					$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
					$allowedMimeTypes  = ['image/jpeg', 'image/png', 'image/webp'];

					$originalName = $file['name'];
					$tmpName      = $file['tmp_name'];
					$fileSize     = (int) $file['size'];
					$extension    = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

					// Validar tamaño
					if ($fileSize <= 0 || $fileSize > $maxSize) {
						echo json_encode([
							'status' => false,
							'msg' => 'La imagen debe ser válida y no superar los 2MB.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					// Validar extensión
					if (!in_array($extension, $allowedExtensions, true)) {
						echo json_encode([
							'status' => false,
							'msg' => 'Formato de imagen no permitido. Solo JPG, JPEG, PNG y WEBP.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					// Validar MIME real
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mimeType = finfo_file($finfo, $tmpName);
					finfo_close($finfo);

					if (!in_array($mimeType, $allowedMimeTypes, true)) {
						echo json_encode([
							'status' => false,
							'msg' => 'El archivo enviado no es una imagen válida.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					// Crear nombre único robusto
					$newImageName = bin2hex(random_bytes(16)) . '.' . $extension;
					$uploadDir = dirname(__DIR__) . '/Assets/img/uploads/';
					$uploadPath = $uploadDir . $newImageName;

					// Crear carpeta si no existe
					if (!is_dir($uploadDir)) {
						mkdir($uploadDir, 0775, true);
					}

					if (!move_uploaded_file($tmpName, $uploadPath)) {
						echo json_encode([
							'status' => false,
							'msg' => 'Los datos fueron actualizados, pero no se pudo guardar la imagen.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					// Guardar nombre en BD
					$request_user_image = $this->model->updateImage($idUsuario, $newImageName);

					if (!$request_user_image) {
						// Si falla BD, elimina la imagen subida para no dejar basura
						if (file_exists($uploadPath)) {
							unlink($uploadPath);
						}

						echo json_encode([
							'status' => false,
							'msg' => 'Los datos fueron actualizados, pero no fue posible registrar la imagen.'
						], JSON_UNESCAPED_UNICODE);
						die();
					}

					// Eliminar imagen anterior si aplica
					if ($imageOld !== '' && $imageOld !== 'default_profile.jpg') {
						$oldPath = $uploadDir . $imageOld;
						if (file_exists($oldPath) && is_file($oldPath)) {
							unlink($oldPath);
						}
					}
				}

				// =========================
				// 5) Refrescar sesión
				// =========================
				sessionUser($idUsuario);

				echo json_encode([
					'status' => true,
					'msg' => 'Perfil actualizado correctamente.'
				], JSON_UNESCAPED_UNICODE);
				die();

			} catch (Exception $e) {
				echo json_encode([
					'status' => false,
					'msg' => 'Ocurrió un error inesperado al actualizar el perfil.'
					// En desarrollo puedes devolver: 'error' => $e->getMessage()
				], JSON_UNESCAPED_UNICODE);
				die();
			}
		}

		public function putDFical(){
			if($_POST){
				if(empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNit = strClean($_POST['txtNit']);
					$strNomFiscal = strClean($_POST['txtNombreFiscal']);
					$strDirFiscal = strClean($_POST['txtDirFiscal']);
					$request_datafiscal = $this->model->updateDataFiscal($idUsuario,
																		$strNit,
																		$strNomFiscal, 
																		$strDirFiscal);
					if($request_datafiscal)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
 ?>