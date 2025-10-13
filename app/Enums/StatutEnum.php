<?php

namespace App\Enums;

enum StatutEnum: string
{
    case Nouvelle = 'nouvelle';
    case Diagnostic = 'diagnostic';
    case EnReparation = 'en_reparation';
    case Termine = 'termine';
    case NonReparable = 'non_reparable';
}
