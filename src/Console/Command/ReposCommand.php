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

use Github\Client;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class ReposCommand extends AbstractCommand
{
    const FILENAME_REPOS = 'data/repos.yaml';
    const FILENAME_HTML = 'docs/repos.html';

    protected function configure()
    {
        $this
            ->setName('repos:list')
            ->setDescription('Lista de repositorios');

        parent::configure();
    }

    protected function getClient(): Client
    {
        $client = new Client();

        return $client;
    }

    protected function loadRepos(): array
    {
        if (file_exists(static::getResourcesPath().$this::FILENAME_REPOS)) {
            return $this->getResourceYaml($this::FILENAME_REPOS);
        }

        $repositories = $this->getClient()->api('user')->repositories('gpupo');
        $this->saveResourceToYamlFile(static::getResourcesPath().$this::FILENAME_REPOS, $repositories);

        return $repositories;
    }

    protected function factoryTwig(): Environment
    {
        $paths = [
            './Resources/views',
        ];
        $loader = new FilesystemLoader($paths);

        return new Environment($loader, []);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repos = $this->loadRepos();
        $twig = $this->factoryTwig();
        $content = $twig->render('repos.html.twig', ['repos' => $repos]);
        file_put_contents($this::FILENAME_HTML, $content);

        return 0;
    }
}
