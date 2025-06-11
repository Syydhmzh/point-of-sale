<?php 

function group1()
{ return['3'];

}
function group2() {
    return['5'];
}
function group3(){
    return ['1', '2', '4'];
}

function role_available(){
    // 3: instruktur, 5:student
    return['3', '5'];
}

function canAddModul($role){
    if(in_array($role, role_available())){
        return true;
    }
    
}

?>