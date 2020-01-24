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

final class ReposCommand extends AbstractCommand
{
    const FILENAME_USER_INFO = 'data/user_info.yaml';
    const FILENAME_REPOS = 'data/repos.yaml';

    protected function configure()
    {
        $this
            ->setName('repos:list')
            ->setDescription('Lista de repositorios');

        parent::configure();
    }

    protected function loadUserInfo(OutputInterface $output): array
    {
        if ($this->dev_mode === false && file_exists(static::getResourcesPath().$this::FILENAME_USER_INFO)) {
            $output->writeln(sprintf('Using <comment>%s</> from cache', $this::FILENAME_USER_INFO), OutputInterface::VERBOSITY_VERBOSE);

            return $this->getResourceYaml($this::FILENAME_USER_INFO);
        }
        $api = $this->getUserApi();
        $info['organizations'][$this->github_username] = $api->show($this->github_username);

        foreach ($api->orgs() as $org) {
            $info['organizations'][$org['login']] = $org;
        }

        $info['repositories'] = $api->myRepositories();
        $this->saveResourceToYamlFile(static::getResourcesPath().$this::FILENAME_USER_INFO, $info);
        $output->writeln(sprintf('File <comment>%s</> saved', $this::FILENAME_USER_INFO), OutputInterface::VERBOSITY_VERBOSE);

        return $info;
    }

    protected function loadRepos(array $user_info, OutputInterface $output): array
    {
        if ($this->dev_mode === false && file_exists(static::getResourcesPath().$this::FILENAME_REPOS)) {
            $output->writeln(sprintf('Using <comment>%s</> from cache', $this::FILENAME_REPOS), OutputInterface::VERBOSITY_VERBOSE);

            return $this->getResourceYaml($this::FILENAME_REPOS);
        }

        $api = $this->getClient()->api('repo');
        $repositories = [];

        foreach($user_info['organizations'] as $org) {

            if ($this->github_username === $org['login']) {
                $customApi = $this->getUserApi()->repositories($this->github_username);
            } else {
                $customApi = $this->getOrganizationApi()->repositories($org['login']);
            }

            $repositories[$org['login']] = $this->fetchReposFromEntity($org['login'], $api, $customApi, $output);
        }

        $this->saveResourceToYamlFile(static::getResourcesPath().$this::FILENAME_REPOS, $repositories);
        $output->writeln(sprintf('File <info>%s</> saved', $this::FILENAME_REPOS), OutputInterface::VERBOSITY_VERBOSE);

        return $repositories;
    }

    protected function fetchReposFromEntity(string $entity_name, ApiInterface $api, array $repositories, OutputInterface $output): array
    {
        $yamlFile = sprintf('data/%s-repos.yaml', $entity_name);
        if ($this->dev_mode === false && file_exists(static::getResourcesPath().$yamlFile)) {
            $output->writeln(sprintf('Using <comment>%s</> from cache', $yamlFile), OutputInterface::VERBOSITY_VERBOSE);

            return $this->getResourceYaml($yamlFile);
        }

        foreach($repositories as $k => $repo) {
            $output->writeln(sprintf('Fetching %s::<comment>%s</> repo', $entity_name, $repo['name']));
            $branches = $api->branches($entity_name, $repo['name']);

            foreach($branches as $branch) {
                $repositories[$k]['branches'][] = $branch['name'];
            }

            foreach([
                'tags',
                'teams',
                'contributors',
            ] as $method) {
                $string = sprintf('Fetching %s::<comment>%s</> repo <info>%s</>', $entity_name, $repo['name'], $method);
                $output->writeln($string, OutputInterface::VERBOSITY_VERBOSE);
                $data = $api->$method($entity_name, $repo['name']);
                $repositories[$k][$method] = $data;
            }
        }

        $this->saveResourceToYamlFile(static::getResourcesPath().$yamlFile, $repositories);
        $output->writeln(sprintf('File <comment>%s</> saved', $yamlFile), OutputInterface::VERBOSITY_VERBOSE);

        return $repositories;
    }


    protected function buildHtml(array $parameters, string $filenameHtml, OutputInterface $output):void
    {
        $twig = $this->factoryTwig();
        $content = $twig->render('repos.html.twig', $parameters);
        file_put_contents($filenameHtml, $content);
        $output->writeln(sprintf('File <comment>%s</> saved', $filenameHtml), OutputInterface::VERBOSITY_VERBOSE);
    }

    protected function buildFiles(array $parameters, string $filename, OutputInterface $output):void
    {
        $twig = $this->factoryTwig();
        $content = $twig->render('repos.sh.twig', $parameters);
        file_put_contents($filename, $content);
        $output->writeln(sprintf('File <comment>%s</> saved', $filename), OutputInterface::VERBOSITY_VERBOSE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $user_info = $this->loadUserInfo($output);
        $repos = $this->loadRepos($user_info, $output);

        foreach($repos as $k => $repos) {
            $parameters = [
                'user_info' => $user_info,
                'org' => $user_info['organizations'][$k],
                'repos' => $repos,
            ];
            $this->buildHtml($parameters, sprintf('docs/%s-repos.html', $k), $output);
            $this->buildFiles($parameters, sprintf('bin/normalize-%s-repos.sh', $k), $output);
        }

        $output->writeln('Done!');

        return 0;
    }
}
