<?php

namespace SolutionForest\FilamentFirewall\Middleware;

use Illuminate\Database\QueryException;
use Akaunting\Firewall\Abstracts\Middleware as BaseMiddleware;
use SolutionForest\FilamentFirewall\Facades\FilamentFirewall;
use Symfony\Component\HttpFoundation\IpUtils;

/**
 * Allow access if 
 * 1. IP within config('firewall.whitelist') or config('filament-firewall.skip_whitelist_range)
 * 2. the requested IP is whitelisted
 * 3. the requested IP is not in blacklisted
 * 4. the network is whitelisted
 */
class WhitelistRangeMiddleware extends BaseMiddleware
{
    public function allow(): bool
    {
        $currIp = $this->ip();

        $allow = false;

        try {

            $currIpIsAllowOrDeny = FilamentFirewall::getFirewallIpModel()::query()
                ->where('ip', $currIp)
                ->whereNull('prefix_size')
                ->get()
                ->unique('blocked');
            // have allow/deny record for requesting IP
            if ($currIpIsAllowOrDeny->isNotEmpty()) { 
                // Allow access if "ALLOW ACCESS" for requesting IP
                if ($currIpIsAllowOrDeny->filter(fn ($record) => ! $record->blocked)->isNotEmpty()) {
                    return true;
                }
                // Only "DENY ACCESS" for requesting IP
                else {
                    return false;
                }
            }

            $allow = FilamentFirewall::withinWhiteList($currIp);
        } catch (QueryException $e) {
            // Base table or view not found
            
        }


        return $allow;
    }

    public function handle($request, \Closure $next)
    {
        if ($this->skip($request)) {
            return $next($request);
        }

        if (! $this->allow()) {
            return $this->respond(config('firewall.responses.block'));
        }

        return $next($request);
    }

    public function skip($request)
    {
        $this->prepare($request);


        if ($this->isWhitelist()) {
            return true;
        }

        if (IpUtils::checkIp($this->ip(), config('filament-firewall.skip_whitelist_range', []))) {
            return true;
        }

        if (!config('firewall.enabled', true)) {
            return true;
        }

        return false;
    }
}
