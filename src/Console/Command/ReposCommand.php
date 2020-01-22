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
use Github\Api\ApiInterface;
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

    protected function loadRepos(OutputInterface $output): array
    {
        if ($this->dev_mode === false && file_exists(static::getResourcesPath().$this::FILENAME_REPOS)) {
            $output->writeln(sprintf('Using <comment>%s</> from cache', $this::FILENAME_REPOS), OutputInterface::VERBOSITY_VERBOSE);

            return $this->getResourceYaml($this::FILENAME_REPOS);
        }

        $api = $this->getClient()->api('repo');

        $repositories = fetchReposFromEntity($this->github_username, $api, $this->getUserApi()->repositories($this->github_username));

        $this->saveResourceToYamlFile(static::getResourcesPath().$this::FILENAME_REPOS, $repositories);
        $output->writeln(sprintf('File <comment>%s</> saved', $this::FILENAME_REPOS), OutputInterface::VERBOSITY_VERBOSE);

        return $repositories;
    }

    protected function fetchReposFromEntity(string $entity_name, ApiInterface $api, array $repositories): array
    {
        foreach($repositories as $k => $repo) {
            $branches = $api->branches($this->github_username, $repo['name']);

            foreach($branches as $branch) {
                $repositories[$k]['branches'][] = $branch['name'];
            }

            $repositories[$k]['tags'] = $api->tags($this->github_username, $repo['name']);
        }

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
        parent::execute($input, $output);
        $repos = $this->loadRepos($output);

        $twig = $this->factoryTwig();
        $content = $twig->render('repos.html.twig', ['repos' => $repos]);
        file_put_contents($this::FILENAME_HTML, $content);
        $output->writeln(sprintf('File <comment>%s</> saved', $this::FILENAME_HTML), OutputInterface::VERBOSITY_VERBOSE);
        $output->writeln('Done!');

        return 0;
    }
}
