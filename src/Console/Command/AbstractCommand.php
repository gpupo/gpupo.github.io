<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/gpupo.github.io
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://opensource.gpupo.com/>.
 *
 */

namespace Gpupo\GithubIo\Console\Command;

use Gpupo\Common\Traits\TableTrait;
use Gpupo\CommonSdk\Console\Command\AbstractCommand as Core;
use Gpupo\CommonSdk\Traits\ResourcesTrait;
use Symfony\Component\Console\Input\InputOption;
use Github\Client;
use Github\Api\ApiInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractCommand extends Core
{
    use TableTrait;
    use ResourcesTrait;

    const USERNAME = 'gpupo';
    const DEV_MODE = false;

    protected $client;

    protected function getClient(): Client
    {
        if (empty($this->client)) {
            $this->client = new Client();
            $this->client->authenticate($_ENV['GITHUB_TOKEN'], null, 'http_token');
        }

        return $this->client;
    }

    protected function getUserApi(): ApiInterface
    {
        $api = $this->getClient()->api('user');
        $api->setPerPage(90);

        return $api;
    }


    protected function configure()
    {
        $this
            ->addOption(
                'no-cache',
                null,
                InputOption::VALUE_OPTIONAL,
                'Should ignore cache?',
                false
            )
            ->addOption(
                'filter',
                null,
                InputOption::VALUE_OPTIONAL,
                'Name to filter',
                false
            );
    }
}
