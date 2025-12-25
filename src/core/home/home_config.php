<?php
function numberToWords($num)
{
  $words = [
    0 => 'Zero',
    1 => 'One',
    2 => 'Two',
    3 => 'Three',
    4 => 'Four',
    5 => 'Five',
    6 => 'Six',
    7 => 'Seven',
    8 => 'Eight',
    9 => 'Nine',
    10 => 'Ten',
    11 => 'Eleven',
    12 => 'Twelve',
    13 => 'Thirteen',
    14 => 'Fourteen',
    15 => 'Fifteen',
    16 => 'Sixteen',
    17 => 'Seventeen',
    18 => 'Eighteen',
    19 => 'Nineteen',
    20 => 'Twenty',
    30 => 'Thirty',
    40 => 'Forty',
    50 => 'Fifty',
    60 => 'Sixty',
    70 => 'Seventy',
    80 => 'Eighty',
    90 => 'Ninety'
  ];

  if ($num <= 20) return $words[$num];
  if ($num < 100) {
    $tens = intval($num / 10) * 10;
    $ones = $num % 10;
    return $words[$tens] . ($ones ? ' ' . $words[$ones] : '');
  }
  return strval($num);
}

function timeAgo($datetime)
{
  $now = new DateTime();
  $time = new DateTime($datetime);
  $diff = $now->diff($time);
  $isFuture = $time > $now;

  if ($diff->y >= 10) return 'A decade ago';
  if ($diff->y > 0) return ($diff->y == 1 ? 'A' : numberToWords($diff->y)) . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
  if ($diff->m > 0) return ($diff->m == 1 ? 'A' : numberToWords($diff->m)) . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
  if ($diff->d >= 7) {
    $weeks = floor($diff->d / 7);
    return ($weeks == 1 ? 'A' : numberToWords($weeks)) . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
  }
  if ($diff->d > 1) return numberToWords($diff->d) . ' days ago';
  if ($diff->d == 1) return $isFuture ? 'The next day' : 'The previous day';
  if ($diff->h > 0) return numberToWords($diff->h) . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
  if ($diff->i > 0) return numberToWords($diff->i) . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
  if ($diff->s > 0) return numberToWords($diff->s) . ' second' . ($diff->s > 1 ? 's' : '') . ' ago';
  return 'Just now';
}

function formatDuration($duration)
{
  $parts = explode(':', $duration);
  if (count($parts) == 2) {
    $minutes = intval($parts[0]);
    $seconds = intval($parts[1]);
    if ($minutes > 0 && $seconds > 0) return $minutes . 'm ' . $seconds . 's';
    if ($minutes > 0) return $minutes . 'm';
    return $seconds . ' s';
  } elseif (count($parts) == 3) {
    $hours = intval($parts[0]);
    $minutes = intval($parts[1]);
    $seconds = intval($parts[2]);
    $result = '';
    if ($hours > 0) $result .= $hours . 'h';
    if ($minutes > 0) $result .= ($result ? ' ' : '') . $minutes . 'm';
    if ($seconds > 0) $result .= ($result ? ' ' : '') . $seconds . 's';
    return $result;
  }
  return $duration;
}

function formatViews($num)
{
  if ($num >= 1000000000) return round($num / 1000000000, 1) . 'B';
  if ($num >= 1000000) return round($num / 1000000, 1) . 'M';
  if ($num >= 1000) return round($num / 1000, 1) . 'k';
  return $num;
}
