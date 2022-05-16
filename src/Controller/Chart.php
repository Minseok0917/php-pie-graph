<?php
namespace src\Controller;

class Chart
{

	function pie($params)
	{
		// DB idx Address 
		[$idx] = $params;

		// dummy setting 
		$dummys = [
			addDummy($idx,500), //민석
			addDummy('mmm2',500), //준우
			addDummy('mmm3',200), //준서
		];
		$sum = array_reduce($dummys,  fn($acc,$item) => $acc+$item->value);
		$p = 360/$sum;


		// base setting 
		$imageWidth = 600;
		$imageHeight = 600;
		$circleSize = 400;
		$image = imagecreate($imageWidth,$imageHeight);

		// @start
		$bg = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image,0,0,0);
		$acc = -90;

		foreach ($dummys as $idx => $item) {
			$color = imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
			$x = $imageWidth/2;
			$y = $imageHeight/2;
			$angle = $p*$item->value;
			$start = $acc;
			$end = $acc+$angle;
			$acc = $end;

			$degres =  $start + $angle/2;
			$radians = $degres*(pi()/180);

			$ax = $x + cos($radians) * 5;
			$ay = $y + sin($radians) * 5;
			$lx = $x + cos($radians) * ($circleSize/2+30);
			$ly = $y + sin($radians) * ($circleSize/2+30);
			$tx = $x + cos($radians) * ($circleSize/2+45);
			$ty = $y + sin($radians) * ($circleSize/2+45);

			imagefilledarc($image, $ax, $ay, $circleSize, $circleSize, $start, $end, $color,IMG_ARC_PIE);			
			imageline($image,$ax,$ay,$lx,$ly,$color);

			imagestring($image,2, $tx, $ty, $item->name,$color);
		}


		header('Content-type: image/png');

		imagepng($image);
	}
}