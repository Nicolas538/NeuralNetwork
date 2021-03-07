<?php
namespace neural;

class matriz{    
    //Function & diversas
    function constructor($rows, $cols){
        $data = array();       

        for($i=0; $i<$rows; $i++):
            $arr = array();
            for($j=0; $j<$cols; $j++):
                $arr[] = rand(0,9);
            endfor;
            $data[] = $arr;
        endfor; 
        
        return $data;
    }
    
    function arrayToMatrix($A){        
        $array = array();
        for($i=0; $i<count($A); $i++):            
            $array[] = array($A[$i]);            
        endfor;        
                
        return $array;
    }

    function MatrixToArray($obj){
        $array = array();
        
        for($i=0; $i<count($obj); $i++):            
            $array += $obj[$i];
        endfor;        
                
        return $array;
    }

    function ramdomize($A){ 
        $array = array();
        for($i=0; $i<count($A); $i++):
            $arr = array();
            for($j=0; $j<count($A[0]); $j++):
                $arr[] = (0+lcg_value()*(abs(1-0)))*2-1;                                                   
            endfor;
            $array[] = $arr;
        endfor;             
        return $array;       
    }

    function transpose($A){
        $array = array();
        for($i=0; $i<count($A[0]); $i++):
            $arr = array();
            for($j=0; $j<count($A); $j++):
                if(isset($A[$j][$i])):
                    $arr[] = $A[$j][$i];                
                endif;                    
            endfor;
            $array[] = $arr;
        endfor;             
        return $array;
    }

    //operaçoes matriz x Escalar 
    function escalar_multiply($A, $escalar){
        $array = array();  
        for($i=0; $i<count($A); $i++):                          
            for($j=0; $j<count($A[0]); $j++):
                $array[] = array($A[$i][$j]*$escalar);                                   
            endfor;           
        endfor;

        return $array;
    }

    //operaçoes matriz x matriz
    function subtract_matrix($A, $B){
        $array = array();

        for($i=0; $i<count($A); $i++):
            $arr = array();            
            for($j=0; $j<count($A[0]); $j++):
                if(isset($A[$i][$j]) && isset($B[$i][$j])):
                    $arr[] = $A[$i][$j]-$B[$i][$j];
                endif;                                  
            endfor; 
            $array[] = $arr;           
        endfor;               

        return $array;
    }

    function hadamard_matrix($A, $B){
        $array = array();
        for($i=0; $i<count($A); $i++): 
            $arr = array();           
            for($j=0; $j<count($A[0]); $j++):
                $arr[] = $A[$i][$j]*$B[$i][$j];                    
            endfor;   
            $array[] = $arr;           
        endfor;  

        return $array;
    }    

    function soma_matrix($A, $B){               
        $array = array();
        for($i=0; $i<count($A); $i++):   
            $arr = array();         
            for($j=0; $j<count($B[0]); $j++):
                if(isset($A[$i][$j]) && isset($B[$i][$j])):
                    $elem1 = $A[$i][$j]; 
                    $elem2 = $B[$i][$j]; 
                    $sum = $elem1+$elem2;
                    $arr[] = $sum;      
                endif;
            endfor; 
            $array[] = $arr;           
        endfor;  

        return $array;
    }

    function multiplicar_matrix($A, $B){
        $array = array();        
        for($i=0; $i<count($A); $i++):
            $arr = array();                                     
            for($j=0; $j<count($A[0]); $j++):                
                for($k=0; $k<count($A[0]); $k++):                     
                    if(isset($A[$i][$k]) && isset($B[$k][$j])):
                        $elem1 = $A[$i][$k];
                        $elem2 = $B[$k][$j];
                        $arr[] = $elem1*$elem2;                    
                    endif;                     
                endfor;                                                         
            endfor;
            $array[] = array(array_sum($arr));              
        endfor;          

        return $array;
    }   
}