<?php
// Buat logo dengan PHP GD
header('Content-Type: image/png');

// Ukuran
$width = 200;
$height = 200;

// Buat gambar
$image = imagecreatetruecolor($width, $height);

// Warna
$darkBlue = imagecolorallocate($image, 13, 71, 161);  // #0d47a1
$lightBlue = imagecolorallocate($image, 21, 101, 192); // #1565c0
$gold = imagecolorallocate($image, 255, 213, 79);      // #ffd54f
$white = imagecolorallocate($image, 255, 255, 255);
$lightBlueText = imagecolorallocate($image, 144, 202, 249); // #90caf9

// Background gradient (manual)
imagefilledrectangle($image, 0, 0, $width, $height, $darkBlue);
imagefilledrectangle($image, 0, 0, $width, 100, $lightBlue);

// Sudut melengkung (manual dengan kotak)
imagefilledrectangle($image, 10, 10, 190, 190, $darkBlue);

// Teks "SMK"
$fontSize = 5;
$text = "SMK";
$textWidth = imagefontwidth($fontSize) * strlen($text);
$x = ($width - $textWidth) / 2;
$y = 55;
imagestring($image, $fontSize, $x, $y, $text, $gold);

// Teks "BPPI" (ukuran lebih besar)
$text = "BPPI";
$textWidth = imagefontwidth($fontSize) * strlen($text);
$x = ($width - $textWidth) / 2;
$y = 85;
imagestring($image, $fontSize, $x, $y, $text, $white);

// Teks "Baleendah"
$text = "Baleendah";
$textWidth = imagefontwidth($fontSize) * strlen($text);
$x = ($width - $textWidth) / 2;
$y = 115;
imagestring($image, $fontSize, $x, $y, $text, $lightBlueText);

// Simpan ke file
imagepng($image, 'logo-smk-bppi.png');
imagedestroy($image);

echo "Logo berhasil dibuat di: " . __DIR__ . "/logo-smk-bppi.png";
?>