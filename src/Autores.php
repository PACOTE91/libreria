<?php

namespace Libreria;
use PDOException;
use Faker;
use PDO;

class Autores extends Conexion{

    private $id;
    private $nombre;
    private $apellidos;
    private $pais;

    public function __construct(){
        //Llama al contructor de la case padre
        parent::__construct();

    }

    //////-------------------CRUD----------------------////////
    public function create(){

        //Parametrizando la consulta :n / :a / :p (EVITAR ATAQUES)
        $sql="INSERT INTO autores (nombre, apellidos, pais) VALUES (:n, :a, :p)";
        $stmt=parent::$conexion->prepare($sql);

        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':p'=>$this->pais
            ]);
            
        }catch(PDOException $ex){
            die("Error al insertar: ".$ex->getMessage());
        }

    }

    public function devolverAutores(){
        $sql="select apellidos, nombre, id FROM autores";
        $stmt=parent::$conexion->prepare($sql);

        try{
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error ".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetchall(PDO::FETCH_OBJ);

    }


    public function update(){
        $sql="UPDATE autores SET nombre=:n, apellidos=:a, pais=:p WHERE id=:i";

        $stmt=parent::$conexion->prepare($sql);
        try{
            //$stmt.execute() Ejecutar la sec
            $stmt->execute([
                ':n'=>$this->nombre,
                ':a'=>$this->apellidos,
                ':p'=>$this->pais,
                ':i'=>$this->id
            ]

            );
        }catch(PDOException $ex){
            die("Error al actualizar el autor".$ex->getMessage());

        }
        parent::$conexion=null;

    }

    public function delete($id){
        $sql="DELETE FROM autores WHERE id=:i";
        $stmt=parent::$conexion->prepare($sql);
        try{
            //$stmt.execute() Ejecutar la sec
            $stmt->execute([
                ':i'=>$id
            ]

            );
        }catch(PDOException $ex){
            die("Error al borrar el autor".$ex->getMessage());

        }
        parent::$conexion=null;
        //Aqui no hay nada que devolver
        // return $stmt;

    }

    public function read(){
        $sql="SELECT * FROM autores ORDER BY id DESC";

        //(Statement) stmt, hereda conexión y prepara la secuencia SQL para su ejecucion
        $stmt=parent::$conexion->prepare($sql);

        try{
            //$stmt.execute() Ejecutar la sec
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los autores".$ex->getMessage());

        }
        parent::$conexion=null;
        return $stmt;

    }

    public function read_id($id){
        $sql="SELECT * FROM autores WHERE id=$id";

        //(Statement) stmt, hereda conexión y prepara la secuencia SQL para su ejecucion
        $stmt=parent::$conexion->prepare($sql);

        try{
            //$stmt.execute() Ejecutar la sec
            $stmt->execute();
        }catch(PDOException $ex){
            die("Error al recuperar los autores".$ex->getMessage());

        }
        parent::$conexion=null;
        //Fetch se recorre con while (Microconexiones)
        //fetchAll se recorre con each (Manda todos)
        return $stmt->fetch(PDO::FETCH_OBJ);

    }


    

        //////-------------------FIN CRUD----------------------////////


        //////-------------------OTROS METODOS-----------------/////////
        public function generarAutores($cantidad){

            if($this->hayAutores()==0){

                $faker=Faker\Factory::create('es_ES');

                for($i=0; $i<$cantidad; $i++){

                    $nombre=$faker->firstName();
                    $apellidos=$faker->lastName();
                    $pais=$faker->country();     
               
                    (new Autores)->setNombre($nombre)->setApellidos($apellidos)->setPais($pais)->create();

                }
            }

        }

        public function hayAutores(){
            $sql="SELECT * FROM autores";
            $stmt=parent::$conexion->prepare($sql);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error en hay autores:".$ex->getMessage());
            }
            parent::$conexion=null;

            return $stmt->rowCount(); //Devuelve numero filas

        }


        public function devolverId(){
            $q="select id from autores order by id";
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error en el metodo devolver id: ".$ex->getMessage());
            }
            $id=[];
            while($fila=$stmt->fetch(PDO::FETCH_OBJ)){
                $id[]=$fila->id;
            }
            parent::$conexion=null;
            return $id;
    
        }


    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of pais
     */ 
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     *
     * @return  self
     */ 
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }
}
