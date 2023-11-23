<?php

declare(strict_types=1);

$fileName = "file.txt";
$searchResult = [];
$totalCount = 0;

/**
 * Обработка содержимого строки
 *
 * @param string $line
 * @param array $lineArray
 * @return integer
 */
function lineParser(string $line, array &$lineArray): int
{
  $count = 0;
  $tempArray = mb_str_split(implode('', explode(PHP_EOL, $line)));
  foreach ($tempArray as $value) {
    if (array_key_exists($value, $lineArray)) {
      $lineArray[$value]++;
    } else {
      $lineArray[$value] = 1;
    }
    $count++;
  }
  return $count;
};

/**
 * Чтение данных из файла
 *
 * @param string $path
 * @return Generator
 */
function fileLines(string $path): Generator
{
  $file = fopen($path, "r");

  while (($line = fgets($file)) !== false) {
    yield $line;
  }

  fclose($file);
}

if (!file_exists($fileName)) {
  echo "File not found";
  exit;
}

foreach (fileLines($fileName) as $line) {
  $totalCount += lineParser($line, $searchResult);
}

ksort($searchResult);
foreach ($searchResult as $key => $value) {
  echo (string)$key . ' - ' . (string)round(($value / $totalCount * 100), 2) . '%' .  PHP_EOL;
}
