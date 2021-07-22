<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Algorithm\ES256;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\Serializer\CompactSerializer;

class GenerateAppleLoginSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apple:secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates Apple Login Secret';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $teamId = '76D99ZUGF4';
        $clientId = 'login.sportm4te.com';
        $keyFileId = '49MNLYNTR4';
        $keyFileName = base_path('AuthKey_49MNLYNTR4.p8');

        $algorithmManager = new AlgorithmManager([new ES256()]);

        $jwsBuilder = new JWSBuilder($algorithmManager);
        $jws = $jwsBuilder
            ->create()
            ->withPayload(json_encode([
                'iat' => time(),
                'exp' => time() + (60 * 60 * 24 * 7),
                'iss' => $teamId,
                'aud' => 'https://appleid.apple.com',
                'sub' => $clientId
            ]))
            ->addSignature(JWKFactory::createFromKeyFile($keyFileName), [
                'alg' => 'ES256',
                'kid' => $keyFileId
            ])
            ->build();

        $serializer = new CompactSerializer();

        $secret = $serializer->serialize($jws, 0);

        put_permanent_env('APPLE_CLIENT_SECRET', $secret, true);

        $this->info('Client Secret: ' . $secret);

        return 0;
    }
}
