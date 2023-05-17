<?php

namespace SolutionForest\FilamentFirewall\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Collection;

/**
 * @method static Collection getWhiteList()
 * @method static bool withinWhiteList($ip)
 * @method static Collection getBlackList()
 * @method static bool withinBlackList($ip)
 * @method static string getFirewallIpModel()
 * 
 * @see \SolutionForest\FilamentFirewall\FilamentFirewall
 */
class FilamentFirewall extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \SolutionForest\FilamentFirewall\FilamentFirewall::class;
    }
}
