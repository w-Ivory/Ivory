<?php
class Fichier
{
	private $path;
	private $ressource;
	private $overwrite;

	public function __construct($path, $overwrite = false)
	{
		$this->overwrite = $overwrite;
		$this->path = $path;
		$this->ressource = fopen($path, 'c+');
	}

	public function __destruct()
	{
		fclose($this->ressource);
	}

	public function GetName()
	{
		return pathinfo($this->path, PATHINFO_BASENAME);
	}

	public function GetSize()
	{
		clearstatcache();
		return filesize($this->path);
	}

	public function Read()
	{
		$this->Rewind();
		return fread($this->ressource, $this->GetSize());
	}

	public function ReadLine()
	{
		return fgets($this->ressource);
	}

	public function Write($content)
	{
		if(!$this->overwrite)
		{
			$this->FastForward();
		}
		fwrite($this->ressource, $content);
	}

	public function WriteLine($line)
	{
		$this->Write($line . PHP_EOL);
	}

	public function Rewind()
	{
		rewind($this->ressource);
	}

	public function FastForward()
	{
		fseek($this->ressource, 0, SEEK_END);
	}

	public function Clear()
	{
		ftruncate($this->ressource, 0);
		$this->Rewind();
	}
}