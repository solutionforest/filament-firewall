<?php 

namespace SolutionForest\FilamentFirewall\Models;

class Ip extends \Akaunting\Firewall\Models\Ip
{
    protected $table = 'firewall_ips';

    protected $fillable = [
        'ip', 
        'prefix_size', 
        'log_id', 
        'blocked',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'blocked' => 'bool',
    ];
}
