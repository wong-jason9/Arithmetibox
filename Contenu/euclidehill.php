<?php

function euclid($a, $b) {
while ($b!=0){
$t=$a%$b;
$res['0']=$a;
$res['1']=$b;
$res['2']=$t;
$res['3']=(int)($a/$b);
$tab[]=$res;
$a=$b;
$b=$t;
}
$eucli=$tab;
if($eucli!=NULL){
echo "\$\$";
echo "\\Large\\begin{array}{c|c|c|c c}";
echo "\\Large a&b&r&q\\\\\\hline";
foreach($eucli as $v){
foreach($v as $r){
echo "$r&";
}
echo "\\\\";
}
echo"\\end{array}";
echo "\$\$";
}

}

?>
