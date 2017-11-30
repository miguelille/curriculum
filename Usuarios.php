<?php

		include_once "bd.php";

    class Usuarios{
        public static function comprobarUsuario(){
            $dni = $_REQUEST["dni"];

            $db = new BD();
            $sql = "SELECT * FROM alumno WHERE dni='$dni'";
            $resultado = $db->consultar($sql);


            if(count($resultado) > 0){
              return true;
            }else{
              return false;
            }
        }

        public static function crearUsuario(){
            $dni = $_REQUEST["dni"];
            $nombreal = $_REQUEST["nombreal"];
            $apellido = $_REQUEST["apellido"];
            $passal = $_REQUEST["passal"];
            $telefono = $_REQUEST["telefono"];
            $correo = $_REQUEST["correo"];
            $provincia = $_REQUEST["provincia"];
            $localidad = $_REQUEST["localidad"];
            $direccion = $_REQUEST["direccion"];
            $activo = $_REQUEST["activo"];

            $db = new BD();
            $sql = "INSERT INTO alumno(dni,nombreal,apellido,telefono,correo,direccion,localidad,provincia,activo,passal, validado) VALUES('$dni','$nombreal','$apellido','$telefono','$correo','$direccion','$localidad','$provincia','$activo','$passal', 0)";

            if ($db->ejecutar($sql) == 1)
								$r = true;
						else
								$r =  false;
					  return $r;
        }

        public static function logueoAdmin($dni, $contra){
            $db= new BD();
            // primero comprobamos que si es un administrador
            $sql= "SELECT * FROM admin WHERE username='$dni' AND passad='$contra'";
            //echo $sql;
            $resultado = $db->consultar($sql);

            if(count($resultado) > 0){
                $_SESSION['tipo']="admin";
                return true;
            }else{
                return false;
            }
        }

	public static function logueoUser($dni, $contra){
            $db= new BD();
            // primero comprobamos que si es un administrador
            $sql= "SELECT * FROM alumno WHERE dni='$dni' AND passal='$contra' ";
            //echo $sql;
            $resultado = $db->consultar($sql);

            if(count($resultado) > 0){

                $sql = "SELECT validado FROM alumno WHERE dni='$dni'";
                $resultado = $db->consultar($sql);
                $resultado=$resultado[0];
                if($resultado['validado']==0){
                    return false;

                }else{
                    $sql = "SELECT alumnoid FROM alumno WHERE dni='$dni' ";
                    $resultado = $db->consultar($sql);

                    $resultado = $resultado["0"];
                    $_SESSION['id']=$resultado["0"];
                    return true;
                }

            }else{
                return false;
            }
        }
        public static function usuariosParo(){
                $db = new BD();

                $sql = "SELECT * FROM alumno WHERE activo=0 and validado=1 ORDER BY puntuacion desc";
                $tabla["alumnos"]= $db->consultar($sql);

                return $tabla;
        }
        public static function usuariosSinValidar(){
            $db = new BD();

                $sql = "SELECT * FROM alumno WHERE validado=0 order by alumnoid";
                $tabla["alumnos"]= $db->consultar($sql);

                return $tabla;
        }

        public static function validarUsuario(){
            $db = new BD();
            $id=$_REQUEST["id"];
            $puntuacion = $_REQUEST["puntuacion"];
            $sql = "UPDATE alumno SET validado='1' where alumnoid='$id'";
            $db->ejecutar($sql);
            $sql = "UPDATE alumno SET puntuacion='$puntuacion' WHERE alumnoid='$id'";
            $db->ejecutar($sql);
        }

        public static function borrarUsuario(){
            $db = new BD();
            $id=$_REQUEST["id"];
            $sql = "DELETE FROM alumno WHERE alumnoid=$id";
            $db->ejecutar($sql);
            $sql = "DELETE FROM habilidad WHERE alumnoid=$id";
            $db->ejecutar($sql);
            $sql = "DELETE FROM idiomaalumno WHERE alumnoid=$id";
            $db->ejecutar($sql);
            $sql = "DELETE FROM otrosalumno WHERE alumnoid=$id";
            $db->ejecutar($sql);
            $sql = "DELETE FROM titulo WHERE alumnoid=$id";
            $db->ejecutar($sql);

        }
        public static function busqueda(){

            $db = new BD();
            $busqueda=$_REQUEST["buscar"];//nombreal,apellido,alumnoid,correo,telefono

            $sql = "SELECT alumno.nombreal, alumno.apellido, alumno.telefono, alumno.correo, alumno.puntuacion FROM
						 alumno LEFT JOIN habilidad ON alumno.alumnoid=habilidad.alumnoid
						 LEFT JOIN titulo ON alumno.alumnoid=titulo.alumnoid
						 LEFT JOIN  idiomaalumno ON alumno.alumnoid=idiomaalumno.alumnoid
						 LEFT JOIN idioma ON idiomaalumno.idiomaid=idioma.idiomaid
						 LEFT JOIN nivel ON idiomaalumno.nivelid=nivel.nivelid
						 WHERE alumno.nombreal LIKE '%$busqueda%'
						 OR alumno.apellido LIKE '%$busqueda%'
						 OR alumno.provincia LIKE '%$busqueda%'
						 OR alumno.localidad LIKE '%$busqueda%'
						 OR habilidad.nombreha LIKE '%$busqueda%'
						 OR habilidad.descripcion LIKE '%$busqueda%'
						 OR titulo.nombreti LIKE '%$busqueda%'
						 OR titulo.centro LIKE '%$busqueda%'" ;
						 echo "$sql";
            $tabla=$db->consultar($sql);
            return $tabla;
        }
		public static function infoUsuario($id){
            $db = new BD();

            $sql = "SELECT * FROM alumno WHERE alumnoid='$id'";

            $resultado = $db->consultar($sql);

            return $resultado;
        }
        public static function modificarInfoUsuario(){
            $db = new BD();
			if(isset($_REQUEST["puntuacion"])){
				$sql = "UPDATE alumno SET nombreal='".$_REQUEST['nombreal']."',"
                    . "apellido='".$_REQUEST['apellido']."',"
                    . "telefono='".$_REQUEST['telefono']."',"
                    . "correo='".$_REQUEST['correo']."',"
                    . "direccion='".$_REQUEST['direccion']."',"
                    . "localidad='".$_REQUEST['localidad']."',"
                    . "provincia='".$_REQUEST['provincia']."',"
                    . "dni='".$_REQUEST['dni']."',"
                    . "activo='".$_REQUEST['activo']."', "
                    . "puntuacion='".$_REQUEST['puntuacion']."'"
                    . "WHERE alumnoid='".$_REQUEST['id']."'";
			}else{
				$sql = "UPDATE alumno SET nombreal='".$_REQUEST['nombreal']."',"
                    . "apellido='".$_REQUEST['apellido']."',"
                    . "telefono='".$_REQUEST['telefono']."',"
                    . "correo='".$_REQUEST['correo']."',"
                    . "direccion='".$_REQUEST['direccion']."',"
                    . "localidad='".$_REQUEST['localidad']."',"
                    . "provincia='".$_REQUEST['provincia']."',"
                    . "dni='".$_REQUEST['dni']."',"
                    . "activo='".$_REQUEST['activo']."'"
                    . "WHERE alumnoid='".$_REQUEST['id']."'";
			}
            $db->ejecutar($sql);
        }
        
       
        public static function insertarImagen(){
            //var_dump($_FILES['imagen']);
            //$documento = $_FILES['imagen'];
            
            echo $_SESSION['id'];
            
            $nombre_imagen=$_FILES['imagen']['name'];
            $tipo_imagen=$_FILES['imagen']['type'];
            $tamano_imagen=$_FILES['imagen']['size'];
            
            if (($nombre_imagen == !NULL) && ($_FILES['imagen']['size'] <= 1500000)){
                if (($_FILES["imagen"]["type"] == "image/jpeg")
               || ($_FILES["imagen"]["type"] == "image/jpg"))
               {
            $carpeta_destino=$_SERVER['DOCUMENT_ROOT'].'/curriculum-master/imagenes/';
   
            move_uploaded_file($_FILES['imagen']['tmp_name'],$carpeta_destino.$_SESSION['id'].".jpg");
                    
              }else{
                   //si no cumple con el formato
                   echo "Solo puedes imagenes con formato jpg";
                }
            }else{
               //si existe la variable pero se pasa del tamaño permitido
               if($nombre_imagen == !NULL) 
                   echo "La imagen es demasiado grande"; 
            }       
           
        } 
        
    }
