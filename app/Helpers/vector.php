<?php
if (!function_exists('dot_product')) {
  function dot_product(array $a, array $b): float
  {
    $n = min(count($a), count($b));
    $dot = 0.0;
    for ($i = 0; $i < $n; $i++) {
      $dot += ((float) $a[$i]) * ((float) $b[$i]);
    }
    return $dot;
  }
}
