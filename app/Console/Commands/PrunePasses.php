<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Spatie\LaravelMobilePass\Models\MobilePass;

#[Signature('passes:prune {--hours=24 : Delete passes older than this many hours}')]
#[Description('Delete mobile passes older than the given threshold along with their registrations.')]
class PrunePasses extends Command
{
    public function handle(): int
    {
        $threshold = now()->subHours((int) $this->option('hours'));

        $prunedCount = 0;

        MobilePass::where('created_at', '<', $threshold)
            ->chunkById(100, function (Collection $passes) use (&$prunedCount): void {
                foreach ($passes as $pass) {
                    $pass->registrations()->delete();
                    $pass->delete();
                    $prunedCount++;
                }
            });

        $this->info("Pruned {$prunedCount} passes older than {$threshold->toDateTimeString()}.");

        return self::SUCCESS;
    }
}
