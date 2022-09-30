<?php
/**
 * Clase para las operaciones de la tabla privilegio y acciones.
 */
class Action extends Validator
{
    /**
    *  Declaración de propiedades.
    */
    private $id = null;
    private $tipo = null;
    private $nombre = null;
    private $accion = null;

    /**
    *   Método para asignar el valor en la propiedad id.
    *
    *   @return boolean true cuando se asigna correctamente el valor y false en caso contrario.
    *
    *   @param string $value es el valor a validar y asignar a la propiedad.
    */
    public function setId($value)
    {
        if ($this->validateId($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    *   Método para obtener el valor de la propiedad id.
    *
    *   @return int el valor de la propiedad id.
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    *   Método para asignar el valor en la propiedad tipo.
    *
    *   @return boolean true cuando se asigna correctamente el valor y false en caso contrario.
    *
    *   @param string $value es el valor a validar y asignar a la propiedad.
    */
    public function setTipo($value)
    {
        if ($this->validateId($value)) {
            $this->tipo = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    *   Método para obtener el valor de la propiedad tipo.
    *
    *   @return int el valor de la propiedad tipo.
    */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
    *   Método para asignar el valor en la propiedad nombre.
    *
    *   @return boolean true cuando se asigna correctamente el valor y false en caso contrario.
    *
    *   @param string $value es el valor a validar y asignar a la propiedad.
    */
    public function setNombre($value)
    {
        if ($this->validateAlphabetic($value,1,60)) {
            $this->nombre = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    *   Método para obtener el valor de la propiedad nombre.
    *
    *   @return int el valor de la propiedad tipo.
    */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
    *   Método para asignar el valor en la propiedad accion.
    *
    *   @return boolean true cuando se asigna correctamente el valor y false en caso contrario.
    *
    *   @param string $value es el valor a validar y asignar a la propiedad.
    */
    public function setAccion($value)
    {
        if ($this->validateId($value)) {
            $this->accion = $value;
            return true;
        } else {
            return false;
        }
    }

    /**
    *   Método para obtener el valor de la propiedad accion.
    *
    *   @return int el valor de la propiedad accion.
    */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
    *   Método para leer todas las acciones
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function readAllAction()
    {
        $sql = 'SELECT idAccion as Codigo, accionUsuario as Nombre FROM acciones ORDER BY accionUsuario asc';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    /**
    *   Método para leer las acciones que tiene el tipo de usuario
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function readAction()
    {
        $sql = 'SELECT accionUsuario as Accion, paginaAccion as Link, iconAccion as Icon FROM privilegios INNER JOIN (acciones) USING(idAccion) WHERE idTipoUsuario = ? ORDER BY  accionUsuario asc';
        $params = array($this->tipo);
        return Database::getRows($sql, $params);
    }

    /**
    *   Método para leer todos los tipos de usuario
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function readType()
    {
        $sql = 'SELECT idTipoUsuario as Codigo , tipousuario as Nombre FROM tipousuario WHERE estadoEliminacion = 1';
        $params = array(null);
        return Database::getRows($sql, $params);
    }

    /**
    *   Método para verificar el nombre
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function checkName()
    {
        $sql = 'SELECT estadoEliminacion FROM tipousuario WHERE tipousuario = ?';
        $params = array($this->nombre);
        return Database::getRow($sql, $params);
    }

    /**
    *   Método para verificar el nombre a la hora de modificar
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function checkNameUpdate()
    {
        $sql = 'SELECT estadoEliminacion FROM tipousuario WHERE tipousuario = ? AND idTipoUsuario NOT IN (?)';
        $params = array($this->nombre,$this->id);
        return Database::getRow($sql, $params);
    }

    /**
    *   Método para crear un tipo de usuario
    *
    *   @return boolean true si se ejecuto correctamente y false caso contrario.
    */
    public function createType()
    {
        $sql = 'INSERT INTO tipousuario VALUES (NULL, ?, 1)';
        $params = array($this->nombre);
        $exc = Database::executeRow($sql, $params);
        if($exc){
            $sql = 'SELECT idTipoUsuario FROM tipousuario WHERE tipousuario = ?';
            $params = array($this->nombre);
            $data = Database::getRow($sql, $params);
            if ($data) {
                $this->id = $data['idTipoUsuario'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    *   Método para seleccionar los privilegios del tipo de usuario
    *
    *   @return boolean true si se ejecuto correctamente y false caso contrario.
    */
    public function createPrivilege()
    {
        $sql = 'INSERT INTO privilegios VALUES (NULL, ?, ?)';
        $params = array($this->accion,$this->id);
        return Database::executeRow($sql, $params);
    }

    /**
    *   Método para obtener el nombre del tipo de usuario
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function getType()
    {
        $sql = 'SELECT idTipoUsuario as Codigo, tipousuario as Nombre FROM tipousuario WHERE idTipoUsuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    /**
    *   Método para obtener los id de las acciones del tipo de usuario
    *
    *   @return array con los datos correspondiente a la consulta
    */
    public function getAccionType()
    {
        $sql = 'SELECT idAccion as Codigo FROM privilegios  WHERE idTipoUsuario = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    /**
    *   Método para seleccionar los privilegios del tipo de usuario
    *
    *   @return boolean true si se ejecuto correctamente y false caso contrario.
    */
    public function updateType()
    {
        $sql = 'UPDATE tipousuario SET tipousuario = ? WHERE idTipoUsuario = ?';
        $params = array($this->nombre,$this->id);
        $exc = Database::executeRow($sql, $params);
        if($exc){
            $sql = 'DELETE FROM privilegios WHERE idTipoUsuario = ?';
            $params = array($this->id);
            return Database::executeRow($sql, $params);
        } else {
            return false;
        }
    }

    /**
    *   Método para seleccionar los privilegios del tipo de usuario
    *
    *   @return boolean true si se ejecuto correctamente y false caso contrario.
    */
    public function deleteType()
    {
        $sql = 'UPDATE tipousuario SET estadoEliminacion = 0 WHERE idTipoUsuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>