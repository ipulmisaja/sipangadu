<?php

function getModelRelationship($proposal_code) : ?array
{
    switch(explode('-', $proposal_code)[0])
    {
        case 'PM' :
            return [
                'badge' => 'badge-primary',
                'name'  => 'Paket Meeting',
                'alias' => 'fullboard',
                'relationship' => 'paketMeetingRelationship',
                'url' => 'paket-meeting',
                'abbreviation' => 'PM'
            ];
            break;
        case 'LB' :
            return [
                'badge' => 'badge-info',
                'name'  => 'Lembur',
                'alias' => 'overtime',
                'relationship' => 'lemburRelationship',
                'url' => 'lembur',
                'abbreviation' => 'LB'
            ];
            break;
        case 'PD' :
            return [
                'badge' => 'badge-warning',
                'name'  => 'Perjalanan Dinas',
                'alias' => 'trip',
                'relationship' => 'perjadinRelationship',
                'url' => 'perjalanan-dinas',
                'abbreviation' => 'PD'
            ];
            break;
    }
}
