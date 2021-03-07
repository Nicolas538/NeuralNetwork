<?php 
namespace neural;

session_start();

require_once 'matriz.php';

class NeuralNetwork{
    function constructor($i_nodes, $h_nodes, $o_nodes){
        $m = new matriz();        

        $bias_ih = $m->constructor($h_nodes, 1); 
        $bias_ih = $m->ramdomize($bias_ih);

        $bias_ho = $m->constructor($o_nodes, 1);
        $bias_ho = $m->ramdomize($bias_ho);         

        $Peso_ih = $m->constructor($h_nodes, $i_nodes);        
        $Peso_ih = $m->ramdomize($Peso_ih);         

        $Peso_ho = $m->constructor($o_nodes, $h_nodes);                     
        $Peso_ho = $m->ramdomize($Peso_ho);      

        $learning_rate = 0.1;        

        $_SESSION['$bias_ih'] = $bias_ih;
        $_SESSION['$bias_ho'] = $bias_ho;
        $_SESSION['$Peso_ih'] = $Peso_ih;
        $_SESSION['$Peso_ho'] = $Peso_ho;
        $_SESSION['$learning_rate'] = $learning_rate;        
    }

    function sigmoid($A){
        $array = array();
            for($i=0; $i<count($A); $i++):
                $arr = array();
                for($j=0; $j<count($A[0]); $j++):
                    if(isset($A[$i][$j])):
                        $arr[] = (1/(1+exp(-$A[$i][$j])));                
                    endif;                    
                endfor;
                $array[] = $arr;
            endfor;             
            return $array;
    }

    function dsigmoid($A){
        $array = array();
        for($i=0; $i<count($A); $i++):                
            for($j=0; $j<count($A[0]); $j++):
                if(isset($A[$i][$j])):
                    $array[] = array(($A[$i][$j]*(1-$A[$i][$j])));                
                endif;                    
            endfor;                
        endfor;             
        return $array;
    }    

    function train($input, $target){
        $m = new matriz();        

        $input = $m->arrayToMatrix($input);         
        
        $hidden = $m->multiplicar_matrix($_SESSION['$Peso_ih'], $input);                  
        $hidden = $m->soma_matrix($hidden, $_SESSION['$bias_ih']);              
        $hidden = $this->sigmoid($hidden);              

        
        //hidden -> output
        $output = $m->multiplicar_matrix($_SESSION['$Peso_ho'], $hidden);        
        $output = $m->soma_matrix($output, $_SESSION['$bias_ho']);        
        $output = $this->sigmoid($output);
                        

        //Backpropagation
        $expected = $m->arrayToMatrix($target);        
        $output_error = $m->subtract_matrix($expected, $output);        
        $d_output = $this->dsigmoid($output);        
        $hidden_T = $m->transpose($hidden);

        $gradient = $m->hadamard_matrix($d_output, $output_error);      
        $gradient = $m->escalar_multiply($gradient, $_SESSION['$learning_rate']);                     
        
        //bias_ho
        $_SESSION['$bias_ho'] = $m->soma_matrix($_SESSION['$bias_ho'], $gradient);       

        $weights_ho_deltas = $m->multiplicar_matrix($gradient, $hidden_T);                 
        $_SESSION['$Peso_ho'] = $m->soma_matrix($_SESSION['$Peso_ho'], $weights_ho_deltas);      
        

        //hidden -> input
        $weights_ho_T = $m->transpose($_SESSION['$Peso_ho']);
        $hidden_error = $m->multiplicar_matrix($weights_ho_T, $output_error);
        $d_hidden = $this->dsigmoid($hidden);
        $input_t = $m->transpose($input);

        $gradient_H = $m->hadamard_matrix($hidden_error, $d_hidden);
        $gradient_H = $m->escalar_multiply($gradient_H, $_SESSION['$learning_rate']);  

        //bias_ih        
        $_SESSION['$bias_ih'] = $m->soma_matrix($_SESSION['$bias_ih'], $gradient_H);

        $weights_ih_deltas = $m->multiplicar_matrix($gradient_H, $input_t);
        $_SESSION['$Peso_ih'] = $m->soma_matrix($_SESSION['$Peso_ih'], $weights_ih_deltas);        
    }

    function predict($input){
        $m = new matriz();        

        $input = $m->arrayToMatrix($input);         
        
        $hidden = $m->multiplicar_matrix($_SESSION['$Peso_ih'], $input);                  
        $hidden = $m->soma_matrix($hidden, $_SESSION['$bias_ih']);              
        $hidden = $this->sigmoid($hidden);              

        
        //hidden -> output
        $output = $m->multiplicar_matrix($_SESSION['$Peso_ho'], $hidden);        
        $output = $m->soma_matrix($output, $_SESSION['$bias_ho']);        
        $output = $this->sigmoid($output);
        $output = $m->MatrixToArray($output);

        return $output;
    }
}