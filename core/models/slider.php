<?php 
class Slider extends Validator{
    //Declaración de propiedades
    private $id = null;
    private $titulo = null;
    private $subtitulo = null;
    private $estado = null;
    private $foto = null;
    private $ruta = "../../resources/img/public/slider/";

    //Métodos para sobrecarga de propiedades
    public function setId($value)
    {
        if ($this->validateId($value)) {
			$this->id = $value;
			return true;
        } else {
			return false;
		}
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitulo($value)
    {
        if($this->validateAlphanumeric($value,1,50)){
            $this->titulo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setSubtitulo($value)
    {
        if($this->validateAlphanumeric($value,1,50)){
            $this->subtitulo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getSubtitulo()
    {
        return $this->subtitulo;
    }

    public function setEstado($value)
	{
		if ($value == '1' || $value == '0') {
			$this->estado = $value;
			return true;
		} else {
			return false;
		}
	}

	public function getEstado()
	{
		return $this->estado;
	}

    public function setFoto($file,$name)
    {
        if($this->validateImageFile($file,$this->ruta,$name,700,400)) {
            $this->foto = $this->getImageName();
            return true;
        } else {
            return false;
        }
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function readSlider()
    {
        $sql = 'SELECT idSlider, tituloSlider,subtituloSlider,fotoSlider,visibilidadSlider FROM slider WHERE estadoSlider = ? ORDER BY visibilidadSlider DESC';
		$params = array($this->estado);
		return Database::getRows($sql, $params);
    }

    public function createSlider()
    {
        $sql = 'INSERT slider VALUES (NULL,?,?,?,1,1)';
		$params = array($this->titulo,$this->subtitulo,$this->foto);
		return Database::executeRow($sql, $params);
    }

    public function getSlider(){
        $sql = 'SELECT idSlider, tituloSlider,subtituloSlider,fotoSlider,visibilidadSlider FROM slider WHERE idSlider = ?';
		$params = array($this->id);
		return Database::getRow($sql, $params);
    }

    public function updateSlider(){
        $sql = 'UPDATE slider SET tituloSlider = ? , subtituloSlider = ?, fotoSlider = ?, visibilidadSlider = ? WHERE idSlider = ?';
		$params = array($this->titulo,$this->subtitulo,$this->foto,$this->estado,$this->id);
		return Database::executeRow($sql, $params);
    }

    public function actSlider(){
        $sql = 'UPDATE slider SET estadoSlider = ? WHERE idSlider = ?';
		$params = array($this->estado,$this->id);
		return Database::executeRow($sql, $params);
    }

    public function readSliderCommerce()
    {
        $sql = 'SELECT tituloSlider,subtituloSlider,fotoSlider FROM slider WHERE estadoSlider = 1 AND visibilidadSlider = 1';
		$params = array(null);
		return Database::getRows($sql, $params);
    }
}

?>