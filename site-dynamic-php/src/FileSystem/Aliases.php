<?php

declare(strict_types=1);

namespace JoshBruce\SiteDynamic\FileSystem;

use JoshBruce\SiteDynamic\Environment;

use JoshBruce\SiteDynamic\FileSystem\File;

class Aliases
{
    public static function from(
        string $requestPath,
        Environment $environment,
    ): bool|File {
        // $path = $environment->contentPublic() .
        //     $requestPath .
        //     $environment->contentFilename();
        // die(var_dump($path));
        return false;
    }
}
