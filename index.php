<?php 
namespace neural;

require_once 'NeuralNetwork.php';

$_SESSION = array();

if(isset($_SESSION['trein'])):
    $rd = new NeuralNetwork(); 
    $r = $rd->predict([0,1]); 
else:
    $dataset['input'] = array([1,1],[1,0],[0,1],[0,0]);
    $dataset['target'] = array([0],[1],[1],[0]);

    learning($dataset['input'], $dataset['target']);
endif;

function learning($input, $target){
    $rd = new NeuralNetwork();    

    $rd->constructor(2, 3, 1);

    for($t=0; $t<10000; $t++):
        $index = rand(0,3);
        $rd->train($input[$index], $target[$index]);        
        $output0 = $rd->predict([0,0]);
        $output1 = $rd->predict([1,0]);

        if($output0[0] < 0.04 && $output1[0] > 0.98):            
            $_SESSION['trein'] = array();
            echo '<hr>';       
            echo 'rede aprendeu';
            echo '<hr>';
            echo '- epoca: '.$t.' resultadoA = '.$output0[0].' resultadoB = '.$output1[0];
            $t=11000;
        elseif($t == 9999):             
            echo '<hr>';       
            echo 'não aprendeu nada';
            echo '<hr>';
            echo '- epoca: '.$t.' resultadoA = '.$output0[0].' resultadoB = '.$output1[0];
        endif;                
    endfor;
}