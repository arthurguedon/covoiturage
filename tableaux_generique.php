<?php
function listeHeures() {
    for ($i = 0 ; $i <= 24 ; $i++){
    $heures[] = $i;
    }
    return $heures;     
}

function listeMinutes() {
    for ($i = 0 ; $i <= 59 ; $i++){
    $minutes[] = $i;
    }
    return $minutes;     
}

function listeJours() {
    for ($i = 1 ; $i <= 31; $i++){
    $jour[] = $i;
    }
    return $jour;     
}

function listeMois() {
    for ($i = 1 ; $i <= 12; $i++){
    $mois[] = $i;
    }
    return $mois;     
}

function listeAnnees() {
    return array(date('Y'),date('Y')+1);     
}
