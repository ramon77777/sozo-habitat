<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

/* SOZO_AIVEN_CA_BOOTSTRAP_START */
/*
 * Vercel expose les variables d'environnement pendant l'exÃ©cution.
 * PDO MySQL exige toutefois un chemin de fichier pour le certificat CA.
 * Le certificat Aiven encodÃ© en base64 est donc matÃ©rialisÃ© dans /tmp
 * avant le chargement de la configuration de base de donnÃ©es Laravel.
 */
$aivenCaBase64 = getenv('AIVEN_CA_CERT_BASE64');

if (is_string($aivenCaBase64) && trim($aivenCaBase64) !== '') {
    $aivenCaPath = getenv('MYSQL_ATTR_SSL_CA');

    if (! is_string($aivenCaPath) || trim($aivenCaPath) === '') {
        $aivenCaPath = sys_get_temp_dir().'/aiven-ca.pem';
    }

    $normalizedBase64 = preg_replace('/\s+/', '', $aivenCaBase64);
    $aivenCaContents = base64_decode($normalizedBase64 ?: '', true);

    if (
        $aivenCaContents === false
        || $aivenCaContents === ''
        || ! str_contains($aivenCaContents, 'BEGIN CERTIFICATE')
    ) {
        throw new RuntimeException('La variable AIVEN_CA_CERT_BASE64 ne contient pas un certificat CA valide.');
    }

    $mustWriteCertificate = ! is_file($aivenCaPath)
        || hash_file('sha256', $aivenCaPath) !== hash('sha256', $aivenCaContents);

    if ($mustWriteCertificate) {
        $aivenCaDirectory = dirname($aivenCaPath);

        if (
            ! is_dir($aivenCaDirectory)
            && ! mkdir($aivenCaDirectory, 0700, true)
            && ! is_dir($aivenCaDirectory)
        ) {
            throw new RuntimeException('Impossible de crÃ©er le dossier du certificat Aiven.');
        }

        $temporaryCaPath = $aivenCaPath.'.'.getmypid().'.tmp';

        if (file_put_contents($temporaryCaPath, $aivenCaContents, LOCK_EX) === false) {
            throw new RuntimeException('Impossible de crÃ©er le certificat Aiven temporaire.');
        }

        @chmod($temporaryCaPath, 0600);

        if (! @rename($temporaryCaPath, $aivenCaPath)) {
            @unlink($temporaryCaPath);

            if (! is_file($aivenCaPath)) {
                throw new RuntimeException('Impossible dâ€™installer le certificat Aiven.');
            }
        }

        @chmod($aivenCaPath, 0600);
    }

    putenv('MYSQL_ATTR_SSL_CA='.$aivenCaPath);
    $_ENV['MYSQL_ATTR_SSL_CA'] = $aivenCaPath;
    $_SERVER['MYSQL_ATTR_SSL_CA'] = $aivenCaPath;
}
/* SOZO_AIVEN_CA_BOOTSTRAP_END */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Faire confiance au reverse proxy de Render (nécessaire pour HTTPS)
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();