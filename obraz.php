<?php

//Warianty:
//1 - Zachowaj proporcje i nie przekrocz podanych wymiarow
//2 - Zachowaj proporcje i zapełnij podane wymiary
//3 - Przeskaluj dokładnie do podanych wymiarów

function obraz_wyswietl($adres, $szerokosc = 0, $wysokosc = 0, $wariant = 1, $znakwodny = 0)
{
$adres_docelowy = $adres;

	if( $szerokosc > 0 || $wysokosc > 0 || $znakwodny )
	{
	$rozszerzenie = explode('.', $adres);
	$rozszerzenie = $rozszerzenie[count($rozszerzenie)-1];

		if( $szerokosc > 0 && $wysokosc > 0 )
		{
		$adres_docelowy = $adres_docelowy.'.mini_x'.$szerokosc.'_y'.$wysokosc;
		}
		elseif( $szerokosc > 0 )
		{
		$adres_docelowy = $adres_docelowy.'.mini_x'.$szerokosc;
		}
		elseif( $wysokosc > 0 )
		{
		$adres_docelowy = $adres_docelowy.'.mini_y'.$wysokosc;
		}

		if( $wariant == 1 )
		{
		$adres_docelowy = $adres_docelowy.'.w_1';
		}
		elseif( $wariant == 2 )
		{
		$adres_docelowy = $adres_docelowy.'.w_2';
		}
		elseif( $wariant == 3 )
		{
		$adres_docelowy = $adres_docelowy.'.w_3';
		}

		if( $znakwodny )
		{
		$adres_docelowy = $adres_docelowy.'.zw';
		}

	$adres_docelowy = $adres_docelowy.'.'.$rozszerzenie;

		if( !file_exists($adres_docelowy) )
		{
		list($szerokosc_aktualna, $wysokosc_aktualna) = getimagesize($adres);

			if( $wariant == 1 )
			{

				if( ( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna ) && ( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna ) )
				{

					if( ( $szerokosc_aktualna / $szerokosc ) > ( $wysokosc_aktualna / $wysokosc ) )
					{
					$skala = $szerokosc_aktualna / $szerokosc;
					$szerokosc_skala = $szerokosc;
					$wysokosc_skala = round($wysokosc_aktualna / $skala);
					$generowanie_skala = 1;
					}
					else
					{
					$skala = $wysokosc_aktualna / $wysokosc;
					$szerokosc_skala = round($szerokosc_aktualna / $skala);
					$wysokosc_skala = $wysokosc;
					$generowanie_skala = 1;
					}

				}
				elseif( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna )
				{
				$skala = $szerokosc_aktualna / $szerokosc;
				$szerokosc_skala = $szerokosc;
				$wysokosc_skala = round($wysokosc_aktualna / $skala);
				$generowanie_skala = 1;
				}
				elseif( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna )
				{
				$skala = $wysokosc_aktualna / $wysokosc;
				$szerokosc_skala = round($szerokosc_aktualna / $skala);
				$wysokosc_skala = $wysokosc;
				$generowanie_skala = 1;
				}

			}
			elseif( $wariant == 2 )
			{

				if( ( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna ) && ( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna ) )
				{

					if( ( $szerokosc_aktualna / $szerokosc ) < ( $wysokosc_aktualna / $wysokosc ) )
					{
					$skala = $szerokosc_aktualna / $szerokosc;
					$szerokosc_skala = $szerokosc;
					$wysokosc_skala = round($wysokosc_aktualna / $skala);
					$generowanie_skala = 1;
					}
					else
					{
					$skala = $wysokosc_aktualna / $wysokosc;
					$szerokosc_skala = round($szerokosc_aktualna / $skala);
					$wysokosc_skala = $wysokosc;
					$generowanie_skala = 1;
					}

				}
				elseif( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna && $wysokosc == 0 )
				{
				$skala = $szerokosc_aktualna / $szerokosc;
				$szerokosc_skala = $szerokosc;
				$wysokosc_skala = round($wysokosc_aktualna / $skala);
				$generowanie_skala = 1;
				}
				elseif( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna && $szerokosc == 0 )
				{
				$skala = $wysokosc_aktualna / $wysokosc;
				$szerokosc_skala = round($szerokosc_aktualna / $skala);
				$wysokosc_skala = $wysokosc;
				$generowanie_skala = 1;
				}
				elseif( ( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna ) || ( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna ) )
				{
				$szerokosc_skala = $szerokosc_aktualna;
				$wysokosc_skala = $wysokosc_aktualna;
				$generowanie_skala = 1;
				}

			}
			elseif( $wariant == 3 )
			{

				if( $szerokosc > 0 && $szerokosc < $szerokosc_aktualna )
				{
				$szerokosc_skala = $szerokosc;
				$generowanie_skala = 1;
				}
				else
				{
				$szerokosc_skala = $szerokosc_aktualna;
				}

				if( $wysokosc > 0 && $wysokosc < $wysokosc_aktualna )
				{
				$wysokosc_skala = $wysokosc;
				$generowanie_skala = 1;
				}
				else
				{
				$wysokosc_skala = $wysokosc_aktualna;
				}

			}

			if( file_exists($znakwodny) )
			{
			$generowanie_znakwodny = 1;
			}

			if( $generowanie_skala || $generowanie_znakwodny )
			{

				if( $generowanie_skala )
				{
				$szerokosc_polozenie = 0;
				$wysokosc_polozenie = 0;

					if( $szerokosc > 0 && $szerokosc < $szerokosc_skala )
					{
					$szerokosc_docelowa = $szerokosc;
					$szerokosc_polozenie = ( $szerokosc - $szerokosc_skala) / 2 ;
					}
					else
					{
					$szerokosc_docelowa = $szerokosc_skala;
					}

					if( $wysokosc > 0 && $wysokosc < $wysokosc_skala )
					{
					$wysokosc_docelowa = $wysokosc;
					$wysokosc_polozenie = ( $wysokosc - $wysokosc_skala) / 2 ;
					}
					else
					{
					$wysokosc_docelowa = $wysokosc_skala;
					}

				$obraz_docelowy = imagecreatetruecolor($szerokosc_docelowa, $wysokosc_docelowa);

					if( $rozszerzenie == 'png' )
					{
					imagealphablending($obraz_docelowy, false);
					imagesavealpha($obraz_docelowy, true);
					$transparent_png = imagecolorallocatealpha($obraz_docelowy, 255, 255, 255, 127);
					imagefilledrectangle($obraz_docelowy, 0, 0, $szerokosc_docelowa, $wysokosc_docelowa, $transparent_png);
					}
					if( $rozszerzenie == 'gif' )
					{
					$transparent_gif = imagecolorallocate($obraz_docelowy, 1, 2, 3);
					imagefilledrectangle($obraz_docelowy, 0, 0, $szerokosc_docelowa, $wysokosc_docelowa, $transparent_gif);
					imagecolortransparent($obraz_docelowy, $transparent_gif);
					}

					if( $rozszerzenie == 'png' ) $obraz_tymczasowy = imagecreatefrompng($adres);
					if( $rozszerzenie == 'jpg' ) $obraz_tymczasowy = imagecreatefromjpeg($adres);
					if( $rozszerzenie == 'jpeg' ) $obraz_tymczasowy = imagecreatefromjpeg($adres);
					if( $rozszerzenie == 'gif' ) $obraz_tymczasowy = imagecreatefromgif($adres);

				imagecopyresampled($obraz_docelowy, $obraz_tymczasowy, $szerokosc_polozenie, $wysokosc_polozenie, 0, 0, $szerokosc_skala, $wysokosc_skala, $szerokosc_aktualna, $wysokosc_aktualna);

				$szerokosc_aktualna = $szerokosc_docelowa;
				$wysokosc_aktualna = $wysokosc_docelowa;
				}
				else
				{

					if( $rozszerzenie == 'png' ) $obraz_docelowy = imagecreatefrompng($adres);
					if( $rozszerzenie == 'jpg' ) $obraz_docelowy = imagecreatefromjpeg($adres);
					if( $rozszerzenie == 'jpeg' ) $obraz_docelowy = imagecreatefromjpeg($adres);
					if( $rozszerzenie == 'gif' ) $obraz_docelowy = imagecreatefromgif($adres);

				}

				if( $generowanie_znakwodny )
				{
				$znakwodny_rozszerzenie = explode('.', $znakwodny);
				$znakwodny_rozszerzenie = $znakwodny_rozszerzenie[count($znakwodny_rozszerzenie)-1];

				list($szerokosc_znakwodny, $wysokosc_znakwodny) = getimagesize($znakwodny);

					if( $znakwodny_rozszerzenie == 'png' ) $obraz_tymczasowy = imagecreatefrompng($znakwodny);
					if( $znakwodny_rozszerzenie == 'jpg' ) $obraz_tymczasowy = imagecreatefromjpeg($znakwodny);
					if( $znakwodny_rozszerzenie == 'jpeg' ) $obraz_tymczasowy = imagecreatefromjpeg($znakwodny);
					if( $znakwodny_rozszerzenie == 'gif' ) $obraz_tymczasowy = imagecreatefromgif($znakwodny);

				imagecopy($obraz_docelowy, $obraz_tymczasowy, $szerokosc_aktualna-$szerokosc_znakwodny-20, $wysokosc_aktualna-$wysokosc_znakwodny-20, 0, 0, $szerokosc_znakwodny, $wysokosc_znakwodny);
				}

				if( $rozszerzenie == 'png' ) imagepng($obraz_docelowy, $adres_docelowy);
				if( $rozszerzenie == 'jpg' ) imagejpeg($obraz_docelowy, $adres_docelowy, 90);
				if( $rozszerzenie == 'jpeg' ) imagejpeg($obraz_docelowy, $adres_docelowy, 90);
				if( $rozszerzenie == 'gif' ) imagegif($obraz_docelowy, $adres_docelowy);

			}
			else
			{
			copy($adres, $adres_docelowy);
			}

		chmod($adres_docelowy, 0644);
		}

	}

return $adres_docelowy;
}

