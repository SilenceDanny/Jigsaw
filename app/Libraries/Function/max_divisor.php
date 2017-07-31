<?php  
function max_divisor($a, $b)
  {
    if($b == 0)
    {
      return $a;
    }
    else
    {
      return max_divisor($b,($a%$b));
    }
  }
?>  