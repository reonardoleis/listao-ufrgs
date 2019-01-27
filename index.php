<?php
set_time_limit(0);
$alfabeto = str_split('abcdefghijklmnopqrstuvwxyz');
function getPessoas($letra)
  {
  $conteudo = file_get_contents('http://vestibular.ufrgs.br/cv2019/listao/arquivo_' . $letra . '.html');
  $conteudo = @explode('</thead>', $conteudo) [1];
  $conteudo = explode('</table>', $conteudo) [0];
  $conteudo = str_replace('<tr>', '', $conteudo);
  $conteudo = str_replace('</tr>', '|', $conteudo);
  $conteudo = str_replace('<td>', '', $conteudo);
  $conteudo = str_replace('</td>', ',', $conteudo);
  $conteudo = explode('|', $conteudo);
  for ($i = 0; $i < count($conteudo); $i++)
    {
    $conteudo[$i] = substr($conteudo[$i], 0, strrpos($conteudo[$i], ','));
    }

  return $conteudo;
  }

$pessoas = array();

for ($i = 0; $i < count($alfabeto); $i++)
  {
  $temp = getPessoas($alfabeto[$i]);
  for ($j = 0; $j < count($temp); $j++)
    {
    array_push($pessoas, $temp[$j]);
    }
  }

$pessoas_string = array();

for ($i = 0; $i < count($pessoas); $i++)
  {
  $temp = explode(',', $pessoas[$i]);
  @$pessoas_string[$i] = @$temp[3] . " xxx " . @$temp[1];
  }

sort($pessoas_string);
$ultimo_curso = '';

for ($i = 0; $i < count($pessoas_string); $i++)
  {
  $curso_temp = (explode('xxx', $pessoas_string[$i]) [0]);
  $pessoa_atual = explode('xxx', $pessoas_string[$i]) [1];
  if ($curso_temp != $ultimo_curso)
    {
    echo '<hr>';
    echo '<label style="font-size: 15pt">' . $curso_temp . '</label><br />________________________________<br />';
    echo $pessoa_atual . '<br />';
    }
    else
    {
    echo $pessoa_atual . '<br />';
    }

  $ultimo_curso = $curso_temp;
  }

?>



?>