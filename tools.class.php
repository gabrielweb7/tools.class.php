<?php
	/**
	*	Biblioteca com utilidades diversas para o PHP
	*	Author: Gabriel Azuaga Barbosa <gabrielbarbosaweb7@gmail.com>
	*	Github: https://github.com/gabrielweb7
	*	Site pessoal: http://gabrieldaluz.com.br
	*	Version: 1.0.0
	*/
	class tools {

		/** 
		*	Redirecionar 
		*/
		public static function redirecionar($valor) {
			if(isset($valor)) {
			    header("Location: {$valor}");
			}
		}

		/** 
		*	Formatar Bytes para escrita mais legivel 
		*/
	    public static function formatBytes($size, $precision = 0){
	        $unit = ['Byte','KB','MB','GB','TB','PB','EB','ZB','YB'];
	        for($i = 0; $size >= 1024 && $i < count($unit)-1; $i++){
	            $size /= 1024;
	        }
	        return round($size, $precision).' '.$unit[$i];
	    }

		/** 
		*	Remover break lines de uma string 
		*/
	    public static function removerBreakLinesFromString($string) {
	        return  preg_replace( "/\r|\n/", "", $string );
	    }

		/** 
		*	Função para retornar IP do visitante 
		*/
		public static function getRealIp()
		{
			if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ) )
			{
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
			elseif( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
			{
				$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
			}
			else
			{
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			return $ip;
		}

		/** 
		*	Verifica se URL remoto existe! 
		*/
		public static function urlExists($url) {
			$url = filter_var($url, FILTER_SANITIZE_URL);
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE
			    || !in_array(strtolower(parse_url($url, PHP_URL_SCHEME)), ['http','https'], true )
			) {
			    return false;
			}
			$file_headers = @get_headers($url);
			return !(!$file_headers || $file_headers[0] === 'HTTP/1.1 404 Not Found');
		}

		/** 
		*	Gerar numeros randômicos 
		*/
		public static function numeroRandomico($min = 0,$max = 10) {
			return mt_rand($min, $max);
		}

		/* Converte Data de Mysql para BR */
		public static function convertDateMysqlToBr($data) {
			return implode("/",array_reverse(explode("-",$data)));
		}

		/* Converte Data de BR para Mysql */
		public static function convertDateBrtoMysql($data) {
			return implode("-",array_reverse(explode("/",$data)));
		}

		/** 
		*	Converte Data e Hora de Mysql para BR 
		*/
		public static function convertDateTimeMysqlToBr($dataTime) {
			if(empty($dataTime)) { return false; }
			$explodeString = explode(" ", $dataTime);
			$data = self::convertDateMysqlToBR($explodeString[0]);
			$hora = self::convertHoraToHM($explodeString[1]);
			$retorno = $data." ".$hora;
			return $retorno;
		}

		/** 
		*	Converte Data e Hora de BR para Mysql 
		*/
		public static function convertDateTimeBrToMysql($dataTime) {
			if(empty($dataTime)) { return false; }
			$explodeString = explode(" ", $dataTime);
			$data = self::convertDateBRtoMysql($explodeString[0]);
			$hora = $explodeString[1];
			$retorno = $data." ".$hora;
			return $retorno;
		}

		/** 
		*	Converte Hora 00:00:00 para 00:00 
		*/
		public static function convertHoraToHM($hora) {
			$horaEx = explode(":", $hora);
			$horaNova = $horaEx[0].":".$horaEx[1];
			return $horaNova;
		}

		/** 
		*	Retornar Data e Hora formato BR 
		*/
		public static function getDataHoraBr() {
			return date("d/m/Y h:i:s");
		}
		
		/** 
		*	Retornar Data formato BR 
		*/
		public static function getDataBr() {
			return date("d/m/Y");
		}

		/** 
		*	Retornar Data e Hora formato MYSQL 
		*/
		public static function getDataHoraMysql() {
			return date("Y-m-d h:i:s");
		}
		
		/** 
		*	Retornar Data formato MYSQL 
		*/
		public static function getDataMysql() {
			return date("Y-m-d");
		}

		/** 
		*	Retornar Hora Atual completa 
		*/
		public static function getFullHora() {
			return date("h:i:s");
		}

		/** 
		*	Retornar Hora Atual 
		*/
		public static function getHora() {
			return date("h:i");
		}

		/**
		*	Função criada para setar codificação da página
		*/
		public static function setContentType($tipo) {
			if($tipo == "utf8") { 
				header ('Content-type: text/html; charset=UTF-8');
			} else if($tipo == "iso") { 
				header ('Content-type: text/html; charset=ISO-8859-1');
			}
		}

		/**
		*	Função criada para setar timeZone do Sistema
		*/
		public static function setTimeZone($data = false) {
			if($data) { 
				date_default_timezone_set($data);
			} 
		}

		/**
		*	Função criada para validar E-mail
		*/
		public static function checkEmailValido($email) { 
			if(empty($email)) { return false; }
			return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? false : true;
		}
		
		/**
		*	Função criada para limitar caracteres de um texto e adicionar 3 pontos
		*/
		public static function limitaCaracteres($texto, $limite, $quebra = true){
			$tamanho = strlen($texto);
			if($tamanho <= $limite){
				$novo_texto = $texto;
			}else{ 
				if($quebra == true){
					$novo_texto = trim(substr($texto, 0, $limite))."...";
				}else{ 
					$ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); 
					$novo_texto = trim(substr($texto, 0, $ultimo_espaco))."..."; 
				}
			}
			return $novo_texto; 
		}

	}
?>