function obraz_usun($adres)
{

	if( file_exists($adres) ) unlink($adres);

$katalog_tab = explode('/', $adres);
$katalog = '';

	for( $i = 0 ; $katalog_tab[$i] ; $i++ )
	{

		if( $i < count($katalog_tab) - 1 )
		$katalog .= $katalog_tab[$i].'/';

	}

$plik = $katalog_tab[count($katalog_tab)-1];

$rozszerzenie = explode('.', $plik);
$rozszerzenie = $rozszerzenie[count($rozszerzenie)-1];

	if ( $katalog_uchwyt = opendir($katalog) )
	{

		while ( false !== ( $plik_uchwyt = readdir($katalog_uchwyt) ) )
		{
		$plik_wyrazenie = str_replace('.', '\.', $plik);

			if( preg_match('/^'.$plik_wyrazenie.'\.mini(_x[0-9]+){0,1}(_y[0-9]+){0,1}\.w_[123]\.'.$rozszerzenie.'$/', $plik_uchwyt) ) unlink($katalog.$plik_uchwyt);
			if( preg_match('/^'.$plik_wyrazenie.'\.mini(_x[0-9]+){0,1}(_y[0-9]+){0,1}\.w_[123]\.zw\.'.$rozszerzenie.'$/', $plik_uchwyt) ) unlink($katalog.$plik_uchwyt);
			if( preg_match('/^'.$plik_wyrazenie.'\.w_[123]\.zw\.'.$rozszerzenie.'$/', $plik_uchwyt) ) unlink($katalog.$plik_uchwyt);

		}

	closedir($katalog_uchwyt);
	}

}

?>