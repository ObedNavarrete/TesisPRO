<?php
require_once "conexion.php";

class ModeloNumeros
{
    /*MOSTRAR USUARIOS*/
    static public function mdlMostrarNumeros($tabla, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla
                WHERE $item = :$item"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla
                ORDER BY numero ASC"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /*MOSTRAR Numeros en el modal de vender de los vendedores*/
    static public function mdlMostrarNumerosVenta($tabla, $item, $valor)
    {
        if ($item != null && $valor != null) {
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla
                WHERE $item = :$item AND pasivo=0"
            );

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            // //Tambien podria hacerse de esta manera
            // $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where $item = $valor");

            $stmt->execute();
            return $stmt->fetch();
        } else {
            //Para mostrar todos los datos de la tabla en la seccion de usuarios
            $stmt = Conexion::conectar()->prepare(
                "SELECT * FROM $tabla
                WHERE pasivo = 0
                ORDER BY numero ASC"
            );

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    static public function mdlRegistroNumeros($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare(
            "INSERT INTO $tabla(numero)
            VALUES (:numero)"
        );

        $stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

        if ($stmt->execute()) {
            return "ok";
        } else {
            /* echo "\nPDO::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo()); */
            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }

    //Para editar un Usuario
    static public function mdlEditarNumeros($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET numero = :numero WHERE id = :id"
        );

        $stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_INT);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        //Igual a como sale en el controlador

        if ($stmt->execute()) {

            return "ok";
        } else {

            /* echo "\nPDO::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo()); */
            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
    }

    //Eliminar Usuarios
    static public function mdlEliminarNumeros($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare(
            "UPDATE $tabla SET pasivo = 1
            WHERE id = :id"
        );

        $stmt->bindParam(':id', $datos["id"], PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            /* echo "\nPDO::errorInfo():\n";
            print_r(Conexion::conectar()->errorInfo()); */

            echo "
                    <script>
                        Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ERROR: No puede tener dos números iguales',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    ";
        }
        $stmt = null;
    }


    static public function mdlActualizarNumero($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		/* $stmt -> close(); */
		$stmt = null;

	}
}
