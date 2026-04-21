<?php

namespace App\Console\Commands;

use App\Actions\GenerateExampleBoardingPass;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:create-pass')]
#[Description('Generate an example boarding pass and write the .pkpass file to public/pass.pkpass')]
class CreatePass extends Command
{
    public function handle(GenerateExampleBoardingPass $generator): int
    {
        $pass = $generator->execute();

        file_put_contents(public_path('pass.pkpass'), $pass->generate());

        $this->info("Wrote pass {$pass->id} to public/pass.pkpass");

        return self::SUCCESS;
    }
}
