
<?php
error_reporting(0);
/**
 *
 */
class datacheck

	{
	public $filename;

	public $csv;

	public $sku;

	public $coloresSku;

	public $colorEncontrado;

	public $brand;

	public $perfil;

	function __construct($foto, $csvAray)
		{
		$this->filename = $foto;
		$this->csv = $csvAray;
		$this->sku = $this->contieneSku($foto);
		$this->coloresSku = $this->coloresSku();
		$this->colorEncontrado = $this->skuContieneColor();
		$this->brand = str_replace("_color", "", $csvAray[0][1]);;
		$this->perfil = $this->perfil($foto);
		}

	function getSku()
		{
		return $this->sku;
		}

	function getColoresSku()
		{
		return $this->coloresSku;
		}

	function getColor()
		{
		return $this->colorEncontrado;
		}

	function getBrand()
		{
		return $this->brand;
		}

	function getPerfil()
		{
		return $this->perfil;
		}

	public

	function contieneSku($filename)
		{
		$skusencontrados = [];
		$csv = $this->csv;
		for ($a = 0; $a < count($csv); $a++)
			{
			$sku = $csv[$a][0];
			switch ($sku[0] == 'asd')
				{
			case true:
				$pos = strpos(strtolower($filename) , substr($sku, 1));
				if ($pos === false)
					{
					}
				  else
					{
					array_push($skusencontrados, $sku);
					array_push($skusencontrados, $sku);
					$largos = array_map('strlen', $skusencontrados);
					$LargoMax = max($largos);
					$index = array_search($LargoMax, $largos);
					}

				break;

			default:
				$pos = strpos(strtolower($filename) , strtolower($sku));
				if ($pos === false)
					{
					}
				  else
					{
					array_push($skusencontrados, $sku);
					array_push($skusencontrados, $sku);
					$largos = array_map('strlen', $skusencontrados);
					$LargoMax = max($largos);
					$index = array_search($LargoMax, $largos);
					}

				break;
				}
			}

		return ($skusencontrados[$index] != "" ? $skusencontrados[$index] : "SKU");;
		}

	public

	function coloresSku()
		{
		$sku = $this->sku;
		$csv = $this->csv;
		$coloresSku = 'Not Found';
		for ($b = 0; $b < count($csv); $b++)
			{
			if (strtolower($csv[$b][0]) == strtolower($sku))
				{
				$coloresSku = $csv[$b][1];
				}
			}

		return $coloresSku;
		}

	function skuContieneColor()
		{
		$sku = $this->sku;
		$colores = $this->coloresSku;
		$filename = $this->filename;
		$largosku = strlen($sku);
		$filenameSinSKU = str_replace($sku, "", $filename);
		$arrayColoresSKU = explode("|", $colores);
		$colorEncontradoEncontrado = "COLOR";
		for ($b = 0; $b < count($arrayColoresSKU); $b++)
			{
			$donde = $filenameSinSKU;
			$que = $arrayColoresSKU[$b];
			$pos = strpos(strtolower($donde) , strtolower($que));
			if ($pos === false)
				{
				}
			  else
				{
				$colorEncontradoEncontrado = $arrayColoresSKU[$b];
				}
			}

		return $colorEncontradoEncontrado;
		}

	function perfil($filename)
		{
		$ultimoChar = substr(str_replace(".jpg", "", $filename) , -1);
		$perfil = 0;
		if (!is_numeric($ultimoChar))
			{
			$perfil = 1;
			}
		  else
			{
			$perfil = $ultimoChar;
			}

		return $perfil;
		}
	}
